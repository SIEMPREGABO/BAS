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

    if (openReserva && modal) {
      const closeModal = () => {
        modal.classList.remove('is-open');
        document.body.classList.remove('modal-open');
        modal.setAttribute('aria-hidden', 'true');
      };

      const openModal = () => {
        modal.classList.add('is-open');
        document.body.classList.add('modal-open');
        modal.setAttribute('aria-hidden', 'false');
      };

      openReserva.addEventListener('click', openModal);
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
  });