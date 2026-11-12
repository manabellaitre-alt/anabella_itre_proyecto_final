<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// Valores aproximados por 100 g. [alimento, kcal, proteínas g, carbohidratos g, grasas g]
$grupos = [
    'Fuentes de proteína' => [
        ['Pechuga de pollo cocida',          165, 31,   0,   3.6],
        ['Carne vacuna magra cocida (≈)',    210, 29,   0,   10],
        ['Huevo entero',                     143, 12.6, 0.7, 9.5],
        ['Atún enlatado al natural',         116, 26,   0,   1],
        ['Yogur griego natural descremado',   59, 10,   3.6, 0.4],
        ['Queso cottage',                     98, 11,   3.4, 4.3],
        ['Tofu firme',                        76, 8,    1.9, 4.8],
    ],
    'Carbohidratos' => [
        ['Arroz blanco cocido',              130, 2.7,  28,  0.3],
        ['Papa cocida',                       87, 1.9,  20,  0.1],
        ['Batata cocida',                     90, 2,    21,  0.2],
        ['Avena en hojuelas (cruda)',        389, 17,   66,  7],
        ['Pan integral (≈)',                 250, 13,   41,  3.4],
        ['Banana',                            89, 1.1,  23,  0.3],
    ],
    'Legumbres' => [
        ['Lentejas cocidas',                 116, 9,    20,  0.4],
        ['Garbanzos cocidos',                164, 8.9,  27,  2.6],
    ],
    'Grasas saludables' => [
        ['Palta',                            160, 2,    9,   15],
        ['Almendras',                        579, 21,   22,  50],
        ['Nueces',                           654, 15,   14,  65],
        ['Aceite de oliva',                  884, 0,    0,   100],
    ],
];

$etiqueta = [
    ['Tamaño de la porción', 'Todos los datos de la etiqueta se refieren a esa porción, no al paquete completo.'],
    ['Calorías', 'Indican la energía total por porción.'],
    ['Proteínas, carbohidratos y grasas', 'Sumalos con los de tus otras comidas para cumplir tu objetivo diario.'],
    ['Azúcares y sodio', 'Conviene limitarlos en productos ultraprocesados.'],
    ['Lista de ingredientes', 'Están ordenados de mayor a menor cantidad: los primeros son los más abundantes.'],
];

$titulo = 'Tabla de alimentos';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Tabla de alimentos',
    'Calorías y macronutrientes de alimentos habituales para armar tus comidas con datos.',
    'alimentos_banner.jpg'
);
?>
<nav class="indice-pagina">
    <?php foreach (array_keys($grupos) as $i => $nombreGrupo): ?>
        <a href="#g<?= (int)$i ?>"><?= escapar($nombreGrupo) ?></a>
    <?php endforeach; ?>
    <a href="#etiquetas">Cómo leer una etiqueta</a>
</nav>

<div class="aviso">Valores <strong>aproximados por 100 g</strong> basados en tablas de composición de alimentos (USDA). Cambian según la marca, el corte y la forma de cocción. Donde figura (≈) la variación es mayor.</div>

<?php $i = 0; foreach ($grupos as $nombreGrupo => $alimentos): ?>
    <section class="tarjeta" id="g<?= (int)$i ?>">
        <h2><?= escapar($nombreGrupo) ?></h2>
        <div class="tabla-scroll">
        <table class="tabla">
            <thead><tr><th>Alimento (100 g)</th><th>Calorías</th><th>Proteínas</th><th>Carbohidratos</th><th>Grasas</th></tr></thead>
            <tbody>
            <?php foreach ($alimentos as [$n, $kcal, $p, $c, $g]): ?>
                <tr>
                    <td><strong><?= escapar($n) ?></strong></td>
                    <td><?= (int)$kcal ?> kcal</td>
                    <td><?= escapar(number_format($p, 1, ',', '')) ?> g</td>
                    <td><?= escapar(number_format($c, 1, ',', '')) ?> g</td>
                    <td><?= escapar(number_format($g, 1, ',', '')) ?> g</td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        </div>
    </section>
<?php $i++; endforeach; ?>

<section class="grilla-2" id="etiquetas">
    <div class="tarjeta">
        <h2>Cómo leer una etiqueta nutricional</h2>
        <ul>
            <?php foreach ($etiqueta as [$n, $d]): ?>
                <li><strong><?= escapar($n) ?>:</strong> <?= escapar($d) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('alimentos_etiqueta.jpg', 'Etiqueta nutricional', 'Idea: foto de una etiqueta nutricional o de un mercado') ?>
        <p class="sub" style="margin-top:12px">Ejemplo de armado: 150 g de pollo + 200 g de arroz cocido + verduras + una cucharada de aceite de oliva.</p>
    </div>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>