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

  <form method="POST" action="<?= base_url('profile/update-userlogged') ?>">
    <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
    <input type="hidden" name="persona_id" value="<?= $usuario['persona_id'] ?>">
    <div class="row mb-4">
      <h4>Información personal</h4>
      <div class="col-md-6">

        <div class="mb-3">
          <label for="dni" class="form-label">DNI</label>
          <input 
          type="text"
          class="form-control" 
          id="dni" 
          name="dni"
          placeholder="Ingrese el DNI" 
          maxlength="8" pattern="[0-9]{8}"
          inputmode="numeric" 
          oninput="this.value = this.value.replace(/[^0-9]/g, '');"
          value="<?= esc($usuario['dni'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="nombres" class="form-label">Nombres</label>
          <input type="text" class="form-control" id="nombres" name="nombres"
            value="<?= esc($usuario['nombres'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="apellidos" class="form-label">Apellidos</label>
          <input type="text" class="form-control" id="apellidos" name="apellidos"
            value="<?= esc($usuario['apellidos'] ?? '') ?>">
        </div>
      </div>

      <div class="col-md-6">

        <div class="mb-3">
          <label for="correo" class="form-label">Correo institucional</label>
          <input type="email" class="form-control" id="correo" name="correo"
            value="<?= esc($usuario['correo_institucional'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username"
            value="<?= esc($usuario['username'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label for="telefono" class="form-label">Teléfono</label>
          <input 
          type="tel" 
          class="form-control" 
          id="telefono" 
          name="telefono"
          placeholder="Ingrese el teléfono" 
          maxlength="9"
          value="<?= esc($usuario['telefono'] ?? '') ?>">
        </div>

      </div>
    </div>

    <hr>

    <div class="row mb-4">
      <div class="col-md-6">
        <h4>Autenticación 2FA</h4>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="auth_SMS" name="auth_SMS"
            <?= !empty($configuracion['auth_SMS']) && $configuracion['auth_SMS'] ? 'checked' : '' ?>>
          <label class="form-check-label" for="auth_SMS">Recibir código por SMS</label>
        </div>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="auth_email" name="auth_email"
            <?= !empty($configuracion['auth_email']) && $configuracion['auth_email'] ? 'checked' : '' ?>>
          <label class="form-check-label" for="auth_email">Recibir código por email</label>
        </div>
      </div>

      <div class="col-md-6">
        <h4>Notificaciones</h4>
        <div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="notif_email" name="notif_email"
            <?= !empty($configuracion['notif_email']) && $configuracion['notif_email'] ? 'checked' : '' ?>>
          <label class="form-check-label" for="notif_email">Recibir notificaciones por email</label>
        </div>
      </div>
    </div>

    <hr>

    <div class="row mb-4">
      <h4>Cambiar contraseña</h4>
      <div class="col-md-8">

        <div class="mb-3">
          <label class="form-label" for="currentPassword">Contraseña actual</label>
          <div class="input-group-custom">
            <input type="password" name="currentPassword" id="currentPassword" class="form-control-custom"
              placeholder="Ingrese su contraseña actual" required>
            <button type="button" class="btn-password-toggle" id="toggleCurrentPassword">
              <i data-lucide="eye"></i>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label for="newPassword" class="form-label">Nueva contraseña</label>
          <div class="input-group-custom">
            <input type="password" class="form-control-custom" id="newPassword" name="newPassword">
            <button type="button" class="btn-password-toggle" id="toggleNewPassword">
              <i data-lucide="eye"></i>
            </button>
          </div>
        </div>

        <div class="mb-3">
          <label for="confirmPassword" class="form-label">Confirmar nueva contraseña</label>
          <div class="input-group-custom">
            <input type="password" class="form-control-custom" id="confirmPassword" name="confirmPassword">
            <button type="button" class="btn-password-toggle" id="toggleConfirmPassword">
              <i data-lucide="eye"></i>
            </button>
          </div>
        </div>

      </div>
    </div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <button type="button" class="btn btn-secondary me-md-2">Cancelar</button>
      <button type="submit" class="btn btn-primary">Guardar cambios</button>
    </div>
  </form>
</div>
<?= $this->include('shared/toasts/notyf') ?>
<script type="module" src="<?= base_url('js/services/decolecta.js') ?>"></script>
<script src="<?= base_url('js/shared/inputs/showPassInput.js') ?>"></script>

<?= $this->endSection() ?>