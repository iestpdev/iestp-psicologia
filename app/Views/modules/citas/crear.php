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

                    <form action="<?= base_url('api/citas/add') ?>" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="isAlumnoEnviado" value="<?= esc($alumnoEnviado) ?>">
                        <div class="row">
                            <!-- Tipo de derivación -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        Tipo de derivación <span class="required-mark">*</span>
                                    </label>
                                    <select name="tipo_derivacion" id="tipo_derivacion" class="form-control-custom"
                                        required>
                                        <option value="AUTONOMO" <?= set_select('tipo_derivacion', 'AUTONOMO', true) ?>>
                                            Autónomo</option>
                                        <option value="DOCENTE" <?= set_select('tipo_derivacion', 'DOCENTE') ?>>Docente
                                        </option>
                                        <option value="FAMILIAR" <?= set_select('tipo_derivacion', 'FAMILIAR') ?>>
                                            Familiar</option>
                                    </select>
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
                                            value="<?= esc(session('user.nombres') . ' ' . session('user.apellidos')) ?>"
                                            disabled>
                                        <input type="hidden" name="usuario_id" value="<?= esc(session('user.id')) ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Filtros de alumno -->
                        <fieldset id="seccionFiltros" class="fieldset">
                            <legend>Filtros de alumno</legend>

                            <div class="row">
                                <!-- Programa de estudio -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Programa de estudio</label>
                                        <select id="programaEstudio" name="programa_estudio"
                                            class="form-control-custom">
                                            <option value="">Filtre por programa de estudio</option>
                                            <?php foreach ($programaEstudios as $programaEstudio): ?>
                                                <option value="<?= $programaEstudio['id'] ?>"
                                                    <?= set_select('programa_estudio', $programaEstudio['id']) ?>>
                                                    <?= esc($programaEstudio['nombre']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Ciclo -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Ciclo</label>
                                        <select id="ciclo" name="ciclo" class="form-control-custom">
                                            <option value="">Filtre por ciclo</option>
                                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                                <option value="<?= $i ?>" <?= set_select('ciclo', $i) ?>><?= $i ?>º Ciclo
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Turno -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">Turno</label>
                                        <select id="turno" name="turno" class="form-control-custom">
                                            <option value="">Filtre por turno</option>
                                            <option value="M" <?= set_select('turno', 'M') ?>>Mañana</option>
                                            <option value="T" <?= set_select('turno', 'T') ?>>Tarde</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Alumno -->
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">DNI</label>
                                        <input type="text" id="inputDNIAlumno" class="form-control-custom"
                                            placeholder="Filtrar por DNI de alumno" maxlength="8" pattern="[0-9]{8}"
                                            value="<?= set_value('dni_alumno') ?>">
                                        <span id="msg-dni-alumno"></span>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label class="form-label">Alumno <span class="required-mark">*</span></label>
                                        <select id="alumnoSelect" name="alumno">
                                            <option value="">-- Seleccione un alumno --</option>
                                            <?php foreach ($alumnos as $alumno): ?>
                                                <option value="<?= $alumno['id'] ?>" <?= set_select('alumno', $alumno['id'], isset($alumnoEnviado) && $alumnoEnviado == $alumno['id']) ?>>
                                                    <?= esc($alumno['alumno_nombres_completos']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span id="msg-filtros-alumno"></span>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <!-- Derivaciones pendientes -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Derivaciones pendientes <span
                                            class="required-mark">*</span></label>
                                    <select id="derivacionSelect" name="derivacion">
                                        <option value="">-- Seleccione una derivación pendiente --</option>
                                        <?php foreach ($derivaciones_pendientes as $deriv_pen): ?>
                                            <option value="<?= $deriv_pen['id'] ?>" <?= set_select('derivacion', $deriv_pen['id']) ?>>
                                                <?= esc($deriv_pen['data_derivacion']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- Familiares -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Familiares <span class="required-mark">*</span></label>

                                    <select id="familiarSelect" name="familiar" class="form-control-custom"
                                        <?= isset($familiares) && !empty($familiares) ? 'required' : '' ?>>
                                        <?php if (isset($familiares) && !empty($familiares)): ?>
                                            <option value="">-- Seleccione un familiar --</option>
                                            <?php foreach ($familiares as $familiar): ?>
                                                <option value="<?= esc($familiar['id']) ?>" <?= set_select('familiar', $familiar['id']) ?>>
                                                    <?= esc($familiar['info_pariente']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="<?= set_value('familiar') ?>">
                                                <?= set_value('familiar') ? 'Seleccionado previamente' : '-- Seleccione --' ?>
                                            </option>
                                        <?php endif; ?>
                                    </select>

                                </div>
                            </div>
                        </div>

                        <!-- Motivo -->
                        <div class="textarea-wrapper">
                            <label class="textarea-label">Motivos <span class="required-mark">*</span></label>
                            <textarea name="motivo" class="auto-expand-textarea" placeholder="Detalle el motivo..."
                                maxlength="500"><?= set_value('motivo') ?></textarea>
                            <div class="character-count"><?= strlen(set_value('motivo')) ?>/500</div>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoDerivacion = document.getElementById('tipo_derivacion');

        // Secciones del formulario
        const seccionPsicologo = document.querySelector('[name="usuario_id"]').closest('.col-md-6');
        const seccionFiltros = document.getElementById('seccionFiltros').closest('fieldset');
        const seccionDerivaciones = document.getElementById('derivacionSelect').closest('.row');
        const seccionFamiliares = document.getElementById('familiarSelect').closest('.row');
        const seccionMotivo = document.querySelector('textarea[name="motivo"]').closest('.textarea-wrapper');
        const seccionAtencion = document.querySelector('input[name="fecha_atencion"]').closest('.row');
        const seccionAsistencia = document.querySelector('input[name="asistencia"]').closest('.row');
        const seccionDetalles = document.getElementById('detallesCitaFieldset').closest('fieldset');

        // Oculta todas las secciones
        function ocultarTodo() {
            [
                seccionPsicologo,
                seccionFiltros,
                seccionDerivaciones,
                seccionFamiliares,
                seccionMotivo,
                seccionAtencion,
                seccionAsistencia,
                seccionDetalles
            ].forEach(sec => sec.style.display = 'none');
        }

        // Muestra las secciones según el tipo
        function mostrarSegunTipo(tipo) {
            ocultarTodo();
            switch (tipo) {
                case 'AUTONOMO':
                    seccionPsicologo.style.display = '';
                    seccionFiltros.style.display = '';
                    seccionMotivo.style.display = '';
                    seccionAtencion.style.display = '';
                    seccionAsistencia.style.display = '';
                    seccionDetalles.style.display = '';
                    break;
                case 'FAMILIAR':
                    seccionPsicologo.style.display = '';
                    seccionFiltros.style.display = '';
                    seccionFamiliares.style.display = '';
                    seccionMotivo.style.display = '';
                    seccionAtencion.style.display = '';
                    seccionAsistencia.style.display = '';
                    seccionDetalles.style.display = '';
                    break;
                case 'DOCENTE':
                    seccionPsicologo.style.display = '';
                    seccionDerivaciones.style.display = '';
                    seccionMotivo.style.display = '';
                    seccionAtencion.style.display = '';
                    seccionAsistencia.style.display = '';
                    seccionDetalles.style.display = '';
                    break;
            }
            toggleDetallesCita();
        }

        // Evento: cada vez que cambia el tipo
        tipoDerivacion.addEventListener('change', function () {
            mostrarSegunTipo(this.value);
        });

        // mostrar predeterminado:
        mostrarSegunTipo('AUTONOMO');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // SELECT DE FAMILIARES POR ALUMNOID
        const familiarSelect = document.getElementById("familiarSelect");

        // Evitar limpiar el select si ya tiene familiares renderizados desde PHP
        if (familiarSelect.options.length <= 1) {
            familiarSelect.innerHTML = "<option value=''>-- Seleccione un familiar --</option>";
        }

        // textarea - motivo
        const motivoTextArea = document.querySelector('textarea[name="motivo"]');

        // ===============================
        // ALUMNOS
        // ===============================
        let alumnoSelect = new TomSelect('#alumnoSelect', {
            valueField: 'id',
            labelField: 'alumno_nombres_completos',
            searchField: 'alumno_nombres_completos',
            load: function (query, callback) {
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

        // Capturando el valor del alumno con cada cambio
        alumnoSelect.on('change', async function (value) {
            if (value) {
                setTimeout(function () {
                    $('#inputDNIAlumno').val('');
                    $('#msg-dni-alumno').text('');
                }, 1000);

                const res = await fetch(`/api/familiares/obtener-por-alumnoid/${value}`);
                const familiares = await res.json();

                familiarSelect.innerHTML = "<option value=''>-- Seleccione un familiar --</option>";

                familiares.forEach(fam => {
                    familiarSelect.innerHTML += `<option value="${fam.id}">${fam.info_pariente}</option>`;
                });
            } else {
                familiarSelect.innerHTML = "<option value=''>-- Seleccione un familiar --</option>";
            }
        });

        // Filtro de DNI para Alumno
        $('#inputDNIAlumno').on('input', function () {
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

        // ===============================
        // FILTROS EXTRA (programa, ciclo, turno)
        // ===============================
        $('#programaEstudio, #ciclo, #turno').on('change', function () {
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


        // ===============================
        // DERIVACIONES
        // ===============================
        let derivacionSelect = new TomSelect('#derivacionSelect', {
            valueField: 'id',
            labelField: 'data_derivacion',
            searchField: 'data_derivacion',
            load: function (query, callback) {
                if (!query.length) return callback();
                fetch('<?= base_url("api/derivaciones/obtener-pendientes") ?>?term=' + encodeURIComponent(query))
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            callback(data.data.map(derivacion => ({
                                id: derivacion.id,
                                data_derivacion: derivacion.data_derivacion
                            })));
                        }
                    })
                    .catch(() => callback());
            }
        });

        // Detectar los cambios de valor en el select de Derivaciones
        derivacionSelect.on('change', async function (value) {
            const res = await fetch(`/api/derivaciones/obtener-por-id/${value}`);
            const data = await res.json();
            console.log(data)
            motivoTextArea.value = data.derivacion.motivo;
        });
    });
</script>

<?= $this->endSection() ?>