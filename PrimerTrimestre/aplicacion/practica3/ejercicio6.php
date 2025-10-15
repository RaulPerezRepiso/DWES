<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación III:" => "./index.php",
    "Ejercicio 6" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 6: Función llamadaAFuncion()");


cuerpo();
finCuerpo();
function cuerpo()
{

}
