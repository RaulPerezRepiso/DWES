<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Dibuja la plantilla de la vista
inicioCabecera("APLICACION PRUEBA");
cabecera();
finCabecera();

inicioCuerpo("APLICACION PRUEBA");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
?>
    <a href="sintaxisBasica.php">Sintaxis Básica</a>
<?php

}
