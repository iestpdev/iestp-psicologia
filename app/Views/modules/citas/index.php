<?php
$session = session();
$userLogged = $session->get('user');
?>

<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="d-flex align-items-center mt-3 mb-2">
    <form action="<?= base_url('api/citas/generar-asistidas-pdf') ?>" method="POST" target="_blank"
        class="d-flex align-items-center">

        <label class="form-label me-2">
            Generar reporte:
        </label>
        <input type="month" name="fechaFiltro" class="form-control me-2" style="max-width: 200px;" required>

        <button type="submit" class="btn btn-danger">
            <i class="fa-solid fa-file-pdf"></i>
        </button>
    </form>
</div>

<div class="tabla">
    <div class="TableHeader">
        <h2>CONSULTAS</h2>

        <?= view('shared/inputs/searchInput', [
            'id' => 'searchCitas',
            'placeholder' => 'Buscar por DNI, nombres o apellidos'
        ]) ?>

        <div>
            <a href="<?= base_url('citas/crear') ?>" class="btn btn-primary">
                Agregar
            </a>
        </div>
    </div>

    <?php if ($userLogged['rol'] === 'PSICOLOGO'): ?>
        <!-- aplicando where para traer solo los registros de un psicologo logeado -->
        <input type="hidden" id="usuarioLogeadoId" value="<?= esc(session('user.id')) ?>">
        <input type="hidden" id="where" value="usuario_id">
    <?php endif; ?>

    <table id="datatable">
        <thead>
            <tr>
                <th>N°</th>
                <?php if ($userLogged['rol'] !== 'PSICOLOGO'): ?>
                    <th>Psicólogo/a (DNI)</th>
                <?php endif; ?>
                <th>Tipo de derivación</th>
                <th>Alumno (DNI)</th>
                <th>Fecha atención</th>
                <th>Horario</th>
                <th>Asistencia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<?= $this->include('shared/table/datatable') ?>

<script>
    $(document).ready(function () {
        const usuarioLogeadoId = document.getElementById('usuarioLogeadoId')?.value || '';
        const whereField = document.getElementById('where')?.value || '';
        const userRol = "<?= esc($userLogged['rol']) ?>";

        const extraOptions = {
            ajax: {
                data: function (d) {
                    if (usuarioLogeadoId && whereField) {
                        d.where_field = whereField;
                        d.where_value = usuarioLogeadoId;
                    }
                }
            },
            dom: 'lrtip',
            responsive: true
        };

        const columns = [];
        if (userRol !== 'PSICOLOGO') {
            columns.push({
                data: null,
                render: function (data) {
                    return `${data.usuario_nombres_completos} <br><small>(${data.usuario_dni})</small>`;
                }
            });
        }
        columns.push(
            { data: "tipo_derivacion" },
            {
                data: null,
                render: function (data) {
                    return `${data.alumno_nombres_completos} <br><small>(${data.alumno_dni})</small>`;
                }
            },
            { data: "atencion_fech" },
            {
                data: null,
                render: function (data) {
                    return `${data.hora_inicio} - ${data.hora_fin}`;
                }
            },
            {
                data: "asistencia",
                render: function (data) {
                    if (data === 'PENDIENTE') return '<span class="badge bg-warning">Pendiente</span>';
                    if (data === 'ASISTIDO') return '<span class="badge bg-success">Asistido</span>';
                    if (data === 'AUSENTE') return '<span class="badge bg-danger">Ausente</span>';
                    return data;
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <a href="<?= base_url('citas/info/') ?>${row.id}" class="btn btn-sm btn-success">
                            <ion-icon name="newspaper-outline" class="icon-lg"></ion-icon>
                        </a>

                        <a id="editar-${row.id}" 
                           href="<?= base_url('citas/editar/') ?>${row.id}" 
                           class="btn btn-sm btn-${row.asistencia === 'PENDIENTE' ? "warning" : "secondary disabled"}">
                           <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                        </a>

                        <a id="eliminar-${row.id}" 
                           href="<?= base_url('api/citas/delete/') ?>${row.id}" 
                           class="btn btn-sm btn-danger"
                           data-confirm
                           data-title="Eliminar Consulta"
                           data-text="¿Desea eliminar esta consulta?"
                           data-icon="warning">
                           <ion-icon name="trash-outline" class="icon-lg"></ion-icon>
                        </a>
                    `;
                }
            }
        );

        // Inicializamos DataTable
        const table = initDataTable("<?= base_url('api/datatable/CitaFullInfo') ?>", columns, extraOptions);

        attachSearchInput(table, 'searchCitas');
    });
</script>
<?= $this->include('shared/alerts/sweetAlert2') ?>

<?= $this->endSection() ?>