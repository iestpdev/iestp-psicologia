<?php // TODO: REFACTORIZAR ESTE CÓDIGO 
?>
<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<style>
    .msg-dni-success {
        color: green;
        font-size: 0.9rem;
        margin-top: 5px;
    }

    .msg-dni-error {
        color: red;
        font-size: 0.9rem;
        margin-top: 5px;
    }

    #detallesCitaFieldset {
        display: none;
    }
</style>

<div class="form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-card">
                    <!-- Título y botón de regresar -->
                    <?= view('shared/forms/formHeader', [
                        'title' => 'Registrar Consulta',
                        'backUrl' => base_url('citas')
                    ]) ?>

                    <form action="<?= base_url('api/citas/add') ?>" method="POST" data-confirm
                        data-title="Registrar Consulta" data-text="¿Desea registrar esta nueva consulta?"
                        data-icon="question">
                        <?= csrf_field() ?>
                        <input type="hidden" name="isDerivacionDocente" value="<?= esc($derivacionEnviada['id']) ?>">
                        <div class="row">
                            <!-- Tipo de derivación -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Tipo de derivación <span class="required-mark">*</span>
                                    </label>
                                    <input type="hidden" name="tipo_derivacion" value="DOCENTE">
                                    <input type="text" class="form-control-custom bg-light" value="DOCENTE" readonly>
                                </div>
                            </div>

                            <!-- Psicólogo asignado -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Psicólogo asignado <span class="required-mark">*</span>
                                    </label>
                                    <?php if (session('user.rol') === 'ADMIN'): ?>
                                    <select name="usuario_id" id="usuario_id" class="form-control-custom" required>
                                        <option value="">-- Seleccione un psicólogo --</option>
                                        <?php foreach ($psicologos as $psicologo): ?>
                                            <option value="<?= $psicologo['id'] ?>" <?= set_select('usuario_id', $psicologo['id']) ?>>
                                                <?= esc($psicologo['persona_nombres_completos']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php elseif (session('user.rol') === 'PSICOLOGO'): ?>
                                        <input type="text" class="form-control-custom"
                                               value="<?= esc(session('user.nombres').' '.session('user.apellidos') ) ?>" disabled>
                                        <input type="hidden" name="usuario_id" 
                                               value="<?= esc(session('user.id')) ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Derivaciones pendientes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Derivaciones pendientes <span
                                            class="required-mark">*</span></label>
                                    <input type="hidden" name="derivacion" value="<?= esc($derivacionEnviada['id']) ?>">
                                    <input type="text" class="form-control-custom bg-light"
                                        value="<?= esc($derivacionEnviada['data_derivacion']) ?>" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Motivo -->
                        <div class="textarea-wrapper">
                            <label class="textarea-label">Motivos <span class="required-mark">*</span></label>
                            <textarea name="motivo" class="auto-expand-textarea" placeholder="Detalle el motivo..."
                                maxlength="500"><?= esc($derivacionEnviada['motivo'] ?? set_value('motivo')) ?></textarea>
                            <div class="character-count">
                                <?= strlen($derivacionEnviada['motivo'] ?? set_value('motivo')) ?>/500
                            </div>
                        </div>

                        <!-- Atención -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Fecha de atención <span
                                            class="required-mark">*</span></label>
                                    <input type="date" name="fecha_atencion" class="form-control-custom" required
                                        value="<?= set_value('fecha_atencion') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Hora inicio <span class="required-mark">*</span></label>
                                    <input type="time" name="hora_inicio" class="form-control-custom" required
                                        value="<?= set_value('hora_inicio') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Hora fin <span class="required-mark">*</span></label>
                                    <input type="time" name="hora_fin" class="form-control-custom" required
                                        value="<?= set_value('hora_fin') ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Asistencia -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Asistencia <span class="required-mark">*</span></label>
                                    <div>
                                        <label><input type="radio" name="asistencia" value="PENDIENTE"
                                                <?= set_radio('asistencia', 'PENDIENTE') ?>> Pendiente</label>
                                        <label><input type="radio" name="asistencia" value="ASISTIDO"
                                                <?= set_radio('asistencia', 'ASISTIDO') ?>> Asistido</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles -->
                        <fieldset id="detallesCitaFieldset" class="fieldset">
                            <legend>Detalles de la consulta</legend>

                            <?php
                            $textareas = [
                                'problema' => 'Problema',
                                'recomendacion' => 'Recomendación',
                                'aspecto_fisico' => 'Aspecto físico',
                                'aseo_personal' => 'Aseo personal',
                                'conducta' => 'Conducta'
                            ];
                            foreach ($textareas as $name => $label): ?>
                                <div class="textarea-wrapper">
                                    <label class="textarea-label"><?= $label ?></label>
                                    <textarea name="<?= $name ?>" class="auto-expand-textarea"
                                        placeholder="Detalle <?= strtolower($label) ?>..."
                                        maxlength="500"><?= set_value($name) ?></textarea>
                                    <div class="character-count"><?= strlen(set_value($name)) ?>/500</div>
                                </div>
                            <?php endforeach; ?>
                        </fieldset>

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

<script src="<?= base_url('js/shared/textarea/textarea.js') ?>"></script>

<?= $this->include('shared/selects/tomSelect') ?>

<script>
    // Definimos fuera del DOMContentLoaded para que sea global
    function toggleDetallesCita() {
        const detallesCitaFieldset = document.getElementById('detallesCitaFieldset');
        const seleccionado = document.querySelector('input[name="asistencia"]:checked');
        if (seleccionado && seleccionado.value === 'ASISTIDO') {
            detallesCitaFieldset.style.display = 'block';
        } else {
            detallesCitaFieldset.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const radiosAsistencia = document.querySelectorAll('input[name="asistencia"]');
        const detallesCitaFieldset = document.getElementById('detallesCitaFieldset');

        // evento de cambio
        radiosAsistencia.forEach(radio => {
            radio.addEventListener('change', toggleDetallesCita);
        });

        // inicializar al cargar
        radiosAsistencia[0].checked = true;
        toggleDetallesCita();
    });
</script>
<?= $this->include('shared/alerts/sweetAlert2') ?>
<?= $this->endSection() ?>