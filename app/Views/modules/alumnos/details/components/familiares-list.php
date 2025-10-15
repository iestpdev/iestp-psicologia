<div class="familiares-header d-flex justify-content-between align-items-center mb-3">
    <button type="button" class="btn btn-sm btn-primary ms-3" data-bs-toggle="modal" data-bs-target="#familiarModal">
        <i class="fa fa-plus"></i> Registrar nuevo familiar
    </button>
</div>

<?php if (empty($familiares)): ?>
    <div class="text-center text-muted py-4">
        <i class="fa fa-info-circle fa-lg mb-2"></i>
        <p>No hay familiares registrados.</p>
    </div>
<?php else: ?>
    <div class="familiares-grid mx-3">
        <?php foreach ($familiares as $f): ?>
            <div class="familiar-card">
                <button type="button" class="btn btn-sm btn-light btn-delete-familiar" title="Eliminar familiar">
                    <i class="fa fa-times"></i>
                </button>
                <div class="familiar-card-body">
                    <h6 class="familiar-name mb-1" data-pariente-id="<?= $f['pariente_id'] ?>">
                        <?= esc($f['pariente_nombres'] . ' ' . $f['pariente_apellidos']) ?>
                    </h6>
                    <p class="familiar-detail mb-1"><i class="fa fa-id-card"></i> <?= esc($f['pariente_dni']) ?></p>
                    <p class="familiar-detail mb-1"><i class="fa fa-phone"></i>
                        <?= esc($f['pariente_telefono'] ?? 'Sin teléfono') ?></p>
                    <p class="familiar-detail mb-0"><i class="fa fa-link"></i>
                        <?= esc($f['pariente_parentesco'] ?? 'No especificado') ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?= view('modules/alumnos/details/components/modal/familiar-register-modal', [
    'parentescos' => $parentescos,
]) ?>
<?= view('modules/alumnos/details/components/modal/familiar-edit-modal', [
    'parentescos' => $parentescos,
]) ?>

<?= $this->include('shared/toasts/notyf') ?>
<?= $this->include('shared/alerts/sweetAlert2') ?>
<script type="module">
    import { showToast } from '../../js/shared/toasts/notyf.js';

    document.addEventListener('click', async (e) => {
        const BASE_URL = document.querySelector('meta[name="base-url"]').content;
        const btn = e.target.closest('.btn-delete-familiar');
        if (!btn) return;

        const card = btn.closest('.familiar-card');
        const parienteId = card.querySelector('.familiar-name')?.dataset.parienteId;
        if (!parienteId) {
            showToast('error', 'No se pudo identificar el familiar.');
            return;
        }

        const result = await Swal.fire({
            title: '¿Eliminar familiar?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
        });

        if (!result.isConfirmed) return;

        try {
            const res = await fetch(`${BASE_URL}api/familiares/delete/${parienteId}`, {
                method: 'DELETE'
            });
            const data = await res.json();

            if (!res.ok) throw data;

            showToast('success', data.message || 'Familiar eliminado correctamente');
            card.remove(); // eliminamos visualmente la card

            // Si ya no hay cards, mostramos el mensaje vacío
            const grid = document.querySelector('.familiares-grid');
            if (grid && grid.children.length === 0) {
                grid.insertAdjacentHTML('afterend', `
                <div class="text-center text-muted py-4">
                    <i class="fa fa-info-circle fa-lg mb-2"></i>
                    <p>No hay familiares registrados.</p>
                </div>
            `);
            }

        } catch (err) {
            console.error(err.message);
            showToast('error', err.message || 'Error al eliminar familiar');
        }
    });
</script>

<style>
    .familiares-header {
        border-bottom: 1px solid #e5e5e5;
        padding-bottom: .5rem;
    }

    .familiares-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .familiar-card {
        position: relative;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 1rem 1.2rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .familiar-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .familiar-card .btn-delete-familiar {
        position: absolute;
        top: 6px;
        right: 6px;
        border: none;
        color: #fff;
        background: #dc3545;
        font-size: 1rem;
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }

    .familiar-card .btn-delete-familiar:hover {
        opacity: 1;
        color: var(--black);
    }

    .familiar-card-body {
        font-size: 0.9rem;
    }

    .familiar-name {
        font-weight: 600;
        color: var(--blue);
        cursor: pointer;
    }

    .familiar-name:hover {
        color: var(--black);
    }

    .familiar-detail {
        color: #555;
        font-size: 0.86rem;
    }

    .familiar-detail i {
        color: var(--blue);
        margin-right: 0.4rem;
    }

    @media (max-width: 768px) {
        .familiares-grid {
            grid-template-columns: 1fr;
        }
    }
</style>