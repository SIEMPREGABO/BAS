<?php
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
    header('Location: citas.php');
    exit;
}

// Obtener datos de la cita
$appointment = new Appointment();
$cita = $appointment->getAppointment($_GET['id']);

if (!$cita) {
    header('Location: citas.php');
    exit;
}

// Formatear fecha y hora
$fecha = date('d/m/Y', strtotime($cita['fecha_hora']));
$hora = date('H:i', strtotime($cita['fecha_hora']));
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Cita - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
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

        .badge-status {
            padding: 0.5em 0.75em;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .detail-label {
            font-weight: 600;
            color: var(--primary-color);
        }

        #paymentModal .modal-dialog {
            max-width: 500px;
        }

        #paymentForm label {
            font-weight: 500;
        }

        #paymentForm .form-control,
        #paymentForm .form-select {
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Detalles de Cita #<?php echo $cita['id_cita']; ?></h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="citas.php" class="btn btn-outline-secondary me-2">
                            <i class="bi bi-arrow-left"></i> Volver
                        </a>
                        <a href="edit_appointment.php?id=<?php echo $cita['id_cita']; ?>" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Información de la Cita</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="detail-label">Cliente</p>
                                        <p><?php echo $cita['cliente_nombre']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="detail-label">Contacto</p>
                                        <p>
                                            <?php echo $cita['cliente_email']; ?><br>
                                            <?php echo $cita['cliente_telefono']; ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="detail-label">Servicio</p>
                                        <p><?php echo $cita['servicio_nombre']; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="detail-label">Duración</p>
                                        <p><?php echo $cita['duracion']; ?> minutos</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <p class="detail-label">Fecha y Hora</p>
                                        <p><?php echo $fecha; ?> a las <?php echo $hora; ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="detail-label">Estado</p>
                                        <p>
                                            <span class="badge badge-status bg-<?php
                                                                                switch ($cita['estado']) {
                                                                                    case 'confirmada':
                                                                                        echo 'success';
                                                                                        break;
                                                                                    case 'pendiente':
                                                                                        echo 'warning';
                                                                                        break;
                                                                                    case 'completada':
                                                                                        echo 'info';
                                                                                        break;
                                                                                    case 'cancelada':
                                                                                        echo 'danger';
                                                                                        break;
                                                                                    case 'no_show':
                                                                                        echo 'dark';
                                                                                        break;
                                                                                    default:
                                                                                        echo 'secondary';
                                                                                }
                                                                                ?>">
                                                <?php echo ucfirst($cita['estado']); ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <p class="detail-label">Precio</p>
                                        <p>$<?php echo number_format($cita['precio'], 2); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Notas Adicionales</h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($cita['notas'])): ?>
                                    <p><?php echo nl2br(htmlspecialchars($cita['notas'])); ?></p>
                                <?php else: ?>
                                    <p class="text-muted">No hay notas adicionales para esta cita.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Acciones Rápidas</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="tel:<?php echo $cita['cliente_telefono']; ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-telephone"></i> Llamar al Cliente
                                    </a>
                                    <a href="mailto:<?php echo $cita['cliente_email']; ?>" class="btn btn-outline-primary">
                                        <i class="bi bi-envelope"></i> Enviar Email
                                    </a>
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#paymentModal" data-cita-id="<?php echo $cita['id_cita']; ?>">
                                        <i class="bi bi-cash"></i> Registrar Pago
                                    </button>
                                    <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                                        <i class="bi bi-x-circle"></i> Cancelar Cita
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Historial de Cambios</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item">
                                        <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($cita['fecha_creacion'])); ?></small>
                                        <p class="mb-0">Cita creada</p>
                                    </div>
                                    <?php if (!empty($cita['fecha_actualizacion'])): ?>
                                        <div class="list-group-item">
                                            <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($cita['fecha_actualizacion'])); ?></small>
                                            <p class="mb-0">Última actualización</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal de Cancelación -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancelar Cita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro que deseas cancelar esta cita?</p>
                    <form id="cancelForm" method="POST" action="update_appointment_status.php">
                        <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
                        <input type="hidden" name="nuevo_estado" value="cancelada">
                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo de cancelación</label>
                            <textarea class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" form="cancelForm" class="btn btn-danger">Confirmar Cancelación</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Registrar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="paymentForm">
                        <input type="hidden" name="id_cita" id="id_cita">
                        <input type="hidden" name="id_cliente" id="id_cliente">

                        <div class="mb-3">
                            <label for="monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" class="form-control" id="monto" name="monto" required>
                        </div>

                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                <option value="">Seleccionar...</option>
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="transferencia">Transferencia</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="referencia" class="form-label">Referencia/Número</label>
                            <input type="text" class="form-control" id="referencia" name="referencia">
                        </div>

                        <div class="mb-3">
                            <label for="notas" class="form-label">Notas</label>
                            <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-success">Registrar Pago</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentModal = document.getElementById('paymentModal');

            paymentModal.addEventListener('show.bs.modal', async function(event) {
                const button = event.relatedTarget;
                const citaId = button.getAttribute('data-cita-id');

                document.getElementById('id_cita').value = citaId;

                // Obtener el ID del cliente de la cita
                try {
                    const response = await fetch(`get_appointment_details.php?id=${citaId}`);
                    const data = await response.json();

                    if (data.success && data.id_cliente) {
                        document.getElementById('id_cliente').value = data.id_cliente;
                    }
                } catch (error) {
                    console.error('Error al obtener detalles de la cita:', error);
                }
            });

            const paymentForm = document.getElementById('paymentForm');

            paymentForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...';

                try {
                    const formData = new FormData(this);
                    const response = await fetch('process_payment.php', {
                        method: 'POST',
                        body: formData
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Error en la respuesta del servidor');
                    }

                    if (data.success) {
                        // Mostrar notificación de éxito con Toast
                        showToast('success', 'Pago registrado correctamente');

                        // Cerrar el modal
                        bootstrap.Modal.getInstance(paymentModal).hide();

                        // Recargar la página después de 1 segundo
                        setTimeout(() => window.location.reload(), 1000);
                    } else {
                        throw new Error(data.message || 'Error al registrar el pago');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showToast('error', error.message);
                } finally {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Registrar Pago';
                }
            });
        });

        function showToast(type, message) {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();
            const toast = document.createElement('div');

            toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');
            toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;

            toastContainer.appendChild(toast);

            // Eliminar el toast después de 5 segundos
            setTimeout(() => toast.remove(), 5000);
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
            container.style.zIndex = '1100';
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>

</html>