<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(3)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}


// Dibuja la plantilla de la vista
inicioCabecera("Borrar Usuario");
cabecera();
finCabecera();

inicioCuerpo("Borrar Usuario");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
?>

<?php

}
