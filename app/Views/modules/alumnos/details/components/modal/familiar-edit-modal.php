<div class="modal fade" id="familiarEditModal" tabindex="-1" aria-labelledby="familiarEditModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-light">
                <h5 class="modal-title" id="familiarEditModalLabel">
                    <i class="fa fa-user-edit me-2"></i> Editar familiar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form id="formEditarFamiliar" autocomplete="off">
                    <input type="hidden" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombres" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">DNI</label>
                        <input type="text" name="dni" class="form-control" maxlength="8" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" maxlength="9">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parentesco</label>
                        <select name="parentesco" class="form-select" required>
                            <option value="">-- Seleccione --</option>
                            <?php foreach ($parentescos as $parentesco): ?>
                                <option value="<?= $parentesco['id'] ?>"><?= esc($parentesco['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary text-white">Actualizar</button>
                    </div>
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
        const editModalEl = document.getElementById('familiarEditModal');
        const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
        const form = document.getElementById('formEditarFamiliar');

        // Abrir modal al hacer click en una card
        document.querySelectorAll('.familiar-name').forEach(card => {
            card.addEventListener('click', async () => {
                const id = card.dataset.parienteId;
                try {
                    const res = await fetch(`${BASE_URL}api/parientes/obtener-por-id/${id}`);
                    const data = await res.json();

                    if (!res.ok) throw new Error('No se pudo obtener el pariente');

                    form.id.value = data.id;
                    form.nombres.value = data.nombres;
                    form.apellidos.value = data.apellidos;
                    form.dni.value = data.dni;
                    form.telefono.value = data.telefono ?? '';
                    form.parentesco.value = data.parentesco_id;

                    // Guardamos la card actual que se esta editando
                    form.dataset.targetCard = id;

                    editModal.show();
                } catch (err) {
                    console.error(err);
                    showToast('error', err.message || 'Error al cargar los datos');
                }
            });
        });

        // Guardar cambios
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = form.id.value;
            const formData = new FormData(form);

            try {
                const res = await fetch(`${BASE_URL}api/parientes/update/${id}`, {
                    method: 'POST',
                    body: formData
                });
                const data = await res.json();

                if (!res.ok) {
                    if (Array.isArray(data.errors)) {
                        data.errors.forEach(error => showToast('error', error));
                    } else if (typeof data.errors === 'object') {
                        Object.values(data.errors).forEach(error => showToast('error', error));
                    } else if (data.message) {
                        showToast('error', data.message);
                    }
                    throw data;
                }

                showToast('success', data.message || 'Familiar actualizado correctamente');
                editModal.hide();

                // Actualizar dinamicamente la card
                const card = document.querySelector(`.familiar-card[data-pariente-id="${form.dataset.targetCard}"]`);
                if (card) {
                    card.querySelector('.familiar-name').textContent = `${form.nombres.value} ${form.apellidos.value}`;
                    card.querySelector('.familiar-detail:nth-of-type(1)').innerHTML = `<i class="fa fa-id-card"></i> ${form.dni.value}`;
                    card.querySelector('.familiar-detail:nth-of-type(2)').innerHTML = `<i class="fa fa-phone"></i> ${form.telefono.value || 'Sin teléfono'}`;

                    // Obtener el texto visible del parentesco
                    const parentescoText = form.parentesco.options[form.parentesco.selectedIndex].text;
                    card.querySelector('.familiar-detail:nth-of-type(3)').innerHTML = `<i class="fa fa-link"></i> ${parentescoText}`;
                }
            } catch (err) {
                console.error(err);
            }
        });
    });
</script>

<style>
    #familiarEditModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
    }
</style>