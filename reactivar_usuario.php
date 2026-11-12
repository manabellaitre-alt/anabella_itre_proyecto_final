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

try {
    $stmt = $conexion->prepare(
        'UPDATE usuarios SET archivado_en = NULL
         WHERE id = :id AND archivado_en IS NOT NULL'
    );
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() > 0) {
        poner_flash('ok', 'Usuario reactivado correctamente.');
    } else {
        poner_flash('error', 'El usuario no existe o ya estaba activo.');
    }
} catch (PDOException $e) {
    error_log($e->getMessage());
    poner_flash('error', 'No se pudo reactivar el usuario.');
}
header('Location: usuarios_archivados.php');
exit;