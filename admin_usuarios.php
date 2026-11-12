<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';
requerir_admin();

$buscar = trim($_GET['buscar'] ?? '');
$sql = 'SELECT id, nombre, apellido, dni, email, rol, creado_en
        FROM usuarios
        WHERE archivado_en IS NULL';
$parametros = [];

if ($buscar !== '') {
    $sql .= ' AND (nombre LIKE :nombre OR apellido LIKE :apellido
               OR dni LIKE :dni OR email LIKE :email)';
    $termino = '%' . $buscar . '%';
    $parametros = [
        'nombre'   => $termino,
        'apellido' => $termino,
        'dni'      => $termino,
        'email'    => $termino,
    ];
}
$sql .= ' ORDER BY id DESC';

try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute($parametros);
    $usuarios = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('No se pudo consultar el listado de usuarios.');
}

$titulo = 'Administración de usuarios';
require __DIR__ . '/includes/header.php';
?>
<h1>Administración de usuarios</h1>

<div class="barra-acciones">
    <form method="GET" action="admin_usuarios.php" class="buscador">
        <input type="search" name="buscar" maxlength="100"
               placeholder="Nombre, apellido, DNI o correo"
               value="<?= escapar($buscar) ?>">
        <button type="submit" class="btn">Buscar</button>
        <?php if ($buscar !== ''): ?><a href="admin_usuarios.php" class="btn btn-sec">Limpiar</a><?php endif; ?>
    </form>
    <div>
        <a href="admin_crear_usuario.php" class="btn">+ Nuevo usuario</a>
        <a href="usuarios_archivados.php" class="btn btn-sec">Ver archivados</a>
    </div>
</div>

<p><strong>Total:</strong> <?= count($usuarios) ?> usuario(s) activo(s)</p>

<?php if (empty($usuarios)): ?>
    <p class="vacio">No se encontraron usuarios.</p>
<?php else: ?>
<div class="tabla-scroll">
<table class="tabla">
    <thead>
        <tr><th>ID</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr>
    </thead>
    <tbody>
    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= escapar((string)$u['id']) ?></td>
            <td><?= escapar($u['nombre']) ?></td>
            <td><?= escapar($u['apellido']) ?></td>
            <td><?= escapar($u['dni']) ?></td>
            <td><?= escapar($u['email']) ?></td>
            <td><span class="rol rol-<?= escapar($u['rol']) ?>"><?= escapar($u['rol']) ?></span></td>
            <td><span class="estado-activo">● Activo</span></td>
            <td class="acciones">
                <a class="btn btn-sm" href="editar_usuario.php?id=<?= (int)$u['id'] ?>">Editar</a>
                <?php if ((int)$u['id'] !== (int)$_SESSION['usuario_id']): ?>
                <form action="archivar_usuario.php" method="POST"
                      onsubmit="return confirm('Se archivará esta cuenta. ¿Continuar?');">
                    <?= csrf_campo() ?>
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-peligro">Archivar</button>
                </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>