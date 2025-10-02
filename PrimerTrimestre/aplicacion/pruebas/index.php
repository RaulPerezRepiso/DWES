<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("PRUEBAS");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
?>
    <a href="sintaxisBasica.php">Sintaxis Básica</a><br>
    <a href="arrays.php">Arrays</a><br>
    <a href="arrays.php">Fechas</a><br>
<?php

}
