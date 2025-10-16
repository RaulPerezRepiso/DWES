<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include("libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 3" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 3: - Función operaciones()");


cuerpo();
finCuerpo();

function cuerpo()
{

}
