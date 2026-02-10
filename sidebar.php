<style>
    #sidebar {
        background: #ea2f5e;
        min-height: 100vh;

        width: 15%;

    }

    #sidebar .nav-link {
        color: rgb(255, 255, 255);
        padding: 0.85rem 1.2rem;
        margin-bottom: 0.3rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
    }

    #sidebar .nav-link:hover,
    #sidebar .nav-link.active {
        background: #f8f9ff;
        color: #3a4d47 !important;
        border-radius: 50px 0 0 50px;
    }

    #sidebar .nav-link.active i,
    #sidebar .nav-link:hover i {
        color: rgb(0, 0, 0);
    }

    #sidebar .nav-link i {
        margin-right: 0.7rem;
        color: rgb(255, 255, 255);
        font-size: 1.2rem;
    }

    #sidebar .text-center img {
        border-radius: 50%;
        padding: 0.5rem;
    }

    #sidebar .position-sticky {
        padding-top: 2rem;
    }

    .btn-primary {
        background: #ea2f5e !important;
        font-weight: 600 !important;
        border-radius: 50px !important;
        padding: 0.5rem 1rem !important;
        border: none !important;
    }

    .btn-primary:hover {
        background: #f6c23e !important;
        color: #fff !important;
    }
</style>

<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3 d-flex flex-column" style="height: 100vh;">
        <div class="text-center mb-4">
            <img src="images/logoW.png" alt="Beauty Soul Spa" width="80%" class="img-fluid">
            <h5 class="text-white mt-2">Beauty & Soul</h5>
            <p class="text-white">Bienvenid@, <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></p>
        </div>
        <ul class="nav flex-column flex-grow-1">
            <li class="nav-item">
                <a class="nav-link" id="s-dashboard" href="dashboard.php">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="s-citas" href="citas.php">
                    <i class="bi bi-calendar-check"></i> Citas
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="s-clientes" href="clientes.php">
                    <i class="bi bi-people"></i> Clientes
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="s-users" href="users.php">
                    <i class="bi bi-person-lines-fill"></i> Usuarios
                </a>
            </li>
            <!-- Más elementos aquí -->
        </ul>
        <div class="mt-auto mb-3">
            <a href="logout.php" class="nav-link">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
        </div>
    </div>
</nav>