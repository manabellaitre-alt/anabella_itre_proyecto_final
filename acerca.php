<?php
require_once __DIR__ . '/includes/funciones.php';

$tecnologias = [
    ['PHP ', 'Lógica del servidor: formularios, validaciones, sesiones y permisos.'],
    ['MySQL / MariaDB', 'Almacenamiento de las cuentas de usuario.'],
    ['PDO', 'Conexión a la base de datos con consultas preparadas.'],
    ['HTML y CSS', 'Estructura y diseño responsive de todas las páginas.'],
    ['XAMPP y phpMyAdmin', 'Servidor local y administración de la base de datos.'],
];

$seguridad = [
    ['Contraseñas', 'Se guardan con password_hash() y se comprueban con password_verify(). Nunca en texto plano.'],
    ['Inyección SQL', 'Todas las consultas usan sentencias preparadas con parámetros de PDO.'],
    ['XSS', 'Todo dato mostrado en pantalla pasa por la función escapar() (htmlspecialchars).'],
    ['CSRF', 'Los formularios llevan un token de sesión que se valida en el servidor.'],
    ['Sesiones', 'Se regenera el ID de sesión al iniciar sesión y se verifica en cada página privada.'],
    ['Roles', 'Las páginas administrativas verifican el rol admin en el servidor. El rol nunca se toma del formulario público.'],
    ['Borrado lógico', 'Los usuarios se archivan con una fecha en lugar de eliminarse, conservando el historial.'],
    ['Errores', 'Los errores técnicos se registran en el log del servidor y el usuario ve mensajes comprensibles.'],
];

$tablas = [
    ['usuarios', 'id, nombre, apellido, dni (único), email (único), password_hash, rol, creado_en, archivado_en'],
];

$titulo = 'Acerca del proyecto';
require __DIR__ . '/includes/header.php';
echo hero_pagina(
    'Acerca de FitZone',
    'Un sistema web de usuarios con contenido sobre el mundo fitness, desarrollado con PHP y MySQL como Trabajo Práctico Final.',
    'acerca_banner.jpg'
);
?>
<section class="tarjeta">
    <h2>El proyecto</h2>
    <p>FitZone permite que las personas se registren, inicien sesión y accedan a un panel personal con guías de entrenamiento,
       nutrición, descanso y herramientas de cálculo. Un administrador puede registrar, buscar, editar, archivar y reactivar usuarios.</p>
    <p><strong>Instituto Sagrado Corazón de Almagro · Informática 4.º año.</strong></p>
</section>

<section class="grilla-2" style="margin-bottom:22px">
    <div class="tarjeta">
        <h2>Tecnologías</h2>
        <ul>
            <?php foreach ($tecnologias as [$n, $d]): ?>
                <li><strong><?= escapar($n) ?>:</strong> <?= escapar($d) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="tarjeta">
        <h2>Base de datos</h2>
        <ul>
            <?php foreach ($tablas as [$n, $d]): ?>
                <li><strong><?= escapar($n) ?>:</strong> <?= escapar($d) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<section class="tarjeta">
    <h2>Medidas de seguridad implementadas</h2>
    <div class="tabla-scroll">
    <table class="tabla">
        <thead><tr><th>Aspecto</th><th>Cómo se resuelve</th></tr></thead>
        <tbody>
        <?php foreach ($seguridad as [$a, $c]): ?>
            <tr><td><strong><?= escapar($a) ?></strong></td><td><?= escapar($c) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</section>
<?php require __DIR__ . '/includes/footer.php'; ?>