<?php
require_once __DIR__ . '/includes/funciones.php';

// La primera pantalla es el login. Si ya hay sesión, va al panel.
header('Location: ' . (isset($_SESSION['usuario_id']) ? 'panel.php' : 'login.php'));
exit;