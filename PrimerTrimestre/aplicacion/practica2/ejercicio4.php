<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 4" => "ejercicio4.php"
];
$GLOBALS['ubicacion'] = $ubicacion;



inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 4: Array de valores");

cuerpo();
finCuerpo();

function cuerpo()
{

}
