<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$actividades = [
    'sedentario'  => ['Sedentario (poco o nada de ejercicio)', 1.2],
    'ligero'      => ['Ligero (1 a 3 días por semana)', 1.375],
    'moderado'    => ['Moderado (3 a 5 días por semana)', 1.55],
    'intenso'     => ['Intenso (6 a 7 días por semana)', 1.725],
    'muy_intenso' => ['Muy intenso (doble turno o trabajo físico)', 1.9],
];
$objetivos = [
    'bajar'    => ['Bajar grasa (déficit aproximado del 15%)', -0.15],
    'mantener' => ['Mantener el peso', 0.0],
    'subir'    => ['Ganar músculo (superávit aproximado del 10%)', 0.10],
];

$errores = [];
$resultado = null;
$sexo = 'm'; $edad = $peso = $altura = '';
$act = 'moderado'; $obj = 'mantener';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_validar()) {
        $errores[] = 'Solicitud inválida. Recargá la página.';
    } else {
        $sexo   = $_POST['sexo'] ?? 'm';
        $edad   = trim($_POST['edad'] ?? '');
        $peso   = str_replace(',', '.', trim($_POST['peso'] ?? ''));
        $altura = str_replace(',', '.', trim($_POST['altura'] ?? ''));
        $act    = $_POST['actividad'] ?? '';
        $obj    = $_POST['objetivo'] ?? '';

        $e = filter_var($edad, FILTER_VALIDATE_INT);
        $p = filter_var($peso, FILTER_VALIDATE_FLOAT);
        $a = filter_var($altura, FILTER_VALIDATE_FLOAT);

        if (!in_array($sexo, ['m', 'f'], true))   { $errores[] = 'Elegí una opción de sexo.'; }
        if ($e === false || $e < 14 || $e > 90)   { $errores[] = 'La edad debe estar entre 14 y 90 años.'; }
        if ($p === false || $p < 30 || $p > 300)  { $errores[] = 'El peso debe estar entre 30 y 300 kg.'; }
        if ($a === false || $a < 120 || $a > 230) { $errores[] = 'La altura debe estar entre 120 y 230 cm.'; }
        if (!isset($actividades[$act]))           { $errores[] = 'Elegí un nivel de actividad.'; }
        if (!isset($objetivos[$obj]))             { $errores[] = 'Elegí un objetivo.'; }

        if (empty($errores)) {
            // Fórmula de Mifflin-St Jeor
            $tmb  = 10 * $p + 6.25 * $a - 5 * $e + ($sexo === 'm' ? 5 : -161);
            $tdee = $tmb * $actividades[$act][1];
            $kcal = $tdee * (1 + $objetivos[$obj][1]);

            $proteinas = 1.8 * $p;                  // g
            $grasas    = ($kcal * 0.25) / 9;        // 25% de las calorías
            $carbos    = max(0, ($kcal - $proteinas * 4 - $grasas * 9) / 4);

            $resultado = [
                'tmb' => round($tmb), 'tdee' => round($tdee), 'kcal' => round($kcal),
                'prot' => round($proteinas), 'gras' => round($grasas), 'carb' => round($carbos),
                'agua' => round($p * 35 / 1000, 1),
            ];
        }
    }
}

$titulo = 'Calculadora de calorías';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Calculadora de calorías y macros',
    'Estimá cuántas calorías gasta tu cuerpo y cómo repartirlas según tu objetivo.',
    'calorias_banner.jpg'
);
?>
<section class="tarjeta formulario formulario-ancho">
    <h2>Tus datos</h2>
    <?php if (!empty($errores)): ?>
        <ul class="errores">
            <?php foreach ($errores as $error): ?><li><?= escapar($error) ?></li><?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form action="calculadora_calorias.php" method="POST">
        <?= csrf_campo() ?>
        <div class="fila-2">
            <div>
                <label for="sexo">Sexo</label>
                <select id="sexo" name="sexo">
                    <option value="m" <?= $sexo === 'm' ? 'selected' : '' ?>>Masculino</option>
                    <option value="f" <?= $sexo === 'f' ? 'selected' : '' ?>>Femenino</option>
                </select>
            </div>
            <div>
                <label for="edad">Edad (años)</label>
                <input type="text" id="edad" name="edad" inputmode="numeric" required value="<?= escapar($edad) ?>">
            </div>
        </div>
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

        <label for="actividad">Nivel de actividad</label>
        <select id="actividad" name="actividad">
            <?php foreach ($actividades as $clave => [$texto, $factor]): ?>
                <option value="<?= escapar($clave) ?>" <?= $act === $clave ? 'selected' : '' ?>><?= escapar($texto) ?></option>
            <?php endforeach; ?>
        </select>

        <label for="objetivo">Objetivo</label>
        <select id="objetivo" name="objetivo">
            <?php foreach ($objetivos as $clave => [$texto, $ajuste]): ?>
                <option value="<?= escapar($clave) ?>" <?= $obj === $clave ? 'selected' : '' ?>><?= escapar($texto) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn">Calcular</button>
    </form>

    <?php if ($resultado): ?>
        <div class="resultado-grilla">
            <div class="caja"><strong><?= (int)$resultado['tmb'] ?></strong>kcal de metabolismo basal</div>
            <div class="caja"><strong><?= (int)$resultado['tdee'] ?></strong>kcal de gasto diario total</div>
            <div class="caja"><strong><?= (int)$resultado['kcal'] ?></strong>kcal objetivo por día</div>
        </div>
        <div class="resultado-grilla">
            <div class="caja"><strong><?= (int)$resultado['prot'] ?> g</strong>Proteínas</div>
            <div class="caja"><strong><?= (int)$resultado['carb'] ?> g</strong>Carbohidratos</div>
            <div class="caja"><strong><?= (int)$resultado['gras'] ?> g</strong>Grasas</div>
            <div class="caja"><strong><?= escapar((string)$resultado['agua']) ?> L</strong>Agua orientativa</div>
        </div>
    <?php endif; ?>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>Cómo se calcula</h2>
        <ul>
            <li><strong>Metabolismo basal (TMB):</strong> calorías que gasta tu cuerpo en reposo, con la fórmula de Mifflin-St Jeor.</li>
            <li><strong>Gasto diario (TDEE):</strong> TMB multiplicada por un factor según tu nivel de actividad.</li>
            <li><strong>Objetivo:</strong> se ajusta el TDEE con un déficit moderado (bajar grasa) o un superávit moderado (ganar músculo).</li>
            <li><strong>Macros:</strong> proteína fija en 1,8 g/kg, grasas en el 25% de las calorías y el resto en carbohidratos.</li>
        </ul>
        <p class="sub">Es una estimación inicial. Observá tu progreso durante 2 a 3 semanas y ajustá las calorías en función de los resultados.</p>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('calorias_comida.jpg', 'Comida saludable', 'Idea: meal prep o plato saludable') ?>
    </div>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>