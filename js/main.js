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
    
    // Smooth scrolling para enlaces con hash
    $('a[href*="#"]').on('click', function(e) {
        var href = $(this).attr('href');
        
        // Extraer el hash del href
        var hash = href.includes('#') ? href.substring(href.indexOf('#')) : '';
        
        // Verificar si el hash no está vacío y el elemento existe
        if (hash && hash !== '#' && $(hash).length) {
            // Si el link incluye una página (como index.php#masajes)
            if (href.includes('.php') && !href.startsWith('#')) {
                // Extraer la página
                var page = href.substring(0, href.indexOf('#'));
                var currentPage = window.location.pathname.split('/').pop();
                
                // Si estamos en la misma página, hacer scroll
                if (page === currentPage || page === '' || page === 'index.php' && currentPage === '') {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top - 80
                    }, 600, 'swing');
                }
                // Si no, dejar que navegue normalmente
            } else {
                // Es un enlace interno simple (#masajes)
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 80
                }, 600, 'swing');
            }
        }
    });
    
    // Scroll automático si hay hash en la URL al cargar
    if (window.location.hash) {
        setTimeout(function() {
            var hash = window.location.hash;
            if ($(hash).length) {
                $('html, body').animate({
                    scrollTop: $(hash).offset().top - 80
                }, 600, 'swing');
            }
        }, 100);
    }
    
    // Volver arriba
    $('.back-to-top').click(function() {
        $('html, body').animate({scrollTop: 0}, 'slow');
        return false;
    });
    

    
    // Asegurar que las animaciones se ejecuten al cargar si el elemento ya está visible
    $(window).trigger('scroll');
});

document.addEventListener('DOMContentLoaded', function() {
    // Menú móvil toggle
    const menuBtnMobile = document.querySelector('.menu-btn-mobile');
    const mobileMenu = document.querySelector('.mobile-menu');
    
    if (menuBtnMobile && mobileMenu) {
        menuBtnMobile.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
            // Cambiar icono del menú
            this.textContent = mobileMenu.classList.contains('active') ? '✕' : '☰';
        });

        // Cerrar menú al hacer click en un link
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
          if (this.id === 'mobile-membresias-trigger') {
            return;
          }
                mobileMenu.classList.remove('active');
                menuBtnMobile.textContent = '☰';
            });
        });
    }

    // Botones de "Agendar Cita" en el header
    const headerAgendarBtn = document.getElementById('header-agendar');
    const mobileAgendarBtn = document.getElementById('mobile-agendar');
    const openReservaBtn = document.getElementById('open-reserva');

    if (headerAgendarBtn && openReservaBtn) {
        headerAgendarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openReservaBtn.click();
        });
    }

    if (mobileAgendarBtn && openReservaBtn) {
        mobileAgendarBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openReservaBtn.click();
        });
    }

    // Subnav de membresías (hover + click persistente)
    const header = document.querySelector('.header');
    const membershipsTrigger = document.getElementById('membresias-trigger');
    const membershipsSubnav = document.getElementById('membresias-subnav');
    let membershipsPinned = false;
    let closeMembersTimeout = null;

    const isDesktopHeader = () => window.matchMedia('(min-width: 969px)').matches;

    const openMemberships = () => {
      if (!header || !membershipsSubnav || !membershipsTrigger) return;
      header.classList.add('memberships-open');
      membershipsSubnav.setAttribute('aria-hidden', 'false');
      membershipsTrigger.setAttribute('aria-expanded', 'true');
    };

    const closeMemberships = (force = false) => {
      if (!header || !membershipsSubnav || !membershipsTrigger) return;
      if (membershipsPinned && !force) return;
      header.classList.remove('memberships-open');
      membershipsSubnav.setAttribute('aria-hidden', 'true');
      membershipsTrigger.setAttribute('aria-expanded', 'false');
    };

    const scheduleMembershipsClose = () => {
      if (closeMembersTimeout) {
        clearTimeout(closeMembersTimeout);
      }
      closeMembersTimeout = setTimeout(() => {
        closeMemberships();
      }, 100);
    };

    if (header && membershipsTrigger && membershipsSubnav) {
      membershipsTrigger.addEventListener('mouseenter', function() {
        if (!isDesktopHeader()) return;
        if (closeMembersTimeout) clearTimeout(closeMembersTimeout);
        openMemberships();
      });

      membershipsTrigger.addEventListener('mouseleave', function() {
        if (!isDesktopHeader() || membershipsPinned) return;
        scheduleMembershipsClose();
      });

      membershipsSubnav.addEventListener('mouseenter', function() {
        if (!isDesktopHeader()) return;
        if (closeMembersTimeout) clearTimeout(closeMembersTimeout);
        openMemberships();
      });

      membershipsSubnav.addEventListener('mouseleave', function() {
        if (!isDesktopHeader() || membershipsPinned) return;
        scheduleMembershipsClose();
      });

      membershipsTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        membershipsPinned = !membershipsPinned;

        if (membershipsPinned) {
          if (closeMembersTimeout) clearTimeout(closeMembersTimeout);
          openMemberships();
        } else {
          closeMemberships(true);
        }
      });

      document.addEventListener('click', function(e) {
        const clickedInside = membershipsTrigger.contains(e.target) || membershipsSubnav.contains(e.target);
        if (!clickedInside) {
          membershipsPinned = false;
          closeMemberships(true);
        }
      });

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          membershipsPinned = false;
          closeMemberships(true);
        }
      });

      window.addEventListener('resize', function() {
        if (!isDesktopHeader()) {
          membershipsPinned = false;
          closeMemberships(true);
        }
      });
    }

    // Modal de membresías para móvil (< 969px)
    const mobileMembershipsTrigger = document.getElementById('mobile-membresias-trigger');
    const mobileMembershipsModal = document.getElementById('memberships-mobile-modal');
    const mobileMembershipsClose = document.querySelectorAll('[data-close="memberships-mobile-modal"]');
    const isMobileMembershipsViewport = () => window.matchMedia('(max-width: 968px)').matches;

    const openMobileMembershipsModal = () => {
      if (!mobileMembershipsModal || !mobileMembershipsTrigger) return;
      mobileMembershipsModal.classList.add('is-open');
      mobileMembershipsModal.setAttribute('aria-hidden', 'false');
      mobileMembershipsTrigger.setAttribute('aria-expanded', 'true');
      document.body.classList.add('modal-open');
    };

    const closeMobileMembershipsModal = () => {
      if (!mobileMembershipsModal || !mobileMembershipsTrigger) return;
      mobileMembershipsModal.classList.remove('is-open');
      mobileMembershipsModal.setAttribute('aria-hidden', 'true');
      mobileMembershipsTrigger.setAttribute('aria-expanded', 'false');
      document.body.classList.remove('modal-open');
    };

    if (mobileMembershipsTrigger && mobileMembershipsModal) {
      mobileMembershipsTrigger.addEventListener('click', function(e) {
        e.preventDefault();
        if (!isMobileMembershipsViewport()) {
          return;
        }
        openMobileMembershipsModal();
      });

      mobileMembershipsClose.forEach(function(btn) {
        btn.addEventListener('click', function() {
          closeMobileMembershipsModal();
        });
      });

      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && mobileMembershipsModal.classList.contains('is-open')) {
          closeMobileMembershipsModal();
        }
      });

      window.addEventListener('resize', function() {
        if (!isMobileMembershipsViewport()) {
          closeMobileMembershipsModal();
        }
      });
    }

    // Configuración solo para móvil
    // if (window.innerWidth < 768) {
    //   const scrollContainer = document.querySelector('.services-mobile-scroll');
    //   const cards = document.querySelectorAll('.services-scroll-wrapper .service-card');
      
    //   // Añadir indicadores de scroll (opcional)
    //   const indicators = document.createElement('div');
    //   indicators.className = 'scroll-indicators';
    //   cards.forEach((_, index) => {
    //     const dot = document.createElement('span');
    //     dot.className = 'scroll-indicator';
    //     if (index === 0) dot.classList.add('active');
    //     indicators.appendChild(dot);
    //   });
    //   scrollContainer.parentNode.insertBefore(indicators, scrollContainer.nextSibling);
      
    //   // Actualizar indicadores al hacer scroll
    //   scrollContainer.addEventListener('scroll', function() {
    //     const scrollPosition = scrollContainer.scrollLeft;
    //     const cardWidth = cards[0].offsetWidth + 15; // + gap
    //     const activeIndex = Math.round(scrollPosition / cardWidth);
        
    //     document.querySelectorAll('.scroll-indicator').forEach((dot, index) => {
    //       dot.classList.toggle('active', index === activeIndex);
    //     });
    //   });
      
    //   // Hacer las tarjetas un poco más grandes en móvil
    //   cards.forEach(card => {
    //     card.style.minHeight = '420px';
    //   });
    // }

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
      const reservaForm = modal.querySelector('.reserva-form');
      const fechaInput = modal.querySelector('input[name="fecha"]');
      console.log('Modal de reserva encontrado, inicializando lógica de reserva', fechaInput);
      const durationInitiallyRequired = duracionSelect ? duracionSelect.required : false;

      const formatDateForInput = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
      };

      const buildDateWindow = () => {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const maxDate = new Date(today);
        maxDate.setMonth(maxDate.getMonth() + 1);

        return {
          min: today,
          max: maxDate,
          minString: formatDateForInput(today),
          maxString: formatDateForInput(maxDate)
        };
      };

      const isWeekendDate = (dateValue) => {
        if (!dateValue) return false;
        const selectedDate = new Date(`${dateValue}T00:00:00`);
        const dayOfWeek = selectedDate.getDay();
        return dayOfWeek === 0 || dayOfWeek === 6;
      };

      const isWithinAllowedRange = (dateValue) => {
        if (!dateValue) return false;
        const selectedDate = new Date(`${dateValue}T00:00:00`);
        const dateWindow = buildDateWindow();
        return selectedDate >= dateWindow.min && selectedDate <= dateWindow.max;
      };

      const updateDateInputConstraints = () => {
        if (!fechaInput) return;
        const dateWindow = buildDateWindow();
        fechaInput.min = dateWindow.minString;
        fechaInput.max = dateWindow.maxString;
      };

      const validateFechaInput = () => {
        if (!fechaInput) return true;

        const value = fechaInput.value;
        if (!value) {
          fechaInput.setCustomValidity('');
          return true;
        }

        if (!isWithinAllowedRange(value)) {
          fechaInput.setCustomValidity('Solo puedes reservar desde hoy y hasta un mes a partir de hoy.');
          return false;
        }

        if (!isWeekendDate(value)) {
          fechaInput.setCustomValidity('Solo se permiten reservas en sábado o domingo.');
          return false;
        }

        fechaInput.setCustomValidity('');
        return true;
      };

      const updateAvailableTimeSlots = () => {
        const horaSelect = document.getElementById('hora-select');
        if (!horaSelect || !fechaInput || !duracionSelect) return;

        const fecha = fechaInput.value;
        const duracion = duracionSelect.value;

        if (!fecha) {
          horaSelect.innerHTML = '<option value="">Primero selecciona una fecha</option>';
          horaSelect.disabled = true;
          return;
        }

        if (!duracion) {
          horaSelect.innerHTML = '<option value="">Primero selecciona una duración</option>';
          horaSelect.disabled = true;
          return;
        }

        // Mostrar mensaje de carga
        horaSelect.innerHTML = '<option value="">Cargando horarios disponibles...</option>';
        horaSelect.disabled = true;

        // Hacer petición AJAX para obtener horarios disponibles
        fetch(`get available_slots.php?fecha=${encodeURIComponent(fecha)}&duracion=${encodeURIComponent(duracion)}`)
          .then(response => response.json())
          .then(data => {
            console.log('Horarios disponibles recibidos:', data);
            if (data.error) {
              horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
              return;
            }

            if (data.length === 0) {
              horaSelect.innerHTML = '<option value="">No hay horarios disponibles</option>';
              return;
            }

            // Limpiar y agregar opción por defecto
            horaSelect.innerHTML = '<option value="">Selecciona una hora</option>';

            // Agregar las opciones de horario
            data.forEach(slot => {
              console.log('Procesando slot:', slot);
              const option = document.createElement('option');
              option.value = slot.time;
              option.textContent = slot.time;
              
              if (!slot.available) {
                option.disabled = true;
                option.textContent = `${slot.time} (No disponible)`;
                option.style.color = '#999';
              }
              
              horaSelect.appendChild(option);
            });

            horaSelect.disabled = false;
          })
          .catch(error => {
            console.error('Error al cargar horarios:', error);
            horaSelect.innerHTML = '<option value="">Error al cargar horarios</option>';
          });
      };

      const isSelectedServicePackage = () => {
        if (!servicioSelect) return false;
        const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
        return !!selectedOption && selectedOption.getAttribute('data-is-package') === '1';
      };

      const isSelectedServiceFacial = () => {
        if (!servicioSelect) return false;
        const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
        if (!selectedOption) return false;
        const optionText = (selectedOption.textContent || '').toLowerCase();
        const optionValue = (selectedOption.value || '').toLowerCase();
        return optionText.includes('(facial)') || optionValue.includes('(facial)');
      };

        const isSelectedServiceMassage = () => {
          if (!servicioSelect) return false;
          const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
          if (!selectedOption) return false;
          const optionText = (selectedOption.textContent || '').toLowerCase();
          const optionValue = (selectedOption.value || '').toLowerCase();
          return optionText.includes('masaje') || optionValue.includes('masaje');
        };

      const getSelectedServiceDuration = () => {
        if (!servicioSelect) return '';
        const selectedOption = servicioSelect.options[servicioSelect.selectedIndex];
        if (!selectedOption) return '';
        return selectedOption.getAttribute('data-duration') || '';
      };

      const setDurationState = (disabled, fixedValue = '') => {
        if (!duracionSelect) return;
        duracionSelect.disabled = disabled;
        duracionSelect.required = disabled ? false : durationInitiallyRequired;
        if (disabled) {
          duracionSelect.value = fixedValue;
        }
      };

        const setDurationOptions = (allowedValues = null) => {
          if (!duracionSelect) return;

          const normalizedAllowed = allowedValues ? allowedValues.map(value => value.toLowerCase()) : null;

          Array.from(duracionSelect.options).forEach(option => {
            if (!option.value) {
              option.disabled = false;
              option.hidden = false;
              return;
            }

            if (!normalizedAllowed) {
              option.disabled = false;
              option.hidden = false;
              return;
            }

            const isAllowed = normalizedAllowed.includes(option.value.toLowerCase());
            option.disabled = !isAllowed;
            option.hidden = !isAllowed;
          });
        };

      const syncDurationByService = (forcePackage = null, forceFacial = null, fixedDuration = null) => {
        const isPackageService = forcePackage === null ? isSelectedServicePackage() : !!forcePackage;
        const isFacialService = forceFacial === null ? isSelectedServiceFacial() : !!forceFacial;
        const isMassageService = isSelectedServiceMassage();
        const selectedServiceDuration = getSelectedServiceDuration();
        const durationToUse = fixedDuration || selectedServiceDuration;

        if (isPackageService) {
          setDurationOptions(durationToUse ? [durationToUse] : null);
          setDurationState(false);
          if (duracionSelect) {
            duracionSelect.value = durationToUse || '';
          }
          return;
        }

        if (isFacialService) {
          setDurationOptions(['90 min']);
          setDurationState(false);
          if (duracionSelect) {
            duracionSelect.value = '90 min';
          }
          return;
        }

        if (isMassageService) {
          setDurationOptions(['50 min', '80 min']);
          setDurationState(false);

          if (fixedDuration && duracionSelect) {
            duracionSelect.value = fixedDuration;
          } else if (duracionSelect && !['50 min', '80 min'].includes(duracionSelect.value)) {
            duracionSelect.value = '';
          }
          return;
        }

        setDurationOptions(null);
        setDurationState(false);
        if (fixedDuration && duracionSelect) {
          duracionSelect.value = fixedDuration;
        }
      };

      const findServiceOptionValue = (serviceIdentifier, preferFacial = false) => {
        if (!servicioSelect || serviceIdentifier === null || serviceIdentifier === undefined) return '';

        const normalizedIdentifier = String(serviceIdentifier).trim();
        if (!normalizedIdentifier) return '';

        const options = Array.from(servicioSelect.options);

        const exactById = options.find(option => String(option.value).trim() === normalizedIdentifier);
        if (exactById) return exactById.value;

        const normalizedServiceName = normalizedIdentifier.toLowerCase();

        const exactByValue = options.find(option => (option.value || '').trim().toLowerCase() === normalizedServiceName);
        if (exactByValue) return exactByValue.value;

        const exactByText = options.find(option => (option.textContent || '').trim().toLowerCase() === normalizedServiceName);
        if (exactByText) return exactByText.value;

        if (preferFacial) {
          const facialByName = options.find(option => {
            const optionText = (option.textContent || '').trim().toLowerCase();
            return optionText.includes(normalizedServiceName) && optionText.includes('(facial)');
          });
          if (facialByName) return facialByName.value;
        }

        const partial = options.find(option => {
          const optionValue = (option.value || '').trim().toLowerCase();
          const optionText = (option.textContent || '').trim().toLowerCase();
          return optionValue.includes(normalizedServiceName) || optionText.includes(normalizedServiceName);
        });

        return partial ? partial.value : '';
      };

      const closeModal = () => {
        modal.classList.remove('is-open');
        document.body.classList.remove('modal-open');
        modal.setAttribute('aria-hidden', 'true');
      };

      const openModal = (serviceIdentifier = null, duration = null, isPackage = null, isFacial = null) => {
        modal.classList.add('is-open');
        document.body.classList.add('modal-open');
        modal.setAttribute('aria-hidden', 'false');

        updateDateInputConstraints();
        validateFechaInput();
        
        // Pre-seleccionar el servicio si se proporciona
        if (serviceIdentifier && servicioSelect) {
          const optionValue = findServiceOptionValue(serviceIdentifier, !!isFacial);
          if (optionValue) {
            servicioSelect.value = optionValue;
          }
        }

        syncDurationByService(isPackage, isFacial, duration);
        
        // Actualizar horarios disponibles si hay fecha y duración
        setTimeout(() => {
          updateAvailableTimeSlots();
        }, 100);
      };

      if (servicioSelect) {
        servicioSelect.addEventListener('change', () => {
          syncDurationByService();
          updateAvailableTimeSlots();
        });
      }

      if (fechaInput) {
        updateDateInputConstraints();
        fechaInput.addEventListener('input', validateFechaInput);
        fechaInput.addEventListener('change', function() {
          validateFechaInput();
          updateAvailableTimeSlots();
        });
      }

      if (duracionSelect) {
        duracionSelect.addEventListener('change', () => {
          updateAvailableTimeSlots();
        });
      }

      if (reservaForm && fechaInput) {
        reservaForm.addEventListener('submit', function(e) {
          const formData = new FormData(reservaForm);
          const payload = Object.fromEntries(formData.entries());
          console.log('Datos de reservación (modal):', payload);

          updateDateInputConstraints();
          const isValidDate = validateFechaInput();

          if (!isValidDate) {
            e.preventDefault();
            fechaInput.reportValidity();
          }
        });
      }

      syncDurationByService();

      // Botón principal "Reserva ahora"
      if (openReserva) {
        openReserva.addEventListener('click', () => openModal());
      }

      // Opciones de duración/precio - al hacer clic abren el modal directamente
      document.querySelectorAll('.service-pricing-item').forEach(function(item) {
        item.addEventListener('click', function() {
          const serviceName = this.getAttribute('data-service');
          const duration = this.getAttribute('data-duration');
          openModal(serviceName, duration, false, false);
        });
        
        // Accesibilidad: permitir Enter/Space para activar
        item.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            const serviceName = this.getAttribute('data-service');
            const duration = this.getAttribute('data-duration');
            openModal(serviceName, duration, false, false);
          }
        });
      });

      // Botones de agendar paquete
      document.querySelectorAll('.package-agendar-btn').forEach(function(button) {
        button.addEventListener('click', function() {
          const serviceName = this.getAttribute('data-service');
          const duration = this.getAttribute('data-duration');
          openModal(serviceName, duration, true, false);
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
      
      // Función para actualizar la información del facial
      const updateFacialInfo = function() {
        const selectedOption = facialSelect.options[facialSelect.selectedIndex];
        
        if (facialSelect.value !== '') {
          // Actualizar la información del facial seleccionado
          const description = selectedOption.getAttribute('data-description');
          const duration = selectedOption.getAttribute('data-duration');
          const price = selectedOption.getAttribute('data-price');
          const name = selectedOption.text;
          
          facialName.textContent = name;
          facialDescription.textContent = description;
          facialDuration.textContent = duration;
          facialPrice.textContent = price;
          
          // Guardar información del servicio para la reserva
          facialReserveBtn.setAttribute('data-service-id', selectedOption.value);
          facialReserveBtn.setAttribute('data-duration', duration);
        }
      };
      
      // Event listener para cambios en el select
      facialSelect.addEventListener('change', updateFacialInfo);
      
      // Cargar información inicial al cargar la página
      updateFacialInfo();
    }

    // Manejar clic en el botón de reservar
    if (facialReserveBtn) {
      facialReserveBtn.addEventListener('click', function() {
        const serviceId = this.getAttribute('data-service-id');
        const duration = this.getAttribute('data-duration') || '90 min';
        
        // Abrir el formulario de reserva con el servicio pre-seleccionado
        const reservaBtn = document.getElementById('open-reserva');
        if (reservaBtn) {
          reservaBtn.click();
          
          // Esperar un poco y luego pre-seleccionar el servicio
          setTimeout(function() {
            const serviceSelect = document.getElementById('servicio-select');
            const durationSelect = document.getElementById('duracion-select');
            if (serviceSelect) {
              if (serviceId) {
                serviceSelect.value = serviceId;
                serviceSelect.dispatchEvent(new Event('change'));
              }

              if (durationSelect) {
                durationSelect.value = duration;
                durationSelect.disabled = false;
                durationSelect.required = true;
              }
            }
          }, 300);
        }
      });
    }
  });