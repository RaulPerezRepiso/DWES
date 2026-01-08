<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación I:" => "./index.php",
    "Ejercicio 3" => "ejercicio3.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 3: Arrays");


//Crear una variable de tipo Array y la rellenamos a mano
$array = [];
$array1[1] = mt_rand(1, 100);
$array1[16] = mt_rand(1, 100);
$array1[54] = mt_rand(1, 100);
$array1[] = 34;
$array1["uno"] = "cadena";
$array1["dos"] = true;
$array1["tres"] = 1.345;
$array1["ultima"] = [1, 34, "nueva"];

// Usando una sola sentencia con array 
$array2 = array(
    1 => mt_rand(1, 100),
    16 => mt_rand(1, 100),
    54 => mt_rand(1, 100),
    "uno" => "cadena",
    "dos" => true,
    "tres" => 1.345,
    "ultima" => array(1, 34, "nueva")
);

// Usando una sola sentencia con []
$array3 = [
    1 => mt_rand(1, 100),
    16 => mt_rand(1, 100),
    54 => mt_rand(1, 100),
    "uno" => "cadena",
    "dos" => true,
    "tres" => 1.345,
    "ultima" => [1, 34, "nueva"]
];

// Array que contiene los 3 arrays
$arrayTodo = [
    "Array1" => $array1,
    "Array2" => $array2,
    "Array3" => $array3
];

cuerpo($array, $array2, $array3, $arrayTodo);
finCuerpo();

function cuerpo($array, $array2, $array3, $arrayTodo)
{
    echo "<h3>Contenido de \$array</h3>";

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

    echo "<h3>Contenido de \$array2</h3>";

    foreach ($array2 as $clave => $valor) {
        if (is_array($valor)) {
            echo "Posición '{$clave}' contiene un array:<br>";
            foreach ($valor as $indice => $valor) {
                echo " - Índice {$indice}: Valor {$valor}<br>";
            }
        } else {
            echo "Posición '{$clave}' => Valor '{$valor}'<br>";
        }
    }

    echo "<h3>Contenido de \$array3</h3>";


    foreach ($array3 as $clave => $valor) {
        if (is_array($valor)) {
            echo "Posición '{$clave}' contiene un array:<br>";
            foreach ($valor as $indice => $valor) {
                echo " - Índice {$indice}: Valor {$valor}<br>";
            }
        } else {
            echo "Posición '{$clave}' => Valor '{$valor}'<br>";
        }
    }

    echo "<h3>Contenido de los 3 Arrays</h3>";

    foreach ($arrayTodo as $nombre => $contenido) {
        echo "<strong>{$nombre}</strong><br>";
        foreach ($contenido as $clave => $valor) {
            if (is_array($valor)) {
                echo "Posición '{$clave}' contiene un array:<br>";
                foreach ($valor as $indice => $subvalor) {
                    echo " - Índice {$indice}: Valor {$subvalor}<br>";
                }
            } else {
                echo "Posición '{$clave}' => Valor '{$valor}'<br>";
            }
        }
        echo "<br>";
    }
}
