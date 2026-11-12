<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$pilares = [
    ['Sueño', 'Dormir entre 7 y 9 horas favorece la recuperación muscular, la regulación hormonal y la concentración.'],
    ['Días de descanso', 'Descansar al menos 1 o 2 días por semana permite que el cuerpo se adapte al entrenamiento.'],
    ['Descarga (deload)', 'Cada 4 a 8 semanas, reducir el volumen o la carga durante una semana ayuda a recuperarte de la fatiga acumulada.'],
    ['Manejo del estrés', 'El estrés crónico empeora el sueño y la recuperación. Caminar, respirar profundo o desconectarse ayuda.'],
    ['Movilidad', 'Dedicar 10 minutos diarios a movilidad y estiramientos mejora el rango de movimiento y la sensación corporal.'],
    ['Alimentación e hidratación', 'Comer suficiente proteína y energía y mantenerte hidratado acelera la recuperación.'],
];

$senales = [
    ['Cansancio que no se va con el descanso', 'Fatiga persistente durante varios días.'],
    ['Rendimiento que baja', 'Levantás menos peso o rendís menos que hace unas semanas.'],
    ['Problemas de sueño', 'Dificultad para dormirte o despertares frecuentes.'],
    ['Cambios de ánimo', 'Irritabilidad, falta de motivación o ansiedad.'],
    ['Molestias que no ceden', 'Dolores musculares o articulares que persisten más de una semana.'],
    ['Frecuencia cardíaca en reposo alta', 'Pulsaciones más altas de lo habitual al despertar.'],
];

$habitosSueno = [
    'Acostate y levantate a horarios parecidos todos los días.',
    'Evitá pantallas brillantes la hora previa a dormir.',
    'Mantené el cuarto oscuro, fresco y silencioso.',
    'Limitá la cafeína en las 6 horas previas a acostarte.',
    'No cenes muy pesado justo antes de dormir.',
];

$titulo = 'Descanso y recuperación';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Descanso y recuperación',
    'El músculo no crece mientras entrenás: crece mientras descansás. Estos son los pilares de una buena recuperación.',
    'descanso_banner.jpg'
);
?>
<section class="tarjeta">
    <h2>Los 6 pilares de la recuperación</h2>
    <div class="grilla-3">
        <?php foreach ($pilares as [$nombre, $texto]): ?>
            <div>
                <h3><?= escapar($nombre) ?></h3>
                <p><?= escapar($texto) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>Higiene del sueño</h2>
        <ul>
            <?php foreach ($habitosSueno as $h): ?><li><?= escapar($h) ?></li><?php endforeach; ?>
        </ul>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('descanso_sueno.jpg', 'Descanso y sueño', 'Idea: persona descansando o estirando') ?>
    </div>
</section>

<section class="tarjeta" style="margin-top:22px">
    <h2>Señales de sobreentrenamiento</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Señal</th><th>Cómo se manifiesta</th></tr></thead>
        <tbody>
        <?php foreach ($senales as [$senal, $desc]): ?>
            <tr><td><strong><?= escapar($senal) ?></strong></td><td><?= escapar($desc) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <p class="sub" style="margin-top:12px">Si varias señales aparecen juntas, bajá el volumen una semana y priorizá el sueño. Si persisten, consultá a un profesional.</p>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>