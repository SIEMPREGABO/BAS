<?php
session_start();

// Incluir el archivo de conexión a la base de datos
require_once 'db_connection.php';

// Crear instancia de la base de datos y obtener conexión
$database = new Database();
$conn = $database->connect();

// Verificar si ya está autenticado
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y sanitizar entradas
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    
    try {
        // Verificar si el usuario existe
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            $_SESSION['error_message'] = "Usuario no encontrado";
        } else {
            // Verificar contraseña
            if (password_verify($password, $result['password'])) {
                $_SESSION['user_id'] = $result['id_usuario'];
                $_SESSION['user_name'] = $result['nombre'] . ' ' . $result['apellido'];
                $_SESSION['user_email'] = $result['email'];
                
                // Regenerar ID de sesión para seguridad
                session_regenerate_id(true);
                
                header('Location: dashboard.php');
                exit;
            } else {
                $_SESSION['error_message'] = "Contraseña incorrecta";
            }
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error en el sistema. Por favor intente más tarde.";
        // Para desarrollo puedes mostrar el error, en producción quita esta línea
        error_log("Error de base de datos: " . $e->getMessage());
    }
}

// Limpiar mensajes de error después de mostrarlos
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión | Beauty Soul Spa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500&family=Playfair+Display:wght@400;500&display=swap">
    <style>
        :root {
            --spa-primary: #e8f4f8;
            --spa-secondary: #d1e7e6;
            --spa-accent: #a7c4bc;
            --spa-dark: #5e8b7e;
            --spa-text: #2d4a43;
            --spa-light: #f8f9fa;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--spa-primary);
            color: var(--spa-text);
            background-image: url('https://images.unsplash.com/photo-1544161515-4ab6ce6db874?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
            animation: fadeIn 0.8s ease-in-out;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
        }
        
        .card-header {
            background: linear-gradient(135deg, var(--spa-accent), var(--spa-dark));
            color: white;
            font-family: 'Playfair Display', serif;
            text-align: center;
            padding: 1.5rem;
            border-bottom: none;
        }
        
        .card-body {
            padding: 2rem;
        }
        
        .form-control {
            border: 1px solid var(--spa-secondary);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s;
            background-color: var(--spa-light);
        }
        
        .form-control:focus {
            border-color: var(--spa-accent);
            box-shadow: 0 0 0 0.25rem rgba(167, 196, 188, 0.25);
        }
        
        .btn-spa {
            background: linear-gradient(135deg, var(--spa-accent), var(--spa-dark));
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .btn-spa:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(94, 139, 126, 0.3);
        }
        
        .logo {
            font-size: 2rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo i {
            margin-right: 10px;
            font-size: 2.2rem;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
        
        .forgot-password a {
            color: var(--spa-dark);
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        
        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--spa-secondary);
        }
        
        .divider-text {
            padding: 0 10px;
            color: var(--spa-text);
            font-size: 0.9rem;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .social-btn:hover {
            transform: translateY(-3px);
        }
        
        .facebook {
            background-color: #3b5998;
        }
        
        .google {
            background-color: #db4437;
        }
        
        .apple {
            background-color: #000000;
        }
        
        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.95rem;
        }
        
        .register-link a {
            color: var(--spa-dark);
            font-weight: 500;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .input-group-text {
            background-color: var(--spa-secondary);
            border: 1px solid var(--spa-secondary);
            color: var(--spa-dark);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="card">
                <div class="card-header">
                    <div class="logo">
                        <img src="images/logoW.png" alt="Beauty Soul Spa" width="80px" class="logo-beauty-soul">
                    </div>
                    <h2>Bienvenid@ de nuevo</h2>
                    <p class="mb-0">Ingresa tus credenciales para acceder</p>
                </div>
                <div class="card-body">
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $error_message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" id="loginForm">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="tucorreo@ejemplo.com">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required placeholder="••••••••">
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label" for="rememberMe">Recordarme</label>
                        </div>
                        
                        <button type="submit" class="btn btn-spa mb-3">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación básica del formulario
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                alert('Por favor completa todos los campos');
            }
        });
    </script>
</body>
</html>