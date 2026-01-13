<?php
//Contenido del Primer Array

echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Rellenar las posiciones 1, 16, 54 con valores cualquiera. ", true);

echo CHTML::dibujaEtiqueta("p", [], "El valor de la posición 1 es: {$array1[1]} ", true);
echo CHTML::dibujaEtiqueta("p", [], "El valor de la posición 16 es: {$array1[16]} ", true);
echo CHTML::dibujaEtiqueta("p", [], "El valor de la posición 54 es: {$array1[54]} ", true);



$ultimaClave = array_key_last($array1);
$ultimoValor = $array1[$ultimaClave];
echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Añade el valor 34 al final. ", true);
echo CHTML::dibujaEtiqueta("p", [], "El valor de la última posición es: {$ultimoValor} ", true);


echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Añadir los valores “cadena”, true, 1.345 en las posiciones “uno”, “dos” y “tres”", true);

echo CHTML::dibujaEtiqueta("p", [], "Posición de \"uno\" '{$array1["uno"]}'<br>", true);
echo CHTML::dibujaEtiqueta("p", [], "Posición de \"dos\" '{$array1["dos"]}'<br>", true);
echo CHTML::dibujaEtiqueta("p", [], "Posición de \"tres\" '{$array1["tres"]}'<br>", true);


$array1["ultima"] = [1, 34, "nueva"];
echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Contenido de la posición 'ultima':, true, 1.345 en las posiciones “uno”, “dos” y “tres”", true);
foreach ($array1["ultima"] as $indice => $valor) {
    echo CHTML::dibujaEtiqueta("p", [], "Posicíon de '{$indice}': Valor '{$valor}'<br/>", true);
}

//Contenido del Segundo Array
echo CHTML::dibujaEtiqueta("h3", [], "<br>Contenido de \$array2: <br>", true);

foreach ($array2 as $clave => $valor) {
    if (is_array($valor)) {
        echo CHTML::dibujaEtiqueta("p", [], "Posición '{$clave}' contiene un array:<br>", true);

        foreach ($valor as $indice => $valor) {
            echo CHTML::dibujaEtiqueta("p", [], " - Índice {$indice}: Valor {$valor}<br>", true);
        }
    } else {
        echo CHTML::dibujaEtiqueta("p", [], "Posición '{$clave}' => Valor '{$valor}'<br>", true);
    }
}

//Contenido del Tercer Array
echo CHTML::dibujaEtiqueta("h3", [], "<br>Contenido de \$array3: <br>", true);

foreach ($array3 as $clave => $valor) {
    if (is_array($valor)) {
        echo CHTML::dibujaEtiqueta("p", [], "Posición '{$clave}' contiene un array:<br>", true);
        foreach ($valor as $indice => $valor) {
            echo CHTML::dibujaEtiqueta("p", [], " - Índice {$indice}: Valor {$valor}<br>", true);
        }
    } else {
        echo CHTML::dibujaEtiqueta("p", [], "Posición '{$clave}' => Valor '{$valor}'<br>", true);
    }
}

echo CHTML::dibujaEtiqueta("h3", [], "<br>Contenido de los 3 Arrays: <br>", true);

foreach ($arrayTodo as $nombre => $contenido) {
    echo "<strong>{$nombre}</strong><br>";
    foreach ($contenido as $clave => $valor) {
        if (is_array($valor)) {
            echo CHTML::dibujaEtiqueta("p", [], "Posición '{$clave}' contiene un array:<br>", true);
            foreach ($valor as $indice => $subvalor) {
                echo CHTML::dibujaEtiqueta("p", [], " - Índice {$indice}: Valor {$subvalor}<br>", true);
            }
        } else {
            echo CHTML::dibujaEtiqueta("p", [], "Posición '{$clave}' => Valor '{$valor}'<br>", true);
        }
    }
    echo "<br>";
}
