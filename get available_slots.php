<?php
require_once 'spa_admin.php';
header('Content-Type: application/json');

if (!isset($_GET['fecha'])) {
    echo json_encode(array('error' => 'Fecha no proporcionada'));
    exit;
}

$fecha = $_GET['fecha'];
$duracion = isset($_GET['duracion']) ? intval($_GET['duracion']) : 50;

// Extraer solo el número de la duración si viene con "min"
if (is_string($_GET['duracion']) && strpos($_GET['duracion'], 'min') !== false) {
    $duracion = intval(preg_replace('/[^0-9]/', '', $_GET['duracion']));
}

$spaAdmin = new SpaAdmin();
$slots = $spaAdmin->getAvailableSlots($fecha, $duracion);

echo json_encode($slots);
?>