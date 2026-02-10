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
  });