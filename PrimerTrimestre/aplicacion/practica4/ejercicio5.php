<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 5" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 5: Función hacerOperacion()");


cuerpo();
finCuerpo();
function cuerpo()
{
    $obj = new Persona();
    echo $obj;
}
