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
                        'title' => 'Editar Consulta',
                        'backUrl' => base_url('citas')
                    ]) ?>

                    <form action="<?= base_url('api/citas/update/' . $cita['id']) ?>" method="POST"
                    data-confirm 
                    data-title="Editar Consulta" 
                    data-text="¿Desea actualizar esta consulta?"
                    data-icon="question">
                        <?= csrf_field() ?>
                        <input type="hidden" name="isAlumnoEnviado" value="<?= esc($desdePerfil) ?>">
                        <div class="row">
                            <!-- Tipo de derivación -->
                            <div class="col-md-6 mb-3 mt-3">
                                <div class="info-box shadow-sm p-3 rounded">
                                    <label class="form-label fw-bold mb-1 me-1">
                                        Tipo de derivación:
                                    </label>
                                    <div class="info-value badge bg-primary text-light fs-6 px-3 py-2">
                                        <?= esc($cita['tipo_derivacion']) ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Psicólogo asignado -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Psicólogo asignado <span class="required-mark">*</span>
                                    </label>
                                    <select name="usuario_id" id="usuario_id" class="form-control-custom" required>
                                        <option value="">-- Seleccione un psicólogo --</option>
                                        <?php foreach ($psicologos as $psicologo): ?>
                                            <option value="<?= $psicologo['id'] ?>" <?= $psicologo['id'] == $cita['usuario_id'] ? 'selected' : '' ?>>
                                                <?= esc($psicologo['persona_nombres_completos']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <?php if ($cita['tipo_derivacion'] === 'AUTONOMO' || $cita['tipo_derivacion'] === 'FAMILIAR'): ?>
                            <!-- Información del alumno -->
                            <div class="col-md-12 mb-3">
                                <div class="info-box shadow-sm p-3 rounded">
                                    <label class="form-label fw-bold mb-1">
                                        Alumno:
                                    </label>
                                    <div class="info-value fs-6" id="alumnoInfo"
                                        data-nombres="<?= esc($alumno['nombres']) ?>"
                                        data-apellidos="<?= esc($alumno['apellidos']) ?>"
                                        data-dni="<?= esc($alumno['dni']) ?>"
                                        data-programa="<?= esc($alumno['programa_estudio']) ?>"
                                        data-turno="<?= esc($alumno['turno']) ?>" data-ciclo="<?= esc($alumno['ciclo']) ?>">
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Derivacion -->
                        <?php if ($cita['tipo_derivacion'] === 'DOCENTE'): ?>
                            <div class="col-md-12 mb-3">
                                <div class="info-box shadow-sm p-3 rounded border-start border-primary border-3">
                                    <h6 class="text-primary mb-3 fw-semibold">Detalles de derivación docente</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <span class="text-muted fw-semibold d-block">Alumno</span>
                                            <span
                                                class="info-value"><?= esc($derivacion['alumno_nombres_completos']) ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted fw-semibold d-block">Docente</span>
                                            <span
                                                class="info-value"><?= esc($derivacion['docente_nombres_completos']) ?></span>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="text-muted fw-semibold d-block">Urgencia</span>
                                            <span
                                                class="badge <?= $derivacion['urgencia'] === 'ALTA' ? 'bg-danger' : ($derivacion['urgencia'] === 'MEDIA' ? 'bg-warning text-dark' : 'bg-success') ?>">
                                                <?= esc($derivacion['urgencia']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Familiares -->
                        <?php if ($cita['tipo_derivacion'] === 'FAMILIAR'): ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Familiares <span class="required-mark">*</span>
                                        </label>
                                        <select name="familiar" id="familiar" class="form-control-custom" required>
                                            <?php foreach ($familiares as $familiar): ?>
                                                <option value="<?= $familiar['id'] ?>" <?= $familiar['id'] == $cita['familiar_id'] ? 'selected' : '' ?>>
                                                    <?= esc($familiar['pariente_nombres'] . ' ' . $familiar['pariente_apellidos'] . '(' . $familiar['pariente_dni'] . ')') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        <!-- Motivo -->
                        <div class="textarea-wrapper">
                            <label class="textarea-label">Motivos <span class="required-mark">*</span></label>
                            <textarea name="motivo" class="auto-expand-textarea" placeholder="Detalle el motivo..."
                                maxlength="500"><?= esc($cita['motivo']) ?></textarea>
                            <div class="character-count"><?= strlen($cita['motivo']) ?>/500</div>
                        </div>

                        <!-- Atención -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Fecha de atención <span
                                            class="required-mark">*</span></label>
                                    <input type="date" name="fecha_atencion" class="form-control-custom" required
                                        value="<?= esc($cita['atencion_fech']) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Hora inicio <span class="required-mark">*</span></label>
                                    <input type="time" name="hora_inicio" class="form-control-custom" required
                                        value="<?= substr($cita['hora_inicio'], 0, 5) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Hora fin <span class="required-mark">*</span></label>
                                    <input type="time" name="hora_fin" class="form-control-custom" required
                                        value="<?= substr($cita['hora_fin'], 0, 5) ?>">
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
                                                <?= $cita['asistencia'] === 'PENDIENTE' ? 'checked' : '' ?>>
                                            Pendiente</label>
                                        <label><input type="radio" name="asistencia" value="ASISTIDO"
                                                <?= $cita['asistencia'] === 'ASISTIDO' ? 'checked' : '' ?>>
                                            Asistido</label>
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
                                <?= view('shared/buttons/submitButton', ['text' => 'Actualizar']) ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url('js/shared/textarea/textarea.js') ?>"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const infoEl = document.getElementById('alumnoInfo');
        if (!infoEl) return;

        const nombres = infoEl.dataset.nombres;
        const apellidos = infoEl.dataset.apellidos;
        const dni = infoEl.dataset.dni;
        const programa = infoEl.dataset.programa;
        const turno = infoEl.dataset.turno;
        const ciclo = infoEl.dataset.ciclo;
        
        const turnoText = getTurnoText(turno);
        const cicloText = getCicloText(ciclo);

        infoEl.innerHTML = `
        <div>
            <span class="fw-semibold">${nombres} ${apellidos}</span>
            <span class="ms-2">(${dni})</span>
        </div>
        <div class="mt-2 text-muted">
            ${programa} - ${turnoText} - ${cicloText}
        </div>
    `;
    });
</script>

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

        // evento de cambio
        radiosAsistencia.forEach(radio => {
            radio.addEventListener('change', toggleDetallesCita);
        });

        // inicializar al cargar (usa el valor actual)
        toggleDetallesCita();
    });
</script>
<?= $this->include('shared/alerts/sweetAlert2') ?>

<?= $this->endSection() ?>