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
                        <small><i class="fa-solid fa-graduation-cap"></i> <span id="alumno-programa-estudio"></span></small>
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
                    <small style="color: #0358CB; font-weight: 600;"><i class="fa fa-calendar-plus"></i> CREADO: <span id="created-at" style="color: black; font-weight: 400;"></span></small>
                </div>
            </div>

            <!-- //TODO: En caso de ser recibido, debe mostrarse la fecha que asigno el psicologo para atender esta situacion -->

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
    .person>i,strong{
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
</style>