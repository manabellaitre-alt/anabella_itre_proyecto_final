<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// Actividad, MET aproximado (valores del Compendio de Actividades Físicas, redondeados)
$actividades = [
    ['Yoga',                  2.5],
    ['Caminata a 5 km/h',     3.5],
    ['Musculación general',   5.0],
    ['Natación recreativa',   6.0],
    ['Trote a 8 km/h',        8.0],
    ['Bicicleta moderada',    8.0],
    ['Circuito / HIIT',       8.0],
];
$pesoRef = 70;     // kg
$horas   = 0.5;    // 30 minutos

$gasto = [];
foreach ($actividades as [$nombre, $met]) {
    $gasto[] = [$nombre, $met, (int)round($met * $pesoRef * $horas)];
}
$maxGasto = max(array_column($gasto, 2));

$energia = [
    ['Grasas', 9],
    ['Alcohol', 7],
    ['Proteínas', 4],
    ['Carbohidratos', 4],
];

$semana = [
    ['Lunes',     'Fuerza: tren superior',       60],
    ['Martes',    'Fuerza: tren inferior',       60],
    ['Miércoles', 'Descanso activo (caminata)',  30],
    ['Jueves',    'Fuerza: tren superior',       60],
    ['Viernes',   'Fuerza: tren inferior',       60],
    ['Sábado',    'Cardio moderado',             45],
    ['Domingo',   'Descanso',                    0],
];
$totalSemana = array_sum(array_column($semana, 2));

$titulo = 'Estadísticas y análisis';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Estadísticas y análisis',
    'Datos y referencias para entender cuánto movimiento recomienda la salud pública y cuánta energía gasta cada actividad.',
    'estadisticas_banner.jpg'
);
?>
<section class="tarjeta">
    <h2>Recomendaciones de la OMS para adultos</h2>
    <div class="grilla-3" style="margin-bottom:0">
        <div>
            <div class="dato-grande">150–300</div>
            <div class="dato-etiqueta">minutos por semana de actividad aeróbica moderada</div>
        </div>
        <div>
            <div class="dato-grande">75–150</div>
            <div class="dato-etiqueta">minutos por semana si la actividad aeróbica es vigorosa</div>
        </div>
        <div>
            <div class="dato-grande">2+</div>
            <div class="dato-etiqueta">días por semana de ejercicios de fuerza para los grandes grupos musculares</div>
        </div>
    </div>
    <p class="sub" style="margin-top:14px">Fuente: Organización Mundial de la Salud, Directrices sobre actividad física y hábitos sedentarios.
        Una parte importante de los adultos del mundo no alcanza estos niveles, por eso conviene moverse más y sentarse menos.</p>
</section>

<section class="tarjeta">
    <h2>Gasto energético por actividad</h2>
    <p class="sub">Estimación para una persona de <?= (int)$pesoRef ?> kg durante 30 minutos. Fórmula: MET × peso (kg) × horas.</p>
    <?php foreach ($gasto as [$nombre, $met, $kcal]): ?>
        <div class="barra-fila">
            <span><?= escapar($nombre) ?> <small>(MET <?= escapar(number_format($met, 1, ',', '')) ?>)</small></span>
            <div class="barra-fondo"><div class="barra-relleno" style="width: <?= (int)round($kcal / $maxGasto * 100) ?>%"></div></div>
            <strong><?= (int)$kcal ?> kcal</strong>
        </div>
    <?php endforeach; ?>
    <p class="sub">Valores orientativos: el gasto real varía con la intensidad, la técnica y las características de cada persona.</p>
</section>

<section class="grilla-2" style="margin-bottom:22px">
    <div class="tarjeta">
        <h2>Energía por gramo de cada nutriente</h2>
        <?php foreach ($energia as [$nombre, $kcal]): ?>
            <div class="barra-fila" style="grid-template-columns: 130px 1fr 80px">
                <span><?= escapar($nombre) ?></span>
                <div class="barra-fondo"><div class="barra-relleno" style="width: <?= (int)round($kcal / 9 * 100) ?>%"></div></div>
                <strong><?= (int)$kcal ?> kcal/g</strong>
            </div>
        <?php endforeach; ?>
        <p class="sub">Las grasas aportan más del doble de energía por gramo que las proteínas y los carbohidratos.</p>
    </div>

    <div class="tarjeta">
        <h2>Semana de ejemplo</h2>
        <div class="tabla-scroll">
        <table class="tabla">
            <thead><tr><th>Día</th><th>Actividad</th><th>Minutos</th></tr></thead>
            <tbody>
            <?php foreach ($semana as [$dia, $act, $min]): ?>
                <tr>
                    <td><?= escapar($dia) ?></td>
                    <td><?= escapar($act) ?></td>
                    <td><?= (int)$min ?></td>
                </tr>
            <?php endforeach; ?>
            <tr><td colspan="2"><strong>Total semanal</strong></td><td><strong><?= (int)$totalSemana ?></strong></td></tr>
            </tbody>
        </table>
        </div>
    </div>
</section>

<section class="tarjeta">
    <h2>Análisis</h2>
    <ul>
        <li>Un entrenamiento de fuerza de 30 minutos gasta menos calorías que un trote, pero construye masa muscular, que eleva el gasto en reposo.</li>
        <li>La actividad de intensidad alta rinde más calorías por minuto, pero exige más recuperación y no se puede sostener todos los días.</li>
        <li>La semana de ejemplo suma <strong><?= (int)$totalSemana ?> minutos</strong>, lo que ya supera el mínimo de 150 minutos semanales de la OMS.</li>
        <li>Para mantener resultados, lo mejor es una combinación de fuerza, cardio moderado y movimiento diario.</li>
    </ul>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>