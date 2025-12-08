<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$ubicacion = [
    "Index Principal" => "/index.php",
];

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($ubicacion);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo()
{
?>
    <li><a href="/aplicacion/ejemplo/index.php">Index</a></li>
<?php

}
