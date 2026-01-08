<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include("libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación III:" => "./index.php",
    "Ejercicio 7" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 7: Función ordenar()");


cuerpo();
finCuerpo();
function cuerpo()
{
    $array = ["hola", "adios", "cumpleaños", "uno"];
    foreach (ordenar($array) as $valor) {
        echo "<br>" . $valor;
    }
}
