<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación III:" => "./index.php",
    "Ejercicio 5" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 5: Función hacerOperacion()");


cuerpo();
finCuerpo();
function cuerpo()
{
    echo "<br>".hacerOperacion("resta", 2, 3);
    echo "<br>".hacerOperacion("suma", 2, 3);
    echo "<br>".hacerOperacion("multiplicacion", 2, 3);
}
