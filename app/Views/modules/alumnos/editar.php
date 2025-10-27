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
            'title' => 'Editar Alumno',
            'backUrl' => base_url('alumnos')
          ]) ?>

          <form action="<?= base_url('api/alumnos/update/' . $alumno['id']) ?>" method="POST" data-confirm
            data-title="Editar Alumno" data-text="¿Desea actualizar este alumno?" data-icon="question">
            <?= csrf_field() ?>
            <input type="hidden" name="id" value="<?= esc($alumno['id']) ?>">

            <div class="row">
              <!-- DNI, email-->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">DNI <span class="required-mark">*</span></label>
                  <input type="text" name="dni" class="form-control-custom" value="<?= esc($alumno['dni']) ?>"
                    maxlength="8" pattern="[0-9]{8}" required>
                </div>
              </div>

              <div class="col-md-8">
                <div class="form-group">
                  <label class="form-label">Correo institucional <span class="required-mark">*</span></label>
                  <input type="email" name="correo" class="form-control-custom" value="<?= $alumno['email'] ?>"
                    placeholder="ejemplo@iestpchincha.edu.pe" required>
                </div>
              </div>

            </div>

            <div class="row">
              <!-- Nombres y Apellidos-->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Nombres <span class="required-mark">*</span></label>
                  <input type="text" name="nombres" class="form-control-custom" value="<?= esc($alumno['nombres']) ?>"
                    required>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Apellidos <span class="required-mark">*</span></label>
                  <input type="text" name="apellidos" class="form-control-custom"
                    value="<?= esc($alumno['apellidos']) ?>" required>
                </div>
              </div>
            </div>

            <!-- Programa de estudio, ciclo, turno -->
            <div class="row">
              <!-- Programa de estudio -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Programa de estudio <span class="required-mark">*</span></label>
                  <select name="programa_estudio" class="form-control-custom" required>
                    <option value="">-- Seleccione un programa--</option>
                    <?php foreach ($programas_estudios as $programa): ?>
                      <option value="<?= $programa['id'] ?>" <?= $programa['id'] == $alumno['programa_estudio_id'] ? 'selected' : '' ?>>
                        <?= esc($programa['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <!-- Ciclo -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Ciclo <span class="required-mark">*</span></label>
                  <select name="ciclo" class="form-control-custom" required>
                    <option value="">Seleccione un ciclo</option>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                      <option value="<?= $i ?>" <?= $alumno['ciclo'] == $i ? 'selected' : '' ?>>
                        <?= $i ?>º Ciclo
                      </option>
                    <?php endfor; ?>
                  </select>
                </div>
              </div>

              <!-- Turno -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Turno <span class="required-mark">*</span></label>
                  <div>
                    <label>
                      <input type="radio" name="turno" value="M" <?= $alumno['turno'] == 'M' ? 'checked' : '' ?>> Mañana
                    </label>
                    <label>
                      <input type="radio" name="turno" value="T" <?= $alumno['turno'] == 'T' ? 'checked' : '' ?>> Tarde
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Teléfono , domicilio y sexo-->
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Teléfono</label>
                  <input type="tel" name="telefono" class="form-control-custom" value="<?= esc($alumno['telefono']) ?>"
                    maxlength="9" pattern="[0-9]{9}">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Domicilio</label>
                  <input type="text" name="domicilio" class="form-control-custom"
                    value="<?= esc($alumno['domicilio']) ?>">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">Sexo <span class="required-mark">*</span></label>
                  <div>
                    <label>
                      <input type="radio" name="sexo" value="M" <?= $alumno['sexo'] == 'M' ? 'checked' : '' ?>> Masculino
                    </label>
                    <label>
                      <input type="radio" name="sexo" value="F" <?= $alumno['sexo'] == 'F' ? 'checked' : '' ?>> Femenino
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <!-- dirección de nacimiento y fecha de nacimiento -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Dirección de nacimiento</label>
                  <input type="text" name="direccion_nac" class="form-control-custom"
                    value="<?= esc($alumno['direccion_nac']) ?>">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Fecha de nacimiento</label>
                  <input type="date" name="fecha_nac" class="form-control-custom"
                    value="<?= esc($alumno['fecha_nac']) ?>">
                </div>
              </div>
            </div>

            <!-- Religion y Estado civil -->
            <div class="row">
              <!-- Religion -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Religión</label>
                  <select name="religion" class="form-control-custom">
                    <option value="">-- Seleccione una religión--</option>
                    <?php foreach ($religiones as $religion): ?>
                      <option value="<?= $religion['id'] ?>" <?= $religion['id'] == $alumno['religion_id'] ? 'selected' : '' ?>>
                        <?= esc($religion['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <!-- Estado civil -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">Estado civil</label>
                  <select name="estado_civil" class="form-control-custom">
                    <option value="">-- Seleccione un estado civil--</option>
                    <?php foreach ($estados_civiles as $estado_civil): ?>
                      <option value="<?= $estado_civil['id'] ?>" <?= $estado_civil['id'] == $alumno['estado_civil_id'] ? 'selected' : '' ?>>
                        <?= esc($estado_civil['nombre']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
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
<?= $this->include('shared/toasts/notyf') ?>
<script type="module" src="<?= base_url('js/services/decolecta.js') ?>"></script>
<?= $this->include('shared/alerts/sweetAlert2') ?>
<?= $this->endSection() ?>