<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$macros = [
    ['Proteínas',         '4 kcal/g', '1,4 a 2,0 g por kg de peso al día', 'Reparan y construyen tejido muscular.', 'Carne magra, huevos, lácteos, legumbres, pescado, tofu.'],
    ['Carbohidratos',     '4 kcal/g', '3 a 7 g por kg al día, según el volumen de entrenamiento', 'Principal fuente de energía para entrenar.', 'Avena, arroz, papa, batata, frutas, pan integral.'],
    ['Grasas saludables', '9 kcal/g', '20% a 35% de las calorías diarias', 'Regulan hormonas y permiten absorber vitaminas A, D, E y K.', 'Palta, frutos secos, aceite de oliva, semillas, pescado azul.'],
    ['Fibra',             '—',        '25 a 35 g al día', 'Mejora la digestión y la saciedad.', 'Verduras, frutas con cáscara, legumbres, cereales integrales.'],
];

$comidas = [
    ['Desayuno',    'Avena con leche o yogur, fruta y frutos secos.',            'Energía sostenida + proteína'],
    ['Almuerzo',    'Carne magra o legumbres, arroz o papa, ensalada variada.',  'Plato completo'],
    ['Merienda',    'Yogur o queso con fruta, o tostada integral con huevo.',    'Proteína + carbohidrato'],
    ['Pre-entreno', 'Banana o tostada con mermelada 60 a 90 min antes.',         'Carbohidrato de fácil digestión'],
    ['Cena',        'Pescado o pollo, verduras cocidas, batata o quinoa.',       'Proteína + verduras'],
];

$habitos = [
    'Tomá agua a lo largo del día: unos 2 litros es una referencia, que sube con el calor y la actividad.',
    'Incluí verduras en al menos dos comidas diarias.',
    'Priorizá alimentos poco procesados la mayor parte del tiempo.',
    'Repartí la proteína en 3 o 4 comidas en lugar de concentrarla en una sola.',
    'Dormí entre 7 y 9 horas: la recuperación también es parte del entrenamiento.',
    'La constancia importa más que la perfección: una comida no define tu progreso.',
];

$titulo = 'Nutrición';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Nutrición para entrenar mejor',
    'Qué aporta cada nutriente, cuánto necesitás de forma orientativa y cómo organizar tu día de comidas.',
    'nutricion_banner.jpg'
);
?>
<section class="tarjeta">
    <h2>Macronutrientes: qué son y cuánto</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead>
            <tr><th>Nutriente</th><th>Energía</th><th>Rango orientativo</th><th>Función</th><th>Fuentes</th></tr>
        </thead>
        <tbody>
        <?php foreach ($macros as [$n, $kcal, $rango, $funcion, $fuentes]): ?>
            <tr>
                <td><strong><?= escapar($n) ?></strong></td>
                <td><?= escapar($kcal) ?></td>
                <td><?= escapar($rango) ?></td>
                <td><?= escapar($funcion) ?></td>
                <td><?= escapar($fuentes) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <p class="sub" style="margin-top:12px">Los rangos son referencias generales para personas que entrenan. Las necesidades reales dependen de cada persona.
        Calculá las tuyas en la <a href="calculadora_calorias.php">calculadora de calorías</a>.</p>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>El plato equilibrado</h2>
        <?= imagen_espacio('nutri_plato.jpg', 'Plato equilibrado', 'Idea: foto de un plato dividido en verduras, proteína y carbohidrato') ?>
        <ul style="margin-top:14px">
            <li><strong>Mitad del plato:</strong> verduras y frutas.</li>
            <li><strong>Un cuarto:</strong> proteína (carne, huevo, legumbres, lácteos).</li>
            <li><strong>Un cuarto:</strong> carbohidratos de calidad (arroz, papa, avena).</li>
            <li><strong>Un toque de grasa saludable:</strong> aceite de oliva, palta o frutos secos.</li>
        </ul>
    </div>
    <div class="tarjeta">
        <h2>Hidratación</h2>
        <?= imagen_espacio('nutri_hidratacion.jpg', 'Hidratación', 'Idea: botella de agua en el gimnasio') ?>
        <ul style="margin-top:14px">
            <li>Una orina de color amarillo claro suele indicar buena hidratación.</li>
            <li>Tomá agua antes, durante y después de entrenar.</li>
            <li>En sesiones de más de 60 minutos o con mucho calor, sumá sales minerales.</li>
            <li>La sed es una señal tardía: no esperes a tenerla.</li>
        </ul>
    </div>
</section>

<section class="tarjeta" style="margin-top:22px">
    <h2>Ejemplo de distribución de comidas</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Momento</th><th>Ejemplo</th><th>Aporte principal</th></tr></thead>
        <tbody>
        <?php foreach ($comidas as [$momento, $ejemplo, $aporte]): ?>
            <tr>
                <td><strong><?= escapar($momento) ?></strong></td>
                <td><?= escapar($ejemplo) ?></td>
                <td><?= escapar($aporte) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>

<section class="tarjeta">
    <h2>Hábitos clave</h2>
    <ul>
        <?php foreach ($habitos as $h): ?><li><?= escapar($h) ?></li><?php endforeach; ?>
    </ul>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>