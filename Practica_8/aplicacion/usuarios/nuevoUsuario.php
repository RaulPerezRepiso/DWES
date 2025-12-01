<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(3)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}


// Dibuja la plantilla de la vista
inicioCabecera("Nuevo Usuario");
cabecera();
finCabecera();

inicioCuerpo("Nuevo Usuario");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
?>

<?php

}
