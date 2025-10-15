<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación III:" => "./index.php",
    "Ejercicio 4" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 4: Función devuelve()");


cuerpo();
finCuerpo();

function cuerpo()
{
    $valor = 7;
    $resultado = devuelve($valor, 4, 8);
    echo "<br>" . $resultado;

    $valor = 7;
    $resultado = devuelve($valor);
    echo "<br>" . $resultado;

    $valor = 7;
    $resultado = devuelve($valor, num1: 6);
    echo "<br>" . $resultado;

    $valor = 7;
    $resultado = devuelve($valor, num2: 8);
    echo "<br>" . $resultado;
}
