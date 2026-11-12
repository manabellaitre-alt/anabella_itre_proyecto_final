<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';
requerir_admin();

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Identificador inválido.');
}

$stmt = $conexion->prepare(
    'SELECT id, nombre, apellido, dni, email
     FROM usuarios WHERE id = :id AND archivado_en IS NULL LIMIT 1'
);
$stmt->execute(['id' => $id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    http_response_code(404);
    exit('Usuario no encontrado o archivado.');
}

$errores  = [];
$nombre   = $usuario['nombre'];
$apellido = $usuario['apellido'];
$dni      = $usuario['dni'];
$email    = $usuario['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página.';
    } else {
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $dni      = trim($_POST['dni'] ?? '');
        $email    = trim($_POST['email'] ?? '');

        $errores = validar_datos_basicos($nombre, $apellido, $dni, $email);

        try {
            if (empty($errores) && ($dup = buscar_duplicado($conexion, $dni, $email, $id))) {
                $errores[] = $dup;
            }
            if (empty($errores)) {
                // El rol NO se toma del formulario: no se puede escalar privilegios
                $upd = $conexion->prepare(
                    'UPDATE usuarios
                     SET nombre = :nombre, apellido = :apellido, dni = :dni, email = :email
                     WHERE id = :id AND archivado_en IS NULL'
                );
                $upd->execute([
                    'nombre' => $nombre, 'apellido' => $apellido,
                    'dni' => $dni, 'email' => $email, 'id' => $id,
                ]);
                poner_flash('ok', 'Datos actualizados correctamente.');
                header('Location: admin_usuarios.php');
                exit;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errores[] = 'Ocurrió un error al actualizar los datos.';
        }
    }
}

$titulo = 'Editar usuario';
require __DIR__ . '/includes/header.php';
?>
<section class="tarjeta formulario">
    <h1>Editar usuario #<?= (int)$id ?></h1>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?><li><?= escapar($error) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="editar_usuario.php?id=<?= (int)$id ?>" method="POST" novalidate>
        <?= csrf_campo() ?>
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" maxlength="80" required value="<?= escapar($nombre) ?>">

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" maxlength="80" required value="<?= escapar($apellido) ?>">

        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni" inputmode="numeric" pattern="[0-9]{7,8}" maxlength="8" required value="<?= escapar($dni) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" maxlength="254" required value="<?= escapar($email) ?>">

        <button type="submit" class="btn">Guardar cambios</button>
        <a href="admin_usuarios.php" class="btn btn-sec">Cancelar</a>
    </form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>