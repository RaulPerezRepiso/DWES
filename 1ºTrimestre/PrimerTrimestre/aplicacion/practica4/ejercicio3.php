<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 3" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 3: - Heredar y Mostrar Clase");


cuerpo();
finCuerpo();

function cuerpo()
{
    $viento = new InstrumentoViento();
    echo $viento;
}
