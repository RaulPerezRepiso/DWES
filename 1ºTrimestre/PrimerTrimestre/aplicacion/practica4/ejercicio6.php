<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 6" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 6: Función llamadaAFuncion()");


cuerpo();
finCuerpo();
function cuerpo()
{
    echo "Valor de Fibonacci de 10 llamando a una nueva SerieFibonaccie:<br>";
    foreach (new SerieFibonacci(10) as $valor) {
        echo "$valor &nbsp;";
    }

    echo "<br><br>Valor de Fibonacci de 10 llamando al metodo fFibonacci de la SerieFibonaccie:<br>";
    foreach (SerieFibonacci::fFibonacci(10) as $valor) {
        echo "$valor &nbsp;";
    }
}
