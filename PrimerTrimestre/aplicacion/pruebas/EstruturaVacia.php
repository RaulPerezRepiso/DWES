<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "",
];
$GLOBALS['ubicacion'] = $ubicacion;


// Dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("PRUEBAS");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
?>
 
<?php

}
