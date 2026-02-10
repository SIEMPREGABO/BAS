<?php
require_once 'db_connection.php';

class Report {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get appointment report
    public function getAppointmentReport($startDate, $endDate) {
        $conn = $this->db->connect();
        
        $query = 'SELECT 
                 DATE(c.fecha_hora) as fecha,
                 s.categoria,
                 COUNT(*) as total_citas,
                 SUM(c.precio) as ingresos_totales,
                 AVG(c.precio) as promedio_por_cita
                 FROM Citas c
                 JOIN Servicios s ON c.id_servicio = s.id_servicio
                 WHERE c.fecha_hora BETWEEN :start_date AND :end_date
                 AND c.estado = "completada"
                 GROUP BY DATE(c.fecha_hora), s.categoria
                 ORDER BY fecha, s.categoria';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get client activity report
    public function getClientActivityReport($startDate, $endDate) {
        $conn = $this->db->connect();
        
        $query = 'SELECT 
                 cl.id_cliente,
                 cl.nombre,
                 cl.email,
                 COUNT(c.id_cita) as total_citas,
                 SUM(c.precio) as total_gastado,
                 MAX(c.fecha_hora) as ultima_visita
                 FROM clientes cl
                 LEFT JOIN Citas c ON cl.id_cliente = c.id_cliente 
                 AND c.estado = "completada"
                 AND c.fecha_hora BETWEEN :start_date AND :end_date
                 GROUP BY cl.id_cliente, cl.nombre, cl.email
                 HAVING total_citas > 0
                 ORDER BY total_gastado DESC';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get membership report
    public function getMembershipReport() {
        $conn = $this->db->connect();
        
        $query = 'SELECT 
                 m.nombre as membresia,
                 COUNT(cm.id) as total_clientes,
                 SUM(m.precio) as ingresos_totales,
                 AVG(cm.servicios_utilizados) as servicios_promedio_usados,
                 AVG(cm.servicios_totales) as servicios_totales_promedio
                 FROM clientes_membresias cm
                 JOIN membresias m ON cm.id_membresia = m.id_membresia
                 WHERE cm.activa = 1
                 GROUP BY m.nombre
                 ORDER BY ingresos_totales DESC';
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get service popularity report
public function getServicePopularityReport($startDate, $endDate, $limit = 5) {
    $conn = $this->db->connect();
    
    $query = 'SELECT 
             s.id_servicio,
             s.nombre as servicio,
             s.categoria,
             COUNT(c.id_cita) as total_citas,
             SUM(c.precio) as ingresos_totales,
             AVG(c.precio) as precio_promedio
             FROM Citas c
             JOIN Servicios s ON c.id_servicio = s.id_servicio
             WHERE c.fecha_hora BETWEEN :start_date AND :end_date
             AND c.estado = "completada"
             GROUP BY s.id_servicio, s.nombre, s.categoria
             ORDER BY total_citas DESC
             LIMIT :limit';
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':start_date', $startDate);
    $stmt->bindParam(':end_date', $endDate);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Agregar porcentaje de participación
    $totalCitas = array_sum(array_column($results, 'total_citas'));
    foreach ($results as &$service) {
        $service['porcentaje'] = $totalCitas > 0 ? round(($service['total_citas'] / $totalCitas) * 100, 1) : 0;
    }
    
    return $results;
}
}
?>