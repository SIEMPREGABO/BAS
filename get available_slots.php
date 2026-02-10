<?php
require_once 'spa_admin.php';
header('Content-Type: application/json');

if (!isset($_GET['fecha'])) {
    echo json_encode(array('error' => 'Date not provided'));
    exit;
}

$spaAdmin = new SpaAdmin();
$slots = $spaAdmin->getAvailableSlots($_GET['fecha']);

echo json_encode($slots);
?>