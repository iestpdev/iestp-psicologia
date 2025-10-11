<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="tabla">
    <div class="TableHeader">
        <h2>DERIVACIONES</h2>

        <?= view('shared/inputs/searchInput', [
            'id' => 'searchDerivaciones',
            'placeholder' => 'DNI, nombres o apellidos'
        ]) ?>

        <div>
            <a href="<?= base_url('derivaciones/crear') ?>" class="btn btn-primary">
                Agregar
            </a>
        </div>
    </div>
    <table id="datatable">
        <thead>
            <tr>
                <th>N°</th>
                <th>DOCENTE</th>
                <th>ALUMNO</th>
                <th>URGENCIA</th>
                <th>ESTADO</th>
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
        const table = initDataTable("<?= base_url('api/datatable/DerivacionFullInfo') ?>", [
            {
                data: null,
                render: function(data, type, row) {
                    return row.docente_nombres_completos + ' ' + ' (' + row.docente_dni + ')';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    return row.alumno_nombres_completos + ' ' + ' (' + row.alumno_dni + ')';
                }
            },
            {
                data: "urgencia",
            },
            {
                data: "estado",
                render: function(data) {
                    return data == 1 ?
                        '<span class="badge bg-success">Recibido</span>' :
                        '<span class="badge bg-warning">En espera</span>';
                }
            },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <a id="editar-${data}" href="<?= base_url('derivaciones/info/') ?>${data}" class="btn btn-sm btn-success">
                        <ion-icon name="newspaper-outline" class="icon-lg"></ion-icon>
                        </a>
                        <a id="editar-${data}" href="<?= base_url('derivaciones/editar/') ?>${data}" class="btn btn-sm btn-warning">
                         <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                        </a>
                        <a id="editar-${data}" href="<?= base_url('api/derivaciones/delete/') ?>${data}" class="btn btn-sm btn-danger">
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
        attachSearchInput(table, 'searchDerivaciones');
    });
</script>

<?= $this->endSection() ?>
