<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principa" => "../../index.php",
    "Relación III:" => "./index.php",
    "Ejercicio 1" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");
cabecera();
finCabecera();

inicioCuerpo("Ejercicio 1: Función cuentaVeces()");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{
    // Aquí defines el array y el contador
    $array = [];
    $num2 = 0;

    // Veces que hemos llamado al método
    cuantasVeces($array, "clave1", 7, $num2);
    cuantasVeces($array, "daw", 12, $num2);
    cuantasVeces($array, "123adw", 73, $num2);
    cuantasVeces($array, "dwa", 4, $num2);
    cuantasVeces($array, "121", 123, $num2);

    // Muestras los resultados
    echo "<pre>";
    print_r($array);
    echo "Número de llamadas: $num2";
    echo "</pre>";
}
