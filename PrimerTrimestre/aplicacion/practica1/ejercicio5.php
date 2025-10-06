<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación I:" => "./index.php",
    "Ejercicio 5" => "ejercicio5.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 5: Rellenar Array con un contenido definido");

//Contenido del array
$vector = array();
$vector[1] = "esto es una cadena";
$vector["posi1"] = 25.67;
$vector[] = false;
$vector["ultima"] = array(2, 5, 96);
$vector[56] = 23;

cuerpo($vector);
finCuerpo();
function cuerpo($vector)
{

    echo "<h3>Contenido del array \$vector</h3><br>";

    foreach ($vector as $indice => $valor) {
        if (is_array($valor)) {
            echo "Posición '{$indice}' contiene un array:<br>";
            foreach ($valor as $i => $v) {
                echo " - Índice {$i}: ";
                if (is_int($v)) {
                    echo "Valor entero bonito '{$v}' en binario " . decbin($v) . "<br>";
                } elseif (is_float($v)) {
                    echo "Valor real '{$v}' que al cuadrado es " . round($v * $v, 2) . "<br>";
                } elseif (is_string($v)) {
                    echo "Valor cadena -{$v}-<br>";
                } elseif (is_bool($v)) {
                    $boolean = $v ? 'true' : 'false';
                    $opuesto = !$v ? 'true' : 'false';
                    echo "Valor booleano '{$boolean}' y su opuesto '{$opuesto}'<br>";
                } else {
                    echo "Valor '{$v}'<br>";
                }
            }
        } elseif (is_int($valor)) {
            echo "Posición '{$indice}': Valor entero bonito '{$valor}' en binario " . decbin($valor) . "<br>";
        } elseif (is_float($valor)) {
            echo "Posición '{$indice}': Valor real '{$valor}' que al cuadrado es " . round($valor * $valor, 2) . "<br>";
        } elseif (is_string($valor)) {
            echo "Posición '{$indice}': Valor cadena -{$valor}-<br>";
        } elseif (is_bool($valor)) {
            $boolean = $valor ? 'true' : 'false';
            $opuesto = !$valor ? 'true' : 'false';
            echo "Posición '{$indice}': Valor booleano '{$boolean}' y su opuesto '{$opuesto}'<br>";
        } else {
            echo "Posición '{$indice}': Valor '{$valor}'<br>";
        }
    }
}
