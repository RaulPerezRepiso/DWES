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
    <a href="sintaxisBasica.php">Pruebas sintaxis básica</a><br>
    <a href="arrays.php">Pruebas arrays</a><br>
    <a href="fechas.php">Pruebas fechas</a><br>
    <a href="string.php">Pruebas Cadenas</a><br>
    <a href="funciones.php">Pruebas Funciones</a><br>
    <a href="clases.php">Pruebas Clases</a><br>
    <a href="formulario.php">Prueba Formulario</a><br>
    <a href="pruebagd.php">Prueba Imagen GD</a><br>
    <a href="pruebaficheros.php">Prueba ficheros</a><br>
    <a href="cookies_seciones.php">Prueba Cookies</a><br>
<?php

}
