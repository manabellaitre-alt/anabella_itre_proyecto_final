<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';
requerir_admin();

try {
    $stmt = $conexion->query(
        'SELECT id, nombre, apellido, dni, email, archivado_en
         FROM usuarios WHERE archivado_en IS NOT NULL
         ORDER BY archivado_en DESC'
    );
    $usuarios = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('No se pudo consultar los usuarios archivados.');
}

$titulo = 'Usuarios archivados';
require __DIR__ . '/includes/header.php';
?>
<h1>Usuarios archivados</h1>
<p><a href="admin_usuarios.php" class="btn btn-sec">← Volver al listado activo</a></p>

<?php if (empty($usuarios)): ?>
    <p class="vacio">No hay usuarios archivados.</p>
<?php else: ?>
<div class="tabla-scroll">
<table class="tabla">
    <thead>
        <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Correo</th><th>Archivado el</th><th>Acción</th></tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= escapar((string)$u['id']) ?></td>
            <td><?= escapar($u['nombre']) ?></td>
            <td><?= escapar($u['apellido']) ?></td>
            <td><?= escapar($u['dni']) ?></td>
            <td><?= escapar($u['email']) ?></td>
            <td><?= escapar($u['archivado_en']) ?></td>
            <td>
                <form action="reactivar_usuario.php" method="POST"
                      onsubmit="return confirm('¿Reactivar esta cuenta?');">
                    <?= csrf_campo() ?>
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <button type="submit" class="btn btn-sm">Reactivar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>