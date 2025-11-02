<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<!-- Contenedor del Botón de Reporte/Importación -->
<div class="d-flex align-items-center mt-3 mb-2 justify-content-start">
    <?php if (session('user.rol') === 'ADMIN'): ?>
        <button type="button" class="btn btn-outline-success me-3" data-bs-toggle="modal" data-bs-target="#importExcelModal">
            <i class="fa-solid fa-file-excel"></i> Importar XLSX
        </button>
    <?php endif; ?>
</div>

<div class="tabla">
    <div class="TableHeader">
        <h2>ALUMNOS</h2>

        <?= view('shared/inputs/searchInput', [
            'id' => 'searchAlumnos',
            'placeholder' => 'DNI, nombres o apellidos'
        ]) ?>

        <?php if (session('user.rol') === 'ADMIN' || session('user.rol') === 'PSICOLOGO'): ?>
            <div>
                <a href="<?= base_url('alumnos/crear') ?>" class="btn btn-primary">
                    Agregar
                </a>
            </div>
        <?php endif; ?>

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

<!-- Modal de Importación de Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-labelledby="importExcelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importExcelModalLabel">Carga Masiva de Alumnos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('api/alumnos/importar-xlsx') ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <p>Selecciona el archivo Excel (.xlsx o .xls) que contiene la lista de alumnos</p>
                    <p class="text-danger small">
                        **Advertencia:** Los alumnos existentes (por DNI) serán actualizados. Los alumnos nuevos serán insertados.
                    </p>
                    <div class="mb-3">
                        <label for="archivo_excel" class="form-label">Archivo de Datos de Alumnos</label>
                        <input class="form-control" type="file" id="archivo_excel" name="archivo_excel" accept=".xlsx, .xls" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-cloud-upload-alt"></i> Subir e Importar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->include('shared/table/datatable') ?>
<script>
    $(document).ready(function () {
        // Capturamos el rol del usuario logeado desde PHP
        const userRole = "<?= esc(session('user.rol')) ?>";

        const table = initDataTable("<?= base_url('api/datatable/AlumnoFullInfo') ?>", [
            { data: "dni" },
            { data: "alumno_nombres_completos" },
            { data: "programa_estudio" },
            {
                data: "ciclo",
                render: function (data) {
                    return getCicloText(data);
                }
            },
            {
                data: "turno",
                render: function (data) {
                    return getTurnoText(data);
                }
            },
            {
                data: "id",
                orderable: false,
                searchable: false,
                render: function (data) {
                    // Botones base (info siempre visible)
                    let buttons = ``;

                    if (userRole === 'DOCENTE') {
                        buttons += `
                        <a id="deriv-${data}" 
                           href="<?= base_url('derivaciones/crear?alumnoId=') ?>${data}" 
                           class="btn btn-sm btn-info">
                            <ion-icon name="radio-outline" class="icon-lg"></ion-icon>
                        </a>
                        `;
                    }

                    if (userRole === 'ADMIN' || userRole === 'PSICOLOGO') {
                        buttons += `
                        <a id="info-${data}" 
                           href="<?= base_url('alumnos/info/') ?>${data}" 
                           class="btn btn-sm btn-success">
                            <ion-icon name="newspaper-outline" class="icon-lg"></ion-icon>
                        </a>
                        `;
                    }

                    // Solo si el usuario es ADMIN, mostramos editar y eliminar
                    if (userRole === 'ADMIN') {
                        buttons += `
                            <a id="editar-${data}" 
                               href="<?= base_url('alumnos/editar/') ?>${data}" 
                               class="btn btn-sm btn-warning">
                                <ion-icon name="create-outline" class="icon-lg"></ion-icon>
                            </a>

                            <a id="eliminar-${data}"
                               href="<?= base_url('api/alumnos/delete/') ?>${data}"
                               class="btn btn-sm btn-danger"
                               data-confirm
                               data-title="Eliminar Alumno"
                               data-text="¿Desea eliminar este alumno?"
                               data-icon="warning">
                                <ion-icon name="trash-outline" class="icon-lg"></ion-icon>
                            </a>
                        `;
                    }

                    return buttons;
                }
            }
        ], {
            dom: 'lrtip', // quitando el buscador default de DataTables
            responsive: true
        });

        attachSearchInput(table, 'searchAlumnos');
    });
</script>
<?= $this->include('shared/alerts/sweetAlert2') ?>

<?= $this->endSection() ?>