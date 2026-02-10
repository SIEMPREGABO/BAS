<?php
session_start();
require_once 'clients.php'; // Cambiado para usar la clase Client de clients.php

// Verificar autenticación y permisos de administrador
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$client = new Client();

// Procesar formularios
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear_cliente'])) {
        $data = [
            'nombre' => $_POST['nombre'],
            'email' => $_POST['email'],
            'telefono' => $_POST['telefono'],
            'notas' => $_POST['notas'],
            'preferencias' => $_POST['preferencias'],
            'recibir_promociones' => isset($_POST['recibir_promociones']) ? 1 : 0
        ];
        
        $success = $client->createClient($data);
        if ($success) {
            $message = "Cliente creado exitosamente";
            $messageType = "success";
        } else {
            $message = "Error al crear el cliente";
            $messageType = "danger";
        }
    } elseif (isset($_POST['actualizar_cliente'])) {
        $data = [
            'nombre' => $_POST['nombre'],
            'email' => $_POST['email'],
            'telefono' => $_POST['telefono'],
            'notas' => $_POST['notas'],
            'preferencias' => $_POST['preferencias'],
            'recibir_promociones' => isset($_POST['recibir_promociones']) ? 1 : 0
        ];
        
        $success = $client->updateClient($_POST['id_cliente'], $data);
        if ($success) {
            $message = "Cliente actualizado exitosamente";
            $messageType = "success";
        } else {
            $message = "Error al actualizar el cliente";
            $messageType = "danger";
        }
    } elseif (isset($_POST['eliminar_cliente'])) {
        $success = $client->deleteClient($_POST['id_cliente']);
        if ($success) {
            $message = "Cliente eliminado exitosamente";
            $messageType = "success";
        } else {
            $message = "Error al eliminar el cliente";
            $messageType = "danger";
        }
    }
}

// Obtener todos los clientes
$clients = $client->getClients();

// Obtener cliente para editar si hay un ID en la URL
$editClient = null;
if (isset($_GET['editar'])) {
    $editClient = $client->getClient($_GET['editar']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Clientes - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #6d4c41;
            --secondary-color: #a1887f;
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

        .table-responsive {
            border-radius: 0.5rem;
            overflow: auto;
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

        .form-section {
            background-color: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.1rem;
        }

        .promo-badge {
            padding: 0.35em 0.65em;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .main-content {
            display: flex;
        }
        .wrapper{
            display: flex;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <div class="main-content" style="background-color:#f8f9ff !important;">
            <div class="container py-5">
                <main class="col-md-12 col-lg-12 px-md-4 py-4">
                    <?php include 'navbar.php'; ?>

                    <?php if ($message): ?>
                        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario para crear/editar cliente -->
                    <div class="form-section">
                        <h4><?php echo $editClient ? 'Editar Cliente' : 'Crear Nuevo Cliente'; ?></h4>
                        <form method="POST">
                            <?php if ($editClient): ?>
                                <input type="hidden" name="id_cliente" value="<?php echo $editClient['id_cliente']; ?>">
                            <?php endif; ?>

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="<?php echo $editClient ? htmlspecialchars($editClient['nombre']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo $editClient ? htmlspecialchars($editClient['email']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" class="form-control" id="telefono" name="telefono"
                                        value="<?php echo $editClient ? htmlspecialchars($editClient['telefono']) : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Recibir Promociones</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="recibir_promociones" name="recibir_promociones"
                                            <?php echo ($editClient && $editClient['recibir_promociones']) ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="recibir_promociones">
                                            Cliente acepta recibir promociones
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="preferencias" class="form-label">Preferencias</label>
                                    <textarea class="form-control" id="preferencias" name="preferencias" 
                                              rows="2"><?php echo $editClient ? htmlspecialchars($editClient['preferencias']) : ''; ?></textarea>
                                    <small class="text-muted">Ej: Masajes suaves, productos sin perfume, etc.</small>
                                </div>
                                <div class="col-md-6">
                                    <label for="notas" class="form-label">Notas Adicionales</label>
                                    <textarea class="form-control" id="notas" name="notas" 
                                              rows="2"><?php echo $editClient ? htmlspecialchars($editClient['notas']) : ''; ?></textarea>
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex">
                                <button type="submit" name="<?php echo $editClient ? 'actualizar_cliente' : 'crear_cliente'; ?>"
                                    class="btn btn-primary me-md-2">
                                    <i class="bi bi-save"></i> <?php echo $editClient ? 'Actualizar Cliente' : 'Crear Cliente'; ?>
                                </button>
                                <?php if ($editClient): ?>
                                    <a href="clientes.php" class="btn btn-outline-secondary">Cancelar</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>

                    <!-- Listado de clientes -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Listado de Clientes</h5>
                            <div>
                                <span class="badge bg-light text-dark">
                                    Total: <?php echo count($clients); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>Registro</th>
                                            <th>Promociones</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($clients as $cliente): ?>
                                            <tr>
                                                <td>
                                                    <div class="client-avatar">
                                                        <?php echo strtoupper(substr($cliente['nombre'], 0, 1)); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong><?php echo htmlspecialchars($cliente['nombre']); ?></strong>
                                                </td>
                                                <td><?php echo htmlspecialchars($cliente['email']); ?></td>
                                                <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                                                <td>
                                                    <?php 
                                                        $fecha = new DateTime($cliente['fecha_registro']);
                                                        echo $fecha->format('d/m/Y');
                                                    ?>
                                                </td>
                                                <td>
                                                    <span class="promo-badge bg-<?php echo $cliente['recibir_promociones'] ? 'success' : 'secondary'; ?>">
                                                        <?php echo $cliente['recibir_promociones'] ? 'Sí' : 'No'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="clientes.php?editar=<?php echo $cliente['id_cliente']; ?>"
                                                            class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                        <form method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este cliente?');">
                                                            <input type="hidden" name="id_cliente" value="<?php echo $cliente['id_cliente']; ?>">
                                                            <button type="submit" name="eliminar_cliente" class="btn btn-sm btn-outline-danger">
                                                                <i class="bi bi-trash"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Cerrar alertas automáticamente después de 5 segundos
        window.setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Marcar como activo el menú de clientes
        const sClients = document.getElementById('s-clientes');
        if (sClients) {
            sClients.classList.add('active');
        }
        
        // Actualizar título de la barra de navegación
        const navTitle = document.getElementById('navTitle');
        if (navTitle) {
            navTitle.textContent = 'Clientes';
        }
        
        // Función para buscar clientes
        function searchClients() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.querySelector('.table');
            const rows = table.getElementsByTagName('tr');
            
            for (let i = 1; i < rows.length; i++) { // Comenzar desde 1 para omitir el encabezado
                const cells = rows[i].getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length; j++) {
                    const cell = cells[j];
                    if (cell) {
                        if (cell.textContent.toLowerCase().indexOf(filter) > -1) {
                            found = true;
                            break;
                        }
                    }
                }
                
                rows[i].style.display = found ? '' : 'none';
            }
        }
        
        // Agregar evento de búsqueda
        document.getElementById('searchInput').addEventListener('keyup', searchClients);
    </script>
</body>
</html>