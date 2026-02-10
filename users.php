<?php
session_start();
require_once 'db_connection.php';

// Verificar autenticación y permisos de administrador

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllUsers()
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT id_usuario, nombre, apellidos, email FROM usuarios");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($nombre, $apellidos, $email, $password)
    {
        $conn = $this->db->connect();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nombre, $apellidos, $email, $hashedPassword]);
    }

    public function updateUser($id, $nombre, $apellidos, $email, $password = null)
    {
        $conn = $this->db->connect();
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellidos = ?, email = ?, password = ? WHERE id_usuario = ?");
            return $stmt->execute([$nombre, $apellidos, $email, $hashedPassword, $id]);
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellidos = ?, email = ? WHERE id_usuario = ?");
            return $stmt->execute([$nombre, $apellidos, $email, $id]);
        }
    }

    public function deleteUser($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
        return $stmt->execute([$id]);
    }

    public function getUserById($id)
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("SELECT id_usuario, nombre, apellidos, email FROM usuarios WHERE id_usuario = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

$user = new User();

// Procesar formularios
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['crear_usuario'])) {
        $success = $user->createUser($_POST['nombre'], $_POST['apellidos'], $_POST['email'], $_POST['password']);
        if ($success) {
            $message = "Usuario creado exitosamente";
            $messageType = "success";
        } else {
            $message = "Error al crear el usuario";
            $messageType = "danger";
        }
    } elseif (isset($_POST['actualizar_usuario'])) {
        $password = !empty($_POST['password']) ? $_POST['password'] : null;
        $success = $user->updateUser($_POST['id_usuario'], $_POST['nombre'], $_POST['apellidos'], $_POST['email'], $password);
        if ($success) {
            $message = "Usuario actualizado exitosamente";
            $messageType = "success";
        } else {
            $message = "Error al actualizar el usuario";
            $messageType = "danger";
        }
    } elseif (isset($_POST['eliminar_usuario'])) {
        $success = $user->deleteUser($_POST['id_usuario']);
        if ($success) {
            $message = "Usuario eliminado exitosamente";
            $messageType = "success";
        } else {
            $message = "Error al eliminar el usuario";
            $messageType = "danger";
        }
    }
}

// Obtener todos los usuarios
$users = $user->getAllUsers();

// Obtener usuario para editar si hay un ID en la URL
$editUser = null;
if (isset($_GET['editar'])) {
    $editUser = $user->getUserById($_GET['editar']);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color:rgb(65, 109, 102);
            --secondary-color: #a1887f;
            --light-color: #f5f5f5;
            --dark-color: #333;
        }
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

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

        .password-toggle {
            cursor: pointer;
        }

        .main-content {
            display: flex;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        <div class="main-content" style="background-color:#f8f9ff !important;">
            <?php include 'sidebar.php'; ?>

            <div class="container py-5">
                <main class="col-md-12 col-lg-12 px-md-4 py-4">
                    <?php include 'navbar.php'; ?>

                    <?php if (isset($message)): ?>
                        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Formulario para crear/editar usuario -->
                    <div class="form-section">
                        <h4><?php echo $editUser ? 'Editar Usuario' : 'Crear Nuevo Usuario'; ?></h4>
                        <form method="POST">
                            <?php if ($editUser): ?>
                                <input type="hidden" name="id_usuario" value="<?php echo $editUser['id_usuario']; ?>">
                            <?php endif; ?>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="<?php echo $editUser ? $editUser['nombre'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" id="apellidos" name="apellidos"
                                        value="<?php echo $editUser ? $editUser['apellidos'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="<?php echo $editUser ? $editUser['email'] : ''; ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">
                                        <?php echo $editUser ? 'Nueva Contraseña (dejar en blanco para no cambiar)' : 'Contraseña'; ?>
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password"
                                            <?php echo !$editUser ? 'required' : ''; ?>
                                            minlength="8"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_\-+=\[\]{};:,.<>?]).{8,}$"
                                            aria-describedby="passwordHelp"
                                            autocomplete="new-password"
                                        >
                                        <span class="input-group-text password-toggle" onclick="togglePassword()">
                                            <i class="bi bi-eye"></i>
                                        </span>
                                    </div>
                                    <div class="progress mt-2" style="height: 8px;">
                                        <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                                    </div>
                                    <small id="passwordHelp" class="form-text text-muted">
                                        La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un caracter especial.
                                    </small>
                                    <script>
                                        const passwordInput = document.getElementById('password');
                                        const strengthBar = document.getElementById('passwordStrengthBar');

                                        passwordInput.addEventListener('input', function() {
                                            const val = passwordInput.value;
                                            let strength = 0;

                                            if (val.length >= 8) strength++;
                                            if (/[A-Z]/.test(val)) strength++;
                                            if (/[a-z]/.test(val)) strength++;
                                            if (/\d/.test(val)) strength++;
                                            if (/[!@#$%^&*()_\-+=\[\]{};:,.<>?]/.test(val)) strength++;

                                            let percent = (strength / 5) * 100;
                                            let color = 'bg-danger';
                                            if (strength >= 4) color = 'bg-warning';
                                            if (strength === 5) color = 'bg-success';

                                            strengthBar.style.width = percent + '%';
                                            strengthBar.className = 'progress-bar ' + color;
                                        });
                                    </script>
                                </div>
                                <div class="col-12">
                                    <button type="submit" name="<?php echo $editUser ? 'actualizar_usuario' : 'crear_usuario'; ?>"
                                        class="btn btn-primary">
                                        <i class="bi bi-save"></i> <?php echo $editUser ? 'Actualizar Usuario' : 'Crear Usuario'; ?>
                                    </button>
                                    <?php if ($editUser): ?>
                                        <a href="users.php" class="btn btn-outline-secondary">Cancelar</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Listado de usuarios -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Listado de Usuarios</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Email</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo $user['id_usuario']; ?></td>
                                                <td><?php echo $user['nombre']; ?></td>
                                                <td><?php echo $user['apellidos']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="users.php?editar=<?php echo $user['id_usuario']; ?>"
                                                            class="btn btn-sm btn-outline-primary me-2">
                                                            <i class="bi bi-pencil"></i> Editar
                                                        </a>
                                                        <form method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                            <input type="hidden" name="id_usuario" value="<?php echo $user['id_usuario']; ?>">
                                                            <button type="submit" name="eliminar_usuario" class="btn btn-sm btn-outline-danger">
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
            // Función para mostrar/ocultar contraseña
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.querySelector('.password-toggle i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('bi-eye');
                    toggleIcon.classList.add('bi-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('bi-eye-slash');
                    toggleIcon.classList.add('bi-eye');
                }
            }

            // Cerrar alertas automáticamente después de 5 segundos
            window.setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);

            const sUsers = document.getElementById('s-users');
            if (sUsers) {
                sUsers.classList.add('active');
            }
            const navTitle = document.getElementById('navTitle');
            if (navTitle) {
                navTitle.textContent = 'Usuarios';
            }
        </script>
</body>

</html>