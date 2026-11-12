<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$categorias = [
    ['Bajo peso',   'Menos de 18,5',  'Puede indicar un aporte de energía insuficiente. Conviene revisar la alimentación.'],
    ['Peso normal', '18,5 a 24,9',    'Rango asociado a menor riesgo de enfermedades vinculadas al peso.'],
    ['Sobrepeso',   '25 a 29,9',      'Se recomienda cuidar la alimentación y aumentar la actividad física.'],
    ['Obesidad',    '30 o más',       'Es recomendable consultar a un profesional de la salud.'],
];

$errores = [];
$resultado = null;
$peso = $altura = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página.';
    } else {
        $peso   = str_replace(',', '.', trim($_POST['peso'] ?? ''));
        $altura = str_replace(',', '.', trim($_POST['altura'] ?? ''));

        $p = filter_var($peso, FILTER_VALIDATE_FLOAT);
        $a = filter_var($altura, FILTER_VALIDATE_FLOAT);

        if ($p === false || $p < 20 || $p > 300) {
            $errores[] = 'Ingresá un peso válido entre 20 y 300 kg.';
        }
        if ($a === false || $a < 100 || $a > 250) {
            $errores[] = 'Ingresá una altura válida entre 100 y 250 cm.';
        }

        if (empty($errores)) {
            $imc = $p / (($a / 100) ** 2);
            if ($imc < 18.5)   { $cat = 'Bajo peso'; }
            elseif ($imc < 25) { $cat = 'Peso normal'; }
            elseif ($imc < 30) { $cat = 'Sobrepeso'; }
            else               { $cat = 'Obesidad'; }

            // Rango de peso saludable para esa altura (IMC 18,5 a 24,9)
            $m = $a / 100;
            $resultado = [
                'imc' => round($imc, 1), 'categoria' => $cat,
                'min' => round(18.5 * $m * $m, 1), 'max' => round(24.9 * $m * $m, 1),
            ];
        }
    }
}

$titulo = 'Calculadora IMC';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Calculadora de IMC',
    'IMC = peso (kg) ÷ altura² (m). Es un valor orientativo, no un diagnóstico.',
    'imc_banner.jpg'
);
?>
<section class="tarjeta formulario formulario-ancho">
    <h2>Calculá tu IMC</h2>
    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?><li><?= escapar($error) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="calculadora_imc.php" method="POST">
        <?= csrf_campo() ?>
        <div class="fila-2">
            <div>
                <label for="peso">Peso (kg)</label>
                <input type="text" id="peso" name="peso" inputmode="decimal" required value="<?= escapar($peso) ?>">
            </div>
            <div>
                <label for="altura">Altura (cm)</label>
                <input type="text" id="altura" name="altura" inputmode="decimal" required value="<?= escapar($altura) ?>">
            </div>
        </div>
        <button type="submit" class="btn">Calcular</button>
    </form>

    <?php if ($resultado): ?>
        <div class="resultado-grilla">
            <div class="caja"><strong><?= escapar((string)$resultado['imc']) ?></strong>Tu IMC</div>
            <div class="caja"><strong style="font-size:1.3rem"><?= escapar($resultado['categoria']) ?></strong>Categoría</div>
            <div class="caja"><strong style="font-size:1.3rem"><?= escapar((string)$resultado['min']) ?> – <?= escapar((string)$resultado['max']) ?> kg</strong>Peso en rango normal para tu altura</div>
        </div>
    <?php endif; ?>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>Categorías según la OMS</h2>
        <div class="tabla-scroll">
        <table class="tabla">
            <thead><tr><th>Categoría</th><th>IMC</th></tr></thead>
            <tbody>
            <?php foreach ($categorias as [$n, $r, $d]): ?>
                <tr><td><strong><?= escapar($n) ?></strong></td><td><?= escapar($r) ?></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('imc_cuerpo.jpg', 'Composición corporal', 'Idea: cinta métrica y balanza') ?>
    </div>
</section>

<section class="tarjeta" style="margin-top:22px">
    <h2>Qué significa cada categoría</h2>
    <ul>
        <?php foreach ($categorias as [$n, $r, $d]): ?>
            <li><strong><?= escapar($n) ?> (<?= escapar($r) ?>):</strong> <?= escapar($d) ?></li>
        <?php endforeach; ?>
    </ul>
</section>

<section class="tarjeta">
    <h2>Limitaciones del IMC</h2>
    <ul>
        <li>No distingue entre masa muscular y grasa: una persona muy musculosa puede tener un IMC alto sin exceso de grasa.</li>
        <li>No indica dónde se distribuye la grasa. El perímetro de cintura aporta información complementaria.</li>
        <li>Puede variar su interpretación según la edad, el sexo y el origen étnico.</li>
        <li>Se usa mejor como una herramienta de orientación junto con otras medidas y la opinión de un profesional.</li>
    </ul>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>