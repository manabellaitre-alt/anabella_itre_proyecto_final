<?php
require_once __DIR__ . '/conexion.php';
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// Nunca se selecciona password_hash
$stmt = $conexion->prepare(
    'SELECT nombre, apellido, dni, email, rol, creado_en
     FROM usuarios WHERE id = :id AND archivado_en IS NULL LIMIT 1'
);
$stmt->execute(['id' => (int)$_SESSION['usuario_id']]);
$u = $stmt->fetch();

if (!$u) { // cuenta archivada o inexistente: se cierra la sesión
    session_destroy();
    header('Location: login.php');
    exit;
}

// Consejo del día: cambia cada día del año
$consejos = [
    'La constancia le gana a la intensidad: es mejor entrenar 3 veces por semana todo el año que 6 veces durante un mes.',
    'Dormir bien mejora el rendimiento, el estado de ánimo y la recuperación muscular.',
    'Aumentá la carga o las repeticiones de forma gradual: esa es la base del progreso.',
    'Tomar agua durante el día mejora la concentración y el rendimiento físico.',
    'Un buen calentamiento de 5 a 10 minutos reduce el riesgo de molestias y lesiones.',
    'Sumá proteína en cada comida principal para repartir mejor el aporte durante el día.',
    'Caminar a diario suma movimiento sin agregar fatiga a tu entrenamiento de fuerza.',
    'La técnica va antes que el peso: si no podés controlar el movimiento, bajá la carga.',
    'Un día de descanso también es parte del plan de entrenamiento.',
    'No compares tu primer mes con el año de otra persona: compará tu hoy con tu ayer.',
];
$consejo = $consejos[(int)date('z') % count($consejos)];

// Secciones agrupadas por tema: [url, nombre, descripción, imagen]
$grupos = [
    'Entrenamiento' => [
        ['rutinas.php',             'Rutinas por nivel',       'Programas para principiantes, intermedios y avanzados.', 'panel_rutinas.jpg'],
        ['entrenamiento_casa.php',  'Entrenamiento en casa',   'Plan sin equipamiento con progresiones.',                'panel_casa.jpg'],
        ['ejercicios.php',          'Biblioteca de ejercicios','Técnica y errores comunes por grupo muscular.',          'panel_ejercicios.jpg'],
        ['cardio.php',              'Cardio',                  'Zonas de frecuencia cardíaca y tipos de cardio.',        'panel_cardio.jpg'],
    ],
    'Nutrición' => [
        ['nutricion.php',            'Guía de nutrición',      'Macronutrientes, hidratación y comidas.',                'panel_nutricion.jpg'],
        ['alimentos.php',            'Tabla de alimentos',     'Calorías y macros de alimentos comunes.',                'panel_alimentos.jpg'],
        ['calculadora_calorias.php', 'Calculadora de calorías','Tus calorías y macros según tu objetivo.',               'panel_calorias.jpg'],
        ['suplementos.php',          'Suplementos',            'Qué tiene evidencia y qué es marketing.',                'panel_suplementos.jpg'],
    ],
    'Bienestar y más' => [
        ['descanso.php',             'Descanso',               'Sueño, recuperación y sobreentrenamiento.',              'panel_descanso.jpg'],
        ['lesiones.php',             'Prevención de lesiones', 'Calentamiento, señales de alerta y vuelta gradual.',     'panel_lesiones.jpg'],
        ['objetivos.php',            'Elegí tu objetivo',      'Bajar grasa, ganar músculo o mantener.',                 'panel_objetivos.jpg'],
        ['estadisticas.php',         'Estadísticas',           'Recomendaciones de la OMS y gasto calórico.',            'panel_estadisticas.jpg'],
    ],
];

$totalPaginas = 0;
foreach ($grupos as $g) { $totalPaginas += count($g); }

$titulo = 'Mi panel';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Hola, ' . $u['nombre'],
    'Este es tu espacio en FitZone: entrená con información clara, calculá tus necesidades y consultá guías organizadas por tema.',
    'panel_banner.jpg'
);
?>
<section class="grilla-3">
    <div class="tarjeta">
        <div class="dato-grande"><?= (int)$totalPaginas ?>+</div>
        <div class="dato-etiqueta">guías y herramientas disponibles</div>
    </div>
    <div class="tarjeta">
        <div class="dato-grande"><?= escapar(date('d/m/Y', strtotime($u['creado_en']))) ?></div>
        <div class="dato-etiqueta">miembro desde</div>
    </div>
    <div class="tarjeta">
        <div class="dato-grande"><?= escapar(ucfirst($u['rol'])) ?></div>
        <div class="dato-etiqueta">tu tipo de cuenta</div>
    </div>
</section>

<div class="destacado">
    <strong>💡 Consejo del día:</strong> <?= escapar($consejo) ?>
</div>

<?php foreach ($grupos as $nombreGrupo => $items): ?>
    <h2 class="titulo-seccion"><?= escapar($nombreGrupo) ?></h2>
    <section class="grilla-4">
        <?php foreach ($items as [$url, $nombre, $desc, $img]): ?>
            <a class="tarjeta enlace-tarjeta" href="<?= escapar($url) ?>">
                <?= imagen_espacio($img, $nombre, 'Recomendado: 800 x 600 px', 'img-cuadrada') ?>
                <h3 style="margin-top:14px"><?= escapar($nombre) ?></h3>
                <p><?= escapar($desc) ?></p>
            </a>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>

<h2 class="titulo-seccion">Mis datos personales</h2>
<section class="tarjeta">
    <dl class="datos">
        <dt>Nombre</dt><dd><?= escapar($u['nombre']) ?></dd>
        <dt>Apellido</dt><dd><?= escapar($u['apellido']) ?></dd>
        <dt>DNI</dt><dd><?= escapar($u['dni']) ?></dd>
        <dt>Correo</dt><dd><?= escapar($u['email']) ?></dd>
        <dt>Rol</dt><dd><?= escapar($u['rol']) ?></dd>
        <dt>Miembro desde</dt><dd><?= escapar($u['creado_en']) ?></dd>
    </dl>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>