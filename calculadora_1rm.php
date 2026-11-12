<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$errores = [];
$resultado = null;
$peso = $reps = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página.';
    } else {
        $peso = str_replace(',', '.', trim($_POST['peso'] ?? ''));
        $reps = trim($_POST['reps'] ?? '');

        $p = filter_var($peso, FILTER_VALIDATE_FLOAT);
        $r = filter_var($reps, FILTER_VALIDATE_INT);

        if ($p === false || $p < 1 || $p > 1000) {
            $errores[] = 'Ingresá un peso válido entre 1 y 1000 kg.';
        }
        if ($r === false || $r < 1 || $r > 12) {
            $errores[] = 'Las repeticiones deben ser un número entre 1 y 12 (la estimación pierde precisión con más).';
        }

        if (empty($errores)) {
            $epley   = $p * (1 + $r / 30);
            $brzycki = $p * 36 / (37 - $r);
            $rm      = ($epley + $brzycki) / 2;

            $tabla = [];
            foreach ([100 => '1', 95 => '2', 90 => '4', 85 => '6', 80 => '8', 75 => '10', 70 => '12', 60 => '15+', 50 => '20+'] as $pct => $repsAprox) {
                $tabla[] = [$pct, round($rm * $pct / 100, 1), $repsAprox];
            }
            $resultado = [
                'epley' => round($epley, 1), 'brzycki' => round($brzycki, 1),
                'rm' => round($rm, 1), 'tabla' => $tabla,
            ];
        }
    }
}

$titulo = 'Calculadora de 1RM';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Calculadora de 1RM',
    'Estimá la carga máxima que podrías levantar una vez y usala para planificar tus series.',
    'rm_banner.jpg'
);
?>
<section class="tarjeta formulario formulario-ancho">
    <h2>Calculá tu 1RM</h2>
    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?><li><?= escapar($error) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="calculadora_1rm.php" method="POST">
        <?= csrf_campo() ?>
        <div class="fila-2">
            <div>
                <label for="peso">Peso levantado (kg)</label>
                <input type="text" id="peso" name="peso" inputmode="decimal" required value="<?= escapar($peso) ?>">
            </div>
            <div>
                <label for="reps">Repeticiones logradas (1 a 12)</label>
                <input type="text" id="reps" name="reps" inputmode="numeric" required value="<?= escapar($reps) ?>">
            </div>
        </div>
        <button type="submit" class="btn">Calcular 1RM</button>
    </form>

    <?php if ($resultado): ?>
        <div class="resultado-grilla">
            <div class="caja"><strong><?= escapar((string)$resultado['rm']) ?> kg</strong>1RM estimado (promedio)</div>
            <div class="caja"><strong><?= escapar((string)$resultado['epley']) ?> kg</strong>Fórmula de Epley</div>
            <div class="caja"><strong><?= escapar((string)$resultado['brzycki']) ?> kg</strong>Fórmula de Brzycki</div>
        </div>

        <h3 style="margin-top:26px">Tabla de cargas según tu 1RM</h3>
        <div class="tabla-scroll">
        <table class="tabla">
            <thead><tr><th>% del 1RM</th><th>Carga</th><th>Repeticiones aproximadas</th></tr></thead>
            <tbody>
            <?php foreach ($resultado['tabla'] as [$pct, $carga, $r]): ?>
                <tr>
                    <td><?= (int)$pct ?>%</td>
                    <td><?= escapar((string)$carga) ?> kg</td>
                    <td><?= escapar($r) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    <?php endif; ?>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>Cómo interpretarlo</h2>
        <ul>
            <li>El 1RM es una <strong>estimación</strong>, no una medición. Cambia según el ejercicio, la técnica y el día.</li>
            <li>Para <strong>fuerza</strong> se trabaja habitualmente entre el 80% y el 90% del 1RM, con pocas repeticiones.</li>
            <li>Para <strong>hipertrofia</strong> se usan cargas moderadas (alrededor del 65% al 80%) con series cerca del fallo.</li>
            <li>No hace falta probar tu máximo real: la estimación evita el riesgo de una repetición al límite.</li>
        </ul>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('rm_barra.jpg', 'Barra con discos', 'Idea: barra cargada en el gimnasio') ?>
    </div>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>