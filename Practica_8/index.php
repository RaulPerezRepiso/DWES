<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$ubicacion = [
    "Inicio" => "/index.php",
];

$cont = isset($_COOKIE["cont"]) ? $_COOKIE["cont"] : 0;
$cont++;
setcookie("cont", $cont);

//dibuja la plantilla de la vista
inicioCabecera("Práctica 8");
cabecera();
finCabecera();
inicioCuerpo("Práctica 8");
cuerpo($cont);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo($cont)
{
    if ($cont < 2) {
        echo "<h2>Has iniciado sesión: $cont vez</h2>";
    }else
    echo "<h2>Has iniciado sesión: $cont veces</h2>";
?>
    <h1>Ver Texto</h1>
    <ul>
        <li><a href="/aplicacion/texto/verTextos.php">Texto</a></li>
    </ul>
    <h1>Personalizar</h1>
    <ul>
        <li><a href="/aplicacion/personalizar/personalizar.php">Personalizar</a></li>
    </ul>
<?php

}
