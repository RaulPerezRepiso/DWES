<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;


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
