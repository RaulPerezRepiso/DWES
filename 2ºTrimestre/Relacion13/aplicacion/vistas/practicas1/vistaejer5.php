<?php
echo CHTML::dibujaEtiqueta("h1", [], "Ejercicio 5", true);
foreach ($vector as $indice => $valor) {
    // Llamamos a la vista parcial y le pasamos los datos
    include "vistaejer5-parte.php";
}
