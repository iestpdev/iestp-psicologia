<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<div class="bienvenida">
    <h4 class="fw-normal text-muted mb-1">Bienvenido,</h4>
    <h2 class="fw-bold text-primary mb-4">Carlos Ramírez</h2>
</div>

<!-- Tarjetas resumen -->
<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers">3</div>
            <div class="cardName">Consultas pendientes</div>
        </div>
        <div class="iconBx">
            <i class="bi bi-heart-pulse"></i>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers">5</div>
            <div class="cardName">Derivaciones pendientes</div>
        </div>
        <div class="iconBx">
            <i class="bi bi-broadcast"></i>
        </div>
    </div>
</div>

<!-- Detalles -->
<div class="detailsDeriv">
    <!-- Consultas pendientes -->
    <div class="consultasPendientes">
        <div class="cardHeader">
            <h5 class="fw-semibold mb-3">Consultas pendientes</h5>
        </div>

        <table class="tablaConsulta">
            <thead>
                <tr>
                    <td>Atención</td>
                    <td>Inicio</td>
                    <td>Fin</td>
                    <td style="text-align:start;">Alumno</td>
                    <td style="text-align:end;">Actualizar</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2025-10-22</td>
                    <td>09:00</td>
                    <td>10:00</td>
                    <td class="text-start text-uppercase">Ramírez López, Ana</td>
                    <td class="text-end">
                        <a href="#" class="btn-edit" title="Actualizar"><i class="bi bi-pencil-square"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2025-10-23</td>
                    <td>11:00</td>
                    <td>12:00</td>
                    <td class="text-start text-uppercase">Velarde Gutiérrez, Ángel</td>
                    <td class="text-end">
                        <a href="#" class="btn-edit" title="Actualizar"><i class="bi bi-pencil-square"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2025-10-24</td>
                    <td>14:00</td>
                    <td>15:00</td>
                    <td class="text-start text-uppercase">Cano Rosas, Catalina</td>
                    <td class="text-end">
                        <a href="#" class="btn-edit" title="Actualizar"><i class="bi bi-pencil-square"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Derivaciones pendientes -->
    <div class="alumnosDerivados">
        <div class="cardHeader">
            <h5 class="fw-semibold mb-3">Derivaciones pendientes</h5>
        </div>

        <table>
            <tbody>
                <tr>
                    <td>
                        <div class="deriv-item">
                            <span class="emoji">🔴</span>
                            <div>
                                <p class="fw-semibold mb-0 text-uppercase small">Ramírez, Ana</p>
                                <span class="text-muted small">Psicología</span>
                            </div>
                            <a href="#" class="btn-details" title="Agregar consulta">
                                <i class="bi bi-heart-pulse"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="deriv-item">
                            <span class="emoji">🟡</span>
                            <div>
                                <p class="fw-semibold mb-0 text-uppercase small">Gutiérrez, Ángel</p>
                                <span class="text-muted small">Orientación Vocacional</span>
                            </div>
                            <a href="#" class="btn-details" title="Agregar consulta">
                                <i class="bi bi-heart-pulse"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="deriv-item">
                            <span class="emoji">🟢</span>
                            <div>
                                <p class="fw-semibold mb-0 text-uppercase small">Cano, Catalina</p>
                                <span class="text-muted small">Bienestar Social</span>
                            </div>
                            <a href="#" class="btn-details" title="Agregar consulta">
                                <i class="bi bi-heart-pulse"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<style>
    .bienvenida {
        padding: 10px 20px;
    }

    .bienvenida h2 {
        font-size: 1.8rem;
    }

    .cardBox {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-gap: 20px;
        margin-bottom: 20px;
    }

    .card {
        background: var(--white);
        padding: 20px;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .card:hover {
        background: var(--blue);
        color: var(--white);
    }

    .numbers {
        font-size: 2rem;
        font-weight: 600;
        color: var(--blue);
    }

    .card:hover .numbers {
        color: var(--white);
    }

    .cardName {
        font-size: 0.95rem;
        color: var(--black2);
    }

    .card:hover .cardName {
        color: var(--white);
    }

    .iconBx {
        font-size: 2.2rem;
        color: var(--black2);
    }

    .detailsDeriv {
        display: grid;
        grid-template-columns: 2fr 1fr;
        grid-gap: 20px;
        padding: 0 20px;
    }

    .consultasPendientes,
    .alumnosDerivados {
        background: var(--white);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
    }

    .consultasPendientes table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .consultasPendientes table td {
        padding: 8px;
    }

    .consultasPendientes tbody {
        display: block;
        overflow-y: auto;
        max-height: 260px;
    }

    .consultasPendientes thead,
    .consultasPendientes tbody tr {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    .consultasPendientes tbody tr:hover {
        background: var(--blue);
        color: var(--white);
    }

    .btn-edit {
        color: var(--blue);
        font-size: 1rem;
        transition: 0.3s;
    }

    .btn-edit:hover {
        color: var(--white);
    }

    .alumnosDerivados tbody {
        display: block;
        overflow-y: auto;
        max-height: 280px;
    }

    .deriv-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 6px 0;
    }

    .emoji {
        font-size: 1.2rem;
    }

    .btn-details {
        color: var(--blue);
        font-size: 1.1rem;
        transition: 0.3s;
    }

    .btn-details:hover {
        color: #fff;
    }

    @media (max-width: 991px) {
        .detailsDeriv {
            grid-template-columns: 1fr;
        }

        .cardBox {
            grid-template-columns: 1fr;
        }
    }
</style>

<?= $this->endSection() ?>