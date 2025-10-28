<?php
$session = session();
$userLogged = $session->get('user');
$primerNombre = explode(' ', trim($userLogged['nombres']))[0] ?? '';
$primerApellido = explode(' ', trim($userLogged['apellidos']))[0] ?? '';
?>

<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="d-flex justify-content-start ms-4 mt-4 mb-2">
    <h4 class="text-muted ms-2">Bienvenido,</h4>
    <h4 class="text-primary sm-text"><?= esc($primerNombre . ' ' . $primerApellido) ?></h4>
</div>

<!-- Tarjetas resumen -->
<div class="cardBox">
    <div class="card-custom">
        <div>
            <div class="numbers">
                <?= !empty($citas) && is_array($citas) ? count($citas) : 0 ?>
            </div>
            <div class="cardName">Consultas pendientes</div>
        </div>
        <div class="iconBx">
            <ion-icon name="heart-circle-outline"></ion-icon>
        </div>
    </div>

    <div class="card-custom">
        <div>
            <div class="numbers">
                <?= !empty($derivaciones) && is_array($derivaciones) ? count($derivaciones) : 0 ?>
            </div>
            <div class="cardName">Derivaciones pendientes</div>
        </div>
        <div class="iconBx">
            <i class="bi bi-broadcast"></i>
        </div>
    </div>
</div>

<!-- Detalles -->
<div class="detailsTable">
    <!-- Consultas pendientes -->
    <div class="consultasPendientes">
        <div class="cardHeader">
            <h5>Consultas pendientes</h5>
        </div>
        <table>
            <thead>
                <tr>
                    <td>Atención</td>
                    <td>Inicio</td>
                    <td>Fin</td>
                    <td style="text-align:start;">Alumno</td>
                    <td style="text-align:center;">Acciones</td>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($citas) && is_array($citas)): ?>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?= esc($cita['atencion_fech']) ?></td>
                            <td><?= esc($cita['hora_inicio']) ?></td>
                            <td><?= esc($cita['hora_fin']) ?></td>
                            <td class="text-uppercase"><?= esc($cita['alumno_nombres_completos']) ?></td>
                            <td class="text-center">
                                <a href="<?= base_url('citas/editar/' . $cita['id']) ?>" class="btn-edit" title="Actualizar">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No hay consultas pendientes.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Derivaciones pendientes -->
    <div class="alumnosDerivados">
        <div class="cardHeader">
            <h5>Derivaciones pendientes</h5>
        </div>
        <div class="deriv-items">
            <?php if (!empty($derivaciones) && is_array($derivaciones)): ?>
                <?php foreach ($derivaciones as $derivacion): ?>
                    <div class="deriv-item">
                        <?php if ($derivacion['urgencia'] === 'ALTA'): ?>
                            <span class="emoji">🔴</span>
                        <?php elseif ($derivacion['urgencia'] === 'MEDIA'): ?>
                            <span class="emoji">🟠</span>
                        <?php else: ?>
                            <span class="emoji">🟢</span>
                        <?php endif; ?>
                        <div class="deriv-info">
                            <?php
                            $primerApellido = explode(' ', trim($derivacion['alumno_apellidos']))[0] ?? '';
                            $primerNombre = explode(' ', trim($derivacion['alumno_nombres']))[0] ?? '';
                            ?>
                            <p class="text-uppercase">
                                <?= esc($primerApellido . ', ' . $primerNombre) ?>
                            </p>
                            <span><?= esc($derivacion['programa_estudio']) ?></span>
                        </div>
                        <a href="<?= base_url('citas/crearPorDerivDocente/' . $derivacion['id']) ?>" class="btn-details"
                            title="Agendar consulta">
                            <ion-icon name="heart-circle-outline"></ion-icon>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="deriv-item">
                    <span>No hay derivaciones pendientes.</span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.ably.com/lib/ably.min-1.js"></script>
<script>
    const ABLY_CHANNEL_NAME = 'iestp-psycho-updates';
    const ABLY_EVENT_NAME = 'dashboard_update';

    // Inicializa el cliente Ably con el Token Request
    const ably = new Ably.Realtime({ 
        authUrl: '<?= base_url('api/ably-token') ?>',
        authMethod: 'GET',
    });
    const channel = ably.channels.get(ABLY_CHANNEL_NAME);

    async function reloadHomeDashboard() {
        try {
            const response = await fetch('<?= base_url('api/home-data') ?>', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            if (!response.ok) throw new Error('Conexión fallida - websocket ably');
            const data = await response.json();

            // Actualizar Contadores
            const citasCountDiv = document.querySelector('.card-custom:nth-child(1) .numbers');
            const derivacionesCountDiv = document.querySelector('.card-custom:nth-child(2) .numbers');
            
            if (citasCountDiv) citasCountDiv.textContent = data.citas_count;
            if (derivacionesCountDiv) derivacionesCountDiv.textContent = data.derivaciones_count;

            // Actualizar Tabla de Citas Pendientes
            const citasTableBody = document.querySelector('.consultasPendientes tbody');
            const citasTableContent = generateCitasTableHtml(data.citas);
            if (citasTableBody) citasTableBody.innerHTML = citasTableContent;

            // Actualizar Lista de Derivaciones Pendientes
            const derivacionesListDiv = document.querySelector('.alumnosDerivados .deriv-items');
            const derivacionesListContent = generateDerivacionesListHtml(data.derivaciones);
            if (derivacionesListDiv) derivacionesListDiv.innerHTML = derivacionesListContent;
        } catch (error) {
            console.error('Error al recargar el Dashboard:', error);
        }
    }

    function generateCitasTableHtml(citas) {
        if (!citas || citas.length === 0) return '<tr><td colspan="5" class="text-center">No hay consultas pendientes.</td></tr>';
        return citas.map(cita => {
            return `
                <tr>
                    <td>${cita.atencion_fech}</td>
                    <td>${cita.hora_inicio}</td>
                    <td>${cita.hora_fin}</td>
                    <td class="text-uppercase">${cita.alumno_nombres_completos}</td>
                    <td class="text-center">
                        <a href="<?= base_url('citas/editar/') ?>${cita.id}" class="btn-edit" title="Actualizar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    </td>
                </tr>
            `;
        }).join('');
    }

    function generateDerivacionesListHtml(derivaciones) {
        if (!derivaciones || derivaciones.length === 0) {
            return `
                <div class="deriv-item">
                    <span>No hay derivaciones pendientes.</span>
                </div>
            `;
        }
        
        return derivaciones.map(derivacion => {
            let emoji = '🟢';
            if (derivacion.urgencia === 'ALTA') {
                emoji = '🔴';
            } else if (derivacion.urgencia === 'MEDIA') {
                emoji = '🟠';
            }
            const alumnoApellidos = derivacion.alumno_apellidos.trim().split(' ')[0];
            const alumnoNombres = derivacion.alumno_nombres.trim().split(' ')[0];
            const nombreCompleto = `${alumnoApellidos}, ${alumnoNombres}`;
            return `
                <div class="deriv-item">
                    <span class="emoji">${emoji}</span>
                    <div class="deriv-info">
                        <p class="text-uppercase">${nombreCompleto}</p>
                        <span>${derivacion.programa_estudio}</span>
                    </div>
                    <a href="<?= base_url('citas/crearPorDerivDocente/') ?>${derivacion.id}" class="btn-details" title="Agendar consulta">
                        <ion-icon name="heart-circle-outline"></ion-icon>
                    </a>
                </div>
            `;
        }).join('');
    }

    // Suscripción al Canal
    channel.subscribe(ABLY_EVENT_NAME, (message) => {
        if (message.name === ABLY_EVENT_NAME) {
            reloadHomeDashboard();
        }
    });

    // depuración
    ably.connection.on('connected', () => {
        console.log('Conectado a Ably con un Token seguro.');
    });
    ably.connection.on('failed', (error) => {
        console.error('Fallo al conectar con el servicio Ably:', error);
    });
</script>

<style>
    .cardBox {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 20px;
        margin-bottom: 30px;
        padding: 0 30px;
    }

    .card-custom {
        background: var(--white);
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .card-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    .numbers {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--blue);
        line-height: 1;
        margin-bottom: 8px;
    }

    .cardName {
        font-size: 1.2rem;
        color: var(--black2);
        font-weight: 600;
    }

    .iconBx {
        font-size: 4rem;
        color: var(--black2);
    }

    .detailsTable {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-gap: 20px;
        padding: 0 30px;
    }

    .consultasPendientes,
    .alumnosDerivados {
        background: var(--white);
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .cardHeader h5 {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--blue);
        margin-bottom: 20px;
    }

    .consultasPendientes table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .consultasPendientes thead td {
        padding: 12px 8px;
        font-weight: 600;
        font-size: 1.1rem;
        color: #666;
        border-bottom: 2px solid #f0f0f0;
    }

    .consultasPendientes tbody {
        display: block;
        overflow-y: auto;
        min-height: 400px;
        max-height: 400px;
    }

    .consultasPendientes thead,
    .consultasPendientes tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .consultasPendientes tbody tr {
        border-bottom: 1px solid #f5f5f5;
        transition: all 0.2s ease;
        font-size: 1rem;
    }

    .consultasPendientes tbody tr:hover {
        background: #f8f9fa;
    }

    .consultasPendientes tbody td {
        padding: 15px 8px;
        color: #333;
    }

    .btn-edit {
        background: #0272e9ff;
        color: white;
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-edit:hover {
        background: #027afbff;
        transform: scale(1.05);
    }

    .deriv-items {
        display: block;
        overflow-y: auto;
        min-height: 400px;
        max-height: 400px;
    }

    .deriv-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 15px 10px;
        border-bottom: 1px solid #f5f5f5;
        transition: all 0.2s ease;
    }

    .deriv-item:hover {
        background: #f8f9fa;
    }

    .emoji {
        font-size: 1.5rem;
        width: 30px;
        text-align: center;
    }

    .deriv-info {
        flex: 1;
    }

    .deriv-info p {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 3px;
    }

    .deriv-info span {
        font-size: 0.8rem;
        color: #999;
    }

    .btn-details {
        background: #0272e9ff;
        color: white;
        width: 32px;
        height: 32px;
        font-size: 1.3rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 6px;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-details:hover {
        background: #027afbff;
        transform: scale(1.05);
    }

    @media (max-width: 991px) {
        .detailsTable {
            grid-template-columns: 1fr;
        }

        .cardBox {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .consultasPendientes {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .consultasPendientes table {
            min-width: 600px;
            display: table;
        }

        .consultasPendientes thead,
        .consultasPendientes tbody {
            display: table-row-group;
        }

        .consultasPendientes tbody {
            overflow-y: visible;
            min-height: auto;
            max-height: none;
        }

        .consultasPendientes thead tr,
        .consultasPendientes tbody tr {
            display: table-row;
            width: 100%;
            /* Asegura que ocupe todo el ancho */
        }

        .consultasPendientes thead td,
        .consultasPendientes tbody td {
            display: table-cell;
            white-space: nowrap;
            padding: 12px 8px;
            /* Mantiene el padding consistente */
        }

        /* Asegura que el thead sea visible y fijo visualmente */
        .consultasPendientes thead {
            display: table-header-group;
        }
    }
</style>

<?= $this->endSection() ?>