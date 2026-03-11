<?php $pageTitle = "Inicio"; ?>
<?php include 'includes/header.php'; ?>

<?php
// Mostrar todos los errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar el log
error_log("Iniciando procesamiento del formulario de reserva");
?>


<!-- HERO -->
<!-- <section class="hero">
    <div class="container hero-content">
        <h2>Belleza que inspira tu bienestar</h2>
        <p>Relájate y renueva con nuestros tratamientos.</p>
        <button class="btn-primary pulse" id="open-reserva" type="button">Reserva ahora</button>
    </div>

    
</section> -->

<section class="hero">
    <video class="hero-video" autoplay loop muted playsinline preload="metadata" poster="images/portada-fallback.jpg">
        <source src="images/Portada.mp4" type="video/mp4">
        Tu navegador no soporta video HTML5.
    </video>

    <div class="hero-overlay"></div>

    <div class="container hero-content">
        <h1>Renueva tu cuerpo y alma</h1>
        <br>
        <p>Experiencias únicas de relajación y bienestar
        </p>
        <br>
        <button class="btn-primary pulse" id="open-reserva" type="button">Reserva ahora</button>
    </div>
</section>

<!-- SERVICIOS -->
<section id="masajes" class="section">
    <div class="container">
        <h3 class="section-title">Nuestros masajes</h3>

        <div class="carousel">
            <button class="carousel-btn prev" type="button" aria-label="Anterior">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="carousel-track">
                <?php
                $services = [
                    ['Masaje', 'Relajante', '<i class="fa-solid fa-hot-tub-person"></i>', ['50 min', '80 min'], ['$250', '$300']],
                    ['Masaje', 'Descontracturante', '<i class="fa-solid fa-hand-back-fist"></i>', ['50 min', '80 min'], ['$250', '$300']],
                    ['Masaje', 'Sueco', '<i class="fa-solid fa-person-swimming"></i>', ['50 min', '80 min'], ['$250', '$300']],
                    ['Masaje', 'Terapéutico', '<i class="fa-solid fa-heart-pulse"></i>', ['50 min', '80 min'], ['$300', '$350']],
                    ['Masaje', 'Deportivo', '<i class="fa-solid fa-dumbbell"></i>', ['50 min', '80 min'], ['$300', '$350']],
                    ['Masaje', 'Con Ventosas', '<i class="fa-solid fa-hand-sparkles"></i>', ['50 min', '80 min'], ['$300', '$350']],
                    ['Masaje', 'Drenaje Linfático', '<i class="fa-solid fa-water"></i>', ['50 min', '80 min'], ['$250', '$300']],
                ];

                foreach ($services as $index => $service):
                    $serviceName = $service[0] . ' ' . $service[1];
                ?>
                    <div class="card carousel-card service-card-container">
                        <div class="icon"><?= $service[2] ?></div>
                        <h4><?= $service[0] ?></h4>
                        <p><?= $service[1] ?></p>

                        <div class="service-float-section">
                            <!-- <h6><i class="fa-solid fa-clock"></i> Duración y Precio</h6> -->
                            <div class="service-pricing-list">
                                <?php
                                $durations = $service[3];
                                $prices = $service[4];
                                for ($i = 0; $i < count($durations); $i++):
                                ?>
                                    <div class="service-pricing-item"
                                        data-service="<?= htmlspecialchars($serviceName) ?>"
                                        data-duration="<?= htmlspecialchars($durations[$i]) ?>"
                                        role="button"
                                        tabindex="0">
                                        <span class="service-duration">
                                            <i class="fa-solid fa-clock"></i> <?= $durations[$i] ?>
                                        </span>
                                        <!-- <span class="service-arrow">→</span> -->
                                        <span class="service-price-value">
                                            <i class="fa-solid fa-tag"></i> <?= $prices[$i] ?>
                                        </span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <a href="#" class="btn-link service-more-link glightbox-link"
                            data-service="<?= htmlspecialchars($serviceName) ?>"
                            data-gallery="gallery-<?= $index ?>">
                            <i class="fa-solid fa-images"></i> Ver galería
                        </a>

                        <!-- Galería de imágenes (ocultas) -->
                        <div class="service-gallery" style="display: none;" data-gallery-id="gallery-<?= $index ?>">
                            <!-- Placeholder images - Reemplazar con imágenes reales -->
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+1"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 1"></a>
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+2"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 2"></a>
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+3"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 3"></a>
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+4"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 4"></a>
                        </div>

                        <!-- <a href="#" class="btn-link service-more-btn" data-service="<?= $index ?>">Ver más</a> -->

                        <!-- Card flotante -->
                        <!-- <div class="service-float-card" id="service-card-<?= $index ?>">
                                <button class="service-float-close" aria-label="Cerrar"><i class="fa-solid fa-x"></i></button>
                                <h5 class="service-float-title"><?= $service[0] ?> <?= $service[1] ?></h5>

                                <div class="service-float-section">
                                    <h6><i class="fa-solid fa-clock"></i> Duración</h6>
                                    <div class="service-options">
                                        <?php foreach ($service[3] as $duration): ?>
                                            <span class="service-option"><?= $duration ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="service-float-section">
                                    <h6><i class="fa-solid fa-tag"></i> Precio</h6>
                                    <div class="service-options">
                                        <?php foreach ($service[4] as $price): ?>
                                            <span class="service-option service-price"><?= $price ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div> -->
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-btn next" type="button" aria-label="Siguiente">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- FACIALES -->
<section id="faciales" class="section bg-soft">
    <div class="container">
        <h3 class="section-title" style="color: white;">Tratamientos Faciales</h3>

        <div class="facial-two-column-layout">
            <!-- Columna del Video -->

            <div class="facial-video-column">
                <!-- <div class="facial-video-container">
                    <video class="facial-video" autoplay loop muted playsinline>
                        <source src="images/Faciales.mp4" type="video/mp4">
                        Tu navegador no soporta el elemento de video.
                    </video>
                </div> -->

                <h1 class="Butler-Light" style="color: white; opacity:1;font-weight: 400; text-align: center;">
                    Hoy mereces consentirte con nuestros faciales

                </h1>

                <div>

                    <h4 class="dosis" style="color: white; opacity:1;font-weight: 400;text-align: center;">
                        ¡Prueba cualquiera


                    </h4>
                    <h4 class="dosis" style="color: white; opacity:1;font-weight: 400; text-align: center;">

                        de nuestros 9 tipos de faciales!
                    </h4>
                </div>


            </div>

            <!-- Columna de Información -->
            <div class="facial-info-column">
                <div class="facial-selector-container">
                    <div class="facial-description-card">
                        <div class="form-group">
                            <label for="facial-select" class="facial-label">
                                <i class="fa-solid fa-spa"></i> Selecciona un tratamiento facial
                            </label>
                            <select id="facial-select" class="facial-select">
                                <option value="8" data-description="Elimina impurezas, puntos negros y células muertas." data-duration="90 min" data-price="$300" selected>Limpieza Facial Profunda</option>
                                <option value="9" data-description="Aporta hidratación profunda y devuelve luminosidad." data-duration="90 min" data-price="$300">Hidratante</option>
                                <option value="10" data-description="Estimula la producción de colágeno y suaviza líneas de expresión." data-duration="90 min" data-price="$350">Antiedad</option>
                                <option value="11" data-description="Trata el acné y previene futuras imperfecciones." data-duration="90 min" data-price="$300">Antiacné</option>
                                <option value="12" data-description="Restaura, nutre y revitaliza la piel." data-duration="90 min" data-price="$300">Regenerante</option>
                                <option value="13" data-description="Mejora la firmeza y elasticidad del rostro." data-duration="90 min" data-price="$300">Reafirmante</option>
                                <option value="14" data-description="Exfolia y renueva la superficie cutánea." data-duration="90 min" data-price="$350">Microdermoabrasión</option>
                                <option value="15" data-description="Tecnología de luz para combatir acné, manchas y arrugas." data-duration="90 min" data-price="$350">Fototerapia LED</option>
                                <option value="16" data-description="Estimula la circulación y reduce la retención de líquidos." data-duration="90 min" data-price="$350">Drenaje Facial</option>
                            </select>
                        </div>

                        <div id="facial-info" class="facial-info">
                            <h4 id="facial-name" class="facial-name"></h4>
                            <p id="facial-description" class="facial-description"></p>

                            <div class="facial-details">
                                <div class="facial-detail-item">
                                    <i class="fa-solid fa-clock"></i>
                                    <span id="facial-duration"></span>
                                </div>
                                <div class="facial-detail-item">
                                    <i class="fa-solid fa-tag"></i>
                                    <span id="facial-price"></span>
                                </div>
                            </div>

                            <button class="btn-primary facial-reserve-btn" id="facial-reserve-btn" type="button">
                                <i class="fa-solid fa-calendar-check"></i> Reservar ahora
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRODUCTOS -->
<!-- <section class="section bg-light" id="membresias">
    <div class="container">
        <h3 class="section-title">Membresias</h3>
        <?php
        $membershipTypes = [

            ['ARMONÍA', '$750 MXN', ['Incluye 3 servicios de 50 minutos', 'Puedes elegir entre masaje o facial'], 6, 'images/armonia.png'],
            ['ESENCIA', '$550 MXN', ['Incluye 3 masajes a elegir', '1 facial de regalo'], 6, 'images/esencia.png'],
            ['ALMA RADIANTE', '$950 MXN', ['Incluye 4 servicios de 80 minutos', 'Puedes elegir entre masaje o facial', 'El 5to servicio es gratis'], 6, 'images/alma-radiante.png'],
        ];
        ?>
        <div class="grid grid-4">
            <?php for ($i = 0; $i < count($membershipTypes); $i++): ?>
                <div class="card product-card">
                    <div class="product-image"> <img style="height: 100%; width: 100%; object-fit: cover; border-radius: 8px;" src="<?php echo $membershipTypes[$i][4]; ?>" alt="<?php echo $membershipTypes[$i][0]; ?>"></div>
                    <h4><?php echo $membershipTypes[$i][0]; ?></h4>
                    <span class="price"><?php echo $membershipTypes[$i][1]; ?></span>
                    <?php if (!empty($membershipTypes[$i][2])): ?>
                        <?php for ($j = 0; $j < count($membershipTypes[$i][2]); $j++): ?>
                            <p class="detail"><?php echo $membershipTypes[$i][2][$j]; ?></p>
                        <?php endfor; ?>
                    <?php endif; ?>
                   
                </div>
            <?php endfor; ?>
        </div>
    </div>
</section> -->

<section id="masajes" class="section">
    <div class="container">
        <h3 class="section-title">Paquetes</h3>

        <div class="carousel">
            <button class="carousel-btn prev" type="button" aria-label="Anterior">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="carousel-track">
                <?php
                $services = [
                    ['Brisa de serenidad', ['Masaje Relajante', 'Facial hidratante', 'Reflexología de pies'], '<i class="fa-solid fa-hot-tub-person"></i>', ['120 min'], ['$750']],
                    ['Esencia radiante', ['Masaje revitalizante', 'Facial hidratante', 'Drenaje linfático'], '<i class="fa-solid fa-hand-back-fist"></i>', ['105 min'], ['$700']],
                    ['Detox & Equilibrio', ['Drenaje linfático', 'Facial limpieza profuda', 'Reflexología podal'], '<i class="fa-solid fa-person-swimming"></i>', ['120 min'], ['$800']],
                    ['Ritual cuerpo & alma', ['Masaje craneal', 'Facial armonizante', 'Reflexología podal', 'Envolvente ligera'], '<i class="fa-solid fa-heart-pulse"></i>', ['135 min'], ['$820']],
                    ['Día glow cumpleañera/o', ['Masaje relajante', 'Facial iluminador', 'Spa de manos'], '<i class="fa-solid fa-dumbbell"></i>', ['105 min'], ['700']],
                    ['Calma profunda', ['Masaje descontracturante', 'Facial refrescante', 'Drenaje linfático'], '<i class="fa-solid fa-hand-sparkles"></i>', ['120 min'], ['$750']],
                    ['Día zen express', ['Masaje corporal express', 'Facial oxigenante', 'Spa de manos'], '<i class="fa-solid fa-water"></i>', ['90 min'], ['$520']],
                    ['Mini ritual de amor', ['Masaje relajante', 'Facial express', 'Spa de manos'], '<i class="fa-solid fa-water"></i>', ['100 min'], ['$700']],

                ];

                foreach ($services as $index => $service):
                    //$serviceName = $service[0] . ' ' . $service[1];
                    $serviceName = $service[0];
                ?>
                    <div class="card carousel-card service-card-container-paquete">
                        <!-- <div class="icon"><?= $service[2] ?></div> -->
                        <h3><?= $service[0] ?></h3>
                        <?php
                        $masajesPaquete = $service[1];
                        for ($i = 0; $i < count($masajesPaquete); $i++):

                        ?>
                            <p><?= $masajesPaquete[$i] ?></p>

                        <?php endfor; ?>

                        <div class="service-float-section">
                            <!-- <h6><i class="fa-solid fa-clock"></i> Duración y Precio</h6> -->
                            <div class="service-pricing-list">
                                <?php
                                $durations = $service[3];
                                $prices = $service[4];
                                for ($i = 0; $i < count($durations); $i++):
                                ?>
                                    <div class="service-pricing-item-normal"
                                        data-service="<?= htmlspecialchars($serviceName) ?>"
                                        data-duration="<?= htmlspecialchars($durations[$i]) ?>"
                                        role="button"
                                        tabindex="0">
                                        <span class="service-duration">
                                            <i class="fa-solid fa-clock"></i> <?= $durations[$i] ?>
                                        </span>
                                        <!-- <span class="service-arrow">→</span> -->
                                        <span class="service-price-value">
                                            <i class="fa-solid fa-tag"></i> <?= $prices[$i] ?>
                                        </span>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <button
                            class="btn-primary small package-agendar-btn"
                            type="button"
                            data-service="<?= htmlspecialchars($serviceName) ?>"
                            data-duration="<?= htmlspecialchars($durations[0]) ?>"
                            data-is-package="1">
                            Agendar
                        </button>

                        <!-- <a href="#" class="btn-link service-more-link glightbox-link"
                            data-service="<?= htmlspecialchars($serviceName) ?>"
                            data-gallery="gallery-<?= $index ?>">
                            <i class="fa-solid fa-images"></i> Ver galería
                        </a> -->

                        <!-- Galería de imágenes (ocultas) -->
                        <div class="service-gallery" style="display: none;" data-gallery-id="gallery-<?= $index ?>">
                            <!-- Placeholder images - Reemplazar con imágenes reales -->
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+1"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 1"></a>
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+2"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 2"></a>
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+3"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 3"></a>
                            <a href="https://via.placeholder.com/800x600/d9a7a1/ffffff?text=<?= urlencode($serviceName) ?>+4"
                                class="glightbox"
                                data-gallery="gallery-<?= $index ?>"
                                data-title="<?= htmlspecialchars($serviceName) ?> - Imagen 4"></a>
                        </div>

                        <!-- <a href="#" class="btn-link service-more-btn" data-service="<?= $index ?>">Ver más</a> -->

                        <!-- Card flotante -->
                        <!-- <div class="service-float-card" id="service-card-<?= $index ?>">
                                <button class="service-float-close" aria-label="Cerrar"><i class="fa-solid fa-x"></i></button>
                                <h5 class="service-float-title"><?= $service[0] ?> <?= $service[1] ?></h5>

                                <div class="service-float-section">
                                    <h6><i class="fa-solid fa-clock"></i> Duración</h6>
                                    <div class="service-options">
                                        <?php foreach ($service[3] as $duration): ?>
                                            <span class="service-option"><?= $duration ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <div class="service-float-section">
                                    <h6><i class="fa-solid fa-tag"></i> Precio</h6>
                                    <div class="service-options">
                                        <?php foreach ($service[4] as $price): ?>
                                            <span class="service-option service-price"><?= $price ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div> -->
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-btn next" type="button" aria-label="Siguiente">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- GALERÍA DE FOTOS -->
<section class="section bg-light" id="galeria-paquetes">
    <div class="container">
        <h3 class="section-title">Fotos</h3>

        <div class="grid grid-3 package-gallery-grid">
            <a href="images/galeria1.jpeg" class="package-gallery-card glightbox" data-gallery="package-gallery">
                <img src="images/galeria1.jpeg" alt="Galería 1">
            </a>
            <a href="images/galeria2.jpeg" class="package-gallery-card glightbox" data-gallery="package-gallery">
                <img src="images/galeria2.jpeg" alt="Galería 2">
            </a>
            <a href="images/galeria3.jpeg" class="package-gallery-card glightbox" data-gallery="package-gallery">
                <img src="images/galeria3.jpeg" alt="Galería 3">
            </a>
            <a href="images/galeria4.jpeg" class="package-gallery-card glightbox" data-gallery="package-gallery">
                <img src="images/galeria4.jpeg" alt="Galería 4">
            </a>
            <a href="images/galeria5.jpeg" class="package-gallery-card glightbox" data-gallery="package-gallery">
                <img src="images/galeria5.jpeg" alt="Galería 5">
            </a>
            <a href="images/galeria6.jpeg" class="package-gallery-card glightbox" data-gallery="package-gallery">
                <img src="images/galeria6.jpeg" alt="Galería 6">
            </a>

            <a href="images/galeria7.jpeg" class="package-gallery-card package-gallery-more glightbox" data-gallery="package-gallery">
                <span>Ver más</span>
            </a>
        </div>

        <div style="display: none;" aria-hidden="true">
            <a href="images/galeria8.jpeg" class="glightbox" data-gallery="package-gallery"></a>
            <a href="images/galeria9.jpeg" class="glightbox" data-gallery="package-gallery"></a>
            <a href="images/galeria10.jpeg" class="glightbox" data-gallery="package-gallery"></a>
            <a href="images/galeria11.jpeg" class="glightbox" data-gallery="package-gallery"></a>
        </div>
    </div>
</section>


<!-- BENEFICIOS -->
<!-- <section class="section" id="beneficios">
    <div class="container">
        <div class="grid grid-3 center">
            <div class="feature">
                <span>✔</span>
                <p>Calidad Profesional</p>
            </div>
            <div class="feature">
                <span>🎧</span>
                <p>Atención Personalizada</p>
            </div>
            <div class="feature">
                <span>🌸</span>
                <p>Ambiente Relajante</p>
            </div>
        </div>
    </div>
</section> -->

<!-- TESTIMONIOS -->
<!-- <section class="section bg-soft" id="testimonios">
    <div class="container">
        <h3 class="section-title">Testimonios</h3>

        <div class="testimonial">
            <p>“Excelente servicio y un ambiente muy relajante.”</p>
            <span>— Laura M.</span>
        </div>
    </div>
</section> -->

<!-- CONTACTO -->
<section class="section contact-section">
    <div class="container contact-grid">
        <div>
            <h3 class="section-title contact-title">Contáctanos</h3>
            <p class="contact-intro">Estamos aquí para responder cualquier pregunta que tengas sobre nuestros servicios.</p>
            <ul class="contact-list">
                <li>
                    <span class="contact-icon"><i class="fa-solid fa-location-dot"></i></span>
                    <div>
                        <strong>Dirección</strong>
                        <p>Calle Olivo, La Isla, 54935 San Pablo de las Salinas, Méx.</p>
                    </div>
                </li>
                <li>
                    <span class="contact-icon"><i class="fa-solid fa-phone"></i></span>
                    <div>
                        <strong>Teléfono</strong>
                        <p>56 2576 4706</p>
                    </div>
                </li>
                <li>
                    <span class="contact-icon"><i class="fa-solid fa-envelope"></i></span>
                    <div>
                        <strong>Email</strong>
                        <p>reservaciones@beautyandsoul.com</p>
                    </div>
                </li>
                <li>
                    <span class="contact-icon"><i class="fa-solid fa-clock"></i></span>
                    <div>
                        <strong>Horario</strong>
                        <p>Sábados: 5:30pm a 8:00pm</p>
                        <p>Domingos: 10:00am a 06:00pm</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="contact-map">
            <iframe
                title="Mapa Beauty & Soul"
                src="https://www.google.com/maps?q=Calle%20Olivo%2C%20La%20Isla%2C%2054935%20San%20Pablo%20de%20las%20Salinas%2C%20M%C3%A9x.&output=embed"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</section>

<div class="modal<?= $_SERVER['REQUEST_METHOD'] === 'POST' ? ' is-open' : '' ?>" id="reserva-modal" aria-hidden="<?= $_SERVER['REQUEST_METHOD'] === 'POST' ? 'false' : 'true' ?>">
    <div class="modal-backdrop" data-close="modal"></div>
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="reserva-title">
        <?php
        // Procesar el formulario solo cuando se envía
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                require_once 'spa_admin.php';
                $spaAdmin = new SpaAdmin();

                $reservationData = array(
                    'nombre' => $_POST['nombre'] ?? '',
                    'email' => $_POST['email'] ?? '',
                    'telefono' => $_POST['telefono'] ?? '',
                    'id_servicio' => $_POST['servicio'] ?? '',
                    'duracion' => $_POST['duracion'] ?? '',
                    'fecha' => $_POST['fecha'] ?? '',
                    'hora' => $_POST['hora'] ?? '',
                    'notas' => $_POST['notas'] ?? ''
                );

                $result = $spaAdmin->createReservation($reservationData);

                if (!empty($result['success'])) {
                    echo '<div class="alert alert-success">¡Reservación confirmada! Tu número de reservación es: ' . $result['reservation_id'] . '</div>';
                } else {
                    $message = isset($result['message']) ? $result['message'] : 'No se pudo procesar la reservación.';
                    echo '<div class="alert alert-danger">' . $message . '</div>';
                }
            } catch (Throwable $e) {
                echo '<div class="alert alert-danger">Ocurrió un error al procesar la reservación.</div>';
            }
        }
        ?>

        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <script>
                document.body.classList.add('modal-open');
            </script>
        <?php endif; ?>

        <button class="modal-close" type="button" aria-label="Cerrar" data-close="modal"><i class="fa-solid fa-x"></i></button>
        <h3 class="modal-title" id="reserva-title">Reserva tu Servicio</h3>
        <form id="reserva-form" class="reserva-form" method="POST">
            <div class="form-section">
                <p class="form-section-title">Contacto del cliente</p>
                <div class="form-grid">
                    <input type="text" name="nombre" placeholder="Nombre Completo" required />
                    <input type="tel" name="telefono" placeholder="Teléfono" required />
                    <input class="full" type="email" name="email" placeholder="Correo Electrónico" required />
                </div>
            </div>
            <div class="form-section">
                <p class="form-section-title">Detalles del servicio</p>
                <div class="form-grid">
                    <select name="servicio" id="servicio-select" required>
                        <option value="">Selecciona un servicio</option>
                        <option value="17" data-is-package="1" data-duration="120 min">Brisa de serenidad (Paquete)</option>
                        <option value="18" data-is-package="1" data-duration="105 min">Esencia radiante (Paquete)</option>
                        <option value="19" data-is-package="1" data-duration="120 min">Detox &amp; Equilibrio (Paquete)</option>
                        <option value="20" data-is-package="1" data-duration="135 min">Ritual cuerpo &amp; alma (Paquete)</option>
                        <option value="21" data-is-package="1" data-duration="105 min">Día glow cumpleañera/o (Paquete)</option>
                        <option value="22" data-is-package="1" data-duration="120 min">Calma profunda (Paquete)</option>
                        <option value="23" data-is-package="1" data-duration="90 min">Día zen express (Paquete)</option>
                        <option value="24" data-is-package="1" data-duration="100 min">Mini ritual de amor (Paquete)</option>
                        <option value="1">Masaje Relajante</option>
                        <option value="2">Masaje Descontracturante</option>
                        <option value="3">Masaje Sueco</option>
                        <option value="5">Masaje Terapéutico</option>
                        <option value="4">Masaje Deportivo</option>
                        <option value="6">Masaje Con Ventosas</option>
                        <option value="7">Masaje Drenaje Linfático</option>
                        <option value="11">Antiacné (Facial)</option>
                        <option value="10">Antiedad (Facial)</option>
                        <option value="16">Drenaje Facial (Facial)</option>
                        <option value="15">Fototerapia LED (Facial)</option>
                        <option value="9">Hidratante (Facial)</option>
                        <option value="8">Limpieza Facial Profunda (Facial)</option>
                        <option value="14">Microdermoabrasión (Facial)</option>
                        <option value="13">Reafirmante (Facial)</option>
                        <option value="12">Regenerante (Facial)</option>
                    </select>
                    <select name="duracion" id="duracion-select" required>
                        <option value="">Selecciona duración</option>
                        <option>30 min</option>
                        <option>45 min</option>
                        <option>50 min</option>
                        <option>60 min</option>
                        <option>80 min</option>
                        <option>90 min</option>
                        <option>100 min</option>
                        <option>105 min</option>
                        <option>120 min</option>
                        <option>135 min</option>
                    </select>
                    <input type="date" name="fecha" id="fecha-input" required />
                    <select name="hora" id="hora-select" required>
                        <option value="">Primero selecciona una fecha</option>
                    </select>
                    <textarea class="full" name="notas" rows="3" placeholder="Notas adicionales (opcional)"></textarea>
                </div>
            </div>
            <button class="btn-primary modal-submit" type="submit">Confirmar Reservación</button>
        </form>
    </div>
</div>

<!-- BOTÓN FLOTANTE WHATSAPP -->
<a href="https://wa.me/5625764706" target="_blank" class="whatsapp-float-btn" aria-label="Contactar por WhatsApp" rel="noopener noreferrer">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<!-- WIDGET FLOTANTE DE REDES SOCIALES -->
<div class="social-widget-wrapper">
    <!-- Botón flotante -->
    <button class="social-float-btn" id="social-float-btn" aria-label="Ver fotos de Instagram" type="button">
        <i class="fa-brands fa-instagram"></i>
        <span class="social-float-badge">6</span>
    </button>

    <!-- Panel lateral -->
    <div class="social-panel" id="social-panel">
        <div class="social-panel-header">
            <h3>Posts Beauty & Soul</h3>
            <button class="social-panel-close" id="social-panel-close" aria-label="Cerrar" type="button">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="social-panel-tabs">
            <button class="social-tab active" data-tab="photos" type="button">
                <i class="fa-solid fa-images"></i> Fotos
            </button>
            <button class="social-tab" data-tab="videos" type="button">
                <i class="fa-solid fa-video"></i> Videos
            </button>
        </div>

        <div class="social-panel-content">
            <!-- Tab de Fotos -->
            <div class="social-tab-content active" data-tab-content="photos">
                <div class="social-grid">
                    <!-- Aquí puedes reemplazar con tus imágenes reales o embeds de Instagram  glightbox en la clase del item y el atributo data-gallery="social-gallery" para agregar la galeria -->
                    <a href="https://www.facebook.com/photo/?fbid=122146481534841302&set=pcb.122146481564841302" class="social-grid-item " target="_blank" rel="noopener noreferrer">
                        <img src="images/Imagen1.jpg" alt="Instagram Post 1">
                        <div class="social-overlay">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </a>
                    <a href="https://www.facebook.com/photo?fbid=122145236174841302&set=a.122142363962841302" class="social-grid-item " target="_blank" rel="noopener noreferrer">
                        <img src="images/Imagen2.jpg" alt="Instagram Post 2">
                        <div class="social-overlay">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </a>
                    <a href="https://www.facebook.com/photo?fbid=122142363950841302&set=a.122142363962841302" class="social-grid-item " target="_blank" rel="noopener noreferrer">
                        <img src="images/Imagen3.jpg" alt="Instagram Post 3">
                        <div class="social-overlay">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </a>
                    <!-- <a href="images/post4.jpg" class="social-grid-item" target="_blank" rel="noopener noreferrer">
                        <img src="images/Imagen4.jpg" alt="Instagram Post 4">
                        <div class="social-overlay">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </a>
                    <a href="images/post5.jpg" class="social-grid-item" target="_blank" rel="noopener noreferrer">
                        <img src="images/Imagen5.jpg" alt="Instagram Post 5">
                        <div class="social-overlay">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </a>
                    <a href="https://www.facebook.com/photo?fbid=122144537072841302&set=a.122097839372841302" class="social-grid-item" target="_blank" rel="noopener noreferrer">
                        <img src="images/Imagen6.jpg" alt="Instagram Post 6">
                        <div class="social-overlay">
                            <i class="fa-solid fa-up-right-and-down-left-from-center"></i>
                        </div>
                    </a> -->
                </div>
            </div>

            <!-- Tab de Videos agregar glightbox en la clase del item y el atributo data-gallery="video-gallery" para agregar la galeria -->
            <div class="social-tab-content" data-tab-content="videos">
                <div class="social-grid">

                    <a href="https://www.facebook.com/reel/802453255848025" class="social-grid-item" target="_blank" rel="noopener noreferrer">
                        <img src="images/Video1.png" alt="Video 1">
                        <div class="social-overlay">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </a>
                    <a href="https://www.tiktok.com/@beautyandsoul.cabina/video/7530549066804071688?_r=1&_t=ZM-8vZVtla2F54" class="social-grid-item" target="_blank" rel="noopener noreferrer">
                        <img src="images/Video2.png" alt="Video 2">
                        <div class="social-overlay">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </a>
                    <a href="https://www.tiktok.com/@beautyandsoul.cabina/video/7529619455760960775?_r=1&_t=ZM-8vZVtla2F54" class="social-grid-item" target="_blank" rel="noopener noreferrer">
                        <img src="images/Video3.png" alt="Video 3">
                        <div class="social-overlay">
                            <i class="fa-solid fa-play"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- <div class="social-panel-footer">
            <a href="https://www.instagram.com/tu_cuenta/" target="_blank" class="btn-primary social-follow-btn" rel="noopener noreferrer">
                <i class="fa-brands fa-instagram"></i> Síguenos en Instagram
            </a>
            <div class="social-icons-footer">
                <a href="https://www.facebook.com/tu_cuenta/" target="_blank" aria-label="Facebook" rel="noopener noreferrer">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://www.tiktok.com/@tu_cuenta" target="_blank" aria-label="TikTok" rel="noopener noreferrer">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
                <a href="https://wa.me/5625764706" target="_blank" aria-label="WhatsApp" rel="noopener noreferrer">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </div> -->
    </div>
</div>

<?php include 'includes/footer.php'; ?>