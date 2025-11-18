<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$ubicacion = [
    "Inicio" => "/index.php",
    "Ver Texto" => "#",
];


//dibuja la plantilla de la vista
inicioCabecera("Práctica 8");
cabecera();
finCabecera();
inicioCuerpo("Práctica 8");
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo()
{
?>
    <p>Estas en el Texto</p>
<?php

}
