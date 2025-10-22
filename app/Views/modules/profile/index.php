<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>


<style>
  .profile-header {
    font-weight: 600;
    color: var(--blue);
  }
</style>

<div class="container py-5">
  <h2 class="profile-header mb-4">Configuración de mi perfil</h2>
  <form>
    <div class="row mb-4">
      <h4>Información personal</h4>
      <div class="col-md-6">

        <div class="mb-3">
          <label for="dni" class="form-label">DNI</label>
          <input type="text" class="form-control" id="dni">
        </div>

        <div class="mb-3">
          <label for="nombres" class="form-label">Nombres</label>
          <input type="text" class="form-control" id="nombres">
        </div>

        <div class="mb-3">
          <label for="apellidos" class="form-label">Apellidos</label>
          <input type="text" class="form-control" id="apellidos">
        </div>
      </div>

      <div class="col-md-6">

        <div class="mb-3">
          <label for="email" class="form-label">Correo institucional</label>
          <input type="email" class="form-control" id="email">
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username">
        </div>

        <div class="mb-3">
          <label for="telefono" class="form-label">Telefono</label>
          <input type="tel" class="form-control" id="telefono">
        </div>

      </div>
    </div>

    <hr>

    <div class="row mb-4">
      <div class="col-md-6">
        <h4>Autenticación 2FA</h4>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="newsletterCheck">
          <label class="form-check-label" for="newsletterCheck">Recibir código por SMS</label>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="promotionsCheck">
          <label class="form-check-label" for="promotionsCheck">Recibir código por email</label>
        </div>
      </div>
      <div class="col-md-6">
        <h4>Notificaciones</h4>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="promotionsCheck">
          <label class="form-check-label" for="promotionsCheck">Recibir notificaciones por email</label>
        </div>
      </div>
    </div>

    <hr>

    <div class="row mb-4">
      <h4>Cambiar contraseña</h4>
      <div class="col-md-8">
        <div class="mb-3">
          <label for="currentPassword" class="form-label">Contraseña actual</label>
          <input type="password" class="form-control" id="currentPassword">
        </div>
        <div class="mb-3">
          <label for="newPassword" class="form-label">Nueva contraseña</label>
          <input type="password" class="form-control" id="newPassword">
        </div>
        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
          <input type="password" class="form-control" id="confirmPassword">
        </div>
      </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-secondary me-md-2">Cancelar</button>
      <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </div>
  </form>
</div>

<?= $this->endSection() ?>