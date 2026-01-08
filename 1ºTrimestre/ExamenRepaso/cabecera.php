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

include(RUTABASE . "/aplicacion/plantilla/plantilla.php");
// include(RUTABASE . "/aplicacion/config/acceso_bd.php");

session_start();

// Si no existe el array en sesión, lo inicializamos
if (!isset($_SESSION['PRO'])) {
    $_SESSION['PRO'] = [];

    try {
        // Crear primer proyecto (tipo Proyecto)
        $p1 = new Proyecto("Sistema Web", "EmpresaX", 10);
        $p1->aniadeOtras("importe_presupuestado", 15000, "provincia", "Málaga", "descripcion", "Proyecto inicial");
        $_SESSION['PRO'][] = $p1;

        // Crear segundo proyecto (tipo Proyecto_Admin)
        $p2 = new Proyecto_Admin("Gestión Hardware", "EmpresaY", 20, "2025/00001");
        $p2->aniadeOtras("importe_presupuestado", 25000, "provincia", "Sevilla", "descripcion", "Proyecto administración");
        $_SESSION['PRO'][] = $p2;

    } catch (Exception $e) {
        error_log("Error creando proyecto: " . $e->getMessage());
    }
}

// Alias para trabajar más fácil
$PRO = &$_SESSION['PRO'];
