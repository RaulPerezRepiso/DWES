<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include("libreria.php");

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
    echo "<br><strong>Llamada a la funcion Suma: </strong>".llamadaAFuncino(2, 4, fn($num1, $num2) => $num1 + $num2);
    echo "<br><strong>Llamada a la funcion Resta: </strong>".llamadaAFuncino(6, 4, fn($num1, $num2) => $num1 - $num2);
    echo "<br><strong>Llamada a la funcion Multiplicación: </strong>".llamadaAFuncino(2, 4, fn($num1, $num2) => $num1 * $num2);
}
