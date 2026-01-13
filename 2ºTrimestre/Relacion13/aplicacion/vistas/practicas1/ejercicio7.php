<?php


echo CHTML::dibujaEtiqueta("h2", [], "Usando la serie de funciones: ", true);
echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Usando la fecha actual con funciones: ", true);

foreach ($arrayFunciones as $clave => $valor) {
    echo CHTML::dibujaEtiqueta("p", [], " - {$clave}: {$valor} ", true);
    $cont++;
    if ($cont == 3) {
        echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Usando la fecha fija '29/3/2024 a 12:45' ", true);
    } elseif ($cont == 6) {
        echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Usando la fecha modificada (Actual -12 dias y 4 horas:' ", true);
    }
}
$cont = 0;
echo CHTML::dibujaEtiqueta("h2", [], "<br>Usando la clase DateTime: ", true);
echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Usando la fecha actual con DateTime: ", true);

foreach ($arrayDateTime as $clave => $valor) {
    echo CHTML::dibujaEtiqueta("p", [], " - {$clave}: {$valor} ", true);

    $cont++;
    if ($cont == 3) {
        echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Usando la fecha fija '29/3/2024 a 12:45' ", true);
    } elseif ($cont == 6) {
        echo CHTML::dibujaEtiqueta("p", ["style" => "font-weight: bold"], "Usando la fecha modificada (Actual -12 dias y 4 horas:' ", true);
    }
}
