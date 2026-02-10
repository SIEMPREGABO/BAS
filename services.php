<?php
require_once 'db_connection.php';

class Service {
    private $db;
    private $table = 'Servicios';

    public function __construct() {
        $this->db = new Database();
    }

    // Create new service
    public function createService($data) {
        $conn = $this->db->connect();
        
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      categoria = :categoria, 
                      duracion_50min = :duracion_50min, 
                      precio_50min = :precio_50min, 
                      duracion_80min = :duracion_80min, 
                      precio_80min = :precio_80min, 
                      duracion_90min = :duracion_90min, 
                      precio_90min = :precio_90min, 
                      activo = :activo';
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':duracion_50min', $data['duracion_50min']);
        $stmt->bindParam(':precio_50min', $data['precio_50min']);
        $stmt->bindParam(':duracion_80min', $data['duracion_80min']);
        $stmt->bindParam(':precio_80min', $data['precio_80min']);
        $stmt->bindParam(':duracion_90min', $data['duracion_90min']);
        $stmt->bindParam(':precio_90min', $data['precio_90min']);
        $stmt->bindParam(':activo', $data['activo']);
        
        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Get all services
    public function getServices($category = null) {
        $conn = $this->db->connect();
        
        $query = 'SELECT * FROM ' . $this->table . ' WHERE activo = 1';
        if ($category) {
            $query .= ' AND categoria = :categoria';
        }
        $query .= ' ORDER BY categoria, nombre';
        
        $stmt = $conn->prepare($query);
        if ($category) {
            $stmt->bindParam(':categoria', $category);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single service
    public function getService($id) {
        $conn = $this->db->connect();
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_servicio = ? LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update service
    public function updateService($id, $data) {
        $conn = $this->db->connect();
        
        $query = 'UPDATE ' . $this->table . ' 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      categoria = :categoria, 
                      duracion_50min = :duracion_50min, 
                      precio_50min = :precio_50min, 
                      duracion_80min = :duracion_80min, 
                      precio_80min = :precio_80min, 
                      duracion_90min = :duracion_90min, 
                      precio_90min = :precio_90min, 
                      activo = :activo
                  WHERE id_servicio = :id';
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':categoria', $data['categoria']);
        $stmt->bindParam(':duracion_50min', $data['duracion_50min']);
        $stmt->bindParam(':precio_50min', $data['precio_50min']);
        $stmt->bindParam(':duracion_80min', $data['duracion_80min']);
        $stmt->bindParam(':precio_80min', $data['precio_80min']);
        $stmt->bindParam(':duracion_90min', $data['duracion_90min']);
        $stmt->bindParam(':precio_90min', $data['precio_90min']);
        $stmt->bindParam(':activo', $data['activo']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Toggle service status
    public function toggleServiceStatus($id, $status) {
        $conn = $this->db->connect();
        $query = 'UPDATE ' . $this->table . ' SET activo = :activo WHERE id_servicio = :id';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':activo', $status, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
?>