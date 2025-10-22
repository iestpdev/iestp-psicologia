<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<?= view('shared/forms/formHeader', [
    'title' => 'Información de Alumno',
    'backUrl' => base_url('alumnos')
]) ?>

<section id="profile">
    <?= view('modules/alumnos/details/components/profile-general-info', ['alumno' => $alumno]) ?>

    <div class="profile-content col-7">
        <ul class="profile-content-menu">
            <li> <a id="active">Historial Clinico</a></li>
            <!-- <li> <a>Perfil psicológico</a></li> -->
            <li> <a><i class="fa fa-users"></i> Familiares</a></li>
        </ul>
        <!-- perfil psicologico container  -->
        <!-- 
        <div class="perfilpsicologico-container">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-sm p-3">
                        <canvas id="lienzo" style="max-width:100%; max-height:400px;"></canvas>
                    </div>
                </div>
            </div>
            <p>perfil psicologicoooo</p>
        </div>        
        -->

        <!-- familiares container  -->
        <div class="familiares-container">
            <?= view('modules/alumnos/details/components/familiares-list', [
                'alumno' => $alumno,
                'familiares' => $familiares
            ]) ?>
        </div>

        <!-- Consultas container -->
        <div class="consultas-container">
            <div class="consultas-header d-flex justify-content-between align-items-center mb-3">
                <a href="<?= base_url('citas/crear?alumnoId=' . $alumno['id']) ?>" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus"></i> Registrar nueva consulta
                </a>
            </div>
            <?php if (!empty($citas)): ?>
                <div class="row g-3">
                    <?php foreach ($citas as $cita): ?>
                        <div class="col-12">
                            <?php
                            $link = ($cita['asistencia'] === 'ASISTIDO' || $cita['asistencia'] === 'AUSENTE')
                                ? base_url('citas/info/' . $cita['id'])
                                : base_url('citas/editar/' . $cita['id'].'?desdePerfil=true');
                            ?>
                            <a href="<?= $link ?>" class="text-decoration-none text-reset">
                                <div class="card border-0 shadow-sm w-100 clickable-card">
                                    <div
                                        class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                        <div>
                                            <h6 class="fw-semibold mb-1 text-primary">
                                                <i class="bi bi-calendar-check me-1"></i>
                                                <?= esc($cita['tipo_derivacion']) ?> – <?= esc($cita['atencion_fech']) ?>
                                            </h6>
                                            <p class="mb-1 text-muted small">
                                                <i class="bi bi-clock me-1"></i>
                                                <?= substr($cita['hora_inicio'], 0, 5) ?> -
                                                <?= substr($cita['hora_fin'], 0, 5) ?>
                                            </p>
                                            <p class="mb-1 small text-secondary">
                                                <i class="bi bi-person-badge me-1"></i>
                                                Psicólogo: <?= esc($cita['usuario_nombres_completos'] ?? 'No asignado') ?>
                                            </p>
                                            <p class="mb-0 text-muted">
                                                <?= esc(mb_strlen($cita['motivo']) > 50 ? mb_substr($cita['motivo'], 0, 50) . '...' : $cita['motivo']) ?>
                                            </p>
                                        </div>

                                        <div class="mt-3 mt-md-0 text-md-end">
                                            <span class="badge 
                                            <?= $cita['asistencia'] === 'ASISTIDO'
                                                ? 'bg-success'
                                                : ($cita['asistencia'] === 'AUSENTE'
                                                    ? 'bg-danger text-light'
                                                    : 'bg-warning text-dark')
                                                ?>">
                                                <?= esc($cita['asistencia']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php else: ?>
                <div class="alert alert-secondary text-center mt-3">
                    <i class="bi bi-info-circle"></i> No hay citas registradas para este alumno.
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
    const profileMenu = document.querySelectorAll(".profile-content-menu li a");
    //const perfilPsicologico = document.querySelector(".perfilpsicologico-container");
    const familiares = document.querySelector(".familiares-container");
    const consultas = document.querySelector(".consultas-container");
    const menu = [
        consultas,
        //perfilPsicologico, 
        familiares
    ];

    function slideContent(profileLinks, content, id = "active") {
        profileLinks.forEach((menuLink, i) =>
            menuLink.addEventListener("click", () => {
                profileLinks.forEach((el, index) =>
                    i === index ? (el.id = id) : (el.id = "")
                );
                content.forEach((el, index) =>
                    i === index && i === 0
                        ? (el.style.display = "flex")
                        : i === index && i !== 0
                            ? (el.style.display = "block")
                            : (el.style.display = "none")
                );
            })
        );
    }

    slideContent(profileMenu, menu);
</script>

<!-- graficos con chart.js
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const lienzo = document.getElementById('lienzo');

        const data = {
            labels: [
                'Ansiedad',
                'Depresión',
                'Autoestima',
                'Estrés',
                'Impulsividad',
                'Sociabilidad',
                'Motivación',
                'Adaptabilidad',
            ],
            datasets: [{
                label: 'Aspecto emocional y conductual',
                data: [4, 6, 2, 1, 10, 7, 8, 5],
                fill: true,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgb(255, 99, 132)',
                pointBackgroundColor: 'rgb(255, 99, 132)',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: 'rgb(255, 99, 132)'
            }]
        };

        const grafico = new Chart(lienzo, {
            type: 'radar',
            data: data,
            options: {
                elements: {
                    line: {
                        borderWidth: 3
                    }
                }
            },
        });

    });

</script>
-->

<style>
    /* Profile */
    #profile {
        justify-content: center;
        flex-wrap: wrap;
        display: flex;
    }

    .profile-content {
        margin: 0 1rem;
        box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.37);
        background-color: #ffffff;
        border-radius: 20px;
    }

    .profile-content ul {
        padding-left: 0;
    }

    .profile-content-menu {
        display: flex;
        margin: 1rem;
    }

    .profile-content-menu li {
        list-style-type: none;
    }

    .profile-content-menu li a {
        position: relative;
        text-decoration: none;
        color: rgba(34, 45, 107);
        margin: 1em;
        cursor: pointer;
    }

    .profile-content-menu li a:after {
        content: "";
        position: absolute;
        width: 0;
        height: 2px;
        display: block;
        margin-top: 0.5px;
        right: 0;
        background: rgba(34, 45, 107);
        transition: width 0.2s ease;
    }

    .profile-content-menu li a:hover:after {
        width: 105%;
        left: 0;
        background: #262626bd;
    }

    /*Grid desktop  */
    .col-4 {
        width: 33.33%;
    }

    .col-7 {
        width: 58.33%;
    }

    /*Responsive layout*/
    @media only screen and (max-width: 768px) {
        [class*="col-"] {
            width: 100%;
        }
    }

    /* Active link */
    #active:after {
        content: "";
        position: absolute;
        width: 105%;
        height: 2px;
        display: block;
        margin-top: 0.5px;
        left: 0;
        background: rgba(34, 45, 107);
        transition: width 0.2s ease;
        -webkit-transition: width 0.2s ease;
    }

    /*perfilPsicologico Card  */
    .perfilpsicologico-container,
    .familiares-container {
        display: none;
    }

    .familiares-container,
    .consultas-container {
        max-height: 600px;
        overflow-y: auto;
        overflow-x: hidden;
        scrollbar-width: thin;
        /* Firefox */
        scrollbar-color: #c1c1c1 #f1f1f1;
    }

    /* Estilos del scrollbar para Chrome/Edge */
    .familiares-container::-webkit-scrollbar,
    .consultas-container::-webkit-scrollbar {
        width: 8px;
    }

    .familiares-container::-webkit-scrollbar-thumb,
    .consultas-container::-webkit-scrollbar-thumb {
        background-color: #c1c1c1;
        border-radius: 4px;
    }

    .familiares-container::-webkit-scrollbar-track,
    .consultas-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    /*Estilo de consultas container */
    .consultas-container {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin: 1rem;
    }

    .consultas-header {
        border-bottom: 1px solid #e5e5e5;
        padding-bottom: .5rem;
    }

    .consultas-container .card {
        border-left: 4px solid var(--blue);
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .consultas-container .card:hover {
        background-color: var(--gray);
        transform: translateY(-2px);
    }

    .consultas-container .text-primary {
        color: var(--blue) !important;
    }

    .clickable-card {
        border-left: 4px solid var(--blue);
        transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }

    .clickable-card:hover {
        background-color: var(--gray);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    }
</style>

<?= $this->endSection() ?>