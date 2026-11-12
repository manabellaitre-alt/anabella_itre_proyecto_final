<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';

// Se bloquea solo si ya existe un administrador
$hay = (int)$conexion->query("SELECT COUNT(*) FROM usuarios WHERE rol = 'admin'")->fetchColumn();
if ($hay > 0) {
    http_response_code(403);
    exit('Ya existe un administrador. Eliminá este archivo del proyecto.');
}

$errores = [];
$nombre = $apellido = $dni = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida.';
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

        if (empty($errores) && ($dup = buscar_duplicado($conexion, $dni, $email))) {
            $errores[] = $dup;
        }

        if (empty($errores)) {
            try {
                $stmt = $conexion->prepare(
                    'INSERT INTO usuarios (nombre, apellido, dni, email, password_hash, rol)
                     VALUES (:nombre, :apellido, :dni, :email, :hash, :rol)'
                );
                $stmt->execute([
                    'nombre' => $nombre, 'apellido' => $apellido, 'dni' => $dni, 'email' => $email,
                    'hash' => password_hash($password, PASSWORD_DEFAULT), 'rol' => 'admin',
                ]);
                poner_flash('ok', 'Administrador creado. Ahora borrá crear_admin.php.');
                header('Location: login.php');
                exit;
            } catch (PDOException $e) {
                error_log($e->getMessage());
                $errores[] = 'No se pudo crear el administrador.';
            }
        }
    }
}

$titulo = 'Crear administrador';
require __DIR__ . '/includes/header.php';
?>
<section class="tarjeta formulario">
    <h1>Crear primer administrador</h1>
    <p class="sub">Herramienta temporal de instalación.</p>

    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?><li><?= escapar($error) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST" action="crear_admin.php" novalidate>
        <?= csrf_campo() ?>
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" name="nombre" maxlength="80" required value="<?= escapar($nombre) ?>">

        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" name="apellido" maxlength="80" required value="<?= escapar($apellido) ?>">

        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni" inputmode="numeric" maxlength="8" required value="<?= escapar($dni) ?>">

        <label for="email">Correo</label>
        <input type="email" id="email" name="email" maxlength="254" required value="<?= escapar($email) ?>">

        <label for="password">Contraseña (mínimo 8 caracteres)</label>
        <input type="password" id="password" name="password" required>

        <label for="confirmar">Repetir contraseña</label>
        <input type="password" id="confirmar" name="confirmar" required>

        <button type="submit" class="btn">Crear administrador</button>
    </form>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>