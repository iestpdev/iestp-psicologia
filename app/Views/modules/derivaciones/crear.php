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
                                    <input type="text" name="dni" class="form-control-custom" placeholder="Filtre por DNI" maxlength="8"
                                        pattern="[0-9]{8}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">
                                        Nombres y apellidos <span class="required-mark">*</span>
                                    </label>
                                    <select id="docenteSelect" name="docente" class="form-control-custom" required></select>
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
                                    <select name="programa_estudio" class="form-control-custom" required>
                                        <option value="">Filtre por programa de estudio</option>
                                        <option value=1>Pepe</option>
                                        <option value=2>Carlos</option>
                                        <option value=3>Maria</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Ciclo -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">
                                        Ciclo
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
                                        Turno
                                    </label>
                                    <select name="turno" class="form-control-custom" required>
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
                                    <input type="text" name="dni" class="form-control-custom" placeholder="Filtre por DNI" maxlength="8"
                                        pattern="[0-9]{8}">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">
                                        Nombres y apellidos <span class="required-mark">*</span>
                                    </label>
                                    <select name="docente" class="form-control-custom" required>
                                        <option value="">Seleccione un alumno</option>
                                        <option value=1>Ricardo</option>
                                        <option value=2>Jorge</option>
                                        <option value=3>Manuel</option>
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

<?= $this->include('shared/select2/select2') ?>

<script>
    $(document).ready(function() {
        $('#docenteSelect').select2({
            placeholder: 'Seleccione un docente',
            ajax: {
                url: '<?= base_url("api/usuarios/obtener-docentes") ?>',
                dataType: 'json',
                delay: 300,
                processResults: function(data) {
                    return {
                        results: data.data.map(function(docente) {
                            return {
                                id: docente.id,
                                text: docente.persona_nombres_completos + ' - ' + docente.dni
                            };
                        })
                    };
                }
            },
            minimumInputLength: 1
        });

        // filtro por DNI cuando escriban exactamente 8 dígitos
        $('input[name="dni"]').on('input', function() {
            let dni = $(this).val();
            if (dni.length === 8) {
                $.getJSON('<?= base_url("api/usuarios/obtener-docentes") ?>/' + dni, function(res) {
                    if (res.data.length > 0) {
                        let docente = res.data[0];
                        // autoseleccionar en el select
                        let option = new Option(docente.persona_nombres_completos + ' - ' + docente.dni, docente.id, true, true);
                        $('#docenteSelect').append(option).trigger('change');
                    }
                });
            }
        });
    });
</script>

<?= $this->endSection() ?>