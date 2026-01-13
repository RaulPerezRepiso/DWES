<?php

// Si es un array, lo recorremos
if (is_array($valor)) {
    echo CHTML::dibujaEtiqueta("p", [], "Posición '{$indice}' contiene un array:<br> ", true);

    foreach ($valor as $i => $v) {
        echo CHTML::dibujaEtiqueta("p", [], " - Índice {$i}: ", false);

        switch (true) {
            case is_int($v):
                echo CHTML::dibujaEtiqueta("label", [], "Valor entero bonito '{$v}' en binario " . decbin($v)."<br>", true);
                break;

            case is_float($v):
                echo CHTML::dibujaEtiqueta("label", [], "Valor real '{$v}' que al cuadrado es " . round($v * $v, 2)."<br>", true);
                break;

            case is_string($v):
                echo CHTML::dibujaEtiqueta("label", [], "Valor cadena -{$v}-"."<br>", true);
                break;

            case is_bool($v):
                $boolean = $v ? 'true' : 'false';
                $opuesto = !$v ? 'true' : 'false';
                echo CHTML::dibujaEtiqueta("p", [], "Posición '{$indice}': Valor booleano '{$boolean}' y su opuesto '{$opuesto}'<br>", true);
                break;

            default:
                echo CHTML::dibujaEtiqueta("p", [], "Valor '{$v}'<br>", true);
        }
    }

    echo "<br>";
    return;
}

// Si NO es array, lo tratamos directamente
switch (true) {
    case is_int($valor):
        echo CHTML::dibujaEtiqueta("label", [], "Posición '{$indice}': Valor entero bonito '{$valor}' en binario " . decbin($valor) . "<br>", true);
        break;

    case is_float($valor):
        echo CHTML::dibujaEtiqueta("label", [], "Posición '{$indice}': Valor real '{$valor}' que al cuadrado es " . round($valor * $valor, 2) . "<br>", true);
        break;

    case is_string($valor):
        echo CHTML::dibujaEtiqueta("label", [], "Posición '{$indice}': Valor cadena -{$valor}-<br>", true);
        break;

    case is_bool($valor):
        $boolean = $valor ? 'true' : 'false';
        $opuesto = !$valor ? 'true' : 'false';
        echo CHTML::dibujaEtiqueta("label", [], "Posición '{$indice}': Valor booleano '{$boolean}' y su opuesto '{$opuesto}'<br>", true);
        break;

    default:
        echo CHTML::dibujaEtiqueta("label", [], "Posición '{$indice}': Valor '{$valor}'<br>", true);
}
