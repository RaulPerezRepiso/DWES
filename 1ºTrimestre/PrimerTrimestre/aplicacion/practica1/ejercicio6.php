<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación I:" => "./index.php",
    "Ejercicio 6" => "ejercicio6.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 6: Array con ForEach");

$vector = array(
    "primera" => 12.56,
    24 => true,
    67 => 23.76
);

cuerpo($vector);
finCuerpo();

function cuerpo($vector)
{
    echo "<h3>Simulación de foreach usando funciones de recorrido</h3>";

    // Simulación con funciones internas: current(), key(), next()
    reset($vector); // Asegura que el puntero esté al inicio
    while (key($vector) !== null) {
        $indice = key($vector);
        $valor = current($vector);
        echo "Posición '{$indice}' => Valor '{$valor}'<br>";
        next($vector);
    }

    echo "<br><h3>Simulación de foreach usando array_keys y array_values</h3>";

    $claves = array_keys($vector);
    $valores = array_values($vector);

    for ($i = 0; $i < count($claves); $i++) {
        echo "Posición '{$claves[$i]}' => Valor '{$valores[$i]}'<br>";
    }
}
