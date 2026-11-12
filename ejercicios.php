<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// [nombre, músculos principales, clave de la técnica, error común]
$grupos = [
    ['nombre' => 'Pecho', 'img' => 'ej_pecho.jpg', 'ejercicios' => [
        ['Press de banca', 'Pectoral mayor, deltoides anterior, tríceps', 'Escápulas juntas y hacia abajo, pies firmes en el piso y barra que baja hasta rozar el pecho.', 'Rebotar la barra en el pecho o despegar la cadera del banco.'],
        ['Press inclinado con mancuernas', 'Pectoral superior, hombros', 'Banco entre 30° y 45°, codos a unos 45° del torso y recorrido controlado.', 'Inclinar demasiado el banco, que lo convierte en un press de hombros.'],
        ['Flexiones de brazos', 'Pectoral, tríceps, core', 'Cuerpo en línea recta de cabeza a talones y pecho que casi toca el suelo.', 'Hundir la cadera o abrir los codos a 90°.'],
        ['Aperturas con mancuernas', 'Pectoral (aislamiento)', 'Codos levemente flexionados y estiramiento controlado del pecho.', 'Bajar demasiado las mancuernas y forzar el hombro.'],
    ]],
    ['nombre' => 'Espalda', 'img' => 'ej_espalda.jpg', 'ejercicios' => [
        ['Dominadas / jalón al pecho', 'Dorsal ancho, bíceps', 'Pecho hacia la barra, hombros lejos de las orejas y descenso controlado.', 'Balancearse para tomar impulso.'],
        ['Remo con barra', 'Dorsales, romboides, trapecio', 'Torso inclinado a unos 45°, espalda neutra y barra que sube hacia el abdomen.', 'Redondear la espalda baja o tirar con los brazos en lugar de la espalda.'],
        ['Remo con mancuerna', 'Dorsal, romboides', 'Apoyo firme de mano y rodilla, codo cerca del cuerpo y pausa arriba.', 'Rotar el torso para levantar más peso.'],
        ['Peso muerto', 'Espalda baja, glúteos, isquiotibiales', 'Barra pegada al cuerpo, espalda neutra y empuje del piso con las piernas.', 'Redondear la zona lumbar o alejar la barra de las piernas.'],
    ]],
    ['nombre' => 'Piernas y glúteos', 'img' => 'ej_piernas.jpg', 'ejercicios' => [
        ['Sentadilla', 'Cuádriceps, glúteos, core', 'Pies al ancho de hombros, rodillas hacia la dirección de los pies y descenso hasta una profundidad cómoda.', 'Que las rodillas colapsen hacia adentro o levantar los talones.'],
        ['Peso muerto rumano', 'Isquiotibiales, glúteos', 'Cadera hacia atrás con rodillas levemente flexionadas y barra pegada a las piernas.', 'Flexionar demasiado las rodillas, que lo convierte en una sentadilla.'],
        ['Zancadas', 'Cuádriceps, glúteos', 'Paso largo, torso erguido y rodilla delantera alineada con el pie.', 'Pasos demasiado cortos que cargan la rodilla.'],
        ['Puente de glúteos', 'Glúteos, isquiotibiales', 'Talones cerca de la cadera, empuje con los talones y pausa arriba apretando glúteos.', 'Arquear la espalda baja en lugar de extender la cadera.'],
    ]],
    ['nombre' => 'Hombros', 'img' => 'ej_hombros.jpg', 'ejercicios' => [
        ['Press militar', 'Deltoides, tríceps', 'Abdomen y glúteos firmes, barra que sube en línea recta cerca de la cara.', 'Arquear la zona lumbar para empujar el peso.'],
        ['Elevaciones laterales', 'Deltoides medio', 'Codos levemente flexionados y subir hasta la altura de los hombros.', 'Usar impulso del cuerpo con pesos excesivos.'],
        ['Pájaros (vuelos posteriores)', 'Deltoides posterior', 'Torso inclinado, espalda neutra y movimiento amplio sin encoger los hombros.', 'Subir los hombros hacia las orejas.'],
        ['Face pull', 'Deltoides posterior, manguito rotador', 'Polea a la altura de la cara y codos altos separando la cuerda.', 'Usar demasiado peso y perder la postura.'],
    ]],
    ['nombre' => 'Brazos', 'img' => 'ej_brazos.jpg', 'ejercicios' => [
        ['Curl de bíceps', 'Bíceps', 'Codos pegados al torso y descenso lento de la mancuerna.', 'Balancear el cuerpo para subir.'],
        ['Curl martillo', 'Braquial, braquiorradial', 'Agarre neutro (palmas enfrentadas) y movimiento sin impulso.', 'Despegar los codos del cuerpo.'],
        ['Extensión de tríceps en polea', 'Tríceps', 'Codos fijos a los costados y extensión completa.', 'Mover los hombros o inclinar el cuerpo sobre la barra.'],
        ['Fondos en paralelas', 'Tríceps, pecho', 'Torso levemente inclinado y descenso hasta un ángulo cómodo del codo.', 'Bajar demasiado y cargar el hombro.'],
    ]],
    ['nombre' => 'Core (zona media)', 'img' => 'ej_core.jpg', 'ejercicios' => [
        ['Plancha', 'Recto abdominal, transverso, oblicuos', 'Cuerpo en línea recta, glúteos y abdomen contraídos y respiración normal.', 'Hundir la cadera o aguantar la respiración.'],
        ['Plancha lateral', 'Oblicuos, glúteo medio', 'Cadera elevada en línea con hombros y pies.', 'Dejar caer la cadera.'],
        ['Elevación de piernas', 'Abdomen inferior, flexores de cadera', 'Zona lumbar apoyada y bajada lenta de las piernas.', 'Arquear la espalda baja al bajar.'],
        ['Bird-dog', 'Core, lumbares, glúteos', 'Extender brazo y pierna contrarios manteniendo la pelvis quieta.', 'Rotar la cadera o apurar el movimiento.'],
    ]],
];

$titulo = 'Biblioteca de ejercicios';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Biblioteca de ejercicios',
    'Los ejercicios fundamentales por grupo muscular, con la clave de la técnica y el error más común.',
    'ejercicios_banner.jpg'
);
?>
<nav class="indice-pagina">
    <?php foreach ($grupos as $i => $g): ?>
        <a href="#g<?= (int)$i ?>"><?= escapar($g['nombre']) ?></a>
    <?php endforeach; ?>
</nav>

<section class="tarjeta">
    <h2>Antes de empezar</h2>
    <ul>
        <li>Aprendé el movimiento con poco peso y recién después aumentá la carga.</li>
        <li>Grabate o pedile a alguien que te mire para corregir la técnica.</li>
        <li>El dolor muscular leve al día siguiente es normal. El dolor agudo durante el ejercicio, no: parate y consultá.</li>
    </ul>
</section>

<?php foreach ($grupos as $i => $g): ?>
    <section class="tarjeta" id="g<?= (int)$i ?>">
        <div class="grilla-2">
            <div>
                <h2><?= escapar($g['nombre']) ?></h2>
                <p class="sub"><?= count($g['ejercicios']) ?> ejercicios fundamentales</p>
            </div>
            <?= imagen_espacio($g['img'], 'Ejercicios de ' . $g['nombre'], 'Recomendado: 1000 x 560 px') ?>
        </div>

        <?php foreach ($g['ejercicios'] as [$nombre, $musculos, $tecnica, $error]): ?>
            <details class="acordeon">
                <summary><?= escapar($nombre) ?></summary>
                <div class="contenido">
                    <p><strong>Músculos:</strong> <?= escapar($musculos) ?></p>
                    <p><strong>Clave de la técnica:</strong> <?= escapar($tecnica) ?></p>
                    <p><strong>Error común:</strong> <?= escapar($error) ?></p>
                </div>
            </details>
        <?php endforeach; ?>
    </section>
<?php endforeach; ?>

<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>