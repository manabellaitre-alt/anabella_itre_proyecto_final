<?php
// Funciones compartidas: sesión, escape, CSRF, permisos, validaciones, imágenes.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** Escapa texto antes de mostrarlo en HTML (evita XSS). */
function escapar(?string $valor): string
{
    return htmlspecialchars((string)$valor, ENT_QUOTES, 'UTF-8');
}

/* ---------- CSRF ---------- */
function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_campo(): string
{
    return '<input type="hidden" name="csrf_token" value="' . escapar(csrf_token()) . '">';
}

function csrf_validar(): bool
{
    return isset($_POST['csrf_token'], $_SESSION['csrf_token'])
        && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

/* ---------- Mensajes flash (sobreviven a una redirección) ---------- */
function poner_flash(string $tipo, string $texto): void
{
    $_SESSION['flash'] = ['tipo' => $tipo, 'texto' => $texto];
}

function obtener_flash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

/* ---------- Control de acceso ---------- */
function requerir_login(): void
{
    if (!isset($_SESSION['usuario_id'])) {
        poner_flash('error', 'Tenés que iniciar sesión para ver esa página.');
        header('Location: login.php');
        exit;
    }
}

function requerir_admin(): void
{
    requerir_login();
    if (($_SESSION['usuario_rol'] ?? '') !== 'admin') {
        http_response_code(403);
        exit('Acceso denegado: esta sección es solo para administradores.');
    }
}

/** Para acciones que solo aceptan POST (archivar, reactivar). */
function requerir_post(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit('Método no permitido.');
    }
}

/* ---------- Validaciones ---------- */
function validar_datos_basicos(string $nombre, string $apellido, string $dni, string $email): array
{
    $e = [];
    if ($nombre === '' || mb_strlen($nombre) > 80) {
        $e[] = 'El nombre es obligatorio (máximo 80 caracteres).';
    }
    if ($apellido === '' || mb_strlen($apellido) > 80) {
        $e[] = 'El apellido es obligatorio (máximo 80 caracteres).';
    }
    if (!preg_match('/^[0-9]{7,8}$/', $dni)) {
        $e[] = 'El DNI debe tener 7 u 8 números.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 254) {
        $e[] = 'Ingresá un correo electrónico válido.';
    }
    return $e;
}

function validar_password(string $password, string $confirmar): array
{
    $e = [];
    if (strlen($password) < 8) {
        $e[] = 'La contraseña debe tener al menos 8 caracteres.';
    }
    if ($password !== $confirmar) {
        $e[] = 'Las contraseñas no coinciden.';
    }
    return $e;
}

/** Devuelve un mensaje si el DNI o el email ya los usa OTRO usuario. */
function buscar_duplicado(PDO $conexion, string $dni, string $email, int $excluirId = 0): ?string
{
    $stmt = $conexion->prepare(
        'SELECT dni, email FROM usuarios
         WHERE (dni = :dni OR email = :email) AND id <> :id LIMIT 1'
    );
    $stmt->execute(['dni' => $dni, 'email' => $email, 'id' => $excluirId]);
    $fila = $stmt->fetch();

    if (!$fila) {
        return null;
    }
    return ($fila['dni'] === $dni)
        ? 'Ya existe un usuario registrado con ese DNI.'
        : 'Ya existe un usuario registrado con ese correo electrónico.';
}

/* ---------- Imágenes y bloques visuales ---------- */

// Poné false cuando termines para ocultar los recuadros de imágenes faltantes
if (!defined('MOSTRAR_ESPACIOS')) {
    define('MOSTRAR_ESPACIOS', true);
}

/**
 * Muestra la imagen img/<archivo> si existe.
 * Si no existe, muestra un espacio indicando qué archivo guardar.
 */
function imagen_espacio(string $archivo, string $alt, string $sugerencia = '', string $clase = ''): string
{
    $archivo = basename($archivo);                    // evita rutas maliciosas
    $ruta    = __DIR__ . '/../img/' . $archivo;
    $clase   = trim('img-slot ' . $clase);

    if (is_file($ruta)) {
        return '<figure class="' . escapar($clase) . '">'
             . '<img src="img/' . escapar($archivo) . '" alt="' . escapar($alt) . '" loading="lazy">'
             . '</figure>';
    }
    if (!MOSTRAR_ESPACIOS) {
        return '';
    }
    return '<figure class="' . escapar($clase) . ' img-vacio"><div class="img-aviso">'
         . '<strong>Espacio para imagen</strong>'
         . '<span>Guardala como <code>img/' . escapar($archivo) . '</code></span>'
         . ($sugerencia !== '' ? '<small>' . escapar($sugerencia) . '</small>' : '')
         . '</div></figure>';
}

/** Bloque de título + texto + imagen que abre cada página. */
function hero_pagina(string $titulo, string $subtitulo, string $imagen, string $alt = ''): string
{
    return '<section class="hero-pagina">'
         . '<div class="hero-pagina-texto"><h1>' . escapar($titulo) . '</h1>'
         . '<p>' . escapar($subtitulo) . '</p></div>'
         . imagen_espacio($imagen, $alt !== '' ? $alt : $titulo, 'Recomendado: 1200 x 675 px (formato 16:9)')
         . '</section>';
}

/** Aviso de salud que se repite en las páginas informativas. */
function aviso_salud(): string
{
    return '<div class="aviso"><strong>Importante:</strong> el contenido de FitZone es informativo y educativo. '
         . 'No reemplaza la consulta con un médico, nutricionista o profesor de educación física, '
         . 'sobre todo si tenés una condición de salud, lesiones o tomás medicación.</div>';
}