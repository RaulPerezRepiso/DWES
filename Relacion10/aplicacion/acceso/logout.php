<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Logout" => "#",
];

// Quitar registro y volver al index
$acceso->quitarRegistroUsuario();
header("Location: /index.php");
exit;
