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

// Obtener clientes y servicios
$clients = $client->getClients();
$services = $service->getServices();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id_cliente' => $_POST['id_cliente'],
        'id_servicio' => $_POST['id_servicio'],
        'duracion' => $_POST['duracion'],
        'fecha' => $_POST['fecha'],
        'hora' => $_POST['hora'],
        'fecha_hora' => $_POST['fecha'] . ' ' . $_POST['hora'],
        'estado' => 'confirmada',
        'notas' => $_POST['notas'],
        'duration_type' => $_POST['duracion'] . 'min'
    ];
    
    // Verificar disponibilidad
    if ($appointment->checkAvailability($data['fecha_hora'], $data['duracion'])) {
        $result = $appointment->createAppointment($data);
        if ($result) {
            $_SESSION['success_message'] = "Cita creada exitosamente con ID: $result";
            header('Location: citas.php');
            exit;
        } else {
            $error = "Error al crear la cita";
        }
    } else {
        $error = "El horario seleccionado no está disponible";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cita - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --primary-color:rgb(65, 106, 109);
            --secondary-color:rgb(127, 153, 161);
        }
        body {
            font-family: 'Poppins', sans-serif;
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
        
        .container-fluid {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <?php include 'navbar.php'; ?>
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
                                        <option value="" selected disabled>Seleccionar cliente</option>
                                        <?php foreach ($clients as $client): ?>
                                            <option value="<?php echo $client['id_cliente']; ?>">
                                                <?php echo $client['nombre']; ?> (<?php echo $client['email']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_servicio" class="form-label">Servicio</label>
                                    <select class="form-select" id="id_servicio" name="id_servicio" required>
                                        <option value="" selected disabled>Seleccionar servicio</option>
                                        <?php foreach ($services as $service): 
                                            $has50 = !is_null($service['duracion_50min']);
                                            $has80 = !is_null($service['duracion_80min']);
                                            $has90 = !is_null($service['duracion_90min']);
                                        ?>
                                            <option value="<?php echo $service['id_servicio']; ?>"
                                                data-duracion50="<?php echo $has50 ? '1' : '0'; ?>"
                                                data-duracion80="<?php echo $has80 ? '1' : '0'; ?>"
                                                data-duracion90="<?php echo $has90 ? '1' : '0'; ?>">
                                                <?php echo $service['nombre']; ?> (<?php echo $service['categoria']; ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="duracion" class="form-label">Duración</label>
                                    <select class="form-select" id="duracion" name="duracion" required>
                                        <option value="" selected disabled>Seleccionar duración</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="fecha" class="form-label">Fecha</label>
                                    <input type="date" class="form-control" id="fecha" name="fecha" required
                                           min="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="hora" class="form-label">Hora</label>
                                    <select class="form-select" id="hora" name="hora" required>
                                        <option value="" selected disabled>Seleccionar hora</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="notas" class="form-label">Notas Adicionales</label>
                                <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-calendar-plus"></i> Agendar Cita
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
            const servicioSelect = document.getElementById('id_servicio');
            const duracionSelect = document.getElementById('duracion');
            const fechaInput = document.getElementById('fecha');
            const horaSelect = document.getElementById('hora');
            
            // Actualizar duraciones disponibles cuando se selecciona un servicio
            servicioSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                
                // Limpiar opciones anteriores
                duracionSelect.innerHTML = '<option value="" selected disabled>Seleccionar duración</option>';
                
                // Agregar opciones según disponibilidad
                if (selectedOption.getAttribute('data-duracion50') === '1') {
                    const option = document.createElement('option');
                    option.value = '50';
                    option.textContent = '50 minutos';
                    duracionSelect.appendChild(option);
                }
                
                if (selectedOption.getAttribute('data-duracion80') === '1') {
                    const option = document.createElement('option');
                    option.value = '80';
                    option.textContent = '80 minutos';
                    duracionSelect.appendChild(option);
                }
                
                if (selectedOption.getAttribute('data-duracion90') === '1') {
                    const option = document.createElement('option');
                    option.value = '90';
                    option.textContent = '90 minutos';
                    duracionSelect.appendChild(option);
                }
            });
            
            // Generar horas disponibles cuando se selecciona fecha
            fechaInput.addEventListener('change', function() {
                if (!this.value) return;
                
                // Determinar si es sábado o domingo
                const fecha = new Date(this.value);
                const diaSemana = fecha.getDay(); // 0=domingo, 6=sábado
                
                // Limpiar opciones anteriores
                horaSelect.innerHTML = '<option value="" selected disabled>Seleccionar hora</option>';
                
                // Generar horarios según el día
                let horasDisponibles = [];
                
                if (diaSemana === 5) { // Sábado
                    // De 17:00 a 20:30 en intervalos de 30 minutos
                    for (let hora = 17; hora <= 20; hora++) {
                        for (let minuto = (hora === 17 ? 0 : 0); minuto < 60; minuto += 30) {
                            if (hora === 20 && minuto > 0) continue; // No pasar de 20:30
                            horasDisponibles.push(
                                `${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}:00`
                            );
                        }
                    }
                } else if (diaSemana === 6) { // Domingo
                    // De 10:00 a 20:00 en intervalos de 30 minutos
                    for (let hora = 10; hora <= 20; hora++) {
                        for (let minuto = 0; minuto < 60; minuto += 30) {
                            if (hora === 20 && minuto > 0) continue; // No pasar de 20:00
                            horasDisponibles.push(
                                `${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}:00`
                            );
                        }
                    }
                } else {
                    // No es fin de semana
                    horaSelect.innerHTML = '<option value="" disabled>Seleccione un sábado o domingo</option>';
                    return;
                }
                
                // Agregar horas disponibles al select
                horasDisponibles.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = hora.substring(0, 5); // Mostrar solo HH:MM
                    horaSelect.appendChild(option);
                });
            });
            
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
        });
        const navTitle = document.querySelector('nav .navbar-brand');
        if (navTitle) {
            navTitle.textContent = 'Nueva Cita';
        }
        const sCitas = document.getElementById('s-citas');
        if (sCitas) {
            sCitas.classList.add('active');
        }
    </script>
</body>
</html>