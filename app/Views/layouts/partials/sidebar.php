<aside id="sidebar" class="navegacion">
  <ul>
    <li class="brand">
      <a href="#">
        <span class="icon"><img src="<?= base_url('assets/images/logo.png') ?>" class="icon" alt="Logo"></span>
        <span class="title">I.E.S.T.P "CHINCHA"</span>
      </a>
      <button class="cerrar-sidebar" type="button" onclick="cerrarSidebar(); event.stopPropagation();">
        <ion-icon name="menu-outline"></ion-icon>
      </button>
    </li>

    <li>
      <a href="<?= base_url('/') ?>">
        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
        <span class="title">Home</span>
      </a>
    </li>

    <li>
      <a href="<?= base_url('/usuarios') ?>">
        <span class="icon"><ion-icon name="people-outline"></ion-icon></span>
        <span class="title">Usuarios</span>
      </a>
    </li>

    <li>
      <a href="<?= base_url('/alumnos') ?>">
        <span class="icon"><ion-icon name="school-outline"></ion-icon></span>
        <span class="title">Alumnos</span>
      </a>
    </li>

    <li>
      <a href="<?= base_url('/derivaciones') ?>">
        <span class="icon"><ion-icon name="radio-outline"></ion-icon></span>
        <span class="title">Derivaciones</span>
      </a>
    </li>

    <li>
      <a href="<?= base_url('/citas') ?>">
        <span class="icon"><ion-icon name="heart-circle-outline"></ion-icon></span>
        <span class="title">Consultas</span>
      </a>
    </li>

    <li>
      <a href="<?= base_url('/api/auth/logout') ?>">
        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
        <span class="title">Cerrar sesión</span>
      </a>
    </li>
  </ul>
</aside>