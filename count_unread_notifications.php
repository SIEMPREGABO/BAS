<?php
require_once 'notifications.php';

header('Content-Type: application/json');

$notification = new Notification();

// No se necesita user_id porque solo hay un usuario
$count = $notification->countUnreadNotifications();

echo json_encode(['count' => $count]);
?>
