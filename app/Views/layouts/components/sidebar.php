<!-- Toggle Button -->
<button class="btn btn-light toggle-btn shadow-sm" onclick="toggleSidebar()">
    <i class="bi bi-list fs-5"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header p-3">
        <div class="d-flex align-items-center justify-content-start">
            <img src="assets/images/logo.png" class="icon" alt="Logo">
            <h5 class="mb-0">I.E.S.T.P "CHINCHA"</h5>
        </div>
    </div>

    <!-- User Profile -->
    <div class="p-3 border-bottom">
        <div class="d-flex align-items-center">
            <!-- <img src="https://via.placeholder.com/40" class="rounded-circle me-2" alt="User">-->
            <div>
                <h6 class="mb-0">Dante Luque</h6>
                <small class="text-muted">
                    <span class="user-status"></span>
                    administrador
                </small>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="nav flex-column mt-2">
        <a href="<?= base_url('/') ?>" class="nav-link active">
            <ion-icon name="home-outline"></ion-icon>
            Home
        </a>
        <a href="<?= base_url('/usuarios') ?>" class="nav-link">
            <ion-icon name="people-outline"></ion-icon>
            Usuarios
        </a>
        <a href="<?= base_url('/alumnos') ?>" class="nav-link">
            <ion-icon name="school-outline"></ion-icon>
            Alumnos
        </a>
        <a href="<?= base_url('/derivaciones') ?>" class="nav-link">
            <ion-icon name="radio-outline"></ion-icon>
            Derivaciones
        </a>
        <a href="<?= base_url('/consultas') ?>" class="nav-link">
            <ion-icon name="heart-circle-outline"></ion-icon>
            Consultas
        </a>
        <a href="<?= base_url('/logout') ?>" class="nav-link">
            <ion-icon name="log-out-outline"></ion-icon>
            Cerrar sesión
        </a>
    </nav>
</div>