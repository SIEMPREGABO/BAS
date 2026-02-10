<?php
// Iniciar sesión y verificar autenticación
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db_connection.php';
require_once 'clients.php';
require_once 'services.php';
require_once 'appointments.php';
require_once 'memberships.php';
require_once 'payments.php';
require_once 'reports.php';

// Instanciar clases
$client = new Client();
$service = new Service();
$appointment = new Appointment();
$membership = new Membership();
$payment = new Payment();
$report = new Report();

// Obtener datos para el dashboard
$totalClients = count($client->getClients());
$totalServices = count($service->getServices());
$todayAppointments = $appointment->getAppointments([
    'start_date' => date('Y-m-d'),
    'end_date' => date('Y-m-d'),
    'status' => 'confirmada'
]);
$upcomingAppointments = $appointment->getAppointments([
    'start_date' => date('Y-m-d'),
    'status' => 'confirmada',
    'limit' => 5
]);
$recentClients = array_slice($client->getClients(), 0, 5);
$activeMemberships = $membership->getClientMemberships(null, true);
$paymentStats = $payment->getPaymentSummary(date('Y-m-01'), date('Y-m-d'));
$appointmentStats = $report->getAppointmentReport(date('Y-m-01'), date('Y-m-d'));
$popularServices = $report->getServicePopularityReport(date('Y-m-01'), date('Y-m-d'));

$serviceNames = array_column($popularServices, 'servicio');
$serviceCounts = array_column($popularServices, 'total_citas');
$serviceColors = generateChartColors(count($popularServices));

function generateChartColors($count)
{
    $baseColors = [
        '#4e73df',
        '#1cc88a',
        '#36b9cc',
        '#f6c23e',
        '#e74a3b',
        '#6610f2',
        '#6f42c1',
        '#fd7e14',
        '#20c997',
        '#17a2b8'
    ];

    if ($count <= count($baseColors)) {
        return array_slice($baseColors, 0, $count);
    }

    return array_merge($baseColors);
}
// Obtener datos del mes actual
$currentMonthData = $payment->getFormattedMonthlyTotal();

// Obtener datos del mes anterior para comparación
$lastMonth = date('m', strtotime('first day of last month'));
$lastYear = date('Y', strtotime('first day of last month'));
$lastMonthData = $payment->getFormattedMonthlyTotal($lastYear, $lastMonth);

// Calcular diferencia porcentual
$difference = 0;
if ($lastMonthData['total'] > 0) {
    $difference = (($currentMonthData['total'] - $lastMonthData['total']) / $lastMonthData['total']) * 100;
}
$trendClass = $difference >= 0 ? 'text-success' : 'text-danger';
$trendIcon = $difference >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beauty Soul Spa - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        :root {
            --primary-color:rgb(65, 102, 109);
            --secondary-color: #a1887f;
            --light-color: #f5f5f5;
            --dark-color: #333;
        }

        body {
            background-color: #f8f9ff;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: transform 0.2s, box-shadow 0.2s;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .badge-status {
            padding: 0.5em 0.75em;
            border-radius: 0.5rem;
            font-weight: 500;
        }

        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .table th {
            background-color: var(--primary-color);
            color: white;
            border: none;
        }

        .table td {
            vertical-align: middle;
        }

        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 1.5rem;
        }

        .main-content {
            display: flex;
        }

        .stat-card {
            border-radius: 0.5rem;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            font-size: 1.5rem;
            width: 3rem;
            height: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(246, 194, 62, 0.2);
        }

        .stat-value {
            font-weight: 700;
            margin: 0.5rem 0;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .text-warning {
            color: #f6c23e !important;
        }

        .bg-success-light {
            background-color: rgba(40, 167, 69, 0.2) !important;
            color: #28a745 !important;
        }

        .bg-danger-light {
            background-color: rgba(220, 53, 69, 0.2) !important;
            color: #dc3545 !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->


        <!-- Main content -->

        <!-- Top navbar -->

        <div class="main-content" style="background-color:#f8f9ff !important;">
            <?php include 'sidebar.php'; ?>

            <div class="container py-5">
                <?php include 'navbar.php'; ?>
                <!-- Stats cards -->
                <div class="row mb-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-icon">
                                        <i class="bi bi-people"></i>
                                    </div>
                                </div>
                                <div class="stat-value h2"><?php echo $totalClients; ?></div>
                                <div class="stat-label text-muted">Clientes</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-icon">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                </div>
                                <div class="stat-value h2"><?php echo count($todayAppointments); ?></div>
                                <div class="stat-label text-muted">Citas Hoy</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-icon">
                                        <i class="bi bi-collection"></i>
                                    </div>
                                </div>
                                <div class="stat-value h2"><?php echo $totalServices; ?></div>
                                <div class="stat-label text-muted">Servicios</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="stat-card card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="stat-icon text-warning">
                                        <i class="bi bi-currency-dollar"></i>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-<?php echo $difference >= 0 ? 'success' : 'danger'; ?>-light">
                                            <i class="bi <?php echo $trendIcon; ?>"></i> <?php echo round(abs($difference), 2); ?>%
                                        </span>
                                    </div>
                                </div>
                                <div class="stat-value h2">$<?php echo $currentMonthData['formatted']; ?></div>
                                <div class="stat-label text-muted">Ingresos del Mes</div>
                                <div class="mt-2 small">
                                    <span class="text-muted">
                                        <i class="bi bi-receipt"></i> <?php echo $currentMonthData['count']; ?> transacciones
                                    </span>
                                    <span class="float-end text-muted">
                                        Mes anterior: $<?php echo number_format($lastMonthData['total'], 2); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Charts Row
                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Ingresos Mensuales</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Servicios más populares</h6>
                                <small class="text-muted"><?php echo date('F Y'); ?></small>
                            </div>
                            <div class="card-body">
                                <div class="chart-pie pt-4 pb-2">
                                    <canvas id="servicesChart" height="300"></canvas>
                                </div>
                                <div class="mt-4 text-center small">
                                    <?php foreach ($popularServices as $index => $service): ?>
                                        <span class="mr-3">
                                            <i class="fas fa-circle" style="color: <?php echo $serviceColors[$index]; ?>"></i>
                                            <?php echo $service['servicio']; ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Tables Row -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Próximas Citas</h5>
                                    <a href="citas.php" class="btn btn-sm btn-primary">Ver todas</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Cliente</th>
                                                <th>Fecha</th>
                                                <th>Servicio</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($upcomingAppointments as $appt): ?>
                                                <tr>
                                                    <td><?php echo $appt['cliente_nombre']; ?></td>
                                                    <td><?php echo date('d/m H:i', strtotime($appt['fecha_hora'])); ?></td>
                                                    <td><?php echo $appt['servicio_nombre']; ?></td>
                                                    <td>
                                                        <span class="badge badge-status bg-<?php
                                                                                            switch ($appt['estado']) {
                                                                                                case 'confirmada':
                                                                                                    echo 'success';
                                                                                                    break;
                                                                                                case 'pendiente':
                                                                                                    echo 'warning';
                                                                                                    break;
                                                                                                case 'cancelada':
                                                                                                    echo 'danger';
                                                                                                    break;
                                                                                                default:
                                                                                                    echo 'secondary';
                                                                                            }
                                                                                            ?>">
                                                            <?php echo ucfirst($appt['estado']); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Clientes Recientes</h5>
                                    <a href="clientes.php" class="btn btn-sm btn-primary">Ver todos</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Teléfono</th>
                                                <th>Registro</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentClients as $client): ?>
                                                <tr>
                                                    <td><?php echo $client['nombre']; ?></td>
                                                    <td><?php echo $client['email']; ?></td>
                                                    <td><?php echo $client['telefono']; ?></td>
                                                    <td><?php echo date('d/m/Y', strtotime($client['fecha_registro'])); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Info Row 
                <div class="row mt-4">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Membresías Activas</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="mb-0"><?php echo count($activeMemberships); ?></h4>
                                    <i class="bi bi-credit-card-2-front fs-1 text-primary"></i>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <p class="mb-0"><small>Renovaciones este mes: 12</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Métodos de Pago</h5>
                            </div>
                            <div class="card-body">
                                <div class="chart-container">
                                    <canvas id="paymentMethodsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Actividad Reciente</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-calendar-check text-success me-3"></i>
                                        <div>
                                            <small class="text-muted">Hace 10 min</small>
                                            <p class="mb-0">Nueva cita reservada</p>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-cash text-primary me-3"></i>
                                        <div>
                                            <small class="text-muted">Hace 1 hora</small>
                                            <p class="mb-0">Pago recibido #1234</p>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-person-plus text-info me-3"></i>
                                        <div>
                                            <small class="text-muted">Hoy</small>
                                            <p class="mb-0">Nuevo cliente registrado</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <script>
        // Revenue Chart (Ingresos Mensuales desde PHP)
        <?php
        // Obtener ingresos mensuales del año actual
        $monthlyRevenue = array_fill(1, 12, 0);
        $currentYear = date('Y');
        $db = (new Database())->connect();
        $stmt = $db->prepare("
            SELECT MONTH(fecha_pago) as mes, SUM(monto) as total
            FROM Pagos
            WHERE YEAR(fecha_pago) = :year AND estado = 'completado'
            GROUP BY mes
            ");
        $stmt->bindValue(':year', $currentYear, PDO::PARAM_INT);
        $stmt->execute();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $monthlyRevenue[(int)$row['mes']] = (float)$row['total'];
        }
        ?>
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                datasets: [{
                    label: 'Ingresos',
                    data: <?php echo json_encode(array_values($monthlyRevenue)); ?>,
                    backgroundColor: 'rgba(78, 115, 223, 0.8)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Services Chart


        // Payment Methods Chart
        const paymentMethodsCtx = document.getElementById('paymentMethodsChart').getContext('2d');
        const paymentMethodsChart = new Chart(paymentMethodsCtx, {
            type: 'pie',
            data: {
                labels: ['Efectivo', 'Tarjeta Crédito', 'Tarjeta Débito', 'Transferencia'],
                datasets: [{
                    data: [45, 30, 15, 10],
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9',
                        '#17a673',
                        '#2c9faf',
                        '#dda20a'
                    ],
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.createElement('button');
            toggleBtn.className = 'btn btn-primary position-fixed';
            toggleBtn.style.top = '10px';
            toggleBtn.style.left = '10px';
            toggleBtn.style.zIndex = '1000';
            toggleBtn.innerHTML = '<i class="bi bi-list"></i>';
            toggleBtn.onclick = function() {
                sidebar.classList.toggle('active');
            };
            document.body.appendChild(toggleBtn);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener datos de PHP
            const serviceData = {
                labels: <?php echo json_encode($serviceNames); ?>,
                counts: <?php echo json_encode($serviceCounts); ?>,
                colors: <?php echo json_encode($serviceColors); ?>
            };

            // Configurar gráfico
            const servicesCtx = document.getElementById('servicesChart').getContext('2d');
            const servicesChart = new Chart(servicesCtx, {
                type: 'doughnut',
                data: {
                    labels: serviceData.labels,
                    datasets: [{
                        data: serviceData.counts,
                        backgroundColor: serviceData.colors,
                        hoverBackgroundColor: serviceData.colors.map(color => shadeColor(color, -20)),
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false,
                            position: 'bottom'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: ${value} citas (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '70%'
                }
            });

            // Función para oscurecer colores (efecto hover)
            function shadeColor(color, percent) {
                let R = parseInt(color.substring(1, 3), 16);
                let G = parseInt(color.substring(3, 5), 16);
                let B = parseInt(color.substring(5, 7), 16);

                R = parseInt(R * (100 + percent) / 100);
                G = parseInt(G * (100 + percent) / 100);
                B = parseInt(B * (100 + percent) / 100);

                R = (R < 255) ? R : 255;
                G = (G < 255) ? G : 255;
                B = (B < 255) ? B : 255;

                R = Math.round(R);
                G = Math.round(G);
                B = Math.round(B);

                const RR = ((R.toString(16).length == 1) ? "0" + R.toString(16) : R.toString(16));
                const GG = ((G.toString(16).length == 1) ? "0" + G.toString(16) : G.toString(16));
                const BB = ((B.toString(16).length == 1) ? "0" + B.toString(16) : B.toString(16));

                return "#" + RR + GG + BB;
            }
        });

        // Añadir la clase 'active' al elemento del sidebar con id 's-dashboard'
        const sDashboard = document.getElementById('s-dashboard');
        if (sDashboard) {
            sDashboard.classList.add('active');
        }
    </script>
</body>

</html>