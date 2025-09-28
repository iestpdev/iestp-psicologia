<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Usuarios</h1>

<table id="tablaUsuarios" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Correo Institucional</th>
            <th>Username</th>
            <th>Rol</th>
            <th>Fecha de creación</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<?= $this->include('shared/table/datatable_init') ?>
<script>
    $(document).ready(function() {
        initDataTable('#tablaUsuarios', "<?= base_url('api/usuarios') ?>", [{
                data: "id"
            },
            {
                data: "correo_institucional"
            },
            {
                data: "username"
            },
            {
                data: "rol"
            },
            {
                data: "created_at"
            },
            {
                data: "estado"
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `
                    <button class="btn btn-sm btn-warning">Editar</button>
                    <button class="btn btn-sm btn-danger">Eliminar</button>
                `;
                }
            }
        ]);
    });
</script>

<?= $this->endSection() ?>