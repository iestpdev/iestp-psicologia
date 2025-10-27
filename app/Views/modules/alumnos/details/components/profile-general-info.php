<aside class="profile-general-info col-4">
    <div class="profile-header">
        <div class="profile-name-container">
            <h2 class="profile-name"><?= esc($alumno['alumno_nombres_completos']) ?></h2>
        </div>
    </div>

    <div class="profile-section">
        <div class="info-item">
            <div class="info-icon">
                <i class="fa fa-id-card"></i>
            </div>
            <div class="info-content">
                <span class="info-label">DNI</span>
                <span class="info-value"><?= esc($alumno['dni']) ?></span>
            </div>
            <div class="info-icon">
                <i class="fa fa-phone"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Teléfono</span>
                <span class="info-value"><?= esc($alumno['telefono'] ?? 'No registrado') ?></span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fa-solid fa-envelope"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Email</span>
                <span class="info-value"><?= esc($alumno['email'] ?? 'No registrado') ?></span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-icon">
                <i class="fa fa-map-marker-alt"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Domicilio</span>
                <span class="info-value"><?= esc($alumno['domicilio'] ?? 'No registrado') ?></span>
            </div>
        </div>
        <div class="info-item">
            <div class="info-icon">
                <i class="fa fa-map-marker-alt"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Dirección de nacimiento</span>
                <span class="info-value"><?= esc($alumno['direccion_nac'] ?? 'No registrado') ?></span>
            </div>
        </div>

    </div>

    <div class="profile-section">
        <div class="info-item">
            <div class="info-icon">
                <i class="fa fa-graduation-cap"></i>
            </div>
            <div class="info-content">
                <span class="info-label">Programa de estudio</span>
                <span class="info-value"><?= esc($alumno['programa_estudio'] ?? 'No especificado') ?></span>
            </div>
        </div>

        <div class="badges-container">
            <span class="badge badge-ciclo">
                <i class="fa fa-layer-group"></i>
                Ciclo <span id="cicloText"><?= esc($alumno['ciclo']) ?></span>
            </span>
            <span class="badge badge-turno">
                <i class="fa fa-clock"></i>
                <span id="turnoText"><?= esc($alumno['turno']) ?></span>
            </span>
        </div>
    </div>

    <div class="profile-section">
        <h3 class="section-title">
            <i class="fa fa-user"></i>
            Información adicional
        </h3>

        <div class="additional-info-grid">
            <div class="info-card">
                <i class="fa fa-venus-mars"></i>
                <span id="sexoText"><?= esc($alumno['sexo'] ?? 'No especificado') ?></span>
            </div>

            <div class="info-card">
                <i class="fa fa-calendar"></i>
                <span><?= esc($alumno['fecha_nac'] ?? 'No registrado') ?></span>
            </div>

            <div class="info-card">
                <i class="fa fa-church"></i>
                <span><?= esc($alumno['religion'] ?? 'No especificada') ?></span>
            </div>

            <div class="info-card">
                <i class="fa fa-ring"></i>
                <span><?= esc($alumno['estado_civil'] ?? 'No especificado') ?></span>
            </div>
        </div>
    </div>
</aside>

<style>
    .profile-general-info {
        display: flex;
        flex-direction: column;
        margin: .0rem .5rem;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 20px 20px 60px #d4d4d4,
            -20px -20px 60px #ffffff;
        overflow: hidden;
        transition: box-shadow 0.3s ease;
    }

    /* Header */
    .profile-header {
        background: var(--blue);
        padding: 2rem 1.5rem;
        text-align: center;
    }

    .profile-name {
        color: #ffffff;
        font-size: 1.4rem;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.3px;
    }

    /* Sections */
    .profile-section {
        padding: 1.1rem;
    }

    .section-title {
        color: #222d6b;
        font-size: 1rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title i {
        font-size: 1.1rem;
    }

    /* Info Items */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.75rem 0;
    }

    .info-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #e8ebf7 0%, #f0f2f9 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-icon i {
        color: #222d6b;
        font-size: 1rem;
    }

    .info-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
    }

    .info-label {
        font-size: 0.75rem;
        color: #6b7280;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 0.95rem;
        color: #1f2937;
        font-weight: 500;
        line-height: 1.4;
    }

    /* Badges */
    .badges-container {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        transition: transform 0.2s ease;
    }

    .badge:hover {
        transform: translateY(-2px);
    }

    .badge i {
        font-size: 0.85rem;
    }

    .badge-ciclo {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .badge-turno {
        background: linear-gradient(135deg, #e7fce8ff 0%, #cffbdfff 100%);
        color: #22c55e;
    }

    /* Additional Info Grid */
    .additional-info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .info-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        text-align: center;
        transition: all 0.2s ease;
    }

    .info-card:hover {
        background: #f3f4f6;
        border-color: #222d6b;
        transform: translateY(-2px);
    }

    .info-card i {
        color: #222d6b;
        font-size: 1.2rem;
    }

    .info-card span {
        font-size: 0.85rem;
        color: #374151;
        font-weight: 500;
        line-height: 1.3;
    }

    /* Divider */
    .profile-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);
        margin: 0 1.5rem;
    }

    /* Responsive */
    @media only screen and (max-width: 768px) {
        .profile-general-info {
            margin: 1rem 0;
        }

        .profile-name {
            font-size: 1.2rem;
        }

        .additional-info-grid {
            grid-template-columns: 1fr;
        }

        .badges-container {
            justify-content: center;
        }
    }

    @media only screen and (max-width: 480px) {
        .profile-header {
            padding: 1.5rem 1rem;
        }

        .profile-section {
            padding: 1rem;
        }

        .info-item {
            gap: 0.75rem;
        }
    }
</style>

<script src="<?= base_url('js/utils.js') ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        cicloText.textContent = getCicloText(document.getElementById("cicloText").textContent.trim());
        turnoText.textContent = getTurnoText(document.getElementById("turnoText").textContent.trim());
        sexoText.textContent = getSexoText(document.getElementById("sexoText").textContent.trim());
    });
</script>