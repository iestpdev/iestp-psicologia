<?php // TODO: REFACTORIZAR ESTE CÓDIGO ?>
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
</style>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

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
                                    <input type="text" id="dniInput" class="form-control-custom" placeholder="Filtrar por DNI de docente" maxlength="8" pattern="[0-9]{8}">
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

                        <fieldset class="fieldset">
                            <legend>Filtros de alumno</legend>
                            <!-- sección ALUMNO: Filtro ProgramaEstudio, ciclo, turno, DNI y alumno_nombres_completos -->
                            <div class="row">
                                <!-- Programa de estudio -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            Programa de estudio
                                        </label>
                                        <select id="programaEstudio" name="programa_estudio" class="form-control-custom">
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
                                        <select id="ciclo" name="ciclo" class="form-control-custom">
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
                                        <select id="turno" name="turno" class="form-control-custom">
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
                                        <input type="text" id="inputDNIAlumno" class="form-control-custom" placeholder="Filtrar por DNI de alumno" maxlength="8" pattern="[0-9]{8}">
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
                                        <span id="msg-filtros-alumno"></span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Motivo -->
                        <div class="textarea-wrapper">
                            <label class="textarea-label" for="auto-textarea">
                                Motivos <span class="required-mark">*</span>
                            </label>
                            <textarea
                                name="motivo"
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

<?= $this->include('shared/selects/tomSelect') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===============================
        // DOCENTES
        // ===============================
        let docenteSelect = new TomSelect('#docenteSelect', {
            valueField: 'id',
            labelField: 'persona_nombres_completos',
            searchField: 'persona_nombres_completos',
            load: function(query, callback) {
                if (!query.length) return callback();
                fetch('<?= base_url("api/usuarios/obtener-docentes") ?>?term=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            callback(data.data.map(docente => ({
                                id: docente.id,
                                persona_nombres_completos: docente.persona_nombres_completos
                            })));
                        }
                    })
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
                                persona_nombres_completos: docente.persona_nombres_completos
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

        // Capturando el valor del docente con cada cambio
        docenteSelect.on('change', function(value) {
            if (value) {
                setTimeout(function() {
                    $('#dniInput').val('');
                    $('#msg-dni').text('');
                }, 1000);
            }
        });

        // ===============================
        // ALUMNOS
        // ===============================
        let alumnoSelect = new TomSelect('#alumnoSelect', {
            valueField: 'id',
            labelField: 'alumno_nombres_completos',
            searchField: 'alumno_nombres_completos',
            load: function(query, callback) {
                if (!query.length) return callback();
                fetch('<?= base_url("api/alumnos/obtener-alumnos") ?>?term=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            callback(data.data.map(alumno => ({
                                id: alumno.id,
                                alumno_nombres_completos: alumno.alumno_nombres_completos
                            })));
                        }
                    })
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
                        if (data.status === 'success') {
                            const alumnoData = data.data;
                            if (alumnoData.length > 0) {
                                const alumno = alumnoData[0];
                                $('#msg-dni-alumno').text('Coincidencia encontrada').removeClass('msg-dni-error').addClass('msg-dni-success');
                                $('#msg-filtros-alumno').text('').removeClass('msg-dni-error').removeClass('msg-dni-success');
                                alumnoSelect.addOption({
                                    id: alumno.id,
                                    alumno_nombres_completos: alumno.alumno_nombres_completos
                                });
                                alumnoSelect.setValue(alumno.id);
                            } else {
                                alumnoSelect.setValue('');
                                $('#msg-dni-alumno').text('No se encontraron coincidencias').removeClass('msg-dni-success').addClass('msg-dni-error');
                                $('#msg-filtros-alumno').text('').removeClass('msg-dni-error').removeClass('msg-dni-success');
                            }
                        }
                    })
            } else {
                $('#msg-dni-alumno').text('').removeClass('msg-dni-error').removeClass('msg-dni-success');
                $('#msg-filtros-alumno').text('').removeClass('msg-dni-error').removeClass('msg-dni-success');
            }
        });

        // Capturando el valor del alumno con cada cambio
        alumnoSelect.on('change', function(value) {
            if (value) {
                setTimeout(function() {
                    $('#inputDNIAlumno').val('');
                    $('#msg-dni-alumno').text('');
                }, 1000);
            }
        });

        // ===============================
        // FILTROS EXTRA (programa, ciclo, turno)
        // ===============================
        $('#programaEstudio, #ciclo, #turno').on('change', function() {
            const programaEstudio = $('#programaEstudio').val();
            const ciclo = $('#ciclo').val();
            const turno = $('#turno').val();

            let params = {};
            if (programaEstudio) params.programa_estudio_id = programaEstudio;
            if (ciclo) params.ciclo = ciclo;
            if (turno) params.turno = turno;

            if (Object.keys(params).length > 0) {
                fetch('<?= base_url("api/alumnos/obtener-alumnos") ?>?' + $.param(params))
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alumnoSelect.clearOptions();
                            if (data.data.length > 0) {
                                $('#msg-filtros-alumno').text('Coincidencia encontrada').removeClass('msg-dni-error').addClass('msg-dni-success');
                                data.data.forEach(alumno => {
                                    alumnoSelect.addOption({
                                        id: alumno.id,
                                        alumno_nombres_completos: alumno.alumno_nombres_completos
                                    });
                                });
                            } else {
                                $('#msg-filtros-alumno').text('No se encontraron coincidencias').removeClass('msg-dni-success').addClass('msg-dni-error');
                                alumnoSelect.addOption({
                                    id: 'no-alumno',
                                    alumno_nombres_completos: ''
                                });
                                alumnoSelect.setValue('');
                                alumnoSelect.clearOptions();
                            }
                        }
                    });
            }
        });
    });
</script>


<?= $this->endSection() ?>