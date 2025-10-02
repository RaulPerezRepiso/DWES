<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 4: Array de valores");


// Declarar la constante
define("FILAS", 5);

// Crear el array usando bucles for
$array = [];
for ($i = 1; $i <= FILAS; $i++) {
    $fila = [];
    for ($j = 1; $j <= $i; $j++) {
        $fila[] = $i;
    }
    $array[] = $fila;
}
cuerpo($array);

function cuerpo($array)
{
    echo "<strong>Contenido del array generado con FILAS</strong><br><br>";

    foreach ($array as $indice => $fila) {
            foreach ($fila as $valor) {
            echo "{$valor} ";
        }
        echo "<br>";
    }
}
