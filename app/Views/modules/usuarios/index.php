<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="tabla">
    <div class="TableHeader">
        <h2>USUARIOS</h2>
        <div class="searchInput">
            <label>
                <input
                    type="text"
                    id="customSearch"
                    placeholder="Buscar..." />
                <ion-icon name="search-outline"></ion-icon>
            </label>
        </div>

        <div>
            <a href="<?= base_url('usuarios/create') ?>" class="btn btn-primary">
                Agregar
            </a>
        </div>
    </div>
    <table id="tablaUsuarios">
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

<?= $this->include('shared/table/datatable_init') ?>
<script>
    $(document).ready(function() {
        const table = initDataTable('#tablaUsuarios', "<?= base_url('api/usuarios') ?>", [{
                data: null,
                render: function(data, type, row) {
                    if (row.rol === 'DOCENTE') {
                        return row.docente_dni ?? '-';
                    } else if (row.rol === 'PSICOLOGO') {
                        return row.psicologo_dni ?? '-';
                    } else if (row.rol === 'ADMIN') {
                        return row.administrador_dni ?? '-';
                    }
                    return '-';
                }
            },
            {
                data: null,
                render: function(data, type, row) {
                    if (row.rol === 'DOCENTE') {
                        return row.docente_nombres + ' ' + row.docente_apellidos;
                    } else if (row.rol === 'PSICOLOGO') {
                        return row.psicologo_nombres + ' ' + row.psicologo_apellidos;
                    } else if (row.rol === 'ADMIN') {
                        return row.administrador_nombres + ' ' + row.administrador_apellidos;
                    }
                    return '-';
                }
            },
            {
                data: "correo_institucional"
            },
            {
                data: "username"
            },
            {
                data: null,
                render: function(data, type, row) {
                    if (row.rol === 'DOCENTE') {
                        return row.docente_telefono ?? '-';
                    } else if (row.rol === 'PSICOLOGO') {
                        return row.psicologo_telefono ?? '-';
                    } else if (row.rol === 'ADMIN') {
                        return row.administrador_telefono ?? '-';
                    }
                    return '-';
                }
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
                data: null,
                orderable: false,
                searchable: false,
                render: function() {
                    return `
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    `;
                }
            }
        ], {
            // extraOptions
            dom: 'lrtip' // quitando el buscador default de DataTables
        });

        // Vinculando input search personalizado con DataTables
        $('#customSearch').on('keyup', function() {
            table.search(this.value).draw();
        });
    });
</script>

<?= $this->endSection() ?>