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
            <div class="familiar-card" data-pariente-id="<?= $f['pariente_id'] ?>">
                <div class="familiar-card-body">
                    <h6 class="familiar-name mb-1">
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

    .familiar-card-body {
        font-size: 0.9rem;
    }

    .familiar-name {
        font-weight: 600;
        color: var(--blue);
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