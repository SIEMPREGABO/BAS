<?php
session_start();
require_once 'db_connection.php';
require_once 'appointments.php';
require_once 'clients.php';
require_once 'services.php';

// Verificar autenticación
//if (!isset($_SESSION['usuario'])) {
//    header('Location: login.php');
 //   exit;
//}

// Verificar ID de cita
if (!isset($_GET['id'])) {
    header('Location: citas.php');
    exit;
}

// Instanciar clases
$appointment = new Appointment();
$client = new Client();
$service = new Service();

// Obtener datos de la cita
$cita = $appointment->getAppointment($_GET['id']);
if (!$cita) {
    header('Location: appointments.php');
    exit;
}

// Obtener clientes y servicios
$clients = $client->getClients();
$services = $service->getServices();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_cita' => $_GET['id'],
        'id_cliente' => $_POST['id_cliente'],
        'id_servicio' => $_POST['id_servicio'],
        'fecha_hora' => $_POST['fecha'] . ' ' . $_POST['hora'],
        'duracion' => $_POST['duracion'],
        'estado' => $_POST['estado'],
        'notas' => $_POST['notas']
    ];
    
    // Verificar disponibilidad (excepto para la misma cita)
    $isAvailable = $appointment->checkAvailability($data['fecha_hora'], $data['duracion'], $_GET['id']);
    
    if ($isAvailable) {
        $success = $appointment->updateAppointment($data);
        if ($success) {
            $_SESSION['success_message'] = "Cita actualizada exitosamente";
            header('Location: appointments.php');
            exit;
        } else {
            $error = "Error al actualizar la cita";
        }
    } else {
        $error = "El horario seleccionado no está disponible";
    }
}

// Extraer fecha y hora por separado
$fecha = date('Y-m-d', strtotime($cita['fecha_hora']));
$hora = date('H:i:s', strtotime($cita['fecha_hora']));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --primary-color: #6d4c41;
            --secondary-color: #a1887f;
        }
        
        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
    </style>
</head>
<body>

    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Editar Cita #<?php echo $cita['id_cita']; ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="citas.php" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Datos de la Cita</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_cliente" class="form-label">Cliente</label>
                                    <select class="form-select" id="id_cliente" name="id_cliente" required>
                                        <?php foreach ($clients as $cli): ?>
                                            <option value="<?php echo $cli['id_cliente']; ?>" 
                                                <?php echo ($cli['id_cliente'] == $cita['id_cliente']) ? 'selected' : ''; ?>>
                                                <?php echo $cli['nombre']; ?> (<?php echo $cli['email']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_servicio" class="form-label">Servicio</label>
                                    <select class="form-select" id="id_servicio" name="id_servicio" required>
                                        <?php foreach ($services as $serv): 
                                            $has50 = !is_null($serv['duracion_50min']);
                                            $has80 = !is_null($serv['duracion_80min']);
                                            $has90 = !is_null($serv['duracion_90min']);
                                        ?>
                                            <option value="<?php echo $serv['id_servicio']; ?>"
                                                data-duracion50="<?php echo $has50 ? '1' : '0'; ?>"
                                                data-duracion80="<?php echo $has80 ? '1' : '0'; ?>"
                                                data-duracion90="<?php echo $has90 ? '1' : '0'; ?>"
                                                <?php echo ($serv['id_servicio'] == $cita['id_servicio']) ? 'selected' : ''; ?>>
                                                <?php echo $serv['nombre']; ?> (<?php echo $serv['categoria']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="duracion" class="form-label">Duración (min)</label>
                                    <input type="number" class="form-control" id="duracion" name="duracion" 
                                           value="<?php echo $cita['duracion']; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" 
                                           value="<?php echo $fecha; ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="hora" class="form-label">Hora</label>
                                    <input type="time" class="form-control" id="hora" name="hora" 
                                           value="<?php echo substr($hora, 0, 5); ?>" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="pendiente" <?php echo ($cita['estado'] == 'pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                                        <option value="confirmada" <?php echo ($cita['estado'] == 'confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                                        <option value="completada" <?php echo ($cita['estado'] == 'completada') ? 'selected' : ''; ?>>Completada</option>
                                        <option value="cancelada" <?php echo ($cita['estado'] == 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                                        <option value="no_show" <?php echo ($cita['estado'] == 'no_show') ? 'selected' : ''; ?>>No Show</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notas" class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" id="notas" name="notas" rows="3"><?php echo $cita['notas']; ?></textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar datepicker
            flatpickr("#fecha", {
                locale: "es",
                dateFormat: "Y-m-d",
                minDate: "today",
                disable: [
                    function(date) {
                        // Deshabilitar todos los días excepto sábado y domingo
                        return (date.getDay() !== 0 && date.getDay() !== 6);
                    }
                ]
            });
            
            // Inicializar timepicker
            flatpickr("#hora", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                minuteIncrement: 30,
                minTime: "10:00",
                maxTime: "20:00"
            });
        });
    </script>
</body>
</html>