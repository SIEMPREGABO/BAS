<?php
require_once 'spa_admin.php';
header('Content-Type: application/json');

if (!isset($_GET['service_id'])) {
    echo json_encode(array('error' => 'Service ID not provided'));
    exit;
}

$spaAdmin = new SpaAdmin();
$durations = $spaAdmin->getServiceDurations($_GET['service_id']);

echo json_encode($durations);
?>