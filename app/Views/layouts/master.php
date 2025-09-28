<?= $this->include('layouts/partials/header') ?>
<div class="wrapper">
    <!-- Main Content/* -->
    <div class="main-content">
        <?= $this->renderSection('content') ?>
    </div>
     <!-- */Main Content -->

    <?= $this->include('layouts/components/sidebar') ?>
</div>

<?= $this->include('layouts/partials/footer') ?>