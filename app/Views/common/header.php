<!doctype html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <title><?php echo esc($title); ?></title>
        <link rel="stylesheet" href="<?php echo base_url("css/estilos.css"); ?>">
    </head>
    <body>
        <main>
            <nav class="main-menu">
                <ul>
                    <li><?php echo anchor("/", "Inicio"); ?></li>
                    <li><?php echo anchor("usuario/lista", "Usuarios"); ?></li>
                    <li><?php echo anchor("asignatura/lista", "Asignaturas"); ?></li>
                    <li><?php echo anchor("usuario/notify", "Notify"); ?></li>
                    <li><?php echo anchor("usuario/notifyhtml", "Notify HTML"); ?></li>
                    <li><?php echo anchor("usuario/bio", "BIO"); ?></li>
                </ul>
            </nav>