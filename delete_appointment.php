<?php
// Mostrar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connection.php';
require_once 'appointments.php';

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
   header('Location: login.php');
    exit;
}

// Verificar ID de cita
if (!isset($_GET['id'])) {
    header('Location: appointments.php');
    exit;
}

// Instanciar clase
$appointment = new Appointment();
echo "Se ha instanciado la clase Appointment correctamente.";
// Verificar si la cita existe
$cita = $appointment->getAppointment($_GET['id']);
if (!$cita) {
    header('Location: citas.php');
    exit;
}

// Verificar si el usuario tiene permiso para eliminar la cita
echo "ID de cita: " . $_GET['id'];

// Procesar eliminación directamente sin confirmación
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Eliminar cita
    $success = $appointment->deleteAppointment($_GET['id']);
    if ($success) {
        $_SESSION['success_message'] = "Cita eliminada exitosamente";
    } else {
        $_SESSION['error_message'] = "Error al eliminar la cita";
    }
    header('Location: citas.php');
    exit;
}
?>
