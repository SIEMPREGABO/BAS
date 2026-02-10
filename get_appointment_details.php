<?php
require_once 'payments.php';

header('Content-Type: application/json');

$appointmentId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$appointmentId) {
    echo json_encode(['success' => false, 'message' => 'ID de cita inválido']);
    exit;
}

$payment = new Payment();
$clientId = $payment->getClientIdFromAppointment($appointmentId);

if ($clientId) {
    echo json_encode(['success' => true, 'id_cliente' => $clientId]);
} else {
    echo json_encode(['success' => false, 'message' => 'No se encontró la cita o no tiene cliente asociado']);
}
?>