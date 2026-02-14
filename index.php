<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Beauty & Soul</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/styles.css" />

      <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

</head>
<body>

<!-- HEADER -->
<header class="header">
    <div class="container header-grid">
        <button class="menu-btn">☰</button>

        <h1 class="logo">
            beauty <span>& </span>soul
        </h1>

        <div class="header-icons">
            <a href="#">🛒</a>
            <a href="#">📷</a>
        </div>
    </div>
</header>

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
                ['Masaje', 'Relajante'],
                ['Masaje', 'Descontracturante'],
                ['Masaje', 'Sueco'],
                ['Masaje', 'Terapéutico'],
                ['Masaje', 'Deportivo'],
                ['Masaje', 'Drenaje Linfático'],
                ['Masaje', 'Con Ventosas'],
            ];

            foreach ($services as $service): ?>
                <div class="card carousel-card">
                    <div class="icon">✿</div>
                    <h4><?= $service[0] ?></h4>
                    <p><?= $service[1] ?></p>
                    <a href="#" class="btn-link">Ver más</a>
                </div>
            <?php endforeach; ?>
            </div>
            <button class="carousel-btn next" type="button" aria-label="Siguiente">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
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

<!-- FOOTER -->
<footer class="footer">
    <div class="container footer-grid">
        <div>
            <h5>Enlaces</h5>
            <a href="#">Inicio</a>
            <a href="#">Servicios</a>
            <a href="#">Productos</a>
            <a href="#">Contacto</a>
        </div>

        <div>
            <h5>Contacto</h5>
            <p>Tel: 555 123 4567</p>
            <p>Email: info@beautyandsoul.com</p>
        </div>

        <div>
            <h5>Síguenos</h5>
            <a href="#">Instagram</a>
            <a href="#">Facebook</a>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container footer-bottom-content">
            <p>© 2025 Beauty & Soul - Todos los derechos reservados / Desarrollado por <span class="footer-brand">XIPELY</span></p>
        </div>
    </div>
</footer>

<!-- BOTONES FLOTANTES -->
<div class="social-float">
    <a href="https://www.facebook.com/share/14kCMCcHzf/?mibextid=wwXIfr" target="_blank" aria-label="Facebook">
        <i class="fa-brands fa-facebook-f"></i>
    </a>
    <a href="https://www.tiktok.com/@beautyandsoul.cabina?_t=ZM-8vZVtla2F54&_r=1" target="_blank" aria-label="TikTok">
        <i class="fa-brands fa-tiktok"></i>
    </a>
    <a href="https://wa.me/525625764706?text=Hola%2C%20he%20visto%20su%20p%C3%A1gina%20y%20estoy%20muy%20interesad%40%20en%20reservar%20un%20servicio.%20%E2%9D%A4%EF%B8%8F" target="_blank" aria-label="WhatsApp">
        <i class="fa-brands fa-whatsapp"></i>
    </a>
</div>

<!-- MODAL RESERVA -->
<div class="modal" id="reserva-modal" aria-hidden="true">
    <div class="modal-backdrop" data-close="modal"></div>
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="reserva-title">
        <button class="modal-close" type="button" aria-label="Cerrar" data-close="modal"><i class="fa-solid fa-x"></i></button>
        <h3 class="modal-title" id="reserva-title">Reserva tu Servicio</h3>
        <form class="reserva-form">
            <div class="form-section">
                <p class="form-section-title">Contacto del cliente</p>
                <div class="form-grid">
                    <input type="text" name="nombre" placeholder="Nombre Completo" required />
                    <input type="tel" name="telefono" placeholder="Teléfono" required />
                    <input class="full" type="email" name="correo" placeholder="Correo Electrónico" required />
                </div>
            </div>
            <div class="form-section">
                <p class="form-section-title">Detalles del servicio</p>
                <div class="form-grid">
                    <select name="servicio" required>
                        <option value="">Selecciona un servicio</option>
                        <option>Drenaje Linfático (Masaje)</option>
                        <option>Masaje con Ventosas (Masaje)</option>
                        <option>Masaje Deportivo (Masaje)</option>
                        <option>Masaje Descontracturante (Masaje)</option>
                        <option>Masaje Relajante (Masaje)</option>
                        <option>Masaje Sueco (Masaje)</option>
                        <option>Masaje Terapéutico (Masaje)</option>
                        <option>Antiacné (Facial)</option>
                        <option>Antiedad (Facial)</option>
                        <option>Drenaje Facial (Facial)</option>
                        <option>Fototerapia LED (Facial)</option>
                        <option>Hidratante (Facial)</option>
                        <option>Limpieza Facial Profunda (Facial)</option>
                        <option>Microdermoabrasión (Facial)</option>
                        <option>Reafirmante (Facial)</option>
                        <option>Regenerante (Facial)</option>
                    </select>
                    <select name="duracion" required>
                        <option value="">Selecciona duración</option>
                        <option>30 min</option>
                        <option>45 min</option>
                        <option>60 min</option>
                        <option>90 min</option>
                    </select>
                    <input type="date" name="fecha" required />
                    <select name="hora" required>
                        <option value="">Selecciona una hora</option>
                        <option>09:00</option>
                        <option>10:30</option>
                        <option>12:00</option>
                        <option>14:00</option>
                        <option>16:00</option>
                        <option>18:00</option>
                    </select>
                    <textarea class="full" name="notas" rows="3" placeholder="Notas adicionales (opcional)"></textarea>
                </div>
            </div>
            <button class="btn-primary modal-submit" type="submit">Confirmar Reservación</button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
