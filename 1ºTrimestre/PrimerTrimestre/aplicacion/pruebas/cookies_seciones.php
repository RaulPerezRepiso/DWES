<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

//Creación de Cookies
setcookie("informacion", "hoy es lunes".time(), time()+2*24*3600);
setcookie("informacion", false);

if(isset($_COOKIE["informacion"]))
        $informacino = $_COOKIE["informacion"];


session_start();

$_SESSION["teclado"] = "español";
$_SESSION["usado"] = false;



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

<?php

}
