<?php
session_start();
require_once 'db_connection.php';
require_once 'appointments.php';
require_once 'clients.php';
require_once 'services.php';

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Instanciar clases
$appointment = new Appointment();
$client = new Client();
$service = new Service();

// Procesar filtros
$filters = [];
if (isset($_GET['fecha'])) {
    $filters['start_date'] = $_GET['fecha'];
    $filters['end_date'] = $_GET['fecha'];
}
if (isset($_GET['estado'])) {
    $filters['status'] = $_GET['estado'];
}

// Obtener citas
$appointments = $appointment->getAppointments($filters);

// Procesar cambios de estado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cambiar_estado'])) {
    $appointment->updateAppointmentStatus($_POST['id_cita'], $_POST['nuevo_estado']);
    header('Location: appointments.php');
    exit;
}

// Obtener datos para filtros
$allStatuses = ['pendiente', 'confirmada', 'completada', 'cancelada', 'no_show'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Citas - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --primary-color:rgb(65, 106, 109);
            --secondary-color:rgb(127, 161, 158);
            --light-color: #f5f5f5;
            --dark-color: #333;
        }
        
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }
        
        .badge-status {
            padding: 0.5em 0.75em;
            border-radius: 0.5rem;
            font-weight: 500;
        }
        
        .table-responsive {
                border-radius: 0.5rem;
    overflow: auto;
    height: 500px;
        }
        
        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .filter-section {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .status-select {
            border-radius: 0.5rem;
            padding: 0.375rem 0.75rem;
            border: 1px solid #ced4da;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <?php include 'navbar.php'; ?>
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="add_appointment.php" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nueva Cita
                        </a>
                    </div>
                </div>
                
                <!-- Filtros -->
                <div class="filter-section">
                    <form method="GET" class="row g-3">
                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="">Todos los estados</option>
                                <?php foreach ($allStatuses as $status): ?>
                                    <option value="<?php echo $status; ?>" 
                                        <?php echo (isset($_GET['estado']) && $_GET['estado'] === $status) ? 'selected' : ''; ?>>
                                        <?php echo ucfirst($status); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">
                                <i class="bi bi-funnel"></i> Filtrar
                            </button>
                            <a href="appointments.php" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                            </a>
                        </div>
                    </form>
                </div>
                
                <!-- Listado de citas -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Listado de Citas</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Cliente</th>
                                        <th>Servicio</th>
                                        <th>Fecha/Hora</th>
                                        <th>Duración</th>
                                        <th>Precio</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($appointments as $appt): ?>
                                    <tr>
                                        <td><?php echo $appt['id_cita']; ?></td>
                                        <td>
                                            <a href="clientes.php">
                                                <?php echo $appt['cliente_nombre']; ?>
                                            </a>
                                        </td>
                                        <td><?php echo $appt['servicio_nombre']; ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($appt['fecha_hora'])); ?></td>
                                        <td><?php echo $appt['duracion']; ?> min</td>
                                        <td>$<?php echo number_format($appt['precio'], 2); ?></td>
                                        <td>
                                            <span class="badge badge-status bg-<?php 
                                                switch($appt['estado']) {
                                                    case 'confirmada': echo 'success'; break;
                                                    case 'pendiente': echo 'warning'; break;
                                                    case 'completada': echo 'info'; break;
                                                    case 'cancelada': echo 'danger'; break;
                                                    case 'no_show': echo 'dark'; break;
                                                    default: echo 'secondary';
                                                }
                                            ?>">
                                                <?php echo ucfirst($appt['estado']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" 
                                                        id="dropdownMenuButton<?php echo $appt['id_cita']; ?>" 
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-gear"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $appt['id_cita']; ?>">
                                                    <li>
                                                        <a class="dropdown-item" href="appointment_details.php?id=<?php echo $appt['id_cita']; ?>">
                                                            <i class="bi bi-eye"></i> Ver Detalles
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="edit_appointment.php?id=<?php echo $appt['id_cita']; ?>">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form method="POST" style="display: inline;">
                                                            <input type="hidden" name="id_cita" value="<?php echo $appt['id_cita']; ?>">
                                                            <div class="dropdown-item">
                                                                <label for="nuevo_estado<?php echo $appt['id_cita']; ?>" class="form-label">Cambiar Estado:</label>
                                                                <select class="form-select form-select-sm status-select" name="nuevo_estado" 
                                                                        onchange="this.form.submit()">
                                                                    <?php foreach ($allStatuses as $status): ?>
                                                                        <option value="<?php echo $status; ?>" 
                                                                            <?php echo ($appt['estado'] === $status) ? 'selected' : ''; ?>>
                                                                            <?php echo ucfirst($status); ?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <input type="hidden" name="cambiar_estado" value="1">
                                                        </form>
                                                    </li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#" 
                                                           onclick="confirmDelete(<?php echo $appt['id_cita']; ?>)">
                                                            <i class="bi bi-trash"></i> Eliminar
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Resumen -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Total Citas</h6>
                                        <h3 class="card-text"><?php echo count($appointments); ?></h3>
                                    </div>
                                    <i class="bi bi-calendar3 fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Confirmadas</h6>
                                        <h3 class="card-text">
                                            <?php echo count(array_filter($appointments, function($a) { return $a['estado'] === 'confirmada'; })); ?>
                                        </h3>
                                    </div>
                                    <i class="bi bi-check-circle fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="card-title">Ingresos Hoy</h6>
                                        <h3 class="card-text">
                                            $<?php 
                                                $total = array_reduce($appointments, function($carry, $a) {
                                                    return $carry + ($a['estado'] === 'completada' ? $a['precio'] : 0);
                                                }, 0);
                                                echo number_format($total, 2);
                                            ?>
                                        </h3>
                                    </div>
                                    <i class="bi bi-cash-stack fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro que deseas eliminar esta cita? Esta acción no se puede deshacer.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a id="deleteLink" href="#" class="btn btn-danger">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        // Inicializar datepicker
        // Función para confirmar eliminación
        function confirmDelete(id) {
            const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
            document.getElementById('deleteLink').href = `delete_appointment.php?id=${id}`;
            modal.show();
        }
        
        // Actualizar estado automáticamente al cambiar
        document.querySelectorAll('select[name="nuevo_estado"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
        const sCitas = document.getElementById('s-citas');
        if (sCitas) {
            sCitas.classList.add('active');
        }
        const navTitle = document.querySelector('nav .navbar-brand');
        if (navTitle) {
            navTitle.textContent = 'Citas';
        }
    </script>
</body>
</html>