<?= $this->include('layouts/partials/header') ?>

<div class="contenedor">
    <!-- Sidebar -->
    <?= $this->include('layouts/partials/sidebar') ?>

    <!-- Área principal -->
    <main id="main" class="main">
        <?= $this->include('layouts/partials/topbar') ?>
        <?= $this->renderSection('content') ?>
    </main>
</div>

<?= $this->include('layouts/partials/footer') ?>