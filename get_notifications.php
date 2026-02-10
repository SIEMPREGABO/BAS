<?php
require_once 'notifications.php';

header('Content-Type: application/json');

$notification = new Notification();

$notifications = $notification->getClientNotifications(null, 5); // null o un valor fijo si es necesario

echo json_encode(array_filter($notifications, function($n) {
    return $n['estado'] === 'pendiente'; // Solo notificaciones no leídas
}));
?>
