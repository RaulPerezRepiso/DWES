<?php
echo CHTML::iniciarForm("registro", "Login");

echo CHTML::modeloLabel($modelo, "nick") . PHP_EOL;
echo CHTML::modeloText($modelo, "nick");
echo CHTML::modeloError($modelo, "nick");
echo "<br>";

echo CHTML::modeloLabel($modelo, "contrasenia") . PHP_EOL;
echo CHTML::modeloPassword($modelo, "contrasenia");
echo CHTML::modeloError($modelo, "contrasenia");
echo "<br>";

echo CHTML::campoBotonSubmit("Entrar");
echo CHTML::finalizarForm();
