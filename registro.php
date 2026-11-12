<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: panel.php');
    exit;
}

$errores = [];
$nombre = $apellido = $dni = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página e intentá de nuevo.';
    } else {
        $nombre    = trim($_POST['nombre'] ?? '');
        $apellido  = trim($_POST['apellido'] ?? '');
        $dni       = trim($_POST['dni'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $confirmar = $_POST['confirmar'] ?? '';

        $errores = array_merge(
            validar_datos_basicos($nombre, $apellido, $dni, $email),
            validar_password($password, $confirmar)
        );

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
                    'nombre'   => $nombre,
                    'apellido' => $apellido,
                    'dni'      => $dni,
                    'email'    => $email,
                    'hash'     => password_hash($password, PASSWORD_DEFAULT),
                    'rol'      => 'usuario',   // el registro público NUNCA crea admins
                ]);
                poner_flash('ok', '¡Cuenta creada! Ya podés iniciar sesión.');
                header('Location: login.php');
                exit;
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errores[] = ($e->getCode() === '23000')
                ? 'El DNI o el correo ya están registrados.'
                : 'Ocurrió un error al guardar los datos.';
        }
    }
}

$titulo = 'Crear cuenta';
require __DIR__ . '/includes/header.php';
?>
<section class="tarjeta formulario">
    <h1>Creá tu cuenta</h1>
    <p class="sub">Sumate a FitZone y accedé a rutinas, nutrición y herramientas.</p>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?>
                <li><?= escapar($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="registro.php" method="POST" novalidate>
        <?= csrf_campo() ?>

        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" maxlength="80" required value="<?= escapar($nombre) ?>">

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" maxlength="80" required value="<?= escapar($apellido) ?>">

        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni" inputmode="numeric" pattern="[0-9]{7,8}" maxlength="8" required value="<?= escapar($dni) ?>">

        <label for="email">Correo electrónico</label>
        <input type="email" id="email" name="email" maxlength="254" required value="<?= escapar($email) ?>">

        <label for="password">Contraseña (mínimo 8 caracteres)</label>
        <input type="password" id="password" name="password" required>

        <label for="confirmar">Repetir contraseña</label>
        <input type="password" id="confirmar" name="confirmar" required>

        <button type="submit" class="btn">Crear cuenta</button>
    </form>
    <p class="enlace-pie">¿Ya tenés cuenta? <a href="login.php">Iniciá sesión</a></p>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>