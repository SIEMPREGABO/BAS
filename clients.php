<?php
require_once 'db_connection.php';

class Client {
    private $db;
    private $table = 'clientes';

    public function __construct() {
        $this->db = new Database();
    }

    // Create new client
    public function createClient($data) {
        $conn = $this->db->connect();
        
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET nombre = :nombre, 
                      email = :email, 
                      telefono = :telefono, 
                      notas = :notas, 
                      preferencias = :preferencias, 
                      recibir_promociones = :recibir_promociones';
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':notas', $data['notas']);
        $stmt->bindParam(':preferencias', $data['preferencias']);
        $stmt->bindParam(':recibir_promociones', $data['recibir_promociones']);
        
        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Get all clients
    public function getClients() {
        $conn = $this->db->connect();
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY fecha_registro DESC';
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single client
    public function getClient($id) {
        $conn = $this->db->connect();
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_cliente = ? LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update client
    public function updateClient($id, $data) {
        $conn = $this->db->connect();
        
        $query = 'UPDATE ' . $this->table . ' 
                  SET nombre = :nombre, 
                      email = :email, 
                      telefono = :telefono, 
                      notas = :notas, 
                      preferencias = :preferencias, 
                      recibir_promociones = :recibir_promociones
                  WHERE id_cliente = :id';
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':notas', $data['notas']);
        $stmt->bindParam(':preferencias', $data['preferencias']);
        $stmt->bindParam(':recibir_promociones', $data['recibir_promociones']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Delete client
    public function deleteClient($id) {
        $conn = $this->db->connect();
        $query = 'DELETE FROM ' . $this->table . ' WHERE id_cliente = ?';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
?>