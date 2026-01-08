<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 4" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 4: Función devuelve()");


cuerpo();
finCuerpo();

function cuerpo()
{
    $array = ["edad" => 12, "material" => "metal"];
    $obj = Flauta::crearDesdeArray($array);
    $obj2 = clone $obj;

    echo $obj . "<br>";
    echo $obj2;
}
