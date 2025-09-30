<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="tabla">
    <div class="TableHeader">
        <h2>Alumnos</h2>

        <?= view('shared/inputs/searchInput', [
            'id' => 'searchAlumnos',
            'placeholder' => 'DNI, nombres o apellidos'
        ]) ?>

        <div>
            <a href="<?= base_url('alumnos/crear') ?>" class="btn btn-primary">
                Agregar
            </a>
        </div>
    </div>
    <table id="datatable">
        <thead>
            <tr>
                <th>N°</th>
                <th>DNI</th>
                <th>Nombres y apellidos</th>
                <th>Programa de estudio</th>
                <th>Ciclo</th>
                <th>Turno</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<?= $this->include('shared/table/datatable') ?>
<script>
    $(document).ready(function() {
        const table = initDataTable("<?= base_url('api/datatable/AlumnoFullInfo') ?>", [
            {
                data: "dni"
            },
            {
                data: null,
                render: function(data, type, row) {
                     return row.nombres + ' ' + row.apellidos;
                }
            },
            {
                data: "programa_estudio"
            },
            {
                data: "ciclo"
            },
            {
                data: "turno"
            },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <a id="editar-${data}" href="<?= base_url('alumnos/editar/') ?>${data}" class="btn btn-sm btn-warning">
                        Editar
                        </a>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    `;
                }
            }
        ], {
            // extraOptions
            dom: 'lrtip', // quitando el buscador default de DataTables
            responsive: true
        });

        // Vinculando input search personalizado con DataTables
        attachSearchInput(table, 'searchAlumnos');
    });
</script>

<?= $this->endSection() ?>