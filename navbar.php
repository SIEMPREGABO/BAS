<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root {
        --spa-primary: #7ec8b2;
        --spa-secondary: #f6f5f3;
        --spa-accent: #e7b7a0;
        --spa-text: #3a4d39;
        --spa-hover: #e3f2ef;
    }

    .navbar {}

    .navbar-brand {
        font-weight: bold;
        font-size: 1.5rem;
        font-family: 'Poppins', sans-serif;
        transform: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        letter-spacing: 2px;
    }

    .navbar-nav .nav-link {
        color: var(--spa-text) !important;
        font-weight: 500;
        transition: background 0.2s, color 0.2s;
        border-radius: 8px;
        padding: 0.5rem 1rem;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link:focus {
        background: var(--spa-hover);
        color: var(--spa-primary) !important;
    }

    .dropdown-menu {
        background: var(--spa-secondary);
        border-radius: 12px;
        border: 1px solid var(--spa-primary);
        box-shadow: 0 4px 16px rgba(126, 200, 178, 0.10);
    }

    .dropdown-header,
    .dropdown-item {
        color: var(--spa-text);
    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background: var(--spa-hover);
        color: var(--spa-primary);
    }

    .user-dropdown img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--spa-primary);
        background: var(--spa-secondary);
    }

    .notification-item {
        transition: background-color 0.3s;
        padding: 0.5rem 1rem;
    }

    .notification-item:hover {
        background-color: var(--spa-hover);
    }

    .notification-counter {
        font-size: 0.7rem;
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: var(--spa-accent) !important;
        color: #fff;
        border-radius: 50%;
        min-width: 20px;
        min-height: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 1px 4px rgba(231, 183, 160, 0.15);
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" id="navTitle" href="#">Beauty & Soul</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto d-flex align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle position-relative" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <svg xmlns="http://www.w3.org/2000/svg" width="31" height="30" viewBox="0 0 31 30" fill="none">
                            <path d="M16.9455 24.7883C16.9455 26.6653 15.4756 28.1878 13.6612 28.1878C11.8469 28.1878 10.377 26.5401 10.377 24.663" stroke="var(--spa-primary)" stroke-width="2.5" stroke-miterlimit="10" />
                            <path d="M18.5455 4.9171C17.6105 4.20398 16.504 3.68199 15.1767 3.51063C10.3569 2.8911 7.84986 5.52477 6.58687 7.28714C4.73845 9.86544 4.56559 13.3295 4.81793 16.6025C4.94789 18.2898 5.07406 19.8742 3.55495 20.6308C1.02898 21.8896 2.05728 24.6591 3.3026 24.6591C9.87113 24.6591 10.1247 24.6591 15.1779 24.6591C17.9575 24.6591 18.4622 24.6591 23.9671 24.5563C25.2124 24.5325 26.2407 21.7868 23.7148 20.528C22.1957 19.7714 22.3218 18.1869 22.4518 16.4997C22.5414 15.3397 22.5779 14.1573 22.5048 12.9974" stroke="var(--spa-primary)" stroke-width="2.5" stroke-miterlimit="10" />
                            <path d="M28.9999 7.5402C28.9999 10.5996 26.5117 13.0791 23.442 13.0791C23.1215 13.0791 22.8073 13.0527 22.502 13C19.8801 12.5545 17.8828 10.2793 17.8828 7.5402C17.8828 6.59113 18.1225 5.69874 18.544 4.91707C19.4827 3.18106 21.3235 2 23.4407 2C26.5117 2.00132 28.9999 4.48076 28.9999 7.5402Z" stroke="var(--spa-primary)" stroke-width="2.5" stroke-miterlimit="10" />
                        </svg>
                        <span class="badge notification-counter">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end notification-dropdown">
                        <li>
                            <h6 class="dropdown-header">Notificaciones</h6>
                        </li>
                        <div class="notification-list">
                            <!-- Las notificaciones se cargarán aquí dinámicamente -->
                        </div>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item view-all" href="#">Ver todas</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown user-dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="images/user-avatar.png" height="40" width="40" alt="Usuario" class="me-2">
                        <?php //echo $_SESSION['usuario']['nombre']; 
                        ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="dashboard.php"><i class="bi bi-house-door me-2"></i> Inicio</a></li>
                        <li><a class="dropdown-item" href="citas.php"><i class="bi bi-calendar-check me-2"></i> Citas</a></li>
                        <li><a class="dropdown-item" href="clientes.php"><i class="bi bi-people me-2"></i> Clientes</a></li>
                        <li><a class="dropdown-item" href="users.php"><i class="bi bi-people me-2"></i> Usuarios</a></li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar notificaciones al abrir el dropdown
        document.querySelector('.dropdown-toggle').addEventListener('click', function() {
            loadNotifications();
        });

        // Marcar como leída al hacer clic en una notificación
        document.querySelector('.notification-dropdown').addEventListener('click', function(e) {
            if (e.target.classList.contains('notification-item')) {
                const notificationId = e.target.dataset.id;
                markAsRead(notificationId);
                e.target.remove();
                updateNotificationCounter();
            }
        });
    });

    function loadNotifications() {
        fetch('get_notifications.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(text => {
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Respuesta no es JSON válido:', text);
                    return;
                }
                const notificationList = document.querySelector('.notification-list');
                notificationList.innerHTML = '';

                if (!Array.isArray(data) || data.length === 0) {
                    notificationList.innerHTML = '<li><a class="dropdown-item" href="#">No hay notificaciones nuevas</a></li>';
                } else {
                    data.forEach(notification => {
                        const notificationItem = document.createElement('li');
                        notificationItem.innerHTML = `
                        <a class="dropdown-item notification-item" href="#" data-id="${notification.id_notificacion}">
                            ${notification.mensaje}
                            <small class="text-muted d-block">${new Date(notification.fecha_envio).toLocaleString()}</small>
                        </a>
                    `;
                        notificationList.appendChild(notificationItem);
                    });
                }

                updateNotificationCounter();
            })
            .catch(error => console.error('Error:', error));
    }

    function markAsRead(notificationId) {
        fetch('mark_as_read.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    id: notificationId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Error al marcar como leída');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function updateNotificationCounter() {
        fetch('count_unread_notifications.php')
            .then(response => response.json())
            .then(data => {
                const counter = document.querySelector('.notification-counter');
                counter.textContent = data.count;

                if (data.count > 0) {
                    counter.classList.remove('d-none');
                    counter.classList.add('bg-danger');
                } else {
                    counter.classList.add('d-none');
                }
            })
            .catch(error => console.error('Error:', error));
    }

    // Actualizar el contador periódicamente
    setInterval(updateNotificationCounter, 30000); // Cada 30 segundos
</script>