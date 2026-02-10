<?php
require_once 'db_connection.php';

class Payment
{
    private $db;
    private $table = 'pagos';

    public function __construct()
    {
        $this->db = new Database();
    }

    // Record a payment
    // Record a payment with additional fields
    // Añade este método a tu clase Payment para obtener el ID del cliente de una cita
    public function getClientIdFromAppointment($appointmentId)
    {
        $conn = $this->db->connect();
        $query = 'SELECT id_cliente FROM Citas WHERE id_cita = :id_cita LIMIT 1';

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cita', $appointmentId, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id_cliente'] : null;
        } catch (PDOException $e) {
            error_log('Error al obtener cliente de cita: ' . $e->getMessage());
            return null;
        }
    }

    public function recordPayment($data)
    {
        $conn = $this->db->connect();

        $query = 'INSERT INTO ' . $this->table . ' 
              SET id_cita = :id_cita, 
                  id_membresia = :id_membresia, 
                  id_cliente = :id_cliente, 
                  monto = :monto, 
                  metodo_pago = :metodo_pago, 
                  estado = :estado, 
                  referencia = :referencia, 
                  notas = :notas,
                  fecha_pago = :fecha_pago';

        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id_cita', $data['id_cita']);
        $stmt->bindParam(':id_membresia', $data['id_membresia']);
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':monto', $data['monto']);
        $stmt->bindParam(':metodo_pago', $data['metodo_pago']);
        $stmt->bindParam(':estado', $data['estado']);
        $stmt->bindParam(':referencia', $data['referencia']);
        $stmt->bindParam(':notas', $data['notas']);
        $stmt->bindParam(':fecha_pago', $data['fecha_pago']);

        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Get all payments
    public function getPayments($filter = array())
    {
        $conn = $this->db->connect();

        $query = 'SELECT p.*, 
                 c.nombre as cliente_nombre,
                 IFNULL(s.nombre, m.nombre) as concepto_nombre,
                 IFNULL(ci.fecha_hora, p.fecha_pago) as fecha_concepto
                 FROM ' . $this->table . ' p
                 LEFT JOIN clientes c ON p.id_cliente = c.id_cliente
                 LEFT JOIN citas ci ON p.id_cita = ci.id_cita
                 LEFT JOIN servicios s ON ci.id_servicio = s.id_servicio
                 LEFT JOIN membresias m ON p.id_membresia = m.id_membresia';

        $where = array();
        $params = array();

        if (!empty($filter['start_date'])) {
            $where[] = 'p.fecha_pago >= :start_date';
            $params[':start_date'] = $filter['start_date'];
        }

        if (!empty($filter['end_date'])) {
            $where[] = 'p.fecha_pago <= :end_date';
            $params[':end_date'] = $filter['end_date'];
        }

        if (!empty($filter['client_id'])) {
            $where[] = 'p.id_cliente = :client_id';
            $params[':client_id'] = $filter['client_id'];
        }

        if (!empty($filter['payment_method'])) {
            $where[] = 'p.metodo_pago = :payment_method';
            $params[':payment_method'] = $filter['payment_method'];
        }

        if (!empty($where)) {
            $query .= ' WHERE ' . implode(' AND ', $where);
        }

        $query .= ' ORDER BY p.fecha_pago DESC';

        $stmt = $conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // Get payment summary (for reports)
    public function getPaymentSummary($startDate, $endDate)
    {
        $conn = $this->db->connect();

        $query = 'SELECT 
                 DATE(fecha_pago) as fecha,
                 metodo_pago,
                 COUNT(*) as cantidad,
                 SUM(monto) as total
                 FROM ' . $this->table . '
                 WHERE fecha_pago BETWEEN :start_date AND :end_date
                 AND estado = "completado"
                 GROUP BY DATE(fecha_pago), metodo_pago
                 ORDER BY fecha DESC';

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update payment status
    public function updatePaymentStatus($paymentId, $status)
    {
        $conn = $this->db->connect();
        $query = 'UPDATE ' . $this->table . ' SET estado = :estado WHERE id_pago = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estado', $status);
        $stmt->bindParam(':id', $paymentId, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    // Agrega este método a tu clase Payment para obtener resumen mensual mejorado
    public function getMonthlySummary($year = null, $month = null)
    {
        $conn = $this->db->connect();

        // Si no se especifica año/mes, usar el actual
        $year = $year ?? date('Y');
        $month = $month ?? date('m');

        $startDate = "$year-$month-01";
        $endDate = date("Y-m-t", strtotime($startDate));

        $query = 'SELECT 
             SUM(monto) as total,
             COUNT(*) as cantidad,
             metodo_pago,
             DAY(fecha_pago) as dia
             FROM ' . $this->table . '
             WHERE fecha_pago BETWEEN :start_date AND :end_date
             AND estado = "completado"
             GROUP BY metodo_pago, DAY(fecha_pago)
             ORDER BY dia, metodo_pago';

        $stmt = $conn->prepare($query);
        $stmt->bindParam(':start_date', $startDate);
        $stmt->bindParam(':end_date', $endDate);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para obtener el total mensual formateado
    public function getFormattedMonthlyTotal($year = null, $month = null)
    {
        $summary = $this->getMonthlySummary($year, $month);
        $total = array_sum(array_column($summary, 'total'));

        return [
            'total' => $total,
            'formatted' => number_format($total, 2),
            'count' => array_sum(array_column($summary, 'cantidad'))
        ];
    }
}
