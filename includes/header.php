<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?php echo isset($pageTitle) ? $pageTitle . ' - Beauty & Soul' : 'Beauty & Soul'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/styles.css" />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <!-- GLightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox@3.3.0/dist/css/glightbox.min.css" />

</head>

<body>

    <!-- HEADER -->
    <header class="header">
        <div class="container header-grid">
            <nav class="nav-left">
                <a href="index.php" class="nav-link">INICIO</a>
                <a href="index.php#masajes" class="nav-link">MASAJES</a>
                <a href="index.php#faciales" class="nav-link">FACIALES</a>
            </nav>

            <div class="logo-center">
                <a href="index.php" class="logo-circle">
                    <img src="images/logoteal.png" alt="Beauty & Soul Logo" style="object-fit: cover; height: 100%; width: 100%;" />
                </a>
            </div>

            <nav class="nav-right">
                <button class="nav-link memberships-trigger" id="membresias-trigger" type="button" aria-haspopup="true" aria-expanded="false" aria-controls="membresias-subnav">
                    MEMBRESIAS <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>
                </button>
                <a href="nosotros.php" class="nav-link">NOSOTROS</a>
                <a href="index.php" class="nav-link nav-link-cta" id="header-agendar">AGENDAR CITA</a>
            </nav>

            <button class="menu-btn-mobile">☰</button>
        </div>

        <!-- Menú móvil -->
        <nav class="mobile-menu">
            <a href="index.php" class="mobile-nav-link">INICIO</a>
            <a href="index.php#masajes" class="mobile-nav-link">MASAJES</a>
            <a href="index.php#faciales" class="mobile-nav-link">FACIALES</a>
            <button class="mobile-nav-link mobile-memberships-trigger" id="mobile-membresias-trigger" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="memberships-mobile-modal">MEMBRESIAS</button>
            <a href="nosotros.php" class="mobile-nav-link">NOSOTROS</a>
            <a href="#" class="mobile-nav-link mobile-nav-link-cta" id="mobile-agendar">AGENDAR CITA</a>
        </nav>

        <div class="memberships-mobile-modal" id="memberships-mobile-modal" aria-hidden="true">
            <button class="memberships-mobile-backdrop" type="button" aria-label="Cerrar modal" data-close="memberships-mobile-modal"></button>
            <div class="memberships-mobile-sheet" role="dialog" aria-modal="true" aria-labelledby="memberships-mobile-title">
                <div class="memberships-mobile-header">
                    <h3 id="memberships-mobile-title">Membresías</h3>
                    <button class="memberships-mobile-close" type="button" aria-label="Cerrar" data-close="memberships-mobile-modal">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="memberships-mobile-content">
                    <div class="memberships-subnav-link-info memberships-subnav-link-main">
                        <strong>Conoce todos los planes y beneficios disponibles.</strong>
                        <small>Contactáme para más información</small>
                    </div>
                    <div class="memberships-subnav-link">
                        <strong>ARMONÍA</strong>
                        <span>3 servicios (a elegir facial o masaje) de 50 minutos.</span>
                    </div>
                    <div class="memberships-subnav-link">
                        <strong>ESENCIA</strong>
                        <span>3 masajes + 1 facial de regalo.</span>
                    </div>
                    <div class="memberships-subnav-link">
                        <strong>ALMA RADIANTE</strong>
                        <span>4 servicios (a elegir facial o masaje) de 80 min + 5to gratis.</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="memberships-subnav" id="membresias-subnav" aria-hidden="true">
            <div class="memberships-subnav-inner container">
                <div class="memberships-subnav-link-info memberships-subnav-link-main">
                    <!-- <strong>Ver Membresías</strong> -->
                    <strong>Conoce todos los planes y beneficios disponibles.</strong>
                    <small>Contactáme para más información</small>
                </div>
                <div class="memberships-subnav-link">
                    <strong>ARMONÍA</strong>
                    <span>3 servicios (a elegir facial o masaje) de 50 minutos.</span>
                </div>
                <div class="memberships-subnav-link">
                    <strong>ESENCIA</strong>
                    <span>3 masajes + 1 facial de regalo.</span>
                </div>
                <div class="memberships-subnav-link">
                    <strong>ALMA RADIANTE</strong>
                    <span>4 servicios (a elegir facial o masaje) de 80 min + 5to gratis.</span>
                </div>
            </div>
        </div>
    </header>