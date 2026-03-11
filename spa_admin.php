<?php
require_once 'db_connection.php';

class SpaAdmin {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }

    // Verificar disponibilidad de horario
    public function checkAvailability($date, $time, $duration) {
        $conn = $this->db->connect();
        
        // Convertir a formato datetime
        $startDateTime = date('Y-m-d H:i:s', strtotime("$date $time"));
        $endDateTime = date('Y-m-d H:i:s', strtotime("$startDateTime + $duration minutes"));
        
        // Verificar que esté dentro del horario de atención
        if (!$this->isWithinBusinessHours($startDateTime, $endDateTime)) {
            return false;
        }
        
        // Verificar solapamiento con otras citas
        // Una cita solapa si:
        // 1. La nueva cita empieza durante una cita existente
        // 2. La nueva cita termina durante una cita existente
        // 3. La nueva cita contiene completamente una cita existente
        $query = "SELECT COUNT(*) as count FROM Citas 
                 WHERE DATE(fecha_hora) = :fecha
                 AND (
                     (:start >= fecha_hora AND :start < DATE_ADD(fecha_hora, INTERVAL duracion MINUTE)) OR
                     (:end > fecha_hora AND :end <= DATE_ADD(fecha_hora, INTERVAL duracion MINUTE)) OR
                     (fecha_hora >= :start AND fecha_hora < :end)
                 ) AND estado IN ('pendiente', 'confirmada')";
        
        $stmt = $conn->prepare($query);
        $fecha = date('Y-m-d', strtotime($startDateTime));
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':start', $startDateTime);
        $stmt->bindParam(':end', $endDateTime);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] == 0;
    }

    // Verificar horario de atención
    private function isWithinBusinessHours($start, $end) {
        $dayOfWeek = date('N', strtotime($start)); // 6=sábado, 7=domingo
        $startTime = date('H:i', strtotime($start));
        $endTime = date('H:i', strtotime($end));
        
        if ($dayOfWeek == 6) { // Sábado: 5:30pm a 8:00pm
            return ($startTime >= '17:30' && $endTime <= '20:00');
        } elseif ($dayOfWeek == 7) { // Domingo: 10:00am a 6:00pm
            return ($startTime >= '10:00' && $endTime <= '18:00');
        }
        
        return false; // No se atiende otros días
    }

    // Obtener horarios disponibles para un día con duración específica
    public function getAvailableSlots($date, $duration = 50) {
        $dayOfWeek = date('N', strtotime($date));
        
        // Redondear duraciones: 50min -> 60min, 80min -> 90min, otros se dejan igual
        $roundedDuration = $duration;
        if ($duration == 50) {
            $roundedDuration = 60;
        } elseif ($duration == 80) {
            $roundedDuration = 90;
        }
        
        if ($dayOfWeek == 6) { // Sábado: 5:30pm a 8:00pm
            $start = '17:30';
            $end = '20:00';
        } elseif ($dayOfWeek == 7) { // Domingo: 10:00am a 6:00pm
            $start = '10:00';
            $end = '18:00';
        } else {
            return array(); // No hay horario otros días
        }
        
        $slots = array();
        $current = strtotime("$date $start");
        $endTime = strtotime("$date $end");
        
        // Intervalos de 30 minutos
        while ($current <= $endTime) {
            $timeSlot = date('H:i', $current);
            
            // Verificar si el servicio cabe en el horario de atención
            $serviceEnd = strtotime("+{$roundedDuration} minutes", $current);
            $businessEnd = strtotime("$date $end");
            
            // Solo agregar si el servicio termina antes del cierre
            if ($serviceEnd <= $businessEnd) {
                // Verificar disponibilidad
                $isAvailable = $this->checkAvailability($date, $timeSlot, $roundedDuration);
                $slots[] = array(
                    'time' => $timeSlot,
                    'available' => $isAvailable
                );
            }
            
            $current = strtotime('+30 minutes', $current);
        }
        
        return $slots;
    }

    // Crear nueva reservación
    public function createReservation($data) {
    $conn = $this->db->connect();
    
    try {
        // Verificar disponibilidad
        $startDateTime = date('Y-m-d H:i:s', strtotime("{$data['fecha']} {$data['hora']}"));
        if (!$this->checkAvailability($data['fecha'], $data['hora'], $data['duracion'])) {
            throw new Exception('El horario seleccionado no está disponible');
        }
        
        // Verificar si el cliente existe o crearlo
        $clientId = $this->getOrCreateClient($data);
        if (!$clientId) {
            throw new Exception('Error al registrar el cliente');
        }
        
        // Obtener precio del servicio

        $mapPricePackets = [
            17 => 750,
            18 => 700,
            19 => 800,
            20 => 820,
            21 => 700,
            22 => 750,
            23 => 520,
            24 => 700,
        ];

        if(isset($mapPricePackets[$data['id_servicio']])) {
            $servicePrice = $mapPricePackets[$data['id_servicio']];
        } else {
            $servicePrice = $this->getServicePrice($data['id_servicio'], $data['duracion']);
        }

        //$servicePrice = $this->getServicePrice($data['id_servicio'], $data['duracion']);
        if ($servicePrice === false) {
            throw new Exception('Servicio no válido o no encontrado');
        }
        
        // Crear la cita
        $query = "INSERT INTO Citas 
                 (id_cliente, id_servicio, fecha_hora, duracion, precio, estado, notas)
                 VALUES 
                 (:id_cliente, :id_servicio, :fecha_hora, :duracion, :precio, 'confirmada', :notas)";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cliente', $clientId, PDO::PARAM_INT);
        $stmt->bindParam(':id_servicio', $data['id_servicio'], PDO::PARAM_INT);
        $stmt->bindParam(':fecha_hora', $startDateTime);
        $stmt->bindParam(':duracion', $data['duracion'], PDO::PARAM_INT);
        $stmt->bindParam(':precio', $servicePrice);
        $stmt->bindParam(':notas', $data['notas']);
        
        if (!$stmt->execute()) {
            throw new Exception('Error al ejecutar la consulta de reservación');
        }
        
        $reservationId = $conn->lastInsertId();
        
        // Crear notificación
        $this->createNotification($clientId, $reservationId, $startDateTime);
        
        return [
            'success' => true, 
            'reservation_id' => $reservationId,
            'message' => 'Reservación creada exitosamente'
        ];
        
    } catch(PDOException $e) {
        error_log("Error PDO en createReservation: " . $e->getMessage());
        return [
            'success' => false, 
            'message' => 'Error de base de datos: ' . $e->getMessage()
        ];
    } catch(Exception $e) {
        error_log("Error en createReservation: " . $e->getMessage());
        return [
            'success' => false, 
            'message' => $e->getMessage()
        ];
    }
}

    // Obtener o crear cliente
    private function getOrCreateClient($data) {
        $conn = $this->db->connect();
        
        // Verificar si el cliente ya existe
        $query = "SELECT id_cliente FROM clientes WHERE email = :email LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return $result['id_cliente'];
        }
        
        // Crear nuevo cliente
        $query = "INSERT INTO clientes 
                 (nombre, email, telefono, fecha_registro)
                 VALUES 
                 (:nombre, :email, :telefono, NOW())";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        
        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch(PDOException $e) {
            error_log('Error al crear cliente: ' . $e->getMessage());
            return false;
        }
    }

    // Obtener precio del servicio según duración
    private function getServicePrice($serviceId, $duration) {
        $conn = $this->db->connect();
        
        $query = "SELECT 
                 CASE 
                     WHEN :duration <= 50 THEN precio_50min
                     WHEN :duration <= 80 THEN precio_80min
                     ELSE precio_90min
                 END as precio
                 FROM Servicios 
                 WHERE id_servicio = :id_servicio AND activo = 1
                 LIMIT 1";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_servicio', $serviceId);
        $stmt->bindParam(':duration', $duration);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result['precio'] : false;
    }

    // Crear notificación de reservación
    private function createNotification($clientId, $reservationId, $reservationDate) {
        $conn = $this->db->connect();
        
        // Obtener detalles del cliente y servicio
        $query = "SELECT c.nombre as cliente_nombre, s.nombre as servicio_nombre
                 FROM Citas ci
                 JOIN clientes c ON ci.id_cliente = c.id_cliente
                 JOIN Servicios s ON ci.id_servicio = s.id_servicio
                 WHERE ci.id_cita = :id_cita
                 LIMIT 1";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cita', $reservationId);
        $stmt->execute();
        $details = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$details) return false;
        
        $message = "Hola {$details['cliente_nombre']}, tu reservación para {$details['servicio_nombre']} " .
                  "está confirmada para el " . date('d/m/Y', strtotime($reservationDate)) . 
                  " a las " . date('H:i', strtotime($reservationDate)) . ". ¡Te esperamos!";
        
        $notificationDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($reservationDate)));
        
        $query = "INSERT INTO notificaciones 
                 (id_cliente, tipo, mensaje, fecha_envio, metodo, estado)
                 VALUES 
                 (:id_cliente, 'recordatorio_cita', :mensaje, :fecha_envio, 'web', 'pendiente')";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cliente', $clientId);
        $stmt->bindParam(':mensaje', $message);
        $stmt->bindParam(':fecha_envio', $notificationDate);
        
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log('Error al crear notificación: ' . $e->getMessage());
            return false;
        }
    }

    // Obtener todos los servicios activos
public function getActiveServices() {
    $conn = $this->db->connect();
    
    $query = "SELECT id_servicio, nombre, categoria, 
             duracion_50min, precio_50min, 
             duracion_80min, precio_80min, 
             duracion_90min, precio_90min
             FROM Servicios 
             WHERE activo = 1
             ORDER BY categoria, nombre";
    
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    // Obtener duraciones disponibles para un servicio
    public function getServiceDurations($serviceId) {
        $conn = $this->db->connect();
        
        $query = "SELECT 
                 CASE 
                     WHEN duracion_50min IS NOT NULL THEN '50min'
                     WHEN duracion_80min IS NOT NULL THEN '80min'
                     ELSE '90min'
                 END as duracion_default,
                 IF(duracion_50min IS NOT NULL, CONCAT('50 min - $', precio_50min), NULL) as opcion_50min,
                 IF(duracion_80min IS NOT NULL, CONCAT('80 min - $', precio_80min), NULL) as opcion_80min,
                 IF(duracion_90min IS NOT NULL, CONCAT('90 min - $', precio_90min), NULL) as opcion_90min
                 FROM Servicios 
                 WHERE id_servicio = :id_servicio
                 LIMIT 1";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_servicio', $serviceId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $durations = array();
        if ($result['opcion_50min']) $durations['50'] = $result['opcion_50min'];
        if ($result['opcion_80min']) $durations['80'] = $result['opcion_80min'];
        if ($result['opcion_90min']) $durations['90'] = $result['opcion_90min'];
        
        return array(
            'durations' => $durations,
            'default' => $result['duracion_default']
        );
    }
}
?>