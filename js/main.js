$(document).ready(function() {
    // Animación al hacer scroll
    $(window).scroll(function() {
        $('.animate__animated').each(function() {
            var position = $(this).offset().top;
            var scroll = $(window).scrollTop();
            var windowHeight = $(window).height();
            
            if (scroll > position - windowHeight + 200) {
                $(this).addClass($(this).data('animate'));
            }
        });
        
        // Mostrar/ocultar botón volver arriba
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').addClass('active');
        } else {
            $('.back-to-top').removeClass('active');
        }
    });
    
    // Smooth scrolling para enlaces
    $('a[href*="#"]').on('click', function(e) {
        e.preventDefault();
        
        $('html, body').animate(
            {
                scrollTop: $($(this).attr('href')).offset().top - 70,
            },
            500,
            'linear'
        );
    });
    
    // Volver arriba
    $('.back-to-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });
    

    
    // Asegurar que las animaciones se ejecuten al cargar si el elemento ya está visible
    $(window).trigger('scroll');
});

document.addEventListener('DOMContentLoaded', function() {
    // Configuración solo para móvil
    if (window.innerWidth < 768) {
      const scrollContainer = document.querySelector('.services-mobile-scroll');
      const cards = document.querySelectorAll('.services-scroll-wrapper .service-card');
      
      // Añadir indicadores de scroll (opcional)
      const indicators = document.createElement('div');
      indicators.className = 'scroll-indicators';
      cards.forEach((_, index) => {
        const dot = document.createElement('span');
        dot.className = 'scroll-indicator';
        if (index === 0) dot.classList.add('active');
        indicators.appendChild(dot);
      });
      scrollContainer.parentNode.insertBefore(indicators, scrollContainer.nextSibling);
      
      // Actualizar indicadores al hacer scroll
      scrollContainer.addEventListener('scroll', function() {
        const scrollPosition = scrollContainer.scrollLeft;
        const cardWidth = cards[0].offsetWidth + 15; // + gap
        const activeIndex = Math.round(scrollPosition / cardWidth);
        
        document.querySelectorAll('.scroll-indicator').forEach((dot, index) => {
          dot.classList.toggle('active', index === activeIndex);
        });
      });
      
      // Hacer las tarjetas un poco más grandes en móvil
      cards.forEach(card => {
        card.style.minHeight = '420px';
      });
    }

    document.querySelectorAll('.carousel').forEach(function(carousel) {
      const track = carousel.querySelector('.carousel-track');
      const prevBtn = carousel.querySelector('.carousel-btn.prev');
      const nextBtn = carousel.querySelector('.carousel-btn.next');

      if (!track || !prevBtn || !nextBtn) {
        return;
      }

      const scrollByAmount = () => {
        const card = track.querySelector('.carousel-card');
        if (card) {
          return card.offsetWidth + 25;
        }
        return track.clientWidth + 25;
      };

      prevBtn.addEventListener('click', function() {
        const amount = scrollByAmount();
        track.scrollBy({ left: -amount, behavior: 'smooth' });
        track.scrollLeft -= amount;
      });

      nextBtn.addEventListener('click', function() {
        const amount = scrollByAmount();
        track.scrollBy({ left: amount, behavior: 'smooth' });
        track.scrollLeft += amount;
      });
    });

    const openReserva = document.getElementById('open-reserva');
    const modal = document.getElementById('reserva-modal');
    const servicioSelect = document.getElementById('servicio-select');
    const duracionSelect = document.getElementById('duracion-select');

    if (modal) {
      const closeModal = () => {
        modal.classList.remove('is-open');
        document.body.classList.remove('modal-open');
        modal.setAttribute('aria-hidden', 'true');
      };

      const openModal = (serviceName = null, duration = null) => {
        modal.classList.add('is-open');
        document.body.classList.add('modal-open');
        modal.setAttribute('aria-hidden', 'false');
        
        // Pre-seleccionar el servicio si se proporciona
        if (serviceName && servicioSelect) {
          servicioSelect.value = serviceName;
        }
        
        // Pre-seleccionar la duración si se proporciona
        if (duration && duracionSelect) {
          duracionSelect.value = duration;
        }
      };

      // Botón principal "Reserva ahora"
      if (openReserva) {
        openReserva.addEventListener('click', () => openModal());
      }

      // Opciones de duración/precio - al hacer clic abren el modal directamente
      document.querySelectorAll('.service-pricing-item').forEach(function(item) {
        item.addEventListener('click', function() {
          const serviceName = this.getAttribute('data-service');
          const duration = this.getAttribute('data-duration');
          openModal(serviceName, duration);
        });
        
        // Accesibilidad: permitir Enter/Space para activar
        item.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            const serviceName = this.getAttribute('data-service');
            const duration = this.getAttribute('data-duration');
            openModal(serviceName, duration);
          }
        });
      });

      // Enlaces "Ver galería" - abrir galería de imágenes
      document.querySelectorAll('.service-more-link').forEach(function(link) {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const galleryId = this.getAttribute('data-gallery');
          
          // Encontrar y hacer clic en el primer enlace de la galería para abrirla
          const firstImage = document.querySelector(`[data-gallery="${galleryId}"].glightbox`);
          if (firstImage) {
            firstImage.click();
          }
        });
      });

      modal.addEventListener('click', function(e) {
        if (e.target && e.target.matches('[data-close="modal"]')) {
          closeModal();
        }
      });

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) {
          closeModal();
        }
      });
    }


    // Manejo de cards flotantes de servicios
    document.querySelectorAll('.service-more-btn').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        const serviceId = this.getAttribute('data-service');
        const floatCard = document.getElementById('service-card-' + serviceId);
        
        // Cerrar todas las otras cards flotantes
        document.querySelectorAll('.service-float-card').forEach(function(card) {
          if (card !== floatCard) {
            card.classList.remove('is-visible');
          }
        });
        
        // Toggle la card actual
        floatCard.classList.toggle('is-visible');
      });
    });

    // Cerrar cards flotantes con el botón X
    document.querySelectorAll('.service-float-close').forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const floatCard = this.closest('.service-float-card');
        floatCard.classList.remove('is-visible');
      });
    });

    // Cerrar cards flotantes al hacer click fuera
    document.addEventListener('click', function(e) {
      if (!e.target.closest('.service-card-container')) {
        document.querySelectorAll('.service-float-card').forEach(function(card) {
          card.classList.remove('is-visible');
        });
      }
    });

    // Cerrar cards flotantes con tecla Escape
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.querySelectorAll('.service-float-card').forEach(function(card) {
          card.classList.remove('is-visible');
        });
      }
    });

    // Inicializar GLightbox para galerías de imágenes
    const lightbox = GLightbox({
      touchNavigation: true,
      loop: true,
      autoplayVideos: true,
      closeButton: true,
      zoomable: true,
      draggable: true,
      dragToleranceX: 40,
      dragToleranceY: 65,
      slideEffect: 'slide',
      moreLength: 0,
      skin: 'clean',
      descPosition: 'bottom'
    });

    // Selector de faciales
    const facialSelect = document.getElementById('facial-select');
    const facialInfo = document.getElementById('facial-info');
    const facialName = document.getElementById('facial-name');
    const facialDescription = document.getElementById('facial-description');
    const facialDuration = document.getElementById('facial-duration');
    const facialPrice = document.getElementById('facial-price');
    const facialReserveBtn = document.getElementById('facial-reserve-btn');

    if (facialSelect) {
      console.log('Facial select found, adding event listener');

      document.addEventListener('DOMContentLoaded', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value === '') {
          // Si no hay selección, ocultar la información
          facialInfo.style.display = 'none';
        } else {
          // Mostrar la información del facial seleccionado
          const description = selectedOption.getAttribute('data-description');
          const duration = selectedOption.getAttribute('data-duration');
          const price = selectedOption.getAttribute('data-price');
          const name = selectedOption.text;
          
          facialName.textContent = name;
          facialDescription.textContent = description;
          facialDuration.textContent = duration;
          facialPrice.textContent = price;
          
          // Mostrar el contenedor de información con animación
          facialInfo.style.display = 'block';
          facialInfo.classList.add('fade-in');
          
          // Guardar información del servicio para la reserva
          facialReserveBtn.setAttribute('data-service', name);
          facialReserveBtn.setAttribute('data-duration', duration);
        }
      });
      
      facialSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value === '') {
          // Si no hay selección, ocultar la información
          facialInfo.style.display = 'none';
        } else {
          // Mostrar la información del facial seleccionado
          const description = selectedOption.getAttribute('data-description');
          const duration = selectedOption.getAttribute('data-duration');
          const price = selectedOption.getAttribute('data-price');
          const name = selectedOption.text;
          
          facialName.textContent = name;
          facialDescription.textContent = description;
          facialDuration.textContent = duration;
          facialPrice.textContent = price;
          
          // Mostrar el contenedor de información con animación
          facialInfo.style.display = 'block';
          facialInfo.classList.add('fade-in');
          
          // Guardar información del servicio para la reserva
          facialReserveBtn.setAttribute('data-service', name);
          facialReserveBtn.setAttribute('data-duration', duration);
        }
      });

      // Manejar clic en el botón de reservar
      if (facialReserveBtn) {
        facialReserveBtn.addEventListener('click', function() {
          const serviceName = this.getAttribute('data-service');
          const duration = this.getAttribute('data-duration');
          
          // Abrir el formulario de reserva con el servicio pre-seleccionado
          const reservaBtn = document.getElementById('open-reserva');
          if (reservaBtn) {
            reservaBtn.click();
            
            // Esperar un poco y luego pre-seleccionar el servicio
            setTimeout(function() {
              const serviceSelect = document.getElementById('service');
              if (serviceSelect) {
                // Buscar la opción que coincida con el nombre del servicio
                for (let i = 0; i < serviceSelect.options.length; i++) {
                  if (serviceSelect.options[i].text.includes(serviceName)) {
                    serviceSelect.selectedIndex = i;
                    serviceSelect.dispatchEvent(new Event('change'));
                    break;
                  }
                }
              }
            }, 300);
          }
        });
      }
    }
  });