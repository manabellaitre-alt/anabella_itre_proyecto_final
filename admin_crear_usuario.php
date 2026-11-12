<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';
requerir_admin();

$errores = [];
$nombre = $apellido = $dni = $email = '';
$rol = 'usuario';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página.';
    } else {
        $nombre    = trim($_POST['nombre'] ?? '');
        $apellido  = trim($_POST['apellido'] ?? '');
        $dni       = trim($_POST['dni'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $rol       = $_POST['rol'] ?? 'usuario';
        $password  = $_POST['password'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';

        $errores = array_merge(
            validar_datos_basicos($nombre, $apellido, $dni, $email),
            validar_password($password, $confirmar)
        );
        if (!in_array($rol, ['usuario', 'admin'], true)) {
            $errores[] = 'Rol inválido.';
        }

        try {
            if (empty($errores) && ($dup = buscar_duplicado($conexion, $dni, $email))) {
                $errores[] = $dup;
            }
            if (empty($errores)) {
                $stmt = $conexion->prepare(
                    'INSERT INTO usuarios (nombre, apellido, dni, email, password_hash, rol)
                     VALUES (:nombre, :apellido, :dni, :email, :hash, :rol)'
                );
                $stmt->execute([
                    'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni,
                    'email' => $email, 'hash' => password_hash($password, PASSWORD_DEFAULT),
                    'rol' => $rol,
                ]);
                poner_flash('ok', 'Usuario registrado correctamente.');
                header('Location: admin_usuarios.php');
                exit;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errores[] = 'Ocurrió un error al guardar los datos.';
        }
    }
}

$titulo = 'Nuevo usuario';
require __DIR__ . '/includes/header.php';
?>
<section class="tarjeta formulario">
    <h1>Registrar nuevo usuario</h1>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?><li><?= escapar($error) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="admin_crear_usuario.php" method="POST" novalidate>
        <?= csrf_campo() ?>
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" maxlength="80" required value="<?= escapar($nombre) ?>">

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" maxlength="80" required value="<?= escapar($apellido) ?>">

        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni" inputmode="numeric" pattern="[0-9]{7,8}" maxlength="8" required value="<?= escapar($dni) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" maxlength="254" required value="<?= escapar($email) ?>">

        <label for="rol">Rol</label>
        <select id="rol" name="rol">
            <option value="usuario" <?= $rol === 'usuario' ? 'selected' : '' ?>>Usuario</option>
            <option value="admin" <?= $rol === 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select>

        <label for="password">Contraseña (mínimo 8 caracteres)</label>
        <input type="password" id="password" name="password" required>

        <label for="confirmar">Repetir contraseña</label>
        <input type="password" id="confirmar" name="confirmar" required>

        <button type="submit" class="btn">Guardar usuario</button>
        <a href="admin_usuarios.php" class="btn btn-sec">Cancelar</a>
    </form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>