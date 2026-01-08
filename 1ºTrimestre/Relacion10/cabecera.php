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
    $fichero = $ruta . "$clase.php";

    if (file_exists($fichero)) {
        require_once($fichero);
    } else {
        throw new Exception("La clase $clase no se ha encontrado.");
    }
});

// =============== CONEXIÓN A BASE DE DATOS ===================
include(RUTABASE . "/config/acceso_bd.php");

// Incluimos la libreria de validación
include_once(RUTABASE . "/scripts/librerias/validacion.php");

// Gestión de errores de MySQLi 
mysqli_report(MYSQLI_REPORT_ERROR);

// Inicar la sesion
session_start();

// Acceso (Gestiona el Inicio de Sesión)
$acceso = new Acceso();

// ACLBD (Gestiona login y permisos desde BD)
$aclbd = new ACLBD($servidor, $usuario, $contrasenia, $baseDatos);

// =============== PLANTILLA GLOBAL ===========================
include(RUTABASE . "/aplicacion/plantilla/plantilla.php");

