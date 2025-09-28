<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Usuarios</h1>

<table id="tablaUsuarios" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>Correo Institucional</th>
            <th>Username</th>
            <th>Rol</th>
            <th>Fecha de creación</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<?= $this->endSection() ?>
