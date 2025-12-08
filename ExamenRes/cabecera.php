<?php

define("RUTABASE", dirname(__FILE__));
//define("MODO_TRABAJO","produccion"); //en "produccion o en desarrollo
define("MODO_TRABAJO", "desarrollo"); //en "produccion o en desarrollo

if (MODO_TRABAJO == "produccion")
    error_reporting(0);
else
    error_reporting(E_ALL);

spl_autoload_register(function ($clase) {
    $ruta = RUTABASE . "/scripts/clases/";
    $rutaExamen = RUTABASE . "/scripts/examen/";

    $fichero = $ruta . "$clase.php";
    $ficheroExamen = $rutaExamen . "$clase.php";

    if (file_exists($fichero)) {
        require_once($fichero);
    } else if (file_exists($ficheroExamen)) {
        require_once($ficheroExamen);
    } else {
        throw new Exception("La clase $clase no se ha encontrado.");
    }
});

require_once(RUTABASE . "/aplicacion/plantilla/plantilla.php");

// creación de la sesión después de las cargas de archivos
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$PRO = [];

// Ajuste de llamadas a constructores
$pro1 = new Proyecto("proyecto1", "empresa1", 10);
$pro2 = new Proyecto_Admin("proyectoAdmin1", "empresaAdmin1", 20, "1111/11111");

$nprop = 0;
$pro1->aniadeOtras("adicional1", "valor1", $nprop, "importe1", "2", "importe2", "3");
$pro2->aniadeOtras("adicional2", "valor1", $nprop, "importe3", "2", "importe4", "3");

// array global con los proyectos
if (!isset($_SESSION["PRO"])) {
    $PRO = [$pro1, $pro2];
    $_SESSION["PRO"] = $PRO;
}

if (!isset($_COOKIE["contador"])) {
    setcookie("contador", 0, time() + 60 * 60 * 24 * 365); // Contamos el número de veces que el usuario inicia sesión en la página
}

$PRO = $_SESSION["PRO"];

/**
 * Sesión
 */
// recoge datos de la sesión
$acceso = new Acceso();

// inicializamos el ACL
$acl = new ACLArray();
