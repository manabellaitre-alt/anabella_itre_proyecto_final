<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$tipos = [
    ['LISS', 'Baja intensidad, ritmo constante',
     'Caminata rápida, bici suave o trote lento durante 30 a 60 minutos. Podés mantener una conversación.',
     'Fácil de recuperar, ideal para sumar volumen y como actividad de base.'],
    ['MISS', 'Intensidad moderada, ritmo constante',
     'Trote o bici a ritmo firme durante 20 a 40 minutos. Podés hablar, pero en frases cortas.',
     'Mejora la resistencia aeróbica con un buen equilibrio entre tiempo y esfuerzo.'],
    ['HIIT', 'Intervalos de alta intensidad',
     'Bloques de 20 a 60 segundos muy intensos alternados con pausas o ritmos suaves, en 15 a 25 minutos en total.',
     'Eficiente en tiempo, pero exige más recuperación: 1 o 2 veces por semana alcanza.'],
];

$beneficios = [
    ['Salud del corazón', 'Fortalece el corazón y mejora la circulación.'],
    ['Resistencia', 'Te permite sostener el esfuerzo por más tiempo, también en el entrenamiento de fuerza.'],
    ['Estado de ánimo', 'La actividad aeróbica regular se asocia con menos estrés y mejor sueño.'],
    ['Gasto energético', 'Suma calorías gastadas y ayuda a sostener un déficit para bajar grasa.'],
    ['Recuperación', 'El cardio suave favorece el flujo de sangre y puede ayudarte a recuperarte entre sesiones.'],
    ['Salud metabólica', 'Mejora la sensibilidad a la insulina y los valores de presión arterial.'],
];

$zonas = [
    ['Z1', 'Muy suave', 'Calentamiento y recuperación activa.',      50, 60],
    ['Z2', 'Suave',     'Base aeróbica: podés conversar con comodidad.', 60, 70],
    ['Z3', 'Moderada',  'Ritmo firme: frases cortas.',                70, 80],
    ['Z4', 'Intensa',   'Esfuerzo duro: solo palabras sueltas.',      80, 90],
    ['Z5', 'Máxima',    'Esfuerzos muy cortos, casi al límite.',      90, 100],
];

$errores = [];
$fcmax = null;
$edad = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página.';
    } else {
        $edad = trim($_POST['edad'] ?? '');
        $e = filter_var($edad, FILTER_VALIDATE_INT);
        if ($e === false || $e < 14 || $e > 90) {
            $errores[] = 'La edad debe estar entre 14 y 90 años.';
        } else {
            // Fórmula de Tanaka: 208 - 0,7 x edad
            $fcmax = (int)round(208 - 0.7 * $e);
        }
    }
}

$semana = [
    ['Lunes',     'Fuerza',               '—'],
    ['Martes',    'Cardio LISS',          '40 min en zona 2'],
    ['Miércoles', 'Fuerza',               '—'],
    ['Jueves',    'Cardio MISS o HIIT',   '20 a 25 min'],
    ['Viernes',   'Fuerza',               '—'],
    ['Sábado',    'Actividad recreativa', 'Caminata, bici, deporte'],
    ['Domingo',   'Descanso',             '—'],
];

$titulo = 'Cardio';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Cardio y frecuencia cardíaca',
    'Tipos de entrenamiento aeróbico, zonas de intensidad y cómo combinarlo con la fuerza.',
    'cardio_banner.jpg'
);
?>
<nav class="indice-pagina">
    <a href="#tipos">Tipos de cardio</a>
    <a href="#zonas">Zonas de frecuencia cardíaca</a>
    <a href="#beneficios">Beneficios</a>
    <a href="#semana">Semana de ejemplo</a>
</nav>

<section id="tipos">
    <h2 class="titulo-seccion" style="margin-top:0">Tres formas de hacer cardio</h2>
    <div class="grilla-3">
        <?php foreach ($tipos as $i => [$sigla, $nombre, $desc, $nota]): ?>
            <div class="tarjeta col-comparar <?= $i === 1 ? 'c2' : ($i === 2 ? 'c3' : '') ?>">
                <h3><?= escapar($sigla) ?></h3>
                <p><strong><?= escapar($nombre) ?></strong></p>
                <p><?= escapar($desc) ?></p>
                <p class="sub"><?= escapar($nota) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="tarjeta" id="zonas">
    <h2>Calculá tus zonas de frecuencia cardíaca</h2>
    <div class="grilla-2">
        <div class="formulario">
            <?php if (!empty($errores)): ?>
                <ul class="errores"><?php foreach ($errores as $err): ?><li><?= escapar($err) ?></li><?php endforeach; ?></ul>
            <?php endif; ?>
            <form action="cardio.php#zonas" method="POST">
                <?= csrf_campo() ?>
                <label for="edad">Tu edad (años)</label>
                <input type="text" id="edad" name="edad" inputmode="numeric" required value="<?= escapar($edad) ?>">
                <button type="submit" class="btn">Calcular zonas</button>
            </form>
            <p class="sub" style="margin-top:12px">Se usa la fórmula de Tanaka (208 − 0,7 × edad). Es una estimación: la frecuencia máxima real varía de una persona a otra.</p>
        </div>
        <?= imagen_espacio('cardio_zonas.jpg', 'Zonas de frecuencia cardíaca', 'Idea: reloj deportivo o cinta de correr') ?>
    </div>

    <?php if ($fcmax): ?>
        <div class="resultado-grilla"><div class="caja"><strong><?= (int)$fcmax ?> lpm</strong>Frecuencia máxima estimada</div></div>
    <?php endif; ?>

    <div style="margin-top:20px">
        <?php foreach ($zonas as [$z, $nombre, $desc, $min, $max]): ?>
            <div class="zona <?= escapar(strtolower($z)) ?>">
                <strong><?= escapar($z) ?></strong>
                <div><strong><?= escapar($nombre) ?></strong> · <?= escapar($desc) ?></div>
                <div class="rango">
                    <?php if ($fcmax): ?>
                        <?= (int)round($fcmax * $min / 100) ?>–<?= (int)round($fcmax * $max / 100) ?> lpm
                    <?php else: ?>
                        <?= (int)$min ?>–<?= (int)$max ?>% FCmáx
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <p class="sub">Regla práctica sin reloj: si podés hablar con comodidad estás en zona 2; si solo decís frases cortas estás en zona 3; si apenas podés hablar estás en zona 4 o más.</p>
</section>

<section class="tarjeta" id="beneficios">
    <h2>Beneficios del entrenamiento aeróbico</h2>
    <div class="grilla-3">
        <?php foreach ($beneficios as [$n, $d]): ?>
            <div><h3><?= escapar($n) ?></h3><p><?= escapar($d) ?></p></div>
        <?php endforeach; ?>
    </div>
</section>

<section class="tarjeta" id="semana">
    <h2>Cómo combinarlo con la fuerza</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Día</th><th>Actividad</th><th>Detalle</th></tr></thead>
        <tbody>
        <?php foreach ($semana as [$d, $a, $det]): ?>
            <tr><td><strong><?= escapar($d) ?></strong></td><td><?= escapar($a) ?></td><td><?= escapar($det) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <p class="sub" style="margin-top:12px">Si tu prioridad es la fuerza, hacé el cardio intenso en un día separado o después de entrenar con pesas, y mantené el volumen controlado.</p>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>