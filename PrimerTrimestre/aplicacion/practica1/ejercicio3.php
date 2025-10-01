<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 3: Arrays");
cuerpo();

function cuerpo()
{
    //Crear una variable de tipo Array
    $array = [];
    echo "<strong>Variable de tipo Array creada '\$array'</strong><br><br>";

    echo "<strong>Rellenar las posiciones 1, 16, 54 con valores cualquiera. </strong><br>";
    // Rellenar las posiciones 1, 16, 54 con valores cualquiera.
    $array[1] = mt_rand(1, 100);
    echo "El valor de la posición 1 es: {$array[1]}<br>";
    $array[16] = mt_rand(1, 100);;
    echo "El valor de la posición 16 es: {$array[16]}<br>";
    $array[54] = mt_rand(1, 100);;
    echo "El valor de la posición 54 es: {$array[54]}<br><br>";

    $array[] = 34;
    $ultimoIndice = array_key_last($array);
    echo "<strong>Añadir el valor 34 al final </strong><br>";
    echo "El valor de la última posición es: {$array[$ultimoIndice]}<br><br>";

    echo "<strong>Añadir los valores “cadena”, true, 1.345 en las posiciones “uno”, “dos” y “tres”</strong> <br>";
    $array = [
        "uno" => "cadena",
        "dos" => true,
        "tres" => 1.345
    ];

    foreach ($array as $clave => $valor) {
        echo "Posición '{$clave}' => Valor '{$valor}'<br>";
    }

    $array["ultima"] = [1, 34, "nueva"];
    echo "<br><strong>Contenido de la posición 'ultima':</strong><br>";
    foreach ($array["ultima"] as $indice => $valor) {
        echo "Posicíon de '{$indice}': Valor '{$valor}'<br/>";
    }
}
