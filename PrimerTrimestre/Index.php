<?php
include_once(dirname(__FILE__) . "/cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

// Dibuja la plantilla de la vista
inicioCabecera("2DAW APLICACIÓN");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo();
finCuerpo();



// **********************************************************

function cabecera() {}
//vista
function cuerpo()
{
?>  
    <h1>Pruebas y Ejercicios</h1>
    <ul>
        <li><a href="/aplicacion/pruebas/index.php">Pruebas</a></li>
        <li><a href="/aplicacion/practica1/index.php">Práctica 1</a></li>
    </ul>
<?php

}
