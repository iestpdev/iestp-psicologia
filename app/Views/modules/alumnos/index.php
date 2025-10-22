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