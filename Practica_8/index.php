<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

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
    <h1>Ver Texto</h1>
    <ul>
        <li><a href="/aplicacion/texto/verTextos.php">Texto</a></li>
    </ul>
<?php

}
