<!-- Modal Info Derivaciones -->
<div class="modal fade" id="modalInfo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modern-modal">
            <!-- Header -->
            <div class="modal-header-custom">
                <h5 class="modal-title-custom">Información de Derivación</h5>
                <button type="button" class="btn-close-custom" data-bs-dismiss="modal">
                    <i class="fa fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body-custom">
                <!-- Docente y Alumno -->
                <div class="section">
                    <div class="person">
                        <i class="fa fa-chalkboard-user"></i> <strong>DOCENTE</strong>
                        <p id="docente-nombre"></p>
                        <small><i class="fa fa-id-card"></i> <span id="docente-dni"></span></small>
                        <small><i class="fa fa-envelope"></i> <span id="docente-correo"></span></small>
                    </div>
                    <div class="person">
                        <i class="fa fa-user-graduate"></i> <strong>ALUMNO</strong>
                        <p id="alumno-nombre"></p>
                        <small><i class="fa fa-id-card"></i> <span id="alumno-dni"></span></small>
                        <small><i class="fa-solid fa-graduation-cap"></i> <span
                                id="alumno-programa-estudio"></span></small>
                    </div>
                </div>

                <!-- Urgencia y Estado -->
                <div class="section badges">
                    <div class="info-item">
                        <span class="label"><i class="fa fa-exclamation-triangle"></i> Urgencia:</span>
                        <span id="urgencia"></span>
                    </div>
                    <div class="info-item">
                        <span class="label"><i class="fa fa-clipboard-check"></i> Estado:</span>
                        <span id="estado"></span>
                    </div>
                </div>

                <!-- Motivo -->
                <div class="section">
                    <strong><i class="fa fa-message"></i> MOTIVO</strong>
                    <p id="motivo"></p>
                </div>

                <!-- Fechas -->
                <div class="section">
                    <small style="color: #0358CB; font-weight: 600;"><i class="fa fa-calendar-plus"></i> CREADO: <span
                            id="created-at" style="color: black; font-weight: 400;"></span></small>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer-custom">
                <button type="button" class="btn-custom btn-custom-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .modern-modal {
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    }

    .modal-header-custom {
        background: #0066cc;
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
    }

    .modal-title-custom {
        margin: 0;
        font-weight: 600;
    }

    .btn-close-custom {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        font-size: 1.2rem;
    }

    .modal-body-custom {
        padding: 1.5rem;
        background: #f9fafb;
    }

    .section {
        margin-bottom: 1rem;
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .person {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 1rem;
        flex: 1 1 200px;
    }

    .person>i,
    strong {
        color: #0358CB;
    }

    .person small {
        display: block;
        color: #6b7280;
    }

    .section.badges {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.5rem 0.8rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .label {
        font-weight: 600;
        color: #0358CB;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge {
        padding: 0.4rem 0.9rem;
        border-radius: 20px;
        font-weight: 500;
        text-align: center;
        display: inline-block;
    }

    .bg-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .bg-warning {
        background-color: #facc15;
        color: #000;
    }

    .bg-info {
        background-color: #0dcaf0;
        color: #000;
    }

    .bg-success {
        background-color: #198754;
        color: #fff;
    }

    .bg-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .modal-footer-custom {
        padding: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        background: #fff;
    }

    .btn-custom {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        border: none;
        cursor: pointer;
    }

    .btn-custom-secondary {
        background: #e5e7eb;
        color: #374151;
    }

    /* Estilos para la sección de cita */
    .cita-section {
        margin-top: 1rem;
        display: block;
    }

    .cita-container {
        background: linear-gradient(135deg, #0358CB 0%, #0066cc 100%);
        border-radius: 12px;
        padding: .7rem;
        box-shadow: 0 4px 12px rgba(3, 88, 203, 0.15);
        border: 1px solid rgba(3, 88, 203, 0.2);
    }

    .cita-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.2rem;
        color: #fff;
        font-size: 1rem;
    }

    .cita-header i {
        font-size: 1.3rem;
    }

    .cita-header strong {
        color: #fff;
        letter-spacing: 0.5px;
    }

    .cita-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
    }

    .cita-item {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.8rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cita-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .cita-item i {
        color: #0358CB;
        font-size: 1.2rem;
        margin-top: 0.2rem;
    }

    .cita-item-content {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
        flex: 1;
    }

    .cita-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cita-value {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .cita-details {
            grid-template-columns: 1fr;
        }
    }
</style>