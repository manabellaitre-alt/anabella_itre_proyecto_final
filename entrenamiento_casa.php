<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// [patrón, versión fácil, versión estándar, versión difícil]
$progresiones = [
    ['Empuje',            'Flexiones en pared o con manos elevadas', 'Flexiones en el suelo', 'Flexiones con pies elevados'],
    ['Tracción',          'Remo invertido con mesa firme, rodillas flexionadas', 'Remo invertido con piernas estiradas', 'Remo invertido con pies elevados'],
    ['Piernas',           'Sentadilla a una silla', 'Sentadilla libre', 'Sentadilla búlgara o con salto'],
    ['Bisagra de cadera', 'Puente de glúteos', 'Puente a una pierna', 'Peso muerto a una pierna con mochila cargada'],
    ['Core',              'Plancha sobre rodillas', 'Plancha completa', 'Plancha con elevación alternada de brazos o piernas'],
];

$semanas = [
    ['Semana 1', '2 vueltas',      '10 repeticiones por ejercicio', 'Aprender la técnica. Descanso de 60 s entre ejercicios.'],
    ['Semana 2', '3 vueltas',      '10 repeticiones por ejercicio', 'Sumar una vuelta manteniendo la técnica.'],
    ['Semana 3', '3 vueltas',      '12 repeticiones por ejercicio', 'Subir repeticiones y reducir el descanso a 45 s.'],
    ['Semana 4', '3 a 4 vueltas',  '12 a 15 repeticiones',          'Pasar a la versión estándar o difícil de uno o dos ejercicios.'],
];

$circuito = [
    'Sentadilla libre',
    'Flexiones (versión adaptada a tu nivel)',
    'Puente de glúteos',
    'Remo invertido o remo con mochila',
    'Zancadas alternadas',
    'Plancha 20 a 40 segundos',
];

$elementos = [
    ['Mochila con libros', 'Sirve como carga para sentadillas, remos y peso muerto.'],
    ['Silla firme', 'Para sentadillas asistidas, fondos y elevaciones de pies.'],
    ['Botellas de agua', 'Pesos livianos para elevaciones laterales y curl.'],
    ['Toalla', 'Se usa para ejercicios de deslizamiento y estiramientos.'],
    ['Banda elástica (opcional)', 'Suma resistencia sin ocupar espacio.'],
];

$titulo = 'Entrenamiento en casa';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Entrenamiento en casa',
    'Un plan completo sin gimnasio: con tu peso corporal y objetos de uso diario podés trabajar todo el cuerpo.',
    'casa_banner.jpg'
);
?>
<nav class="indice-pagina">
    <a href="#circuito">Circuito base</a>
    <a href="#progresiones">Progresiones</a>
    <a href="#plan">Plan de 4 semanas</a>
    <a href="#elementos">Elementos útiles</a>
</nav>

<section class="tarjeta" id="circuito">
    <h2>Circuito base de cuerpo completo</h2>
    <div class="grilla-2">
        <div>
            <p>Hacé los ejercicios en orden, uno detrás de otro. Al terminar los seis, descansá 1 a 2 minutos: eso es una <strong>vuelta</strong>.
               Entrená 3 días por semana, con al menos un día de descanso entre sesiones.</p>
            <ol class="pasos">
                <?php foreach ($circuito as $c): ?><li><?= escapar($c) ?></li><?php endforeach; ?>
            </ol>
        </div>
        <?= imagen_espacio('casa_circuito.jpg', 'Circuito en casa', 'Idea: persona entrenando en el living con ropa cómoda') ?>
    </div>
</section>

<section class="tarjeta" id="progresiones">
    <h2>Progresiones: cómo hacerlo más fácil o más difícil</h2>
    <p class="sub">Sin pesas, la progresión se logra cambiando la palanca o la variante del ejercicio. Elegí la versión que te permita hacer las repeticiones con buena técnica.</p>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Patrón</th><th>Más fácil</th><th>Estándar</th><th>Más difícil</th></tr></thead>
        <tbody>
        <?php foreach ($progresiones as [$p, $f, $e, $d]): ?>
            <tr>
                <td><strong><?= escapar($p) ?></strong></td>
                <td><?= escapar($f) ?></td>
                <td><?= escapar($e) ?></td>
                <td><?= escapar($d) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>

<section class="tarjeta" id="plan">
    <h2>Plan de progresión de 4 semanas</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Semana</th><th>Vueltas</th><th>Repeticiones</th><th>Qué hacer</th></tr></thead>
        <tbody>
        <?php foreach ($semanas as [$s, $v, $r, $n]): ?>
            <tr>
                <td><strong><?= escapar($s) ?></strong></td>
                <td><?= escapar($v) ?></td>
                <td><?= escapar($r) ?></td>
                <td><?= escapar($n) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <p class="sub" style="margin-top:12px">Después de la semana 4, repetí el ciclo con variantes más difíciles. Cuando el peso corporal ya no sea suficiente, sumá carga con mochila o mancuernas.</p>
</section>

<section class="grilla-2" id="elementos">
    <div class="tarjeta">
        <h2>Elementos que ya tenés en casa</h2>
        <ul>
            <?php foreach ($elementos as [$n, $d]): ?>
                <li><strong><?= escapar($n) ?>:</strong> <?= escapar($d) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="tarjeta">
        <h2>Consejos para sostener el hábito</h2>
        <ul>
            <li>Elegí un horario fijo y dejá la ropa preparada.</li>
            <li>Empezá con sesiones de 20 a 30 minutos: es mejor corto y constante.</li>
            <li>Usá un piso antideslizante o una colchoneta.</li>
            <li>Anotá lo que hacés cada día para ver tu avance.</li>
        </ul>
        <?= imagen_espacio('casa_habito.jpg', 'Hábito de entrenar en casa', 'Idea: calendario o colchoneta lista') ?>
    </div>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>