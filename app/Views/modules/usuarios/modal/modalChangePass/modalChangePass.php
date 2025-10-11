<div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold" id="modalPasswordLabel">
                    <i class="bi bi-key-fill me-2 text-primary"></i>Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-2 pb-4">
                <div class="mb-3">
                    <label class="form-label text-muted small mb-2">Nueva Contraseña</label>
                    <div class="input-group">
                        <input type="text" id="newPassword" class="form-control border-end-0"
                            placeholder="Ingrese o genere una contraseña">
                        <button class="btn btn-success border-start-0" type="button"
                            id="generatePassword">
                            Generar
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary px-4" id="confirmPasswordChange">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<style>
#modalPassword .modal-content {
    border-radius: 12px;
    overflow: hidden;
}

#modalPassword .modal-header {
    padding: 1.5rem 1.5rem 1rem;
}

#modalPassword .modal-body {
    padding: 0 1.5rem 1.5rem;
}

#modalPassword .modal-footer {
    padding: 0 1.5rem 1.5rem;
}

#modalPassword .form-control {
    border: 1px solid #dee2e6;
    padding: 0.625rem 0.875rem;
    transition: all 0.2s ease;
}

#modalPassword .form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

#modalPassword .btn-outline-secondary {
    border-color: #dee2e6;
    color: #6c757d;
    transition: all 0.2s ease;
}

#modalPassword .btn-outline-secondary:hover {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #495057;
}

#modalPassword .btn-light {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #6c757d;
}

#modalPassword .btn-light:hover {
    background-color: #e9ecef;
    border-color: #dee2e6;
}

#modalPassword .btn-primary {
    background-color: #0d6efd;
    border: none;
}

#modalPassword .btn-primary:hover {
    background-color: #0b5ed7;
}

#modalPassword .input-group {
    border-radius: 6px;
    overflow: hidden;
}
</style>