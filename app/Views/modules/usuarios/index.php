<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<h1 class="mb-4">Usuarios</h1>

<table>
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
        <?php if (!empty($usuarios) && is_array($usuarios)): ?>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= esc($usuario['id']) ?></td>
                    <td><?= esc($usuario['correo_institucional']) ?></td>
                    <td><?= esc($usuario['username']) ?></td>
                    <td><?= esc($usuario['rol']) ?></td>
                    <td><?= esc($usuario['created_at']) ?></td>
                    <td><?= esc($usuario['estado']) ?></td>
                    <td>
                        <button>Editar</button>
                        <button>Eliminar</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No hay usuarios disponibles.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<?= $this->endSection() ?>