<?php $pageTitle = "Inicio"; ?>
<?php include 'includes/header.php'; ?>

    <!-- HERO -->
    <section class="hero">
        <div class="container hero-content">
            <h2>Belleza que inspira tu bienestar</h2>
            <p>Relájate y renueva con nuestros tratamientos.</p>
            <button class="btn-primary pulse" id="open-reserva" type="button">Reserva ahora</button>
        </div>
    </section>

    <!-- SERVICIOS -->
    <section class="section">
        <div class="container">
            <h3 class="section-title">Nuestros masajes</h3>

            <div class="carousel">
                <button class="carousel-btn prev" type="button" aria-label="Anterior">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <div class="carousel-track">
                    <?php
                    $services = [
                        ['Masaje', 'Relajante', '<i class="fa-solid fa-hot-tub-person"></i>', ['50 min', '80 min'], [ '$250', '$300']],
                        ['Masaje', 'Descontracturante', '<i class="fa-solid fa-hand-back-fist"></i>', ['50 min', '80 min'], [ '$250', '$300']],
                        ['Masaje', 'Sueco', '<i class="fa-solid fa-person-swimming"></i>', ['50 min', '80 min'], [ '$250', '$300']],
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
    <section class="section bg-soft">
        <div class="container">
            <h3 class="section-title">Tratamientos Faciales</h3>
            
            <div class="facial-selector-container">
                <div class="form-group">
                    <label for="facial-select" class="facial-label">
                        <i class="fa-solid fa-spa"></i> Selecciona un tratamiento facial
                    </label>
                    <select id="facial-select" class="facial-select">
                        
                        <option value="limpieza" data-description="Elimina impurezas, puntos negros y células muertas." data-duration="90 min" data-price="$300">Limpieza Facial Profunda</option>
                        <option value="hidratante" data-description="Aporta hidratación profunda y devuelve luminosidad." data-duration="90 min" data-price="$300">Hidratante</option>
                        <option value="antiedad" data-description="Estimula la producción de colágeno y suaviza líneas de expresión." data-duration="90 min" data-price="$350">Antiedad</option>
                        <option value="antiacne" data-description="Trata el acné y previene futuras imperfecciones." data-duration="90 min" data-price="$300">Antiacné</option>
                        <option value="regenerante" data-description="Restaura, nutre y revitaliza la piel." data-duration="90 min" data-price="$300">Regenerante</option>
                        <option value="reafirmante" data-description="Mejora la firmeza y elasticidad del rostro." data-duration="90 min" data-price="$300">Reafirmante</option>
                        <option value="microdermoabrasion" data-description="Exfolia y renueva la superficie cutánea." data-duration="90 min" data-price="$350">Microdermoabrasión</option>
                        <option value="fototerapia" data-description="Tecnología de luz para combatir acné, manchas y arrugas." data-duration="90 min" data-price="$350">Fototerapia LED</option>
                        <option value="drenaje" data-description="Estimula la circulación y reduce la retención de líquidos." data-duration="90 min" data-price="$350">Drenaje Facial</option>
                    </select>
                </div>

                <div id="facial-info" class="facial-info" style="display: none;">
                    <div class="facial-description-card">
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
    </section>

    <!-- PRODUCTOS -->
    <section class="section bg-light">
        <div class="container">
            <h3 class="section-title">Productos Destacados</h3>

            <div class="grid grid-4">
                <?php for ($i = 1; $i <= 4; $i++): ?>
                    <div class="card product-card">
                        <div class="product-image"></div>
                        <h4>Producto Ejemplo</h4>
                        <span class="price">$600 MXN</span>
                        <a href="#" class="btn-primary small">Ver producto</a>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </section>

    <!-- BENEFICIOS -->
    <section class="section">
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
    </section>

    <!-- TESTIMONIOS -->
    <section class="section bg-soft">
        <div class="container">
            <h3 class="section-title">Testimonios</h3>

            <div class="testimonial">
                <p>“Excelente servicio y un ambiente muy relajante.”</p>
                <span>— Laura M.</span>
            </div>
        </div>
    </section>

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

<?php include 'includes/footer.php'; ?>
