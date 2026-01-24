<?php

// Iniciamos el FORM
echo CHTML::iniciarForm();
echo CHTML::modeloLabel($modelo, "nick") . PHP_EOL;
echo CHTML::modeloText($modelo, "nick", array("maxlength" => 40, "size" => 40));
echo CHTML::modeloError($modelo, "nick");
echo "<br>";

echo CHTML::modeloLabel($modelo, "nif") . PHP_EOL;
echo CHTML::modeloText($modelo, "nif", array("maxlength" => 10, "size" => 10));
echo CHTML::modeloError($modelo, "nif");
echo "<br>";

echo CHTML::modeloLabel($modelo, "fecha_nacimiento") . PHP_EOL;
echo CHTML::modeloDate($modelo, "fecha_nacimiento", array("maxlength" => 30, "size" => 30));
echo CHTML::modeloError($modelo, "fecha_nacimiento");
echo "<br>";

echo CHTML::modeloLabel($modelo, "provincia") . PHP_EOL;
echo CHTML::modeloText($modelo, "provincia", array("maxlength" => 30, "size" => 30));
echo CHTML::modeloError($modelo, "provincia");
echo "<br>";


echo CHTML::modeloLabel($modelo, "estado") . PHP_EOL;
echo CHTML::modeloNumber($modelo, "estado");
echo CHTML::modeloError($modelo, "estado");
echo "<br>";

echo CHTML::modeloLabel($modelo, "contrasenia") . PHP_EOL;
echo CHTML::modeloPassword($modelo, "contrasenia", array("maxlength" => 30, "size" => 30));
echo CHTML::modeloError($modelo, "contrasenia");
echo "<br>";

echo CHTML::modeloLabel($modelo, "confirmar_contrasenia") . PHP_EOL;
echo CHTML::modeloPassword($modelo, "confirmar_contrasenia", array("maxlength" => 30, "size" => 30));
echo CHTML::modeloError($modelo, "confirmar_contrasenia");
echo "<br>";
echo CHTML::campoBotonSubmit("Registrar");
echo CHTML::finalizarForm();
