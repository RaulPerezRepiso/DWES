<?php

echo CHTML::dibujaEtiqueta("h1", [], "Contenido de \$array:", true);

echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Rellenar las posiciones 1, 16, 54 con valores cualquiera. ", true);

echo CHTML::dibujaEtiqueta("p", [], "El valor de la posición 1 es: {$array1[1]} ", true);
echo CHTML::dibujaEtiqueta("p", [], "El valor de la posición 16 es: {$array1[16]} ", true);
echo CHTML::dibujaEtiqueta("p", [], "El valor de la posición 54 es: {$array1[54]} ", true);



$array[] = 34;
$ultimoIndice = array_key_last($array1);
echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Añade el valor 34 al final. ", true);
echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "El valor de la última posición es: {$ultimoIndice} ", true);

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
