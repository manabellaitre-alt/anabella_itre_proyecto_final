<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$principios = [
    ['Sobrecarga progresiva', 'Para mejorar, el cuerpo necesita un estímulo mayor al que ya domina. Se logra sumando peso, repeticiones, series o mejorando la técnica de forma gradual.'],
    ['Volumen semanal', 'Un rango práctico para la mayoría es de 10 a 20 series por semana por grupo muscular. Los principiantes progresan con menos, y más no siempre es mejor.'],
    ['Frecuencia', 'Entrenar cada grupo muscular al menos 2 veces por semana suele dar mejores resultados que una sola vez, con el mismo volumen total.'],
    ['Intensidad', 'Las series efectivas terminan cerca del fallo técnico: quedan entre 1 y 3 repeticiones en reserva (RIR). No hace falta llegar siempre al límite.'],
    ['Descanso entre series', 'Entre 2 y 3 minutos en ejercicios multiarticulares pesados y entre 1 y 2 minutos en los de aislamiento mantienen el rendimiento.'],
    ['Recuperación', 'Los músculos se adaptan mientras descansás. Dormir y comer bien es parte del entrenamiento.'],
];

$rutinas = [
    [
        'nivel' => 'Principiante',
        'frecuencia' => '3 días por semana',
        'img' => 'rutina_principiante.jpg',
        'objetivo' => 'Aprender los patrones básicos de movimiento, crear el hábito y desarrollar una base de fuerza.',
        'dias' => [
            'Día 1 – Cuerpo completo A' => ['Sentadillas 3x12', 'Flexiones (o de rodillas) 3x10', 'Remo con mancuerna 3x12', 'Plancha 3x30 s'],
            'Día 2 – Cuerpo completo B' => ['Peso muerto rumano 3x10', 'Press de hombros 3x12', 'Zancadas 3x10 por pierna', 'Abdominales 3x15'],
            'Día 3 – Cardio y movilidad' => ['Caminata rápida o bici 30 min', 'Estiramientos 10 min'],
        ],
    ],
    [
        'nivel' => 'Intermedio',
        'frecuencia' => '4 días por semana',
        'img' => 'rutina_intermedio.jpg',
        'objetivo' => 'Aumentar el volumen por grupo muscular y progresar en cargas con una división tren superior / tren inferior.',
        'dias' => [
            'Día 1 – Tren superior (empuje)' => ['Press banca 4x8', 'Press militar 3x10', 'Fondos 3x10', 'Extensión de tríceps 3x12'],
            'Día 2 – Tren inferior' => ['Sentadilla 4x8', 'Prensa 3x12', 'Curl femoral 3x12', 'Elevación de talones 4x15'],
            'Día 3 – Tren superior (tracción)' => ['Dominadas o jalón 4x8', 'Remo con barra 4x8', 'Curl de bíceps 3x12', 'Face pull 3x15'],
            'Día 4 – Piernas y core' => ['Peso muerto 4x6', 'Zancadas caminando 3x12', 'Plancha lateral 3x40 s', 'Elevación de piernas 3x15'],
        ],
    ],
    [
        'nivel' => 'Avanzado',
        'frecuencia' => '5 días por semana',
        'img' => 'rutina_avanzado.jpg',
        'objetivo' => 'Especializar el trabajo por grupo muscular con alto volumen y control fino de la intensidad.',
        'dias' => [
            'Día 1 – Pecho y tríceps' => ['Press banca 5x5', 'Press inclinado 4x8', 'Aperturas 3x12', 'Press francés 3x10'],
            'Día 2 – Espalda y bíceps' => ['Peso muerto 5x5', 'Dominadas lastradas 4x6', 'Remo T 4x8', 'Curl martillo 3x12'],
            'Día 3 – Piernas' => ['Sentadilla 5x5', 'Prensa 4x10', 'Peso muerto rumano 4x8', 'Gemelos 5x15'],
            'Día 4 – Hombros y core' => ['Press militar 5x5', 'Elevaciones laterales 4x15', 'Pájaros 3x15', 'Rueda abdominal 3x12'],
            'Día 5 – Full body metabólico' => ['Circuito de 5 ejercicios, 4 vueltas', 'Descanso 60 s entre vueltas'],
        ],
    ],
];

$titulo = 'Rutinas';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Rutinas de entrenamiento',
    'Programas por nivel con su objetivo. Elegí el que se ajuste a tu experiencia y progresá de a poco.',
    'rutinas_banner.jpg'
);
?>
<section class="tarjeta">
    <h2>Los 6 principios de un buen programa</h2>
    <div class="grilla-3">
        <?php foreach ($principios as [$nombre, $texto]): ?>
            <div>
                <h3><?= escapar($nombre) ?></h3>
                <p><?= escapar($texto) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="tarjeta">
    <h2>Comparativa de niveles</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Nivel</th><th>Frecuencia</th><th>Días de fuerza</th><th>Objetivo principal</th></tr></thead>
        <tbody>
        <?php foreach ($rutinas as $r): ?>
            <tr>
                <td><strong><?= escapar($r['nivel']) ?></strong></td>
                <td><?= escapar($r['frecuencia']) ?></td>
                <td><?= count($r['dias']) ?> días</td>
                <td><?= escapar($r['objetivo']) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>

<?php foreach ($rutinas as $r): ?>
    <section class="tarjeta">
        <div class="grilla-2">
            <div>
                <h2><?= escapar($r['nivel']) ?> <small>· <?= escapar($r['frecuencia']) ?></small></h2>
                <p class="sub"><?= escapar($r['objetivo']) ?></p>
            </div>
            <?= imagen_espacio($r['img'], 'Rutina ' . $r['nivel'], 'Recomendado: 1000 x 560 px') ?>
        </div>
        <?php foreach ($r['dias'] as $dia => $ejercicios): ?>
            <details class="acordeon">
                <summary><?= escapar($dia) ?></summary>
                <div class="contenido">
                    <ul>
                        <?php foreach ($ejercicios as $ej): ?>
                            <li><?= escapar($ej) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </details>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>

<p class="sub">Formato de las series: <strong>series x repeticiones</strong> (por ejemplo, 3x12 son 3 series de 12 repeticiones). Siempre empezá con 5 a 10 minutos de entrada en calor.</p>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>