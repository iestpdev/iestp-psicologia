<?php
$session = session();
$userLogged = $session->get('user');
?>

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

    <?php if ($userLogged['rol'] === 'DOCENTE'): ?>
        <!-- aplicando where para traer solo los registros de un docente logeado -->
        <input type="hidden" id="usuarioLogeadoId" value="<?= esc(session('user.id')) ?>">
        <input type="hidden" id="where" value="usuario_id">
    <?php endif; ?>

    <table id="datatable">
        <thead>
            <tr>
                <th>N°</th>
                <?php if ($userLogged['rol'] !== 'DOCENTE'): ?>
                    <th>DOCENTE</th>
                <?php endif; ?>
                <th>ALUMNO</th>
                <th>URGENCIA</th>
                <th>ESTADO</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <?= $this->include('modules/derivaciones/modal/modalInfo/modalInfo') ?>
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
        if (userRol !== 'DOCENTE') {
            columns.push({
                data: null,
                render: function (data, type, row) {
                    return row.docente_nombres_completos + ' (' + row.docente_dni + ')';
                }
            });
        }
        columns.push(
            {
                data: null,
                render: function (data, type, row) {
                    return row.alumno_nombres_completos + ' (' + row.alumno_dni + ')';
                }
            },
            { data: "urgencia" },
            {
                data: "estado",
                render: function (data) {
                    return data == 1
                        ? '<span class="badge bg-success">Recibido</span>'
                        : '<span class="badge bg-warning">En espera</span>';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button id="key-${row.id}" class="btn btn-sm btn-success">
                            <ion-icon name="newspaper-outline" class="icon-lg"></ion-icon>
                        </button>

                        <a id="editar-${row.id}" 
                           href="<?= base_url('derivaciones/editar/') ?>${row.id}" 
                           class="btn btn-sm btn-${row.estado == 0 ? "warning" : "secondary disabled"}">
                           <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                        </a>

                        <a id="eliminar-${row.id}"
                           href="<?= base_url('api/derivaciones/delete/') ?>${row.id}"
                           class="btn btn-sm btn-danger"
                           data-confirm
                           data-title="Eliminar Derivación"
                           data-text="¿Desea eliminar esta derivación?"
                           data-icon="warning">
                           <ion-icon name="trash-outline" class="icon-lg"></ion-icon>
                        </a>
                    `;
                }
            }
        );

        // Inicializamos tabla
        const table = initDataTable("<?= base_url('api/datatable/DerivacionFullInfo') ?>", columns, extraOptions);

        // Buscador personalizado
        attachSearchInput(table, 'searchDerivaciones');
    });
</script>
<?= $this->include('shared/alerts/sweetAlert2') ?>
<?= $this->include('modules/derivaciones/modal/modalInfo/modalInfo-script') ?>

<?= $this->endSection() ?>