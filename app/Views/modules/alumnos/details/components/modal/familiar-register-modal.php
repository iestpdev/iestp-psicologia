<div class="modal fade" id="familiarModal" tabindex="-1" aria-labelledby="familiarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="familiarModalLabel">
                    <i class="fa fa-user-plus me-2"></i>Registrar nuevo familiar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form id="formRegistrarFamiliar" autocomplete="off">
                    <div class="mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombres" class="form-control" placeholder="Ingrese nombres" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" placeholder="Ingrese apellidos"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">DNI</label>
                        <input type="text" name="dni" class="form-control" maxlength="8" pattern="[0-9]{8}"
                            inputmode="numeric" placeholder="Ingrese DNI" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="tel" name="telefono" class="form-control" maxlength="9" pattern="[0-9]{9}"
                            placeholder="Ingrese teléfono">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parentesco</label>
                        <select name="parentesco" class="form-select" required>
                            <option value="">-- Seleccione--</option>
                            <?php foreach ($parentescos as $parentesco): ?>
                                <option value="<?= $parentesco['id'] ?>"><?= esc($parentesco['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formRegistrarFamiliar" class="btn btn-primary">Registrar</button>
                </form>
            </div>

        </div>
    </div>
</div>

<?= $this->include('shared/toasts/notyf') ?>
<script type="module">
    import { showToast } from '../../js/shared/toasts/notyf.js';

    document.addEventListener('DOMContentLoaded', () => {
        const BASE_URL = document.querySelector('meta[name="base-url"]').content;
        const form = document.getElementById('formRegistrarFamiliar');
        const modalEl = document.getElementById('familiarModal');
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        const alumnoId = <?= $alumno['id'] ?>;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData(form);
            const btn = form.querySelector('button[type="submit"]');
            btn.disabled = true;

            try {
                const res = await fetch(`${BASE_URL}api/familiares/add/${alumnoId}`, {
                    method: 'POST',
                    body: formData
                });

                const data = await res.json();
                if (!res.ok) throw data;

                // notificación
                showToast('success', data.message || 'Familiar registrado correctamente');

                // Cerrar modal y resetear form
                modal.hide();
                form.reset();
                btn.disabled = false;

                // Agregar nueva card sin recargar
                const grid = document.querySelector('.familiares-grid');
                const emptyMsg = document.querySelector('.text-center.text-muted');

                if (emptyMsg) emptyMsg.remove();

                const card = document.createElement('div');
                card.className = 'familiar-card';
                card.innerHTML = `
                <div class="familiar-card-body">
                <h6 class="familiar-name mb-1">${data.data.pariente_nombres} ${data.data.pariente_apellidos}</h6>
                <p class="familiar-detail mb-1"><i class="fa fa-id-card"></i> ${data.data.pariente_dni}</p>
                <p class="familiar-detail mb-1"><i class="fa fa-phone"></i> ${data.data.pariente_telefono ?? 'Sin teléfono'}</p>
                <p class="familiar-detail mb-0"><i class="fa fa-link"></i> ${data.data.pariente_parentesco ?? 'No especificado'}</p>
                </div>
                `;
                grid.appendChild(card);

            } catch (err) {
                console.error(err);
                const msg = err?.message || 'Ocurrió un error al registrar el familiar';
                showToast('error', msg);
                btn.disabled = false;
            }
        });
    });
</script>


<style>
    #familiarModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }

    #familiarModal .form-control:focus,
    #familiarModal .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    #familiarModal .modal-header {
        border-bottom: none;
    }

    #familiarModal .modal-footer {
        border-top: none;
    }
</style>