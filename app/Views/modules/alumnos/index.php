<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="tabla">
    <div class="TableHeader">
        <h2>ALUMNOS</h2>

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
        const table = initDataTable("<?= base_url('api/datatable/AlumnoFullInfo') ?>", [{
                data: "dni"
            },
            {
                data: "alumno_nombres_completos",
            },
            {
                data: "programa_estudio"
            },
            {
                data: "ciclo",
                render: function(data) {
                    return getCicloText(data);
                }
            },
            {
                data: "turno",
                render: function(data) {
                    return getTurnoText(data);
                }
            },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <a id="editar-${data}" href="<?= base_url('alumnos/info/') ?>${data}" class="btn btn-sm btn-success">
                        <ion-icon name="newspaper-outline" class="icon-lg"></ion-icon>
                        </a>
                        <a id="editar-${data}" href="<?= base_url('alumnos/editar/') ?>${data}" class="btn btn-sm btn-warning">
                         <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                        </a>
                        <a id="editar-${data}" href="<?= base_url('api/alumnos/delete/') ?>${data}" class="btn btn-sm btn-danger">
                         <ion-icon name="trash-outline" class="icon-lg"></ion-icon>
                        </a>
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