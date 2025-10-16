<!-- 
 //TODO: si aparece la card nueva al crear un nuevo familiar, pero no tiene la funcion de abrir el modal
         de edicion ya que esta card es meramente estetico, ya cuando se recarga la pagina, se ven los reales
         y la card funciona con normalidad, pero eso no deberia pasar, deberia poder darse click a la nueva card
         generada y que se abra el modal de edicion
-->
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
                        <label class="form-label">DNI</label>
                        <input type="text" name="dni" id="dni" class="form-control" maxlength="8" pattern="[0-9]{8}"
                            inputmode="numeric" placeholder="Ingrese DNI" required>
                        <span>hola</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombres</label>
                        <input type="text" name="nombres" id="nombres" class="form-control"
                            placeholder="Ingrese nombres" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" class="form-control"
                            placeholder="Ingrese apellidos" required>
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
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="formRegistrarFamiliar" class="btn btn-primary">Registrar</button>
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
  const form = document.getElementById('formRegistrarFamiliar');
  const modalEl = document.getElementById('familiarModal');
  const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
  const alumnoId = <?= $alumno['id'] ?>;

  if (!form) return;

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

      // success
      showToast('success', data.message || 'Familiar registrado correctamente');

      // close & reset
      modal.hide();
      form.reset();
      btn.disabled = false;

      // remove empty message if present
      const emptyMsg = document.querySelector('.text-center.text-muted');
      if (emptyMsg) emptyMsg.remove();

      // find or create grid
      let grid = document.querySelector('.familiares-grid');
      if (!grid) {
        // prefer inserting after .familiares-header if exists
        const header = document.querySelector('.familiares-header');
        grid = document.createElement('div');
        grid.className = 'familiares-grid mx-3';

        if (header && header.parentNode) {
          header.insertAdjacentElement('afterend', grid);
        } else {
          // fallback: append inside .profile-content or body
          const profileContent = document.querySelector('.profile-content') || document.body;
          profileContent.appendChild(grid);
        }
      }

      // determine pariente id (puede venir como pariente_id o id)
      const parienteId = data.data?.pariente_id ?? data.data?.id ?? '';

      // create card element
      const card = document.createElement('div');
      card.className = 'familiar-card';
      card.innerHTML = `
        <button type="button" class="btn btn-sm btn-light btn-delete-familiar" title="Eliminar familiar">
          <i class="fa fa-times"></i>
        </button>
        <div class="familiar-card-body">
          <h6 class="familiar-name mb-1" data-pariente-id="${parienteId}">
            ${data.data.pariente_nombres} ${data.data.pariente_apellidos}
          </h6>
          <p class="familiar-detail mb-1"><i class="fa fa-id-card"></i> ${data.data.pariente_dni}</p>
          <p class="familiar-detail mb-1"><i class="fa fa-phone"></i> ${data.data.pariente_telefono ?? 'Sin teléfono'}</p>
          <p class="familiar-detail mb-0"><i class="fa fa-link"></i> ${data.data.pariente_parentesco ?? 'No especificado'}</p>
        </div>
      `;

      grid.appendChild(card);

    } catch (err) {
      console.error(err);
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