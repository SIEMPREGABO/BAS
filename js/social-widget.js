// ======================================
// WIDGET FLOTANTE DE REDES SOCIALES
// ======================================

document.addEventListener('DOMContentLoaded', function() {
  const socialFloatBtn = document.getElementById('social-float-btn');
  const socialPanel = document.getElementById('social-panel');
  const socialPanelClose = document.getElementById('social-panel-close');
  
  // Crear overlay oscuro
  const overlay = document.createElement('div');
  overlay.className = 'social-panel-overlay';
  document.body.appendChild(overlay);
  
  // ======================================
  // ROTACIÓN AUTOMÁTICA DE REDES SOCIALES
  // ======================================
  const socialNetworks = [
    {
      name: 'instagram',
      icon: 'fa-instagram',
      class: 'social-instagram'
    },
    {
      name: 'tiktok',
      icon: 'fa-tiktok',
      class: 'social-tiktok'
    },
    {
      name: 'facebook',
      icon: 'fa-facebook',
      class: 'social-facebook'
    }
  ];
  
  let currentIndex = 0;
  
  function rotateSocialNetwork() {
    const iconElement = socialFloatBtn.querySelector('i');
    const network = socialNetworks[currentIndex];
    
    // Cambiar ícono
    iconElement.className = `fa-brands ${network.icon}`;
    
    // Cambiar color de fondo
    socialFloatBtn.classList.remove('social-instagram', 'social-tiktok', 'social-facebook');
    socialFloatBtn.classList.add(network.class);
    
    // Avanzar al siguiente índice
    currentIndex = (currentIndex + 1) % socialNetworks.length;
  }
  
  // Inicializar con Instagram
  socialFloatBtn.classList.add('social-instagram');
  
  // Rotar cada 2 segundos
  setInterval(rotateSocialNetwork, 2000);
  
  // Abrir panel
  if (socialFloatBtn) {
    socialFloatBtn.addEventListener('click', function() {
      socialPanel.classList.add('active');
      overlay.classList.add('active');
      document.body.style.overflow = 'hidden'; // Prevenir scroll del body
    });
  }
  
  // Cerrar panel
  const closeSocialPanel = () => {
    socialPanel.classList.remove('active');
    overlay.classList.remove('active');
    document.body.style.overflow = ''; // Restaurar scroll
  };
  
  if (socialPanelClose) {
    socialPanelClose.addEventListener('click', closeSocialPanel);
  }
  
  // Cerrar al hacer clic en el overlay
  overlay.addEventListener('click', closeSocialPanel);
  
  // Cerrar con tecla Escape
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && socialPanel.classList.contains('active')) {
      closeSocialPanel();
    }
  });
  
  // Sistema de pestañas
  const socialTabs = document.querySelectorAll('.social-tab');
  const socialTabContents = document.querySelectorAll('.social-tab-content');
  
  socialTabs.forEach(tab => {
    tab.addEventListener('click', function() {
      const targetTab = this.getAttribute('data-tab');
      
      // Remover active de todas las pestañas
      socialTabs.forEach(t => t.classList.remove('active'));
      socialTabContents.forEach(content => content.classList.remove('active'));
      
      // Activar pestaña seleccionada
      this.classList.add('active');
      document.querySelector(`[data-tab-content="${targetTab}"]`).classList.add('active');
    });
  });
});
