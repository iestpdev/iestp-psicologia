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

          <form action="<?= base_url('api/alumnos/edit') ?>" method="POST">
            <?= csrf_field() ?>
            <div class="row">
              <!-- DNI, Nombres y Apellidos-->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    DNI <span class="required-mark">*</span>
                  </label>
                  <input type="text" name="dni" class="form-control-custom" placeholder="Ingrese el DNI" maxlength="8"
                    pattern="[0-9]{8}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Nombres <span class="required-mark">*</span>
                  </label>
                  <input type="text" name="nombres" class="form-control-custom" placeholder="Ingrese los nombres"
                    required>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Apellidos <span class="required-mark">*</span>
                  </label>
                  <input type="text" name="apellidos" class="form-control-custom" placeholder="Ingrese los apellidos"
                    required>
                </div>
              </div>
            </div>

            <!-- Programa de estudio, ciclo, turno -->
            <div class="row">
              <!-- Programa de estudio -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Programa de estudio <span class="required-mark">*</span>
                  </label>
                  <select name="programa_estudio" class="form-control-custom" required>
                    <option value="">-- Seleccione un programa--</option>
                    <?php foreach ($programas_estudios as $programas): ?>
                      <option value="<?= $programas['id'] ?>"><?= esc($programas['nombre']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <!-- Ciclo -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Ciclo <span class="required-mark">*</span>
                  </label>
                  <select name="ciclo" class="form-control-custom" required>
                    <option value="">Seleccione un ciclo</option>
                    <option value="1">1er Ciclo</option>
                    <option value="2">2do Ciclo</option>
                    <option value="3">3er Ciclo</option>
                    <option value="4">4to Ciclo</option>
                    <option value="5">5to Ciclo</option>
                    <option value="6">6to Ciclo</option>
                  </select>
                </div>
              </div>
              <!-- Turno -->
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Turno <span class="required-mark">*</span>
                  </label>
                  <div>
                    <label><input type="radio" name="turno" value="M" required> Mañana</label>
                    <label><input type="radio" name="turno" value="T" required> Tarde</label>
                  </div>
                </div>
              </div>

            </div>

            <!-- Teléfono , domicilio y sexo-->
            <div class="row">

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Teléfono
                  </label>
                  <input type="tel" name="telefono" class="form-control-custom" placeholder="Ingrese el teléfono"
                    maxlength="9" pattern="[0-9]{9}">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Domicilio
                  </label>
                  <input type="text" name="domicilio" class="form-control-custom"
                    placeholder="Ingrese el domicilio">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="form-label">
                    Sexo <span class="required-mark">*</span>
                  </label>
                  <div>
                    <label><input type="radio" name="sexo" value="M" required> Masculino</label>
                    <label><input type="radio" name="sexo" value="F" required> Femenino</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- dirección de nacimiento y fecha de nacimiento -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    Dirección de nacimiento
                  </label>
                  <input type="text" name="direccion_nac" class="form-control-custom"
                    placeholder="Ingrese la dirección de nacimiento">
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    Fecha de nacimiento
                  </label>
                  <input type="date" name="fecha_nac" class="form-control-custom">
                </div>
              </div>
            </div>

            <!-- Religion y Estado civil -->
            <div class="row">
              <!-- Religion -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    Religión <span class="required-mark">*</span>
                  </label>
                  <select name="religion" class="form-control-custom" required>
                    <option value="">-- Seleccione una religión--</option>
                    <?php foreach ($religiones as $religion): ?>
                      <option value="<?= $religion['id'] ?>"><?= esc($religion['nombre']) ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <!-- Estado civil -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label">
                    Estado civil <span class="required-mark">*</span>
                  </label>
                  <select name="estado_civil" class="form-control-custom" required>
                    <option value="">-- Seleccione un estado civil--</option>
                    <?php foreach ($estados_civiles as $estado_civil): ?>
                      <option value="<?= $estado_civil['id'] ?>"><?= esc($estado_civil['nombre']) ?></option>
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

<?= $this->endSection() ?>