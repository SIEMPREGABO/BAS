<?php
require_once 'conn/conexion.php';

// Inicializar variables
$mensaje_exito = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar y sanitizar datos
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $servicio_id = filter_input(INPUT_POST, 'servicio', FILTER_VALIDATE_INT);
        $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);
        $hora = filter_input(INPUT_POST, 'hora', FILTER_SANITIZE_STRING);
        $duracion = filter_input(INPUT_POST, 'duracion', FILTER_SANITIZE_STRING);
        $mensaje = filter_input(INPUT_POST, 'mensaje', FILTER_SANITIZE_STRING);

        // Validaciones básicas
        if (empty($nombre) || empty($email) || empty($telefono) || !$servicio_id || empty($fecha) || empty($hora) || empty($duracion)) {
            throw new Exception("Todos los campos obligatorios deben ser completados");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo electrónico no es válido");
        }

        // Validar fecha y hora
        $fecha_hora = new DateTime("$fecha $hora");
        $dia_semana = $fecha_hora->format('w'); // 0=domingo, 6=sábado
        $hora_num = (int)$fecha_hora->format('H') + ((int)$fecha_hora->format('i') / 60);

        // Validar horarios permitidos
        if ($dia_semana == 6) { // Sábado
            if ($hora_num < 17.5 || $hora_num >= 20) {
                throw new Exception("Los sábados solo se aceptan citas entre 5:30pm y 8:00pm");
            }
        } elseif ($dia_semana == 0) { // Domingo
            if ($hora_num < 10 || $hora_num >= 20) {
                throw new Exception("Los domingos solo se aceptan citas entre 10:00am y 8:00pm");
            }
        } else {
            throw new Exception("Solo se aceptan citas los sábados y domingos");
        }

        // Verificar disponibilidad
        $fecha_hora_str = $fecha_hora->format('Y-m-d H:i:s');
        $hora_fin = clone $fecha_hora;
        $hora_fin->add(new DateInterval("PT{$duracion}M"));
        $hora_fin_str = $hora_fin->format('Y-m-d H:i:s');

        $stmt = $conn->prepare("SELECT COUNT(*) FROM citas 
                              WHERE fecha_hora < ? AND 
                              DATE_ADD(fecha_hora, INTERVAL duracion MINUTE) > ?");
        $stmt->execute([$hora_fin_str, $fecha_hora_str]);
        $citas_solapadas = $stmt->fetchColumn();

        if ($citas_solapadas > 0) {
            throw new Exception("El horario seleccionado no está disponible. Por favor elige otro.");
        }

        // Obtener precio según duración
        $campo_precio = "precio_{$duracion}min";
        $stmt = $conn->prepare("SELECT $campo_precio FROM servicios WHERE id_servicio = ?");
        $stmt->execute([$servicio_id]);
        $precio = $stmt->fetchColumn();

        if (!$precio) {
            throw new Exception("Error al obtener el precio del servicio seleccionado");
        }

        // Iniciar transacción
        $conn->beginTransaction();

        try {
            // Insertar o actualizar cliente
            $stmt = $conn->prepare("INSERT INTO clientes (nombre, email, telefono) 
                                  VALUES (:nombre, :email, :telefono)
                                  ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), telefono = VALUES(telefono)");
            $stmt->execute([':nombre' => $nombre, ':email' => $email, ':telefono' => $telefono]);

            $cliente_id = $conn->lastInsertId() ?: $conn->query("SELECT id_cliente FROM clientes WHERE email = '$email'")->fetchColumn();

            // Insertar cita
            $stmt = $conn->prepare("INSERT INTO citas (id_cliente, id_servicio, fecha_hora, duracion, precio, notas) 
                                  VALUES (:id_cliente, :id_servicio, :fecha_hora, :duracion, :precio, :notas)");
            $stmt->execute([
                ':id_cliente' => $cliente_id,
                ':id_servicio' => $servicio_id,
                ':fecha_hora' => $fecha_hora_str,
                ':duracion' => $duracion,
                ':precio' => $precio,
                ':notas' => $mensaje
            ]);

            // Insertar pago
            $stmt = $conn->prepare("INSERT INTO pagos (id_cita, id_cliente, monto, metodo_pago, estado) 
                                  VALUES (:id_cita, :id_cliente, :monto, 'efectivo', 'pendiente')");
            $stmt->execute([
                ':id_cita' => $conn->lastInsertId(),
                ':id_cliente' => $cliente_id,
                ':monto' => $precio
            ]);

            // Insertar notificación
            $servicio_nombre = $conn->query("SELECT nombre FROM servicios WHERE id_servicio = $servicio_id")->fetchColumn();
            $mensaje_notificacion = "Confirmación: Cita para $servicio_nombre el " . 
                                  $fecha_hora->format('d/m/Y') . " a las " . $fecha_hora->format('H:i');

            $stmt = $conn->prepare("INSERT INTO notificaciones (id_cliente, tipo, mensaje, metodo, estado) 
                                  VALUES (:id_cliente, 'recordatorio_cita', :mensaje, 'email', 'pendiente')");
            $stmt->execute([
                ':id_cliente' => $cliente_id,
                ':mensaje' => $mensaje_notificacion
            ]);

            $conn->commit();

            $mensaje_exito = "¡Tu cita ha sido agendada con éxito para el " . 
                            $fecha_hora->format('d/m/Y') . " a las " . $fecha_hora->format('H:i') . 
                            ". Te hemos enviado un correo de confirmación.";

        } catch (Exception $e) {
            $conn->rollBack();
            throw $e;
        }

    } catch (Exception $e) {
        $error = $e->getMessage();
        error_log("Error al procesar reserva: " . $error);
    }
}

// Redireccionar con mensajes
$query_params = [];
if (!empty($mensaje_exito)) {
    $query_params['success'] = urlencode($mensaje_exito);
} elseif (!empty($error)) {
    $query_params['error'] = urlencode($error);
}

header('Location: ../index.php' . (!empty($query_params) ? '?' . http_build_query($query_params) : ''));
exit;
?>