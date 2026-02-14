<?php
// Mostrar todos los errores de PHP
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Iniciar el log
error_log("Iniciando procesamiento del formulario de reserva");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Beauty & Soul - Spa en Coacalco y CDMX. Ofrecemos los mejores tratamientos de masajes y faciales profesionales. ¡Reserva hoy y renueva tu cuerpo y alma!">
<meta name="keywords" content="tratamientos spa, masajes Coacalco, faciales CDMX, belleza y bienestar, spa Zona Metropolitana, terapias relax, drenaje linfático, masaje descontracturante">

<!-- Open Graph / Facebook (para redes sociales) -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://beautyandsoul.com.mx/">
<meta property="og:title" content="Tratamientos de Spa en Coacalco y CDMX | Beauty & Soul">
<meta property="og:description" content="Los mejores tratamientos de masajes y faciales profesionales en la Zona Metropolitana de la Ciudad de México.">
<meta property="og:image" content="https://beautyandsoul.com.mx/images/beautyAndSoulCabina.png">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:site_name" content="Beauty & Soul">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Tratamientos de Spa en Coacalco y CDMX | Beauty & Soul">
<meta name="twitter:description" content="Los mejores tratamientos de masajes y faciales profesionales en la Zona Metropolitana de la Ciudad de México.">
<meta name="twitter:image" content="https://beautyandsoul.com.mx/images/beautyAndSoulCabina.png">

  <title>Beauty & Soul - Spa y Terapias de Relax</title>
  <!-- Bootstrap 5 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet" />
  <!-- Animate.css -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Font Awesome para íconos -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="icon" href="images/logoW.png" type="image/x-icon">
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "DaySpa",
  "name": "Beauty & Soul - Spa en Coacalco y CDMX",
  "description": "Spa profesional en Coacalco especializado en tratamientos faciales y masajes terapéuticos. Ofrecemos servicios de belleza y bienestar en la Zona Metropolitana de la Ciudad de México.",
  "image": "https://beautyandsoul.com.mx/images/logoW.png",
  "@id": "https://beautyandsoul.com.mx",
  "url": "https://beautyandsoul.com.mx",
  "telephone": "+525625764706",
  "priceRange": "$$",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Calle Olivo, La Isla",
    "addressLocality": "Coacalco de Berriozábal",
    "addressRegion": "Estado de México",
    "postalCode": "54935",
    "addressCountry": "MX"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 19.6837297,
    "longitude": -99.08989
  },
  "openingHoursSpecification": [
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Saturday",
      "opens": "17:30",
      "closes": "20:00"
    },
    {
      "@type": "OpeningHoursSpecification",
      "dayOfWeek": "Sunday",
      "opens": "10:00",
      "closes": "18:00"
    }
  ],
  "hasOfferCatalog": {
    "@type": "OfferCatalog",
    "name": "Servicios de Spa",
    "itemListElement": [
      {
        "@type": "OfferCatalog",
        "name": "Masajes",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Masaje Relajante",
              "description": "Terapia de 50 u 80 minutos para aliviar el estrés"
            }
          },
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Masaje con Ventosas",
              "description": "Técnica tradicional para eliminar toxinas"
            }
          }
        ]
      },
      {
        "@type": "OfferCatalog",
        "name": "Tratamientos Faciales",
        "itemListElement": [
          {
            "@type": "Offer",
            "itemOffered": {
              "@type": "Service",
              "name": "Limpieza Facial Profunda",
              "description": "Tratamiento de 90 minutos para piel perfecta"
            }
          }
        ]
      }
    ]
  },
  "sameAs": [
    "https://www.facebook.com/share/14kCMCcHzf/",
    "https://www.tiktok.com/@beautyandsoul.cabina",
    "https://wa.me/525625764706"
  ],
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "reviewCount": "47",
    "bestRating": "5"
  }
}
</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-S0QH6MWCHH"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-S0QH6MWCHH');
</script>
</head>

<body>
  <!-- Barra de navegación -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container">
      <button
        class="navbar-toggler order-first"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="d-lg-none text-center">
        <a class="navbar-brand" href="#">
          <img src="images/logoteal.png" alt="Beauty & Soul Logo" />
        </a>
      </div>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <a
              class="nav-link animate__animated animate__fadeIn"
              href="#inicio">Inicio</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link animate__animated animate__fadeIn"
              href="#servicios">Masajes</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link animate__animated animate__fadeIn"
              href="#faciales">Faciales</a>
          </li>
        </ul>

        <a class="navbar-brand d-none d-lg-block" href="#">
          <img src="images/logoteal.png" alt="Beauty & Soul Logo" />
        </a>

        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a
              class="nav-link animate__animated animate__fadeIn"
              href="#membresias">Membresias</a>
          <li class="nav-item">
            <a
              class="nav-link animate__animated animate__fadeIn"
              href="#nosotros">Nosotros</a>
          </li>
          <li class="nav-item">
            <a
              class="nav-link animate__animated animate__fadeIn"
              href="#reservar">Agendar Cita</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Sección Hero -->
  <section class="hero-section" id="inicio">
    <div class="container hero-content">
      <div class="row">
        <div class="col-lg-7 animate__animated animate__fadeInLeft">
          <h1 class="display-3 fw-bold mb-4">Renueva tu cuerpo y alma</h1>
          <p class="lead mb-5">
            En Beauty & Soul te ofrecemos experiencias únicas de relajación y
            bienestar con nuestros tratamientos especializados.
          </p>
          <a
            href="#reservar"
            class="btn btn-primary btn-lg animate__animated animate__pulse animate__infinite">Reserva tu cita</a>
        </div>
      </div>
    </div>
  </section>

  <section class="services-section" id="servicios">
    <!-- Fondo con flores de jazmín -->
    <div class="services-bg"></div>

    <!-- Capa de overlay para el efecto glass -->
    <div class="services-overlay"></div>

    <div class="container services-container">
      <div class="text-center mb-5">
        <h1 class="services-title animate__animated animate__fadeIn">SERVICIOS DE MASAJE</h1>
        <p class="services-subtitle animate__animated animate__fadeIn">Descubre nuestras terapias diseñadas para tu bienestar</p>
      </div>

      <div id="servicesCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <!-- Grupo 1 -->
          <div class="carousel-item active">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-spa"></i></div>
                  <h3>Masaje Relajante</h3>
                  <p>Alivia el estrés y relaja cuerpo y mente</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $250</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-hand-holding-heart"></i></div>
                  <h3>Masaje Descontracturante</h3>
                  <p>Alivia contracturas y reduce la tensión muscular</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $250</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-heartbeat"></i></div>
                  <h3>Masaje Sueco</h3>
                  <p>Mejora la circulación y alivia la tensión muscular</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $250</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Grupo 2 -->
          <div class="carousel-item">
            <div class="row">
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-running"></i></div>
                  <h3>Masaje Deportivo</h3>
                  <p>Alivia molestias, acelera la recuperación y previene lesiones</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $350</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-bone"></i></div>
                  <h3>Masaje Terapéutico</h3>
                  <p>Alivia dolores crónicos y mejora el movimiento</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $350</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>

              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-fire"></i></div>
                  <h3>Masaje con Ventosas</h3>
                  <p>Reduce la tensión del cuerpo y elimina toxinas</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $350</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Grupo 3 -->
          <div class="carousel-item">
            <div class="row justify-content-center">
              <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="service-card">
                  <div class="service-icon"><i class="fas fa-water"></i></div>
                  <h3>Drenaje Linfático</h3>
                  <p>Reduce la retención de líquidos y toxinas</p>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 50 min</p>
                    <p><strong>Precio:</strong> $250</p>
                  </div>
                  <div class="service-details">
                    <p><strong>Duración:</strong> 80 min</p>
                    <p><strong>Precio:</strong> $300</p>
                  </div>
                  <a href="#reservar" class="btn btn-reservar">Reservar</a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Controles del carrusel -->
        <button class="carousel-control-prev" type="button" data-bs-target="#servicesCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#servicesCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Siguiente</span>
        </button>
      </div>
      <div class="services-mobile-scroll d-block d-md-none">
        <div class="services-scroll-wrapper">
          <!-- Tarjeta 1 - Relajante -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-spa"></i></div>
            <h3>Masaje Relajante</h3>
            <p>Alivia el estrés y relaja cuerpo y mente</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $250</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>

          <!-- Tarjeta 2 - Descontracturante -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-hand-holding-heart"></i></div>
            <h3>Masaje Descontracturante</h3>
            <p>Alivia contracturas y reduce la tensión muscular</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $250</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>

          <!-- Tarjeta 3 - Sueco -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-heartbeat"></i></div>
            <h3>Masaje Sueco</h3>
            <p>Mejora la circulación y alivia la tensión muscular</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $250</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>

          <!-- Tarjeta 4 - Deportivo -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-running"></i></div>
            <h3>Masaje Deportivo</h3>
            <p>Alivia molestias, acelera la recuperación y previene lesiones</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $350</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>

          <!-- Tarjeta 5 - Terapéutico -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-bone"></i></div>
            <h3>Masaje Terapéutico</h3>
            <p>Alivia dolores crónicos y mejora el movimiento</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $350</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>

          <!-- Tarjeta 6 - Ventosas -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-fire"></i></div>
            <h3>Masaje con Ventosas</h3>
            <p>Reduce la tensión del cuerpo y elimina toxinas</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $350</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>

          <!-- Tarjeta 7 - Drenaje Linfático -->
          <div class="service-card">
            <div class="service-icon"><i class="fas fa-water"></i></div>
            <h3>Drenaje Linfático</h3>
            <p>Reduce la retención de líquidos y toxinas</p>
            <div class="service-details">
              <p><strong>Duración:</strong> 50 min</p>
              <p><strong>Precio:</strong> $250</p>
            </div>
            <div class="service-details">
              <p><strong>Duración:</strong> 80 min</p>
              <p><strong>Precio:</strong> $300</p>
            </div>
            <a href="#reservar" class="btn btn-reservar">Reservar</a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Sección de Facial -->

  <section class="facial-section" id="faciales">
    <div class="container-fluid p-0">
      <div class="row g-0">
        <!-- Columna de imagen (30%) -->
        <div class="col-lg-3 facial-image-col">
          <div class="facial-image"></div>
        </div>

        <!-- Columna de contenido (70%) -->
        <div class="col-lg-9 facial-content-col">
          <div class="container py-5">
            <div class="text-center mb-5 facial-header">
              <h1 class="facial-title">FACIALES PROFESIONALES</h1>
              <p class="facial-subtitle">Tratamientos especializados para cada necesidad de tu piel</p>
            </div>

            <div class="row facial-cards-container">
              <!-- Tarjeta 1 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">LIMPIEZA FACIAL PROFUNDA</h3>
                  <p class="facial-service-description">Elimina impurezas, puntos negros y células muertas.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$300</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 2 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">HIDRATANTE</h3>
                  <p class="facial-service-description">Aporta hidratación profunda y devuelve luminosidad.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$300</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 3 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">ANTIEDAD</h3>
                  <p class="facial-service-description">Estimula la producción de colágeno y suaviza líneas de expresión.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$350</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 4 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">ANTIACNÉ</h3>
                  <p class="facial-service-description">Trata el acné y previene futuras imperfecciones.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$300</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 5 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">REGENERANTE</h3>
                  <p class="facial-service-description">Restaura, nutre y revitaliza la piel.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$300</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 6 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">REAFIRMANTE</h3>
                  <p class="facial-service-description">Mejora la firmeza y elasticidad del rostro.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$300</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 7 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">MICRODERMOABRASIÓN</h3>
                  <p class="facial-service-description">Exfolia y renueva la superficie cutánea.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$350</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 8 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">FOTOTERAPIA LED</h3>
                  <p class="facial-service-description">Tecnología de luz para combatir acné, manchas y arrugas.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$350</span>
                  </div>
                </div>
              </div>

              <!-- Tarjeta 9 -->
              <div class="col-md-6 col-lg-4 mb-4 facial-card-wrapper">
                <div class="facial-card animate__animated">
                  <h3 class="facial-service-title">DRENAJE FACIAL</h3>
                  <p class="facial-service-description">Estimula la circulación y reduce la retención de líquidos.</p>
                  <div class="facial-service-details">
                    <span class="facial-service-duration">90 min</span>
                    <span class="facial-service-price">$350</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="text-center mt-5">
              <a href="#reservar" class="btn btn-reservar">Reserva tu cita</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <style>
    .facial-card:hover {
      transform: scale(1.1);
      box-shadow: 0 8px 25px rgba(125, 107, 145, 0.2);
    }

    @media (max-width: 767.98px) {
      .facial-card {
        margin-bottom: 20px;
      }
    }
  </style>

  <!-- Sección de Membresías -->
  <section class="memberships-section" id="membresias">
    <!-- Fondo decorativo -->
    <div class="memberships-bg"></div>

    <!-- Contenido principal -->
    <div class="container memberships-container">
      <div class="text-center mb-5">
        <h1 class="memberships-title">MEMBRESÍAS</h1>
        <p class="memberships-subtitle">Descubre nuestros paquetes exclusivos y aprovecha al máximo tu experiencia de bienestar</p>
      </div>

      <div class="row justify-content-center">
        <!-- Membresía Armonía -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="membership-card membership-card-armonia">
            <div class="membership-header">
              <h3>MEMBRESÍA ARMONÍA</h3>
              <div class="price">$750</div>
            </div>

            <div class="membership-features">
              <ul>
                <li><i class="fas fa-check-circle"></i>Incluye 3 servicios de 50 minutos</li>
                <li><i class="fas fa-check-circle"></i>Puedes elegir entre masaje o facial</li>
                <li><i class="fas fa-calendar-alt"></i>Vigencia: 6 meses</li>
              </ul>
            </div>

            <a href="#reservar" class="btn btn-membership">Adquirir Membresía</a>
          </div>
        </div>

        <!-- Membresía Esencia -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="membership-card membership-card-esencia">
            <div class="membership-header">
              <h3>MEMBRESÍA ESENCIA</h3>
              <div class="price">$550</div>
            </div>

            <div class="membership-features">
              <ul>
                <li><i class="fas fa-check-circle"></i>Incluye 3 masajes a elegir</li>
                <li><i class="fas fa-check-circle"></i>1 facial de regalo</li>
                <li><i class="fas fa-calendar-alt"></i>Vigencia: 6 meses</li>
              </ul>
            </div>

            <a href="#reservar" class="btn btn-membership">Adquirir Membresía</a>
          </div>
        </div>

        <!-- Membresía Alma Radiante -->
        <div class="col-12 col-md-6 col-lg-4 mb-4">
          <div class="membership-card membership-card-alma">
            <div class="membership-header">
              <h3>MEMBRESÍA ALMA RADIANTE</h3>
              <div class="price">$950</div>
            </div>

            <div class="membership-features">
              <ul>
                <li><i class="fas fa-check-circle"></i>Incluye 4 servicios de 80 minutos</li>
                <li><i class="fas fa-check-circle"></i>Puedes elegir entre masaje o facial</li>
                <li><i class="fas fa-check-circle"></i>El 5to servicio es gratis</li>
                <li><i class="fas fa-calendar-alt"></i>Vigencia: 6 meses</li>
              </ul>
            </div>

            <a href="#reservar" class="btn btn-membership">Adquirir Membresía</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Sección Nosotros -->
  <section class="py-5 bg-light" id="nosotros">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 animate__animated animate__fadeInLeft">
          <img
            src="images/fotoMuestra.jpg"
            alt="Spa Beauty & Soul"
            class="img-fluid rounded shadow" />
        </div>
        <div class="col-lg-6 animate__animated animate__fadeInRight">
          <h2 class="section-title">Sobre Beauty & Soul</h2>
          <p><strong>Beauty and Soul Cabina</strong> es mucho más que un espacio de belleza: es un rincón creado con amor para que reconectes contigo misma, desde el bienestar profundo hasta la belleza consciente.</p>

          <p>Este proyecto nació del anhelo de ofrecer un refugio donde cada persona se sienta vista, valorada y en equilibrio desde el primer instante. No solo se trata de un tratamiento, sino de una experiencia que nutre cuerpo, mente y alma.</p>

          <p>Cada sesión está diseñada de manera personalizada, con un enfoque empático y profesional. Ya sea un facial, un masaje o simplemente un momento para ti, aquí encontrarás un ambiente cálido, cercano y transformador.</p>

          <p>Creo con el corazón que cuando nos regalamos tiempo para pausar, respirar y cuidarnos, todo empieza a alinearse.
            <strong>Beauty and Soul Cabina</strong> es ese lugar donde puedes empezar a hacerlo.
          </p>

          <p><strong>Te espero para que lo vivas. ✨</strong></p>
        </div>
      </div>
    </div>
  </section>


<!-- Sección de Reservas -->
<section class="booking-section py-5" id="reservar">
    <div class="container">
        <?php 
        // Incluir la clase de administración
        require_once 'spa_admin.php';
        $spaAdmin = new SpaAdmin();
        
        // Obtener servicios activos
        $servicios = $spaAdmin->getActiveServices();
        
        // Procesar el formulario si se envió
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $reservationData = array(
                'nombre' => $_POST['nombre'],
                'email' => $_POST['email'],
                'telefono' => $_POST['telefono'],
                'id_servicio' => $_POST['servicio'],
                'duracion' => $_POST['duracion'],
                'fecha' => $_POST['fecha'],
                'hora' => $_POST['hora'],
                'notas' => $_POST['notas']
            );
            
            $result = $spaAdmin->createReservation($reservationData);
            
            if ($result['success']) {
                echo '<div class="alert alert-success">¡Reservación confirmada! Tu número de reservación es: '.$result['reservation_id'].'</div>';
            } else {
                echo '<div class="alert alert-danger">'.$result['message'].'</div>';
            }
        }
        ?>
        
        <h2 class="text-center mb-4">Reserva tu Servicio</h2>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <form id="bookingForm" method="POST">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Correo Electrónico" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <select class="form-select" id="servicio" name="servicio" required>
                                <option value="" selected disabled>Selecciona un servicio</option>
                                <?php foreach ($servicios as $servicio): ?>
                                    <option value="<?php echo $servicio['id_servicio']; ?>"
                                        data-duracion50="<?php echo $servicio['duracion_50min'] ? '1' : '0'; ?>"
                                        data-duracion80="<?php echo $servicio['duracion_80min'] ? '1' : '0'; ?>"
                                        data-duracion90="<?php echo $servicio['duracion_90min'] ? '1' : '0'; ?>"
                                        data-precio50="<?php echo $servicio['precio_50min']; ?>"
                                        data-precio80="<?php echo $servicio['precio_80min']; ?>"
                                        data-precio90="<?php echo $servicio['precio_90min']; ?>">
                                        <?php echo $servicio['nombre']; ?> (<?php echo $servicio['categoria']; ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <select class="form-select" id="duracion" name="duracion" required>
                                <option value="" selected disabled>Selecciona duración</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <input type="date" name="fecha" id="fecha" class="form-control" required
                                min="<?php echo date('Y-m-d'); ?>"
                                max="<?php echo date('Y-m-d', strtotime('+2 weeks')); ?>">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <select name="hora" id="hora" class="form-select" required>
                                <option value="" selected disabled>Selecciona una hora</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <textarea name="notas" class="form-control" placeholder="Notas adicionales (opcional)"></textarea>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Confirmar Reservación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

  <!-- Sección Contacto -->
  <section class="py-5" id="contacto">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 animate__animated animate__fadeInLeft">
          <h2 class="section-title">Contáctanos</h2>
          <p class="mb-4">
            Estamos aquí para responder cualquier pregunta que tengas sobre
            nuestros servicios.
          </p>
          <div class="mb-4">
            <h5>
              <i class="fas fa-map-marker-alt text-primary me-2"></i>
              Dirección
            </h5>
            <p>Calle Olivo, La Isla, 54935 San Pablo de las Salinas, Méx.</p>
          </div>
          <div class="mb-4">
            <h5>
              <i class="fas fa-phone-alt text-primary me-2"></i> Teléfono
            </h5>
            <p>56 2576 4706</p>
          </div>
          <div class="mb-4">
            <h5><i class="fas fa-envelope text-primary me-2"></i> Email</h5>
            <p>reservaciones@beautyandsoul.com</p>
          </div>
          <div class="mb-4">
            <h5><i class="fas fa-clock text-primary me-2"></i> Horario</h5>
            <p>Sabados: 5:30pm a 8:00pm<br />Domingos: 10:00am a 06:00pm</p>
          </div>
        </div>
        <div class="col-lg-6 animate__animated animate__fadeInRight">
          <div
            class="map-container"
            style="
                overflow: hidden;
                padding-bottom: 56.25%;
                position: relative;
                height: 0;
              ">
            <iframe

              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6388.30935868257!2d-99.08989000000001!3d19.6837297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f3fed6bf7a87%3A0xf156deb67efb1442!2sCondominio%20Q!5e1!3m2!1ses-419!2smx!4v1747618045048!5m2!1ses-419!2smx"
              style="
                  border: 0;
                  left: 0;
                  top: 0;
                  height: 100%;
                  width: 100%;
                  position: absolute;
                "
              allowfullscreen=""
              loading="lazy"></iframe>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center text-lg-start">
    <div class="container py-4">
      <div class="row">
        <div class="col-lg-4 mb-4 mb-lg-0">
          <h5 class="text-uppercase mb-4">
            <img src="images/logoW.png" alt="Beauty & Soul Logo" width="60px" class="logo-beauty-soul"> BEAUTY & SOUL
          </h5>
          <p>Tu oasis de paz y bienestar en el corazón de la ciudad.</p>
          <div class="mt-4">
            <a href="https://www.facebook.com/share/14kCMCcHzf/?mibextid=wwXIfr" target="_blank" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="https://www.tiktok.com/@beautyandsoul.cabina?_t=ZM-8vZVtla2F54&_r=1" target="_blank" class="text-white me-3"><i class="fab fa-tiktok"></i></a>
            <a href="https://wa.me/525625764706?text=Hola%2C%20he%20visto%20su%20p%C3%A1gina%20y%20estoy%20muy%20interesad%40%20en%20reservar%20un%20servicio.%20%E2%9D%A4%EF%B8%8F" target="_blank" class="text-white me-3"><i class="fab fa-whatsapp"></i></a>
          </div>
        </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
          <h5 class="text-uppercase mb-4">Enlaces rápidos</h5>
          <div class="footer-links d-flex flex-column">
            <a href="#inicio" class="mb-2">Inicio</a>
            <a href="#servicios" class="mb-2">Servicios</a>
            <a href="#nosotros" class="mb-2">Sobre nosotros</a>
            <a href="#contacto">Contacto</a>
            <a href="login.php">Ingresar</a>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
      © 2025 Beauty & Soul - Todos los derechos reservados / Desarrollado por <a href="https://xipely.com" target="_blank"><img src="https://xipely.com/img/core-img/logo.png" alt="Xipely" width="60px" class="logo-xipely"></a>
    </div>
  </footer>

  <!-- Botón flotante redes sociales -->
  <div
    class="social-float animate__animated animate__fadeInRight animate__delay-1s">
    <a
      href="https://www.facebook.com/share/14kCMCcHzf/?mibextid=wwXIfr" target="_blank"
      class="animate__animated animate__pulse animate__infinite animate__slow"><i class="fab fa-facebook-f"></i></a>
    <a
      href="https://www.tiktok.com/@beautyandsoul.cabina?_t=ZM-8vZVtla2F54&_r=1" target="_blank"
      class="animate__animated animate__pulse animate__infinite animate__slower"><i class="fab fa-tiktok"></i></a>
    <a
      href="https://wa.me/525625764706?text=Hola%2C%20he%20visto%20su%20p%C3%A1gina%20y%20estoy%20muy%20interesad%40%20en%20reservar%20un%20servicio.%20%E2%9D%A4%EF%B8%8F" target="_blank"
      class="animate__animated animate__pulse animate__infinite animate__slow"><i class="fab fa-whatsapp"></i></a>
  </div>

  <!-- Botón volver arriba -->
  <div class="back-to-top">
    <i class="fas fa-arrow-up"></i>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Scripts personalizados -->
  <script src="js/main.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de selección de servicio y duración
    const servicioSelect = document.getElementById('servicio');
    const duracionSelect = document.getElementById('duracion');
    const fechaInput = document.getElementById('fecha');
    const horaSelect = document.getElementById('hora');
    
    // Llenar select de duración cuando se selecciona un servicio
    servicioSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        // Limpiar opciones anteriores
        duracionSelect.innerHTML = '<option value="" selected disabled>Selecciona duración</option>';
        
        // Agregar opciones según disponibilidad
        if (selectedOption.getAttribute('data-duracion50') === '1') {
            const option = document.createElement('option');
            option.value = '50';
            option.textContent = `50 min - $${selectedOption.getAttribute('data-precio50')}`;
            duracionSelect.appendChild(option);
        }
        
        if (selectedOption.getAttribute('data-duracion80') === '1') {
            const option = document.createElement('option');
            option.value = '80';
            option.textContent = `80 min - $${selectedOption.getAttribute('data-precio80')}`;
            duracionSelect.appendChild(option);
        }
        
        if (selectedOption.getAttribute('data-duracion90') === '1') {
            const option = document.createElement('option');
            option.value = '90';
            option.textContent = `90 min - $${selectedOption.getAttribute('data-precio90')}`;
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
        horaSelect.innerHTML = '<option value="" selected disabled>Selecciona una hora</option>';
        
        // Generar horarios según el día
        let horasDisponibles = [];
        
        if (diaSemana === 5) { // Sábado
            // De 17:00 a 20:30 en intervalos de 30 minutos
            for (let hora = 17; hora <= 20; hora++) {
                for (let minuto = (hora === 17 ? 0 : 0); minuto < 60; minuto += 30) {
                    if (hora === 20 && minuto > 0) continue; // No pasar de 20:30
                    horasDisponibles.push(
                        `${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`
                    );
                }
            }
        } else if (diaSemana === 6) { // Domingo
            // De 10:00 a 20:00 en intervalos de 30 minutos
            for (let hora = 10; hora <= 20; hora++) {
                for (let minuto = 0; minuto < 60; minuto += 30) {
                    if (hora === 20 && minuto > 0) continue; // No pasar de 20:00
                    horasDisponibles.push(
                        `${hora.toString().padStart(2, '0')}:${minuto.toString().padStart(2, '0')}`
                    );
                }
            }
        } else {
            // No es fin de semana
            horaSelect.innerHTML = '<option value="" selected disabled>Selecciona un sábado o domingo</option>';
            return;
        }
        
        // Agregar horas disponibles al select
        horasDisponibles.forEach(hora => {
            const option = document.createElement('option');
            option.value = hora;
            option.textContent = hora;
            horaSelect.appendChild(option);
        });
    });
    
    // Si hay una fecha en el input (al recargar), generar horas
    if (fechaInput.value) {
        fechaInput.dispatchEvent(new Event('change'));
    }
});
</script>

</body>

</html>