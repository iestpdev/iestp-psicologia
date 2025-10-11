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
                        'title' => 'Editar Usuario',
                        'backUrl' => base_url('usuarios')
                    ]) ?>

                    <form action="<?= base_url('api/usuarios/update/') ?><?= $usuario['id'] ?>" method="POST"
                        data-confirm 
                        data-title="Editar Usuario" 
                        data-text="¿Desea actualizar este usuario?"
                        data-icon="question">

                        <?= csrf_field() ?>

                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                        <input type="hidden" name="persona_id" value="<?= $usuario['persona_id'] ?>">
                        <div class="row">
                            <!-- Rol -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Rol <span class="required-mark">*</span>
                                    </label>
                                    <select name="rol" class="form-control-custom" required>
                                        <option value="ADMIN" <?= $usuario['rol'] === 'ADMIN' ? 'selected' : '' ?>>
                                            Administrador(a)</option>
                                        <option value="PSICOLOGO" <?= $usuario['rol'] === 'PSICOLOGO' ? 'selected' : '' ?>>
                                            Psicólogo(a)</option>
                                        <option value="DOCENTE" <?= $usuario['rol'] === 'DOCENTE' ? 'selected' : '' ?>>
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
                                    <input type="text" name="dni" class="form-control-custom"
                                        placeholder="Ingrese el DNI" maxlength="8" pattern="[0-9]{8}"
                                        inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                        value="<?= $usuario['dni'] ?>" required>
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
                                    <input type="text" name="nombres" class="form-control-custom"
                                        placeholder="Ingrese los nombres" value="<?= $usuario['nombres'] ?>" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Apellidos <span class="required-mark">*</span>
                                    </label>
                                    <input type="text" name="apellidos" class="form-control-custom"
                                        placeholder="Ingrese los apellidos" value="<?= $usuario['apellidos'] ?>"
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
                                        value="<?= $usuario['telefono'] ?>" pattern="[0-9]{9}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Correo institucional <span class="required-mark">*</span>
                                    </label>
                                    <input type="email" name="correo" class="form-control-custom"
                                        value="<?= $usuario['correo_institucional'] ?>"
                                        placeholder="ejemplo@iestpchincha.edu.pe" required>
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
                                        value="<?= $usuario['username'] ?>" placeholder="Ingrese el username" required>
                                </div>
                            </div>
                        </div>

                        <!-- estado -->
                        <div class="form-check form-switch">
                            <input type="hidden" name="estado" value="0">
                            <input class="form-check-input" type="checkbox" role="switch" name="estado" value="1"
                                <?= $usuario['estado'] == 1 ? 'checked' : '' ?>>
                            <label class="form-check-label">
                                Estado del usuario <span class="required-mark">*</span>
                            </label>
                        </div>

                        <div class="row">
                            <div class="col-6 offset-3 text-center">
                                <?= view('shared/buttons/submitButton', ['text' => 'Actualizar']) ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->include('shared/alerts/sweetAlert2') ?>

<?= $this->endSection() ?>