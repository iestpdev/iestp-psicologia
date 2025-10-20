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
        <div class="user-info">
            <p class="user-name"><?= esc($primerNombre . ' ' . $primerApellido) ?></p>
            <p class="user-role"><?= esc($rol) ?></p>
        </div>
        <div class="user-icon-container">
            <ion-icon name="person-circle-outline"></ion-icon>
        </div>
    </div>
</div>