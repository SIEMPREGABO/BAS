<?php
require_once 'spa_admin.php';
$spaAdmin = new SpaAdmin();

// Obtener servicios disponibles
$services = $spaAdmin->getActiveServices();

// Procesar el formulario si se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationData = array(
        'nombre' => $_POST['nombre'],
        'email' => $_POST['email'],
        'telefono' => $_POST['telefono'],
        'id_servicio' => $_POST['servicio'],
        'duracion' => $_POST['duracion'],
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'notas' => $_POST['notas']
    );
    
    $result = $spaAdmin->createReservation($reservationData);
    
    if ($result['success']) {
        $successMessage = "¡Reservación confirmada! Tu número de reservación es: {$result['reservation_id']}";
    } else {
        $errorMessage = $result['message'];
    }
}

// Obtener fechas disponibles (próximos 2 fines de semana)
$availableDates = array();
for ($i = 0; $i < 14; $i++) {
    $date = date('Y-m-d', strtotime("+$i days"));
    $dayOfWeek = date('N', strtotime($date));
    if ($dayOfWeek == 6 || $dayOfWeek == 7) { // Sábado o domingo
        $availableDates[] = $date;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservaciones - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .reservation-form {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-title {
            color: #6d4c41;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn-spa {
            background-color: #a1887f;
            border-color: #8d6e63;
            color: white;
        }
        .btn-spa:hover {
            background-color: #8d6e63;
            color: white;
        }
        .form-control:focus {
            border-color: #a1887f;
            box-shadow: 0 0 0 0.25rem rgba(161, 136, 127, 0.25);
        }
        .alert-success {
            background-color: #d7ccc8;
            border-color: #bcaaa4;
            color: #3e2723;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="reservation-form">
                    <h2 class="form-title">Reserva tu Servicio</h2>
                    
                    <?php if (isset($successMessage)): ?>
                        <div class="alert alert-success"><?php echo $successMessage; ?></div>
                    <?php elseif (isset($errorMessage)): ?>
                        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    
                    <form id="reservationForm" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="nombre" class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-md-6">
                                <label for="servicio" class="form-label">Servicio</label>
                                <select class="form-select" id="servicio" name="servicio" required>
                                    <option value="" selected disabled>Selecciona un servicio</option>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?php echo $service['id_servicio']; ?>">
                                            <?php echo $service['nombre']; ?> (<?php echo $service['categoria']; ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="duracion" class="form-label">Duración</label>
                                <select class="form-select" id="duracion" name="duracion" required>
                                    <option value="" selected disabled>Selecciona duración</option>
                                    <!-- Se llena dinámicamente con JavaScript -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="fecha" class="form-label">Fecha</label>
                                <select class="form-select" id="fecha" name="fecha" required>
                                    <option value="" selected disabled>Selecciona fecha</option>
                                    <?php foreach ($availableDates as $date): ?>
                                        <option value="<?php echo $date; ?>">
                                            <?php echo date('l, d F Y', strtotime($date)); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="hora" class="form-label">Hora</label>
                                <select class="form-select" id="hora" name="hora" required>
                                    <option value="" selected disabled>Selecciona hora</option>
                                    <!-- Se llena dinámicamente con JavaScript -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="notas" class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" id="notas" name="notas" rows="1"></textarea>
                            </div>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-spa btn-lg">Confirmar Reservación</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const servicioSelect = document.getElementById('servicio');
            const duracionSelect = document.getElementById('duracion');
            const fechaSelect = document.getElementById('fecha');
            const horaSelect = document.getElementById('hora');
            
            // Cargar duraciones cuando se selecciona un servicio
            servicioSelect.addEventListener('change', function() {
                const serviceId = this.value;
                if (!serviceId) return;
                
                fetch(`get_service_durations.php?service_id=${serviceId}`)
                    .then(response => response.json())
                    .then(data => {
                        duracionSelect.innerHTML = '<option value="" selected disabled>Selecciona duración</option>';
                        
                        for (const [duration, text] of Object.entries(data.durations)) {
                            const option = document.createElement('option');
                            option.value = duration;
                            option.textContent = text;
                            if (duration === data.default.replace('min', '')) {
                                option.selected = true;
                            }
                            duracionSelect.appendChild(option);
                        }
                    });
            });
            
            // Cargar horarios disponibles cuando se selecciona una fecha
            fechaSelect.addEventListener('change', function() {
                const fecha = this.value;
                if (!fecha) return;
                
                fetch(`get_available_slots.php?fecha=${fecha}`)
                    .then(response => response.json())
                    .then(slots => {
                        horaSelect.innerHTML = '<option value="" selected disabled>Selecciona hora</option>';
                        
                        slots.forEach(slot => {
                            const option = document.createElement('option');
                            option.value = slot;
                            option.textContent = slot;
                            horaSelect.appendChild(option);
                        });
                    });
            });
            
            // Inicializar datepicker para selección de fecha
            flatpickr("#fecha", {
                locale: "es",
                minDate: "today",
                dateFormat: "Y-m-d",
                disable: [
                    function(date) {
                        // Deshabilitar todos los días excepto sábado y domingo
                        return (date.getDay() !== 6 && date.getDay() !== 0);
                    }
                ]
            });
        });
    </script>
</body>
</html>