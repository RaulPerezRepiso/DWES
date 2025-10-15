<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación III:" => "./index.php",
    "Ejercicio 3" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 3: - Función operaciones()");


cuerpo();
finCuerpo();

function cuerpo()
{

    echo "<br>".operaciones(1, [2, 4, 4]);
    echo "<br>".operaciones(2, [12, 4, 4]);
    echo "<br>".operaciones(3, [2, 4, 4]);
    echo "<br>".operaciones(4, [2, 14, 4]);
}
