<?php
require_once 'db_connection.php';

class Notification
{
    private $db;
    private $table = 'Notificaciones';

    public function __construct()
    {
        $this->db = new Database();
    }

    // Create notification
    public function createNotification($data)
    {
        $conn = $this->db->connect();

        $query = 'INSERT INTO ' . $this->table . ' 
                  SET id_cliente = :id_cliente, 
                      tipo = :tipo, 
                      mensaje = :mensaje, 
                      fecha_envio = :fecha_envio, 
                      metodo = :metodo, 
                      estado = :estado';

        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':id_cliente', $data['id_cliente']);
        $stmt->bindParam(':tipo', $data['tipo']);
        $stmt->bindParam(':mensaje', $data['mensaje']);
        $stmt->bindParam(':fecha_envio', $data['fecha_envio']);
        $stmt->bindParam(':metodo', $data['metodo']);
        $stmt->bindParam(':estado', $data['estado']);

        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
    // Count unread notifications for a client
    public function countUnreadNotifications()
    {
        $conn = $this->db->connect();
        $query = 'SELECT COUNT(*) as count FROM ' . $this->table . ' WHERE estado = "pendiente"';
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Get notifications to send
    public function getPendingNotifications()
    {
        $conn = $this->db->connect();
        $query = 'SELECT n.*, c.nombre as cliente_nombre, c.email, c.telefono
                 FROM ' . $this->table . ' n
                 JOIN Clientes c ON n.id_cliente = c.id_cliente
                 WHERE n.estado = "pendiente" AND n.fecha_envio <= NOW()';
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update notification status
    public function updateNotificationStatus($id, $status)
    {
        $conn = $this->db->connect();
        $query = 'UPDATE ' . $this->table . ' SET estado = :estado WHERE id_notificacion = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':estado', $status);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Get client notifications
    public function getClientNotifications($clientId, $limit = 10)
    {
        $conn = $this->db->connect();
        $query = 'SELECT * FROM ' . $this->table . ' 
                 ORDER BY fecha_envio DESC
                 LIMIT :limit';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
