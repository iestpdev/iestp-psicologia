<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="d-flex align-items-center mt-3 mb-2">
    <form action="<?= base_url('citas/generar-asistidas-pdf') ?>" method="POST" target="_blank" class="d-flex align-items-center">
   
            <label class="form-label me-2">
                Gererar reporte: 
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
    <table id="datatable">
        <thead>
            <tr>
                <th>N°</th>
                <th>Psicólogo/a (DNI)</th>
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
    $(document).ready(function() {
        const table = initDataTable("<?= base_url('api/datatable/CitaFullInfo') ?>", [{
                data: null,
                render: function(data) {
                    return `${data.usuario_nombres_completos} <br><small>(${data.usuario_dni})</small>`;
                }
            },
            {
                data: "tipo_derivacion"
            },
            {
                data: null,
                render: function(data) {
                    return `${data.alumno_nombres_completos} <br><small>(${data.alumno_dni})</small>`;
                }
            },
            {
                data: "atencion_fech"
            },
            {
                data: null,
                render: function(data) {
                    return `${data.hora_inicio} - ${data.hora_fin}`;
                }
            },
            {
                data: "asistencia",
                render: function(data) {
                    if (data === 'PENDIENTE') {
                        return '<span class="badge bg-warning">Pendiente</span>';
                    } else if (data === 'ASISTIDO') {
                        return '<span class="badge bg-success">Asistido</span>';
                    } else if (data === 'AUSENTE') {
                        return '<span class="badge bg-danger">Ausente</span>';
                    }
                    return data;
                }
            },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <a id="editar-${data}" href="<?= base_url('citas/info/') ?>${data}" class="btn btn-sm btn-success">
                        <ion-icon name="newspaper-outline" class="icon-lg"></ion-icon>
                        </a>
                        <a id="editar-${data}" href="<?= base_url('citas/editar/') ?>${data}" class="btn btn-sm btn-warning">
                         <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                        </a>
                        <a id="editar-${data}" href="<?= base_url('api/citas/delete/') ?>${data}" class="btn btn-sm btn-danger">
                         <ion-icon name="trash-outline" class="icon-lg"></ion-icon>
                        </a>
                    `;
                }
            }
        ], {
            dom: 'lrtip',
            responsive: true
        });

        // conectar buscador personalizado
        attachSearchInput(table, 'searchCitas');
    });
</script>

<?= $this->endSection() ?>