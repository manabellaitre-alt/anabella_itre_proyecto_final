<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$objetivos = [
    [
        'titulo' => 'Bajar grasa', 'img' => 'obj_bajar.jpg',
        'resumen' => 'Perder grasa corporal conservando la mayor cantidad posible de músculo.',
        'cal' => 'Déficit moderado, cerca del 10% al 20% por debajo de tu gasto diario.',
        'prot' => 'Alta, entre 1,8 y 2,2 g por kg de peso, para cuidar la masa muscular.',
        'ent' => 'Fuerza 3 a 4 días por semana + caminatas diarias. El entrenamiento de fuerza le indica al cuerpo que conserve el músculo.',
        'ritmo' => 'Un ritmo sostenible ronda el 0,5% al 1% del peso corporal por semana.',
        'error' => 'Déficits muy agresivos: aumentan el hambre, la fatiga y la pérdida de músculo.',
    ],
    [
        'titulo' => 'Ganar músculo', 'img' => 'obj_ganar.jpg',
        'resumen' => 'Aumentar la masa muscular de forma gradual con la menor ganancia de grasa posible.',
        'cal' => 'Superávit pequeño, cerca del 5% al 10% por encima de tu gasto diario.',
        'prot' => 'Entre 1,6 y 2,2 g por kg de peso repartidos en varias comidas.',
        'ent' => 'Fuerza 3 a 5 días por semana, con progresión de cargas y series cerca del fallo técnico.',
        'ritmo' => 'Es un proceso lento: los principiantes progresan más rápido y el ritmo baja con los años de entrenamiento.',
        'error' => 'Comer muy por encima de lo necesario: el exceso se acumula como grasa, no como músculo.',
    ],
    [
        'titulo' => 'Mantener y mejorar salud', 'img' => 'obj_mantener.jpg',
        'resumen' => 'Sostener tu peso y sentirte con energía, fuerza y movilidad.',
        'cal' => 'Calorías de mantenimiento: igual a tu gasto diario estimado.',
        'prot' => 'Entre 1,2 y 1,6 g por kg de peso.',
        'ent' => 'Fuerza 2 o 3 días por semana + 150 minutos semanales de actividad aeróbica moderada.',
        'ritmo' => 'El objetivo es la constancia, no el cambio en la balanza.',
        'error' => 'Esperar hasta tener tiempo "libre": mejor 20 minutos hoy que una hora que nunca llega.',
    ],
];

$pasos = [
    'Definí tu objetivo principal. Si querés dos cosas a la vez, priorizá una por etapa.',
    'Calculá tus calorías y macros en la calculadora de calorías.',
    'Elegí una rutina acorde a tu nivel, en la sección de rutinas o en entrenamiento en casa.',
    'Mantené el plan entre 3 y 4 semanas y observá cómo respondés.',
    'Ajustá pequeñas cosas (calorías, volumen, descanso) según tus resultados.',
];

$preguntas = [
    ['¿Cuánto tarda en notarse un cambio?', 'Las mejoras de fuerza y energía suelen sentirse en las primeras semanas. Los cambios visibles en el cuerpo requieren varios meses de constancia.'],
    ['¿Puedo bajar grasa y ganar músculo a la vez?', 'Es posible, sobre todo en principiantes, personas que retoman el entrenamiento o con mayor porcentaje de grasa. Se llama recomposición corporal y es un proceso más lento.'],
    ['¿Tengo que contar calorías para siempre?', 'No. Contar es una herramienta para aprender cuánto comés. Con el tiempo muchas personas logran estimar porciones sin pesar todo.'],
    ['¿Qué hago si me estanco?', 'Revisá primero lo básico: constancia, sueño y proteína. Después ajustá un poco las calorías o aumentá gradualmente la carga o el volumen.'],
    ['¿Necesito suplementos para lograr mi objetivo?', 'No. La base es entrenar, comer bien y descansar. Los suplementos son un complemento opcional.'],
];

$titulo = 'Elegí tu objetivo';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Elegí tu objetivo',
    'Cada meta pide una estrategia distinta de calorías, proteína y entrenamiento. Compará y elegí la tuya.',
    'objetivos_banner.jpg'
);
?>
<section class="grilla-3">
    <?php foreach ($objetivos as $i => $o): ?>
        <div class="tarjeta col-comparar <?= $i === 1 ? 'c2' : ($i === 2 ? 'c3' : '') ?>">
            <?= imagen_espacio($o['img'], $o['titulo'], 'Recomendado: 1000 x 560 px') ?>
            <h3 style="margin-top:14px"><?= escapar($o['titulo']) ?></h3>
            <p><?= escapar($o['resumen']) ?></p>
        </div>
    <?php endforeach; ?>
</section>

<section class="tarjeta">
    <h2>Comparativa de estrategias</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Aspecto</th><?php foreach ($objetivos as $o): ?><th><?= escapar($o['titulo']) ?></th><?php endforeach; ?></tr></thead>
        <tbody>
            <tr><td><strong>Calorías</strong></td><?php foreach ($objetivos as $o): ?><td><?= escapar($o['cal']) ?></td><?php endforeach; ?></tr>
            <tr><td><strong>Proteína</strong></td><?php foreach ($objetivos as $o): ?><td><?= escapar($o['prot']) ?></td><?php endforeach; ?></tr>
            <tr><td><strong>Entrenamiento</strong></td><?php foreach ($objetivos as $o): ?><td><?= escapar($o['ent']) ?></td><?php endforeach; ?></tr>
            <tr><td><strong>Ritmo esperable</strong></td><?php foreach ($objetivos as $o): ?><td><?= escapar($o['ritmo']) ?></td><?php endforeach; ?></tr>
            <tr><td><strong>Error frecuente</strong></td><?php foreach ($objetivos as $o): ?><td><?= escapar($o['error']) ?></td><?php endforeach; ?></tr>
        </tbody>
    </table>
    </div>
    <p class="sub" style="margin-top:12px">Son rangos generales. Podés calcular tus valores en la <a href="calculadora_calorias.php">calculadora de calorías</a>.</p>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>Cómo empezar en 5 pasos</h2>
        <ol class="pasos">
            <?php foreach ($pasos as $p): ?><li><?= escapar($p) ?></li><?php endforeach; ?>
        </ol>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('objetivos_plan.jpg', 'Plan de entrenamiento', 'Idea: cuaderno con plan de entrenamiento') ?>
        <div class="destacado">El mejor plan es el que podés sostener en el tiempo.</div>
    </div>
</section>

<h2 class="titulo-seccion">Preguntas frecuentes</h2>
<?php foreach ($preguntas as [$q, $r]): ?>
    <details class="acordeon">
        <summary><?= escapar($q) ?></summary>
        <div class="contenido"><p><?= escapar($r) ?></p></div>
    </details>
<?php endforeach; ?>

<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>