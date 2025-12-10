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
    $rutaExamen = RUTABASE . "/scripts/diciembre/";

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
include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
// include(RUTABASE . "/aplicacion/config/acceso_bd.php");

// session_start();

// Si no existe el array en sesión, lo inicializamos
/* if (!isset($_SESSION['COLECCIONES'])) {
    $_SESSION['COLECCIONES'] = [];

    
        // Crear primera Coleccion con 3 libros y 2 propiedades
        $c1 = new Coleccion("Patata", "11/27/2025", 10);
        $c1->aniadirLibros("Francisco", "Paco", "F1", "P1");
        $c1->aniadirLibros("Más alla", "Alberto", "A1", "A1");
        $c1->aniadirLibros("Puede", "Ramon", "D1", "D1");
        $_SESSION['COLECCIONES'][] = $c1;

        // Crear segunda Coleccion con 3 libros y 2 propiedades
        $c2 = new Coleccion("Pepa", "9/15/2027", 20);
        $c2->aniadirLibros("Francisco2", "Paco2", "F2", "P2");
        $c2->aniadirLibros("Más alla2", "Alberto2", "A2", "A2");
        $c2->aniadirLibros("Puede2", "Ramon2", "D2", "D2");
        $_SESSION['COLECCIONES'][] = $c2;
   
}

// Alias para trabajar más fácil
$COLECCIONES = &$_SESSION['COLECCIONES'];

$acceso = new Acceso(); */

session_start();

$c1 = new Coleccion("Antonio", "21/7/2007",  40);
$c2 = new Coleccion("Mario", "11/9/1995", 10);

//array global con los beneficiarios
if (!isset($_SESSION["COLECCIONES"])) {

    $COLECCIONES = [
        $c1,
        $c2,
    ];

    $_SESSION["COLECCIONES"] = $COLECCIONES;
}

$COLECCIONES = $_SESSION["COLECCIONES"];

//recoge datos de la sesion
$acceso = new Acceso();
