<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="tabla">
    <div class="TableHeader">
        <h2>USUARIOS</h2>

        <?= view('shared/inputs/searchInput', [
            'id' => 'searchUsuarios',
            'placeholder' => 'DNI, nombres o apellidos'
        ]) ?>

        <div>
            <a href="<?= base_url('usuarios/crear') ?>" class="btn btn-primary">
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
                <th>Email</th>
                <th>Username</th>
                <th>Telefono</th>
                <th>Rol</th>
                <th>Fecha de creación</th>
                <th>Estado</th>
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
        const table = initDataTable('#datatable', "<?= base_url('api/datatable/UsuarioFullInfo') ?>", [
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
                data: "correo_institucional"
            },
            {
                data: "username"
            },
            {
                data: "telefono"
            },
            {
                data: "rol"
            },
            {
                data: "created_at"
            },
            {
                data: "estado",
                render: function(data) {
                    return data == 1 ?
                        '<span class="badge bg-success">Activo</span>' :
                        '<span class="badge bg-danger">Inactivo</span>';
                }
            },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <a id="editar-${data}" href="<?= base_url('usuarios/editar/') ?>${data}" class="btn btn-sm btn-warning">
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
        attachSearchInput(table, 'searchUsuarios');
    });
</script>

<?= $this->endSection() ?>