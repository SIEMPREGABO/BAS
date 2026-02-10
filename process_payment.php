<?php
require_once 'payments.php';
require_once 'notifications.php';

header('Content-Type: application/json');

// Validar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Recoger y sanitizar datos del formulario
$data = [
    'id_cita' => filter_input(INPUT_POST, 'id_cita', FILTER_VALIDATE_INT),
    'id_membresia' => null,
    'id_cliente' => filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT),
    'monto' => filter_input(INPUT_POST, 'monto', FILTER_VALIDATE_FLOAT),
    'metodo_pago' => filter_input(INPUT_POST, 'metodo_pago', FILTER_SANITIZE_STRING),
    'estado' => 'completado',
    'referencia' => filter_input(INPUT_POST, 'referencia', FILTER_SANITIZE_STRING),
    'notas' => filter_input(INPUT_POST, 'notas', FILTER_SANITIZE_STRING),
    'fecha_pago' => date('Y-m-d H:i:s')
];

// Validación más robusta
$errors = [];
if (!$data['id_cita']) {
    $errors[] = 'ID de cita inválido';
}
if (!$data['monto'] || $data['monto'] <= 0) {
    $errors[] = 'Monto inválido';
}
if (empty($data['metodo_pago'])) {
    $errors[] = 'Método de pago requerido';
}

if (!empty($errors)) {
    error_log('Errores de validación: ' . implode(', ', $errors));
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

try {
    // Registrar el pago
    $payment = new Payment();
    $paymentId = $payment->recordPayment($data);

    if (!$paymentId) {
        throw new Exception('No se pudo registrar el pago');
    }

    error_log('Pago registrado correctamente. ID: ' . $paymentId);

    // Crear notificación solo si hay un cliente asociado
    if ($data['id_cliente']) {
        $notification = new Notification();
        $notificationData = [
            'id_cliente' => $data['id_cliente'],
            'tipo' => 'pago',
            'mensaje' => 'Pago recibido por $' . number_format($data['monto'], 2),
            'fecha_envio' => date('Y-m-d H:i:s'),
            'metodo' => 'sistema',
            'estado' => 'pendiente'
        ];
        
        if (!$notification->createNotification($notificationData)) {
            error_log('Advertencia: No se pudo crear la notificación para el pago ' . $paymentId);
        }
    }

    echo json_encode(['success' => true, 'payment_id' => $paymentId]);
    
} catch (Exception $e) {
    error_log('Error al registrar el pago: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al registrar el pago: ' . $e->getMessage()]);
}
?>