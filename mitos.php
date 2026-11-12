<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// [mito, veredicto, explicación]
$mitos = [
    ['Hacer muchos abdominales quema la grasa de la panza.', 'Falso',
     'No se puede elegir de dónde se pierde la grasa. Los abdominales fortalecen el músculo, pero la grasa se reduce con un déficit calórico sostenido en todo el cuerpo.'],
    ['Las pesas te ponen "demasiado grande" (sobre todo a las mujeres).', 'Falso',
     'Ganar mucha masa muscular lleva años de entrenamiento específico y una alimentación en superávit. El trabajo de fuerza suele dar un cuerpo más firme y tonificado.'],
    ['Sudar más significa quemar más grasa.', 'Falso',
     'El sudor regula la temperatura, no mide la grasa quemada. Se pierde líquido, que se recupera al hidratarte.'],
    ['Comer de noche engorda.', 'Falso',
     'Lo que importa es el balance calórico total del día, no la hora. Cenar tarde influye solo si te hace comer de más.'],
    ['Hay que tomar proteína dentro de los 30 minutos posteriores al entrenamiento.', 'Exagerado',
     'La ventana de aprovechamiento es mucho más amplia. Lo que más pesa es la cantidad total de proteína del día.'],
    ['Los carbohidratos engordan.', 'Falso',
     'Ningún nutriente engorda por sí solo: el aumento de grasa depende del exceso calórico total. Los carbohidratos son una buena fuente de energía para entrenar.'],
    ['Más entrenamiento siempre es mejor.', 'Falso',
     'Más allá de cierto punto, el exceso genera fatiga y estanca el progreso. La clave es el equilibrio entre estímulo y recuperación.'],
    ['El dolor muscular del día siguiente indica un buen entrenamiento.', 'Parcialmente cierto',
     'Las agujetas aparecen sobre todo con ejercicios nuevos, pero su ausencia no significa que no hayas progresado.'],
    ['Estirar antes de entrenar previene lesiones.', 'Matizado',
     'Un calentamiento dinámico (movimientos suaves y progresivos) prepara mejor que el estiramiento estático prolongado.'],
];

$titulo = 'Mitos y verdades';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Mitos y verdades del fitness',
    'Creencias muy repetidas en los gimnasios y en las redes, contrastadas con lo que se sabe hoy.',
    'mitos_banner.jpg'
);
?>
<section class="tarjeta">
    <p>Abrí cada tarjeta para ver el veredicto y la explicación. Ante la duda, desconfiá de las promesas absolutas
       como "el único método", "resultados garantizados" o "el secreto que no quieren que sepas".</p>
</section>

<?php foreach ($mitos as $i => [$mito, $veredicto, $explicacion]): ?>
    <details class="acordeon">
        <summary>Mito <?= $i + 1 ?>: <?= escapar($mito) ?></summary>
        <div class="contenido">
            <p><strong>Veredicto:</strong> <span class="etiqueta <?= $veredicto === 'Falso' ? 'ev-baja' : 'ev-media' ?>"><?= escapar($veredicto) ?></span></p>
            <p><?= escapar($explicacion) ?></p>
        </div>
    </details>
<?php endforeach; ?>

<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>