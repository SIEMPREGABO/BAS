<?php
require_once 'notifications.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit;
}

$notification = new Notification();
$success = $notification->updateNotificationStatus($data['id'], 'leída');

echo json_encode(['success' => $success]);
?>