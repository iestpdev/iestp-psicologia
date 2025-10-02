<?php // TODO: REFACTORIZAR ESTE CÓDIGO 
?>
<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<style>
    .ts-control {
        height: 45px !important;
        border: 1px solid var(--black2) !important;
        color: var(--black2) !important;
        border-radius: 6px !important;
        transition: border-color 0.2s !important;
        background-color: var(--white) !important;
    }

    .ts-control input {
        font-size: 15px !important;
    }

    .ts-dropdown {
        font-size: 15px !important;
    }

    .ts-control .item {
        padding-top: 5px !important;
        color: var(--black1) !important;
        font-size: 15px !important;
    }

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
</style>

<div class="form-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-card">
                    <!-- Título y botón de regresar -->
                    <?= view('shared/forms/formHeader', [
                        'title' => 'Registrar Derivación',
                        'backUrl' => base_url('derivaciones')
                    ]) ?>

                    <form action="<?= base_url('api/derivaciones/add') ?>" method="POST">
                        <?= csrf_field() ?>
                        <!-- sección DOCENTE: Filtro DNI y docente_nombres_completos-->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        DNI
                                    </label>
                                    <input type="text" name="dni" id="dniInput" class="form-control-custom" placeholder="Filtrar por DNI" maxlength="8" pattern="[0-9]{8}">
                                    <span id="msg-dni"></span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">
                                        Docente <span class="required-mark">*</span>
                                    </label>
                                    <select id="docenteSelect" name="docente" required>
                                        <option value="">Seleccione un docente</option>
                                        <?php foreach ($docentes as $docente): ?>
                                            <option value="<?= $docente['id'] ?>"><?= esc($docente['persona_nombres_completos']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- sección ALUMNO: Filtro ProgramaEstudio, ciclo, turno, DNI y alumno_nombres_completos -->
                        <div class="row">
                            <!-- Programa de estudio -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        Programa de estudio
                                    </label>
                                    <select id="programaEstudio" name="programa_estudio" class="form-control-custom" required>
                                        <option value="">Filtre por programa de estudio</option>
                                        <?php foreach ($programaEstudios as $programaEstudio): ?>
                                            <option value="<?= $programaEstudio['id'] ?>"><?= esc($programaEstudio['nombre']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Ciclo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        Ciclo
                                    </label>
                                    <select id="ciclo" name="ciclo" class="form-control-custom" required>
                                        <option value="">Filtre por ciclo</option>
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
                                        Turno
                                    </label>
                                    <select id="turno" name="turno" class="form-control-custom" required>
                                        <option value="">Filtre por turno</option>
                                        <option value="M">Mañana</option>
                                        <option value="T">Tarde</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- sección ALUMNO: Filtro DNI y alumno_nombres_completos-->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        DNI
                                    </label>
                                    <input type="text" name="dni" id="inputDNIAlumno" class="form-control-custom" placeholder="Filtrar por DNI" maxlength="8" pattern="[0-9]{8}">
                                    <span id="msg-dni-alumno"></span>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">
                                        Alumno <span class="required-mark">*</span>
                                    </label>
                                    <select id="alumnoSelect" name="alumno" required>
                                        <option value="">Seleccione un alumno</option>
                                        <?php foreach ($alumnos as $alumno): ?>
                                            <option value="<?= $alumno['id'] ?>"><?= esc($alumno['alumno_nombres_completos']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Motivo -->
                        <div class="textarea-wrapper">
                            <label class="textarea-label" for="auto-textarea">
                                Motivos <span class="required-mark">*</span>
                            </label>
                            <textarea
                                id="auto-textarea"
                                class="auto-expand-textarea"
                                placeholder="Detalle el motivo de la derivación..."
                                maxlength="500"></textarea>
                            <div class="character-count">0/500</div>
                        </div>

                        <!-- Urgencia -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">
                                        Urgencia <span class="required-mark">*</span>
                                    </label>
                                    <div>
                                        <label><input type="radio" name="urgencia" value="BAJA" required> Baja</label>
                                        <label><input type="radio" name="urgencia" value="MEDIA" required> Media</label>
                                        <label><input type="radio" name="urgencia" value="ALTA" required> Alta</label>
                                    </div>
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

<script src="<?= base_url('js/shared/textarea/textarea.js') ?>"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtro Docente
    let docenteSelect = new TomSelect('#docenteSelect', {
        valueField: 'id',
        labelField: 'persona_nombres_completos',
        searchField: 'persona_nombres_completos',
        load: function(query, callback) {
            if (!query.length) return callback();
            fetch('<?= base_url("api/usuarios/obtener-docentes") ?>?term=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => callback(data.data))
                .catch(() => callback());
        }
    });

    // Filtro de DNI para Docente
    $('#dniInput').on('input', function() {
        const dni = $(this).val();

        if (dni.length === 8) {
            fetch('<?= base_url("api/usuarios/obtener-docentes") ?>/' + dni)
                .then(res => res.json())
                .then(data => {
                    const docenteData = data.data;
                    if (docenteData.length > 0) {
                        const docente = docenteData[0];
                        $('#msg-dni').text('Coincidencia encontrada').removeClass('msg-dni-error').addClass('msg-dni-success');
                        docenteSelect.addOption({
                            id: docente.id,
                            text: docente.persona_nombres_completos
                        });
                        docenteSelect.setValue(docente.id);
                    } else {
                        docenteSelect.setValue('');
                        $('#msg-dni').text('No se encontraron coincidencias').removeClass('msg-dni-success').addClass('msg-dni-error');
                    }
                })
        } else {
            $('#msg-dni').text('').removeClass('msg-dni-error').removeClass('msg-dni-success');
        }
    });

    docenteSelect.on('change', function(value) {
        if (value) {
            setTimeout(function() {
                $('#dniInput').val('');
                $('#msg-dni').text('');
            }, 1000);
        }
    });

    // Filtro Alumno
    let alumnoSelect = new TomSelect('#alumnoSelect', {
        valueField: 'id',
        labelField: 'alumno_nombres_completos',
        searchField: 'alumno_nombres_completos',
        load: function(query, callback) {
            if (!query.length) return callback();
            fetch('<?= base_url("api/alumnos/obtener-alumnos") ?>?term=' + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => callback(data.data))
                .catch(() => callback());
        }
    });

    // Filtro de DNI para Alumno
    $('#inputDNIAlumno').on('input', function() {
        const dni = $(this).val();

        if (dni.length === 8) {
            fetch('<?= base_url("api/alumnos/obtener-alumnos") ?>?dni=' + dni)
                .then(res => res.json())
                .then(data => {
                    const alumnoData = data.data;
                    if (alumnoData.length > 0) {
                        const alumno = alumnoData[0];
                        $('#msg-dni-alumno').text('Coincidencia encontrada').removeClass('msg-dni-error').addClass('msg-dni-success');
                        alumnoSelect.addOption({
                            id: alumno.id,
                            text: alumno.alumno_nombres_completos
                        });
                        alumnoSelect.setValue(alumno.id);
                    } else {
                        alumnoSelect.setValue('');
                        $('#msg-dni-alumno').text('No se encontraron coincidencias').removeClass('msg-dni-success').addClass('msg-dni-error');
                    }
                })
        } else {
            $('#msg-dni-alumno').text('').removeClass('msg-dni-error').removeClass('msg-dni-success');
        }
    });

    alumnoSelect.on('change', function(value) {
        if (value) {
            setTimeout(function() {
                $('#inputDNIAlumno').val('');
                $('#msg-dni-alumno').text('');
            }, 1000);
        }
    });

    // Filtro de los otros campos: programa_estudio, ciclo, turno
    $('#programaEstudio, #ciclo, #turno').on('change', function() {
        const programaEstudio = $('#programaEstudio').val();
        const ciclo = $('#ciclo').val();
        const turno = $('#turno').val();

        fetch('<?= base_url("api/alumnos/obtener-alumnos") ?>?programa_estudio_id=' + programaEstudio + '&ciclo=' + ciclo + '&turno=' + turno)
            .then(res => res.json())
            .then(data => {
                alumnoSelect.clearOptions();
                if (data.data.length > 0) {
                    data.data.forEach(alumno => {
                        alumnoSelect.addOption({
                            id: alumno.id,
                            text: alumno.alumno_nombres_completos
                        });
                    });
                } else {
                    alumnoSelect.addOption({
                        id: 'no-alumno',
                        text: 'No se encontraron coincidencias',
                        disabled: true
                    });
                }
            });
    });
});
</script>

<?= $this->endSection() ?>