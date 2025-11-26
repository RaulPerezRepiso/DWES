<?php
define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO == "produccion")
    error_reporting(0);
else
    error_reporting(E_ALL);




// Autoload 1: scripts/clases 
spl_autoload_register(function ($clase) {
    $ruta = RUTABASE . "/scripts/clases/";
    $fichero = $ruta . "$clase.php";

    if (file_exists($fichero)) {
        require_once($fichero);
    }
});

// Autoload 2: aplicacion/clases 
spl_autoload_register(function ($clase) {
    $ruta = RUTABASE . "/aplicacion/clases/";
    $fichero = $ruta . "$clase.php";

    if (file_exists($fichero)) {
        require_once($fichero);
    }
});

include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
include(RUTABASE . "/aplicacion/config/acceso_bd.php");

//Gestion BD
mysqli_report(MYSQLI_REPORT_ERROR);

// Iniciar la sesión
session_start();

// Crear objetos globales de ACL y Acceso para controlar que esten en cualquier página
$acl = new ACLArray();
$acceso = new Acceso();

//Declaración de constantes para colores de texto y de fondo
const COLORESTEXTO = ["negro", "azul", "blanco", "rojo"];
const COLORESDEFONDO = ["blanco", "rojo", "verde", "azul", "cyan"];
