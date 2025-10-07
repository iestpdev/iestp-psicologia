<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="form-title"><?= $title ?? '' ?></h2>
    
    <?php if (!empty($backUrl)): ?>
        <a href="<?= $backUrl ?>" class="btn btn-secondary">
            <?= 'Regresar' ?>
        </a>
    <?php endif; ?>
</div>
