<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-card">
                    <!-- Título y botón de regresar -->
                    <?= view('shared/forms/formHeader', [
                        'title' => 'Registrar Usuario',
                        'backUrl' => base_url('usuarios')
                    ]) ?>

                    <form action="<?= base_url('api/usuarios/add') ?>" method="POST" data-confirm
                        data-title="Registrar Usuario" data-text="¿Desea registrar este nuevo usuario?"
                        data-icon="question">

                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Rol -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Rol <span class="required-mark">*</span>
                                    </label>
                                    <select name="rol" class="form-control-custom" required>
                                        <option value="">Seleccione un rol</option>
                                        <option value="ADMIN" <?= set_value('rol') === 'ADMIN' ? 'selected' : '' ?>>
                                            Administrador(a)</option>
                                        <option value="PSICOLOGO" <?= set_value('rol') === 'PSICOLOGO' ? 'selected' : '' ?>>Psicólogo(a)</option>
                                        <option value="DOCENTE" <?= set_value('rol') === 'DOCENTE' ? 'selected' : '' ?>>
                                            Docente</option>
                                    </select>
                                </div>
                            </div>

                            <!-- DNI -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        DNI <span class="required-mark">*</span>
                                    </label>
                                    <input type="text" name="dni" id="dni" class="form-control-custom"
                                        placeholder="Ingrese el DNI" maxlength="8" pattern="[0-9]{8}"
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        value="<?= set_value('dni') ?>" required>
                                </div>
                            </div>
                        </div>

                        <!-- Nombres y Apellidos -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Nombres <span class="required-mark">*</span>
                                    </label>
                                    <input type="text" name="nombres" id="nombres" class="form-control-custom"
                                        placeholder="Ingrese los nombres" value="<?= set_value('nombres') ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Apellidos <span class="required-mark">*</span>
                                    </label>
                                    <input type="text" name="apellidos" id="apellidos" class="form-control-custom"
                                        placeholder="Ingrese los apellidos" value="<?= set_value('apellidos') ?>"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Teléfono y Correo -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Teléfono
                                    </label>
                                    <input type="tel" name="telefono" class="form-control-custom"
                                        placeholder="Ingrese el teléfono" maxlength="9"
                                        value="<?= set_value('telefono') ?>" pattern="[0-9]{9}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Correo institucional <span class="required-mark">*</span>
                                    </label>
                                    <input type="email" name="correo" class="form-control-custom"
                                        value="<?= set_value('correo') ?>" placeholder="ejemplo@iestpchincha.edu.pe"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Username y Password -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Username <span class="required-mark">*</span>
                                    </label>
                                    <input type="text" name="username" class="form-control-custom"
                                        value="<?= set_value('username') ?>" placeholder="Ingrese el username" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label" for="password">
                                        Password <span class="required-mark">*</span>
                                    </label>
                                    <div class="input-group-custom">
                                        <input type="password" name="password" class="form-control-custom"
                                            placeholder="Ingrese la contraseña" id="password"
                                            pattern="^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$"
                                            title="La contraseña debe tener mínimo 8 caracteres, una mayúscula, un número y un carácter especial"
                                            required>
                                        <button class="btn-password-toggle" type="button" id="togglePassword">
                                            <i data-lucide="eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- estado -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="estado" value="0">
                                    <input class="form-check-input" type="checkbox" role="switch" name="estado"
                                        value="1" <?= set_checkbox('estado', '1', true) ?>>
                                    <label class="form-check-label">
                                        Estado del usuario <span class="required-mark">*</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 offset-3 text-center">
                                <?= view('shared/buttons/submitButton', ['text' => 'Guardar']) ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('shared/toasts/notyf') ?>
<script type="module" src="<?= base_url('js/services/decolecta.js') ?>"></script>
<script src="<?= base_url('js/shared/inputs/showPassInput.js') ?>"></script>
<?= $this->include('shared/alerts/sweetAlert2') ?>

<?= $this->endSection() ?>