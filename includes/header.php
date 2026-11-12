<?php
require_once __DIR__ . '/funciones.php';
$titulo  = $titulo ?? 'FitZone';
$esAdmin = (($_SESSION['usuario_rol'] ?? '') === 'admin');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= escapar($titulo) ?> | FitZone</title>
   <link rel="stylesheet" href="css/estilos.css?v=<?= @filemtime(__DIR__ . '/../css/estilos.css') ?: 1 ?>">
</head>
<body>
<header class="topbar">
    <a class="logo" href="index.php">FIT<span>ZONE</span></a>
    <nav>
        <?php if (isset($_SESSION['usuario_id'])): ?>
            <a href="panel.php">Mi panel</a>

            <div class="menu-grupo">
                <button type="button" class="menu-boton">Entrenamiento ▾</button>
                <div class="submenu">
                    <a href="rutinas.php">Rutinas por nivel</a>
                    <a href="entrenamiento_casa.php">Entrenamiento en casa</a>
                    <a href="ejercicios.php">Biblioteca de ejercicios</a>
                    <a href="cardio.php">Cardio y frecuencia cardíaca</a>
                    <a href="calculadora_1rm.php">Calculadora de 1RM</a>
                </div>
            </div>

            <div class="menu-grupo">
                <button type="button" class="menu-boton">Nutrición ▾</button>
                <div class="submenu">
                    <a href="nutricion.php">Guía de nutrición</a>
                    <a href="alimentos.php">Tabla de alimentos</a>
                    <a href="calculadora_calorias.php">Calculadora de calorías</a>
                    <a href="calculadora_imc.php">Calculadora de IMC</a>
                    <a href="suplementos.php">Suplementos</a>
                </div>
            </div>

            <div class="menu-grupo">
                <button type="button" class="menu-boton">Bienestar ▾</button>
                <div class="submenu">
                    <a href="descanso.php">Descanso y recuperación</a>
                    <a href="lesiones.php">Prevención de lesiones</a>
                    <a href="mitos.php">Mitos y verdades</a>
                </div>
            </div>

            <div class="menu-grupo">
                <button type="button" class="menu-boton">Más ▾</button>
                <div class="submenu">
                    <a href="objetivos.php">Elegí tu objetivo</a>
                    <a href="estadisticas.php">Estadísticas y análisis</a>
                    <a href="glosario.php">Glosario</a>
                    <a href="acerca.php">Acerca del proyecto</a>
                </div>
            </div>

            <?php if ($esAdmin): ?>
                <a href="admin_usuarios.php">Administración</a>
            <?php endif; ?>
            <a class="btn-salir" href="cerrar_sesion.php">Cerrar sesión</a>
        <?php else: ?>
            <a href="acerca.php">Acerca del proyecto</a>
            <a href="login.php">Iniciar sesión</a>
            <a href="registro.php">Registrarme</a>
        <?php endif; ?>
    </nav>
</header>
<main class="contenedor">
<?php if ($flash = obtener_flash()): ?>
    <div class="alerta alerta-<?= escapar($flash['tipo']) ?>">
        <?= escapar($flash['texto']) ?>
    </div>
<?php endif; ?>