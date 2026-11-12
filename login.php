<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: panel.php');
    exit;
}

$errores = [];
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página e intentá de nuevo.';
    } else {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            $errores[] = 'Completá el correo y la contraseña.';
        } else {
            try {
                // Solo las cuentas activas pueden entrar
                $stmt = $conexion->prepare(
                    'SELECT id, nombre, apellido, email, password_hash, rol
                     FROM usuarios
                     WHERE email = :email AND archivado_en IS NULL
                     LIMIT 1'
                );
                $stmt->execute(['email' => $email]);
                $usuario = $stmt->fetch();

                if ($usuario && password_verify($password, $usuario['password_hash'])) {
                    session_regenerate_id(true);   // evita fijación de sesión
                    $_SESSION['usuario_id']     = (int)$usuario['id'];
                    $_SESSION['usuario_nombre'] = $usuario['nombre'];
                    $_SESSION['usuario_rol']    = $usuario['rol'];

                    header('Location: ' . ($usuario['rol'] === 'admin' ? 'admin_usuarios.php' : 'panel.php'));
                    exit;
                }
                // Mensaje genérico: no revela si falló el correo o la contraseña
                $errores[] = 'Correo o contraseña incorrectos.';
            } catch (PDOException $e) {
                error_log($e->getMessage());
                $errores[] = 'Ocurrió un error. Intentá nuevamente.';
            }
        }
    }
}

$titulo = 'Iniciar sesión';
require __DIR__ . '/includes/header.php';
?>
<section class="hero-login">
    <div class="hero-texto">
        <h1>Entrená. <span>Comé bien.</span> Seguí tu progreso.</h1>
        <p>FitZone reúne rutinas, guías de nutrición y herramientas para que empieces hoy.
           Iniciá sesión para acceder a todo el contenido.</p>
        <?= imagen_espacio('login_hero.jpg', 'FitZone', 'Recomendado: 1200 x 675 px') ?>
    </div>

    <div class="tarjeta formulario">
        <h2>Iniciar sesión</h2>

        <?php if (!empty($errores)): ?>
            <ul class="errores">
                <?php foreach ($errores as $error): ?>
                    <li><?= escapar($error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <?= csrf_campo() ?>
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" maxlength="254" required value="<?= escapar($email) ?>">

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Entrar</button>
        </form>
        <p class="enlace-pie">¿No tenés cuenta? <a href="registro.php">Registrate</a></p>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>