<?php
$session = session();
$userLogged = $session->get('user');
$primerNombre = explode(' ', trim($userLogged['nombres']))[0] ?? '';
$primerApellido = explode(' ', trim($userLogged['apellidos']))[0] ?? '';
$rol = ($userLogged['rol'] === 'ADMIN')
    ? 'Administrador'
    : (($userLogged['rol'] === 'PSICOLOGO') ? 'Psicólogo' : 'Docente');
?>

<!-- Topbar -->
<div class="topbar">
    <!-- Botón hamburguesa -->
    <button class="palanca" type="button" onclick="toggleSidebar()">
        <ion-icon name="menu-outline"></ion-icon>
    </button>

    <!-- Título centrado -->
    <div class="titulo-label">
        Área de Psicología
    </div>

    <!-- Menú usuario -->
    <div class="user-menu-container">
        <div class="notification-icon-container" data-bs-toggle="modal" data-bs-target="#notificationsModal"
            style="cursor: pointer;">
            <ion-icon name="notifications-circle-outline"></ion-icon>
            <div class="conteoNotif">0</div>
        </div>

        <div class="user-info">
            <p class="user-name"><?= esc($primerNombre . ' ' . $primerApellido) ?></p>
            <p class="user-role"><?= esc($rol) ?></p>
        </div>
        <div class="user-icon-container">
            <a href="<?= base_url('profile') ?>">
                <ion-icon name="person-circle-outline"></ion-icon>
            </a>
        </div>
    </div>
</div>

<!-- Modal de Notificaciones -->
<div class="modal fade" id="notificationsModal" tabindex="-1" aria-labelledby="notificationsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationsModalLabel">
                    <ion-icon name="notifications-outline"></ion-icon> Notificaciones
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary">Marcar todas como leídas</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const conteoNotif = document.querySelector('.conteoNotif');
    const modalBody = document.querySelector('#notificationsModal .modal-body');
    const marcarBtn = document.querySelector('#notificationsModal .btn.btn-primary');

    const userId = <?= json_encode($userLogged['id']) ?>;
    const userRol = <?= json_encode($userLogged['rol']) ?>;

    // Determinar la URL para listar notificaciones
    const urlListar = (userRol === 'DOCENTE')
        ? `<?= base_url('api/notificaciones') ?>/${userId}`
        : `<?= base_url('api/notificaciones') ?>`;

    // Determinar la URL para marcar como leídas
    const urlMarcar = (userRol === 'DOCENTE')
        ? `<?= base_url('api/notificaciones/marcar-como-leido') ?>/${userId}`
        : `<?= base_url('api/notificaciones/marcar-como-leido') ?>`;

    // Función para cargar notificaciones
    function cargarNotificaciones() {
        fetch(urlListar)
            .then(response => response.json())
            .then(data => {
                modalBody.innerHTML = '';
                conteoNotif.textContent = data.filter(n => n.leido == 0).length;

                if (data.length === 0) {
                    modalBody.innerHTML = '<p class="text-muted text-center">No hay notificaciones.</p>';
                    return;
                }

                data.forEach(notif => {
                    const card = document.createElement('div');
                    card.classList.add('card', 'mb-3');
                    card.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-title">${notif.entidad} - ${notif.tipoNotificacion}</h6>
                            <p class="card-text">${notif.descripcion}</p>
                            <small class="text-muted">${notif.leido ? 'Leída' : 'No leída'}</small>
                        </div>
                    `;
                    modalBody.appendChild(card);
                });
            })
            .catch(err => {
                console.error('Error al cargar notificaciones:', err);
                modalBody.innerHTML = '<p class="text-danger text-center">Error al cargar notificaciones.</p>';
            });
    }

    // Cargar notificaciones al abrir la página
    cargarNotificaciones();

    // Evento para marcar todas como leídas
    marcarBtn.addEventListener('click', () => {
        fetch(urlMarcar, {
            method: 'PATCH'
        })
        .then(response => {
            if (!response.ok) throw new Error('Error en la petición');
            return response.json().catch(() => ({})); // manejar respuestas vacías
        })
        .then(() => {
            // Recargar la lista
            cargarNotificaciones();

            // Mostrar feedback visual (opcional)
            marcarBtn.textContent = '¡Todo leído!';
            setTimeout(() => {
                marcarBtn.textContent = 'Marcar todas como leídas';
            }, 1500);
        })
        .catch(err => {
            console.error('Error al marcar como leídas:', err);
            alert('No se pudieron marcar las notificaciones.');
        });
    });
});
</script>
