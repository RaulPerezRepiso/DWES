<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
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
    <ul>
        <li> <a href="sintaxisBasica.php">Sintaxis Básica</a></li>
        <li> <a href="arrays.php">Arrays</a></li>
        <li> <a href="fechas.php">Fechas</a></li>
    </ul>
<?php

}
