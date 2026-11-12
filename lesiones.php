<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$calentamiento = [
    'Empezá con 3 a 5 minutos de movimiento suave: caminata, bici o saltos suaves.',
    'Hacé movilidad de las articulaciones que vas a usar: cuello, hombros, cadera, rodillas y tobillos.',
    'Sumá ejercicios dinámicos: sentadillas sin peso, zancadas, rotaciones de tronco.',
    'Hacé 1 o 2 series de aproximación con poco peso del primer ejercicio.',
];

$prevencion = [
    ['Progresá de a poco', 'Aumentá cargas, volumen o kilómetros de forma gradual. Los saltos bruscos de carga son una causa frecuente de molestias.'],
    ['Cuidá la técnica', 'Si perdés el control del movimiento, bajá el peso o cortá la serie.'],
    ['Descansá', 'La fatiga acumulada y el sueño insuficiente aumentan el riesgo de molestias.'],
    ['Fortalecé de forma equilibrada', 'Trabajá el cuerpo completo: empuje y tracción, piernas y core.'],
    ['Elegí calzado y superficie adecuados', 'El calzado desgastado o inadecuado puede cargar rodillas, tobillos y espalda.'],
    ['Hidratate y comé bien', 'Los tejidos necesitan energía y nutrientes para adaptarse.'],
];

// [zona, molestia frecuente, qué suele influir, cómo prevenirla]
$zonas = [
    ['Zona lumbar', 'Dolor o tensión en la espalda baja', 'Técnica en peso muerto y sentadilla, poco fortalecimiento del core, mucho tiempo sentado.', 'Mantené la columna neutra, fortalecé core y glúteos y movete durante el día.'],
    ['Rodilla', 'Molestia al flexionar o al bajar escaleras', 'Aumento brusco de volumen, debilidad de glúteos o mala alineación al sentadillar.', 'Sumá fortalecimiento de cadera y piernas y cuidá la alineación rodilla-pie.'],
    ['Hombro', 'Dolor al elevar el brazo o al hacer press', 'Mucho press sin trabajo de tracción, falta de movilidad.', 'Equilibrá empuje con remos, face pulls y movilidad de hombro.'],
    ['Codo y muñeca', 'Molestia en agarres y curls', 'Volumen alto de agarres, mala posición de la muñeca.', 'Variá agarres, mantené la muñeca neutra y evitá aumentos bruscos.'],
    ['Cuello', 'Tensión en trapecios y cuello', 'Postura sostenida, hombros elevados durante los ejercicios.', 'Relajá los hombros al entrenar y hacé pausas de movilidad.'],
];

$molestia = [
    ['Reducí la carga', 'Bajá peso, volumen o rango de movimiento hasta que el movimiento no duela.'],
    ['Evitá lo que duele', 'Reemplazá temporalmente el ejercicio por una variante sin dolor.'],
    ['Seguí moviéndote', 'El reposo absoluto prolongado no suele ser lo mejor: la actividad suave favorece la recuperación.'],
    ['Volvé de a poco', 'Retomá con cargas más bajas y subí progresivamente en las semanas siguientes.'],
];

$consultar = [
    'Dolor agudo, súbito o que aparece con un chasquido.',
    'Hinchazón, deformidad o imposibilidad de apoyar o mover la zona.',
    'Hormigueo, adormecimiento o pérdida de fuerza.',
    'Dolor que no mejora luego de una a dos semanas o que empeora por la noche.',
    'Inestabilidad: sensación de que la articulación se "sale" o "falla".',
];

$urgencia = [
    'Dolor u opresión en el pecho, falta de aire inusual o mareos intensos durante el ejercicio.',
    'Pérdida de conocimiento, palpitaciones fuertes o dolor que se irradia al brazo o a la mandíbula.',
];

$titulo = 'Prevención de lesiones';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Prevención de lesiones',
    'Cómo entrenar de forma segura: calentamiento, hábitos que protegen y señales para saber cuándo consultar.',
    'lesiones_banner.jpg'
);
?>
<nav class="indice-pagina">
    <a href="#calentamiento">Calentamiento</a>
    <a href="#prevencion">Prevención</a>
    <a href="#zonas">Zonas frecuentes</a>
    <a href="#molestia">Si aparece una molestia</a>
    <a href="#consultar">Cuándo consultar</a>
</nav>

<section class="grilla-2" id="calentamiento" style="margin-bottom:22px">
    <div class="tarjeta">
        <h2>Calentamiento en 4 pasos (5 a 10 minutos)</h2>
        <ol class="pasos">
            <?php foreach ($calentamiento as $c): ?><li><?= escapar($c) ?></li><?php endforeach; ?>
        </ol>
        <p class="sub">Al terminar, 3 a 5 minutos de caminata suave y movilidad ayudan a bajar las pulsaciones.</p>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('lesiones_calentamiento.jpg', 'Calentamiento', 'Idea: persona haciendo movilidad antes de entrenar') ?>
    </div>
</section>

<section class="tarjeta" id="prevencion">
    <h2>6 hábitos que protegen</h2>
    <div class="grilla-3">
        <?php foreach ($prevencion as [$n, $d]): ?>
            <div><h3><?= escapar($n) ?></h3><p><?= escapar($d) ?></p></div>
        <?php endforeach; ?>
    </div>
</section>

<section class="tarjeta" id="zonas">
    <h2>Zonas con más molestias frecuentes</h2>
    <p class="sub">Información general para prevenir. No sirve para diagnosticar: ante dolor persistente consultá a un profesional.</p>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Zona</th><th>Molestia frecuente</th><th>Qué suele influir</th><th>Cómo prevenirla</th></tr></thead>
        <tbody>
        <?php foreach ($zonas as [$z, $m, $i, $p]): ?>
            <tr>
                <td><strong><?= escapar($z) ?></strong></td>
                <td><?= escapar($m) ?></td>
                <td><?= escapar($i) ?></td>
                <td><?= escapar($p) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>

<section class="tarjeta" id="molestia">
    <h2>Si aparece una molestia leve</h2>
    <div class="grilla-2">
        <ol class="pasos">
            <?php foreach ($molestia as [$n, $d]): ?>
                <li><strong><?= escapar($n) ?>:</strong> <?= escapar($d) ?></li>
            <?php endforeach; ?>
        </ol>
        <?= imagen_espacio('lesiones_recuperacion.jpg', 'Recuperación', 'Idea: estiramiento suave o consulta con kinesiólogo') ?>
    </div>
</section>

<section class="grilla-2" id="consultar">
    <div class="tarjeta">
        <h2>Cuándo consultar a un profesional</h2>
        <ul>
            <?php foreach ($consultar as $c): ?><li><?= escapar($c) ?></li><?php endforeach; ?>
        </ul>
    </div>
    <div class="tarjeta" style="border-color: var(--peligro)">
        <h2 style="color: var(--peligro)">Atención médica urgente</h2>
        <p>Dejá de entrenar y buscá atención inmediata si aparece alguno de estos signos:</p>
        <ul>
            <?php foreach ($urgencia as $u): ?><li><?= escapar($u) ?></li><?php endforeach; ?>
        </ul>
    </div>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>