<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="tabla">
    <div class="TableHeader">
        <h2>USUARIOS</h2>

        <?= view('shared/inputs/searchInput', [
            'id' => 'searchUsuarios',
            'placeholder' => 'DNI, nombres, apellidos'
        ]) ?>

        <div>
            <a href="<?= base_url('usuarios/crear') ?>" class="btn btn-primary">
                Agregar
            </a>
        </div>
    </div>
    <table id="datatable">
        <colgroup>
            <col width="5%">
            <col width="6%"><!-- DNI -->
            <col width="14%"><!-- Nombres y apellidos -->
            <col width="15%"><!-- Email -->
            <col width="10%"><!-- Username -->
            <col width="10%"><!-- Telefono -->
            <col width="10%"><!-- Rol -->
            <col width="15%"><!-- Fecha de creación -->
            <col width="5%"><!-- Estado -->
            <col width="10%"><!-- Acciones -->
        </colgroup>
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
    <?= $this->include('modules/usuarios/modal/modalChangePass/modalChangePass') ?>
</div>
<?= $this->include('shared/table/datatable') ?>
<script>
    $(document).ready(function () {
        const table = initDataTable("<?= base_url('api/datatable/UsuarioFullInfo') ?>", [{
            data: "dni"
        },
        {
            data: "persona_nombres_completos",
        },
        {
            data: "correo_institucional"
        },
        {
            data: "username"
        },
        {
            data: "telefono",
            render: function (data) {
                return renderNullable(data);
            }
        },
        {
            data: "rol"
        },
        {
            data: "created_at",
            render: function (data) {
                return dateFormat(data);
            }
        },
        {
            data: "estado",
            render: function (data) {
                return data == 1 ?
                    '<span class="badge bg-success">Activo</span>' :
                    '<span class="badge bg-danger">Inactivo</span>';
            }
        },
        {
            data: "id",
            orderable: false,
            searchable: false,
            render: function (data) {
                return `
                        <button id="key-${data}" class="btn btn-sm btn-info">
                        <ion-icon name="key-outline" class="icon-lg"></ion-icon>
                        </button>

                        <a id="editar-${data}" href="<?= base_url('usuarios/editar/') ?>${data}" class="btn btn-sm btn-warning">
                        <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                        </a>
                        
                        <a id="eliminar-${data}"
                        href="<?= base_url('api/usuarios/delete/') ?>${data}"
                        class="btn btn-sm btn-danger"
                        data-confirm
                        data-title="Eliminar Usuario"
                        data-text="¿Desea eliminar este usuario?"
                        data-icon="warning">
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
        attachSearchInput(table, 'searchUsuarios');
    });
</script>

<?= $this->include('modules/usuarios/modal/modalChangePass/modalChangePass-script') ?>
<?= $this->include('shared/alerts/sweetAlert2') ?>

<?= $this->endSection() ?>