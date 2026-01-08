<?php
echo "<br/>";

echo "Hola mundo.";
echo "<br/>";
echo "<br/>" . PHP_EOL;

echo "funciona que no es poco";

echo Sistema::app()->generaURL(["usuarios", "borrar"]);

echo CHTML::link("modificar Usuarios", ["usuarios", "modificar"]);
echo "<br>";
echo CHTML::link(
    "modificar Usuarios",
    Sistema::app()->generaURL(["usuarios", "modificar"], ["id" => 234])
);

echo "El número vale " . $n ." y la cadena es ". $c. $direccion;
