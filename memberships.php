<?php
require_once 'db_connection.php';

class Membership {
    private $db;
    private $table = 'membresias';
    private $clientMembershipTable = 'clientes_membresias';

    public function __construct() {
        $this->db = new Database();
    }

    // Create new membership type
    public function createMembership($data) {
        $conn = $this->db->connect();
        
        $query = 'INSERT INTO ' . $this->table . ' 
                  SET nombre = :nombre, 
                      descripcion = :descripcion, 
                      precio = :precio, 
                      servicios_incluidos = :servicios_incluidos, 
                      vigencia_meses = :vigencia_meses, 
                      beneficios = :beneficios, 
                      activa = :activa';
        
        $stmt = $conn->prepare($query);
        
        // Bind parameters
        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':descripcion', $data['descripcion']);
        $stmt->bindParam(':precio', $data['precio']);
        $stmt->bindParam(':servicios_incluidos', $data['servicios_incluidos']);
        $stmt->bindParam(':vigencia_meses', $data['vigencia_meses']);
        $stmt->bindParam(':beneficios', $data['beneficios']);
        $stmt->bindParam(':activa', $data['activa']);
        
        try {
            $stmt->execute();
            return $conn->lastInsertId();
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Get all membership types
    public function getMemberships($activeOnly = true) {
        $conn = $this->db->connect();
        
        $query = 'SELECT * FROM ' . $this->table;
        if ($activeOnly) {
            $query .= ' WHERE activa = 1';
        }
        $query .= ' ORDER BY nombre';
        
        $stmt = $conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get single membership type
    public function getMembership($id) {
        $conn = $this->db->connect();
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_membresia = ? LIMIT 1';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Assign membership to client
    public function assignMembershipToClient($clientId, $membershipId) {
        $conn = $this->db->connect();
        
        // First get membership details
        $membership = $this->getMembership($membershipId);
        if (!$membership) {
            return false;
        }
        
        // Calculate expiration date
        $startDate = date('Y-m-d');
        $expirationDate = date('Y-m-d', strtotime("+{$membership['vigencia_meses']} months"));
        
        $query = 'INSERT INTO ' . $this->clientMembershipTable . ' 
                  SET id_cliente = :id_cliente, 
                      id_membresia = :id_membresia, 
                      fecha_inicio = :fecha_inicio, 
                      fecha_vencimiento = :fecha_vencimiento, 
                      servicios_totales = :servicios_totales, 
                      activa = 1';
        
        $stmt = $conn->prepare($query);
        
        // Extract number of services from the description
        preg_match('/Paquete de (\d+) servicios/', $membership['descripcion'], $matches);
        $totalServices = isset($matches[1]) ? $matches[1] : 3; // Default to 3 if not found
        
        // Bind parameters
        $stmt->bindParam(':id_cliente', $clientId);
        $stmt->bindParam(':id_membresia', $membershipId);
        $stmt->bindParam(':fecha_inicio', $startDate);
        $stmt->bindParam(':fecha_vencimiento', $expirationDate);
        $stmt->bindParam(':servicios_totales', $totalServices);
        
        try {
            $stmt->execute();
            $clientMembershipId = $conn->lastInsertId();
            
            // Record payment
            $this->recordMembershipPayment($clientId, $membershipId, $membership['precio']);
            
            return $clientMembershipId;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Record membership payment
    private function recordMembershipPayment($clientId, $membershipId, $amount) {
        $conn = $this->db->connect();
        
        $query = 'INSERT INTO Pagos 
                  SET id_cliente = :id_cliente, 
                      id_membresia = :id_membresia, 
                      monto = :monto, 
                      metodo_pago = "tarjeta_credito", 
                      estado = "completado"';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cliente', $clientId);
        $stmt->bindParam(':id_membresia', $membershipId);
        $stmt->bindParam(':monto', $amount);
        
        try {
            return $stmt->execute();
        } catch(PDOException $e) {
            error_log('Payment recording error: ' . $e->getMessage());
            return false;
        }
    }

    // Get client's active memberships
    public function getClientMemberships($clientId, $activeOnly = true) {
        $conn = $this->db->connect();
        
        $query = 'SELECT cm.*, m.nombre as membresia_nombre, m.descripcion as membresia_descripcion
                 FROM ' . $this->clientMembershipTable . ' cm
                 JOIN ' . $this->table . ' m ON cm.id_membresia = m.id_membresia
                 WHERE cm.id_cliente = :id_cliente';
        
        if ($activeOnly) {
            $query .= ' AND cm.activa = 1 AND cm.fecha_vencimiento >= CURDATE()';
        }
        
        $query .= ' ORDER BY cm.fecha_vencimiento ASC';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id_cliente', $clientId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check if client can use membership for a service
    public function canUseMembership($clientId, $serviceId) {
        $conn = $this->db->connect();
        
        // Get client's active memberships
        $memberships = $this->getClientMemberships($clientId);
        
        foreach ($memberships as $membership) {
            // Check if membership has remaining services
            if ($membership['servicios_utilizados'] < $membership['servicios_totales']) {
                // Check if service is included in membership
                if (strpos($membership['membresia_descripcion'], 'masaje') !== false || 
                    strpos($membership['membresia_descripcion'], 'facial') !== false) {
                    return $membership['id'];
                }
            }
        }
        
        return false;
    }

    // Use a service from membership
    public function useMembershipService($clientMembershipId) {
        $conn = $this->db->connect();
        
        $query = 'UPDATE ' . $this->clientMembershipTable . ' 
                 SET servicios_utilizados = servicios_utilizados + 1
                 WHERE id = :id AND servicios_utilizados < servicios_totales';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $clientMembershipId, PDO::PARAM_INT);
        
        try {
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    // Renew membership
    public function renewMembership($clientMembershipId) {
        $conn = $this->db->connect();
        
        // Get current membership details
        $query = 'SELECT cm.*, m.vigencia_meses, m.precio
                 FROM ' . $this->clientMembershipTable . ' cm
                 JOIN ' . $this->table . ' m ON cm.id_membresia = m.id_membresia
                 WHERE cm.id = ? LIMIT 1';
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $clientMembershipId, PDO::PARAM_INT);
        $stmt->execute();
        $currentMembership = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$currentMembership) {
            return false;
        }
        
        // Deactivate current membership
        $deactivateQuery = 'UPDATE ' . $this->clientMembershipTable . ' 
                           SET activa = 0 
                           WHERE id = ?';
        
        $deactivateStmt = $conn->prepare($deactivateQuery);
        $deactivateStmt->bindParam(1, $clientMembershipId, PDO::PARAM_INT);
        $deactivateStmt->execute();
        
        // Create new membership with same parameters
        $newStartDate = date('Y-m-d');
        $newExpirationDate = date('Y-m-d', strtotime("+{$currentMembership['vigencia_meses']} months"));
        
        $insertQuery = 'INSERT INTO ' . $this->clientMembershipTable . ' 
                       SET id_cliente = :id_cliente, 
                           id_membresia = :id_membresia, 
                           fecha_inicio = :fecha_inicio, 
                           fecha_vencimiento = :fecha_vencimiento, 
                           servicios_totales = :servicios_totales, 
                           servicios_utilizados = 0, 
                           activa = 1';
        
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':id_cliente', $currentMembership['id_cliente']);
        $insertStmt->bindParam(':id_membresia', $currentMembership['id_membresia']);
        $insertStmt->bindParam(':fecha_inicio', $newStartDate);
        $insertStmt->bindParam(':fecha_vencimiento', $newExpirationDate);
        $insertStmt->bindParam(':servicios_totales', $currentMembership['servicios_totales']);
        
        try {
            $insertStmt->execute();
            $newMembershipId = $conn->lastInsertId();
            
            // Record payment for renewal
            $this->recordMembershipPayment(
                $currentMembership['id_cliente'], 
                $currentMembership['id_membresia'], 
                $currentMembership['precio']
            );
            
            return $newMembershipId;
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }
}
?>