<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación I:" => "./index.php",
    "Ejercicio 4" => "ejercicio4.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 4: Array de valores");


// Declarar la constante
define("FILAS", 5);

// Crear el array usando bucles for
$array = [];
for ($i = 1; $i <= FILAS; $i++) {
    $fila = [$i]; // No hace falta poner nada dentro [] se rellena solo
    for ($j = 1; $j < $i; $j++) {
        $fila[] = $i; // Podemos ver que sin llamar a j se rellena solo
    }
    $array[] = $fila;
}
cuerpo($array);
finCuerpo();

function cuerpo($array)
{
    echo "<strong>Contenido del array</strong><br><br>";

    foreach ($array as $indice => $fila) {
        foreach ($fila as $valor) {
            echo "{$valor} ";
        }
        echo "<br>";
    }
}
