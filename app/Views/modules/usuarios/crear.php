<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

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

                    <form action="<?= base_url('api/usuarios/add') ?>" method="POST">
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
                                        <option value="ADMIN">Administrador(a)</option>
                                        <option value="PSICOLOGO">Psicólogo(a)</option>
                                        <option value="DOCENTE">Docente</option>
                                    </select>
                                </div>
                            </div>

                            <!-- DNI -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        DNI <span class="required-mark">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="dni"
                                        class="form-control-custom"
                                        placeholder="Ingrese el DNI"
                                        maxlength="8"
                                        pattern="[0-9]{8}"
                                        required>
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
                                    <input
                                        type="text"
                                        name="nombres"
                                        class="form-control-custom"
                                        placeholder="Ingrese los nombres"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Apellidos <span class="required-mark">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="apellidos"
                                        class="form-control-custom"
                                        placeholder="Ingrese los apellidos"
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
                                    <input
                                        type="tel"
                                        name="telefono"
                                        class="form-control-custom"
                                        placeholder="Ingrese el teléfono"
                                        maxlength="9"
                                        pattern="[0-9]{9}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Correo institucional <span class="required-mark">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        name="correo"
                                        class="form-control-custom"
                                        placeholder="ejemplo@iestpchincha.edu.pe"
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
                                    <input
                                        type="text"
                                        name="username"
                                        class="form-control-custom"
                                        placeholder="Ingrese el username"
                                        required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Password <span class="required-mark">*</span>
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control-custom"
                                        placeholder="Ingrese la contraseña"
                                        required>
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

<?= $this->endSection() ?>