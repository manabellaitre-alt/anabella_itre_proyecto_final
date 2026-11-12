<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

$terminos = [
    '1RM' => 'Repetición máxima: la mayor carga que se puede levantar una sola vez con buena técnica.',
    'Carga' => 'Peso que se levanta en un ejercicio.',
    'Core' => 'Conjunto de músculos de la zona media del cuerpo (abdomen, lumbares y cadera) que estabilizan el tronco.',
    'Déficit calórico' => 'Situación en la que consumís menos calorías de las que gastás. Es la base para bajar grasa.',
    'Deload (descarga)' => 'Semana de menor volumen o intensidad para recuperarse de la fatiga acumulada.',
    'Fallo muscular' => 'Punto en el que no se puede completar otra repetición con buena técnica.',
    'HIIT' => 'Entrenamiento de intervalos de alta intensidad: esfuerzos intensos alternados con pausas o ritmos suaves.',
    'Hipertrofia' => 'Aumento del tamaño de las fibras musculares como respuesta al entrenamiento de fuerza.',
    'IMC' => 'Índice de masa corporal: peso en kg dividido la altura en metros al cuadrado. Es una referencia general.',
    'LISS' => 'Cardio de baja intensidad y duración sostenida, como una caminata larga.',
    'Macronutrientes' => 'Nutrientes que aportan energía en grandes cantidades: proteínas, carbohidratos y grasas.',
    'MET' => 'Unidad que mide la intensidad de una actividad respecto al reposo. 1 MET equivale al gasto en reposo.',
    'Repetición' => 'Una ejecución completa de un ejercicio.',
    'RIR' => 'Repeticiones en reserva: cuántas repeticiones más podrías hacer antes de llegar al fallo.',
    'Serie' => 'Grupo de repeticiones seguidas, sin pausa, de un mismo ejercicio.',
    'Sobrecarga progresiva' => 'Aumento gradual del estímulo del entrenamiento para seguir progresando.',
    'Superávit calórico' => 'Situación en la que consumís más calorías de las que gastás. Se usa para ganar masa muscular.',
    'TDEE' => 'Gasto energético diario total: las calorías que gastás en un día incluyendo la actividad.',
    'TMB' => 'Tasa metabólica basal: las calorías que el cuerpo gasta en reposo para mantener sus funciones.',
    'Volumen' => 'Cantidad total de trabajo: series por repeticiones por carga, normalmente medido en series semanales por músculo.',
];

$titulo = 'Glosario';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Glosario fitness',
    'Los términos que vas a escuchar en el gimnasio y en las guías de entrenamiento, explicados en simple.',
    'glosario_banner.jpg'
);
?>
<section class="tarjeta">
    <p class="sub"><?= count($terminos) ?> términos</p>
    <dl class="glosario">
        <?php foreach ($terminos as $termino => $definicion): ?>
            <dt><?= escapar($termino) ?></dt>
            <dd><?= escapar($definicion) ?></dd>
        <?php endforeach; ?>
    </dl>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>