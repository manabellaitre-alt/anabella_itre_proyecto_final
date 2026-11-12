<?php
require_once __DIR__ . '/includes/funciones.php';
requerir_login();

// [nombre, para qué, evidencia (alta/media/baja), dosis estudiada, precauciones]
$suplementos = [
    ['Creatina monohidrato', 'Mejora la fuerza y el rendimiento en esfuerzos cortos e intensos.', 'alta',  '3 a 5 g por día, todos los días.', 'Tomar agua. Consultar con un médico ante enfermedad renal.'],
    ['Proteína en polvo',    'Ayuda a llegar a tu requerimiento diario de proteínas de forma práctica.', 'alta', 'Una medida (20 a 40 g) según lo que te falte.', 'Es un complemento de la comida, no un reemplazo.'],
    ['Cafeína',              'Reduce la sensación de fatiga y mejora el rendimiento.', 'alta', '3 a 6 mg por kg de peso, 30 a 60 minutos antes.', 'Puede afectar el sueño y aumentar la ansiedad o la frecuencia cardíaca.'],
    ['Vitamina D',           'Útil si hay déficit comprobado, por poca exposición al sol.', 'media', 'Según análisis y criterio médico.', 'No automedicarse: el exceso es perjudicial.'],
    ['Omega-3',              'Apoya la salud cardiovascular y puede ayudar a la recuperación.', 'media', 'Alrededor de 1 a 2 g de EPA + DHA por día.', 'Consultar si tomás anticoagulantes.'],
    ['Multivitamínicos',     'Sirven si la dieta es muy restrictiva o hay carencias.', 'baja', 'Según el producto y la indicación profesional.', 'Con una dieta variada aportan poco.'],
    ['BCAA',                 'Aminoácidos que ya están presentes en la proteína de la dieta.', 'baja', '—', 'Si tu ingesta total de proteínas es adecuada, suman muy poco.'],
    ['Quemadores de grasa',  'Prometen acelerar la pérdida de grasa.', 'baja', '—', 'Pueden contener estimulantes con riesgos. Evitar sin supervisión.'],
];

$titulo = 'Suplementos';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Suplementos: qué dice la evidencia',
    'Una guía para distinguir lo que tiene respaldo científico de lo que es puro marketing.',
    'suplementos_banner.jpg'
);
?>
<section class="tarjeta">
    <h2>Primero lo primero</h2>
    <p>Un suplemento <strong>complementa</strong>, no reemplaza. La base del rendimiento son el entrenamiento, la alimentación y el descanso.
       Recién cuando esos tres están resueltos, los suplementos pueden sumar un pequeño porcentaje extra.</p>
    <p>Qué significan los niveles de evidencia:</p>
    <ul>
        <li><span class="etiqueta ev-alta">Alta</span> Muchos estudios de calidad respaldan el efecto.</li>
        <li><span class="etiqueta ev-media">Media</span> Hay resultados prometedores, pero depende de cada caso.</li>
        <li><span class="etiqueta ev-baja">Baja</span> Poco respaldo o efecto muy limitado.</li>
    </ul>
</section>

<section class="tarjeta">
    <h2>Comparativa de suplementos</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead>
            <tr><th>Suplemento</th><th>Para qué se usa</th><th>Evidencia</th><th>Dosis estudiada</th><th>Precauciones</th></tr>
        </thead>
        <tbody>
        <?php foreach ($suplementos as [$nombre, $uso, $ev, $dosis, $prec]): ?>
            <tr>
                <td><strong><?= escapar($nombre) ?></strong></td>
                <td><?= escapar($uso) ?></td>
                <td><span class="etiqueta ev-<?= escapar($ev) ?>"><?= escapar(ucfirst($ev)) ?></span></td>
                <td><?= escapar($dosis) ?></td>
                <td><?= escapar($prec) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>

<section class="grilla-2">
    <div class="tarjeta">
        <h2>Cómo elegir un producto seguro</h2>
        <ul>
            <li>Elegí marcas con registro sanitario y datos del fabricante.</li>
            <li>Desconfiá de las promesas de resultados rápidos o milagrosos.</li>
            <li>Leé la etiqueta: la lista de ingredientes y la dosis tienen que estar claras.</li>
            <li>Consultá antes con un profesional de la salud.</li>
        </ul>
    </div>
    <div class="tarjeta">
        <?= imagen_espacio('suplementos_guia.jpg', 'Suplementos', 'Idea: foto de un pote de creatina o de proteína') ?>
    </div>
</section>
<?= aviso_salud() ?>
<?php require __DIR__ . '/includes/footer.php'; ?>