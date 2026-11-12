<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';
requerir_admin();
requerir_post();

if (!csrf_validar()) {
    http_response_code(403);
    exit('Solicitud no autorizada (token inválido).');
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit('Identificador inválido.');
}

if ($id === (int)$_SESSION['usuario_id']) {
    poner_flash('error', 'No podés archivar tu propia cuenta.');
    header('Location: admin_usuarios.php');
    exit;
}

try {
    $stmt = $conexion->prepare(
        'UPDATE usuarios SET archivado_en = NOW()
         WHERE id = :id AND archivado_en IS NULL'
    );
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() > 0) {
        poner_flash('ok', 'Usuario archivado correctamente.');
    } else {
        poner_flash('error', 'El usuario no existe o ya estaba archivado.');
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    poner_flash('error', 'No se pudo archivar el usuario.');
}
header('Location: admin_usuarios.php');
exit;