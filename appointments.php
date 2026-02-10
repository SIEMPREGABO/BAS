<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'db_connection.php';

class Appointment {
    private $db;
    private $table = 'Citas';

    public function __construct() {
        $this->db = new Database();
    }

    // Create new appointment
    public function createAppointment($data) {
        $conn = $this->db->connect();
        
        // First get service details to determine duration and price
        $service = $this->getServiceDetails($data['id_servicio'], $data['duration_type']);
        
        if (!$service) {
            return false;
        }
        
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET id_cliente = :id_cliente, 
                      id_servicio = :id_servicio, 
                      fecha_hora = :fecha_hora, 
                      duracion = :duracion, 
                      precio = :precio, 
                      estado = :estado, 
                      notas = :notas';
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':id_servicio', $data['id_servicio']);
        $stmt->bindParam(':fecha_hora', $data['fecha_hora']);
        $stmt->bindParam(':duracion', $service['duracion']);
        $stmt->bindParam(':precio', $service['precio']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':notas', $data['notas']);
        
        try {
            $stmt->execute();
            $appointmentId = $conn->lastInsertId();
            
            // Create notification for the appointment
            $this->createAppointmentNotification($data['id_cliente'], $appointmentId, $data['fecha_hora']);
            
            return $appointmentId;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Get service details for appointment
    private function getServiceDetails($serviceId, $durationType) {
        $conn = $this->db->connect();
        
        $query = 'SELECT ';
        if ($durationType == '50min') {
            $query .= 'duracion_50min as duracion, precio_50min as precio ';
        } elseif ($durationType == '80min') {
            $query .= 'duracion_80min as duracion, precio_80min as precio ';
        } else {
            $query .= 'duracion_90min as duracion, precio_90min as precio ';
        }
        $query .= 'FROM Servicios WHERE id_servicio = ? AND activo = 1 LIMIT 1';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $serviceId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAppointment($data) {
        $conn = $this->db->connect();
        $sql = "UPDATE Citas SET 
                    id_cliente = :id_cliente,
                    id_servicio = :id_servicio,
                    fecha_hora = :fecha_hora,
                    duracion = :duracion,
                    estado = :estado,
                    notas = :notas
                WHERE id_cita = :id_cita";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            ':id_cliente' => $data['id_cliente'],
            ':id_servicio' => $data['id_servicio'],
            ':fecha_hora' => $data['fecha_hora'],
            ':duracion' => $data['duracion'],
            ':estado' => $data['estado'],
            ':notas' => $data['notas'],
            ':id_cita' => $data['id_cita']
        ]);
        if ($result) {
            header('Location: citas.php');
            exit;
        }
        return $result;
    }
    // Delete appointment
    public function deleteAppointment($id) {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM Citas WHERE id_cita = ?");
        $result = $stmt->execute([$id]);
        if ($result) {
            header('Location: citas.php');
            exit;
        }
        return $result;
    }

    // Create appointment notification
    private function createAppointmentNotification($clientId, $appointmentId, $appointmentDate) {
        $conn = $this->db->connect();
        
        // Get client and service details
        $clientQuery = 'SELECT nombre FROM clientes WHERE id_cliente = ? LIMIT 1';
        $clientStmt = $conn->prepare($clientQuery);
        $clientStmt->bindParam(1, $clientId, PDO::PARAM_INT);
        $clientStmt->execute();
        $client = $clientStmt->fetch(PDO::FETCH_ASSOC);
        
        $appointmentQuery = 'SELECT s.nombre 
                            FROM Citas c
                            JOIN Servicios s ON c.id_servicio = s.id_servicio
                            WHERE c.id_cita = ? LIMIT 1';
        $appointmentStmt = $conn->prepare($appointmentQuery);
        $appointmentStmt->bindParam(1, $appointmentId, PDO::PARAM_INT);
        $appointmentStmt->execute();
        $service = $appointmentStmt->fetch(PDO::FETCH_ASSOC);
        
        $message = "Hola " . $client['nombre'] . ", tienes una cita para " . $service['nombre'] . 
                  " el " . date('d/m/Y', strtotime($appointmentDate)) . 
                  " a las " . date('H:i', strtotime($appointmentDate)) . 
                  ". ¡Te esperamos!";
        
        $notificationDate = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($appointmentDate)));
        
        $query = 'INSERT INTO notificaciones 
                  SET id_cliente = :id_cliente, 
                      tipo = "recordatorio_cita", 
                      mensaje = :mensaje, 
                      fecha_envio = :fecha_envio, 
                      metodo = "web", 
                      estado = "pendiente"';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cliente', $clientId);
        $stmt->bindParam(':mensaje', $message);
        $stmt->bindParam(':fecha_envio', $notificationDate);
        
        try {
            $stmt->execute();
        } catch(PDOException $e) {
            // Fail silently for notifications
            error_log('Notification error: ' . $e->getMessage());
        }
    }

    // Get all appointments
    public function getAppointments($filter = array()) {
        $conn = $this->db->connect();
        
        $query = 'SELECT c.*, cl.nombre as cliente_nombre, s.nombre as servicio_nombre
                 FROM ' . $this->table . ' c
                 JOIN clientes cl ON c.id_cliente = cl.id_cliente
                 JOIN Servicios s ON c.id_servicio = s.id_servicio';
        
        $where = array();
        $params = array();
        
        if (!empty($filter['start_date'])) {
            $where[] = 'c.fecha_hora >= :start_date';
            $params[':start_date'] = $filter['start_date'];
        }
        
        if (!empty($filter['end_date'])) {
            $where[] = 'c.fecha_hora <= :end_date';
            $params[':end_date'] = $filter['end_date'];
        }
        
        if (!empty($filter['status'])) {
            $where[] = 'c.estado = :status';
            $params[':status'] = $filter['status'];
        }
        
        if (!empty($filter['client_id'])) {
            $where[] = 'c.id_cliente = :client_id';
            $params[':client_id'] = $filter['client_id'];
        }
        
        if (!empty($where)) {
            $query .= ' WHERE ' . implode(' AND ', $where);
        }
        
        $query .= ' ORDER BY c.fecha_hora ASC';
        
        $stmt = $conn->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single appointment
    public function getAppointment($id) {
        $conn = $this->db->connect();
        $query = 'SELECT c.*, cl.nombre as cliente_nombre, cl.email as cliente_email, 
                 cl.telefono as cliente_telefono, s.nombre as servicio_nombre
                 FROM ' . $this->table . ' c
                 JOIN clientes cl ON c.id_cliente = cl.id_cliente
                 JOIN Servicios s ON c.id_servicio = s.id_servicio
                 WHERE c.id_cita = ? LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update appointment status
    public function updateAppointmentStatus($id, $status) {
        $conn = $this->db->connect();
        $query = 'UPDATE ' . $this->table . ' SET estado = :estado WHERE id_cita = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estado', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            $result = $stmt->execute();
            // Redirect to citas.php after updating
            header('Location: citas.php');
            exit;
            return $result;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Check appointment availability
    public function checkAvailability($startDateTime, $duration) {
        $conn = $this->db->connect();
        
        $endDateTime = date('Y-m-d H:i:s', strtotime("+$duration minutes", strtotime($startDateTime)));
        
        $query = 'SELECT COUNT(*) as count 
                 FROM ' . $this->table . ' 
                 WHERE (
                     (:start BETWEEN fecha_hora AND DATE_ADD(fecha_hora, INTERVAL duracion MINUTE)) OR
                     (:end BETWEEN fecha_hora AND DATE_ADD(fecha_hora, INTERVAL duracion MINUTE)) OR
                     (fecha_hora BETWEEN :start AND :end)
                 ) AND estado IN ("pendiente", "confirmada")';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':start', $startDateTime);
        $stmt->bindParam(':end', $endDateTime);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result['count'] == 0;
    }
}
?>