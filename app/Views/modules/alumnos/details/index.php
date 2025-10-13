<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= view('shared/forms/formHeader', [
    'title' => 'Información de Alumno',
    'backUrl' => base_url('alumnos')
]) ?>

<section id="profile">
    <?= view('modules/alumnos/details/components/profile-general-info', ['alumno' => $alumno]) ?>

    <div class="profile-content col-7">
        <ul class="profile-content-menu">
            <li> <a id="active">Historial Clinico</a></li>
            <li> <a>Perfil psicológico</a></li>
            <li> <a><i class="fa fa-users"></i> Familiares</a></li>
        </ul>
        <!-- perfil psicologico container  -->
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

        <!-- familiares container  -->
        <div class="familiares-container">
            <?= view('modules/alumnos/details/components/familiares-list', [
                'alumno' => $alumno,
                'familiares' => $familiares
            ]) ?>
        </div>

        <!-- Consultas container  -->
        <div class="consultas-container">
            <p>consultas</p>
        </div>
    </div>
</section>

<script>
    const profileMenu = document.querySelectorAll(".profile-content-menu li a");
    const perfilPsicologico = document.querySelector(".perfilpsicologico-container");
    const familiares = document.querySelector(".familiares-container");
    const consultas = document.querySelector(".consultas-container");
    const menu = [consultas, perfilPsicologico, familiares];

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
</style>

<?= $this->endSection() ?>