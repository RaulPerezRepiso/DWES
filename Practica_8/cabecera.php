<?php
define("RUTABASE", dirname(__FILE__));
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

// Crear objetos globales para cargar usuraios y contreseña de la BD.
$aclbd = new ACLBD($servidor, $usuario, $contrasenia, $baseDatos);

$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
if ($bd->connect_error) {
    die("Error de conexión: " . $bd->connect_error);
}
$bd->set_charset("utf8");

//Declaración de constantes para colores de texto y de fondo
const COLORESTEXTO = ["negro", "azul", "blanco", "rojo"];
const COLORESDEFONDO = ["blanco", "rojo", "verde", "azul", "cyan"];

// --- Crear roles iniciales si no existen ---
$roles = $aclbd->dameRoles();

if (!in_array("administradores", $roles)) {
    $aclbd->anadirRole("administradores", [1 => true, 2 => true]);
}
if (!in_array("normales", $roles)) {
    $aclbd->anadirRole("normales", [1 => true]);
}
if (!in_array("superadmins", $roles)) {
    $aclbd->anadirRole("superadmins", [1 => true, 2 => true, 3 => true]);
}

// --- Crear usuario inicial si no existe ---
$usuarios = $aclbd->dameUsuarios();
if (!in_array("raul", $usuarios)) {
    // Insertar en ACLBD → nick y nombre básicos
    $aclbd->anadirUsuario(
        "Raúl Pérez",
        "raul",
        "1234",
        $aclbd->getCodRole("superadmins")
    );

    // Comprobar si ya existe en la tabla usuarios ANTES de insertar
    $nick = "raul";
    $check = $bd->prepare("SELECT COUNT(*) FROM usuarios WHERE nick = ?");
    $check->bind_param("s", $nick);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count == 0) {
        $sentencia = "INSERT INTO usuarios 
            (nick, nombre, nif, direccion, poblacion, provincia, cp, fecha_nacimiento, borrado, foto)
            VALUES (
                'raul', 
                'Raúl Pérez',
                '12345678Z',
                'Calle Infante Don Fernando, 25',
                'Antequera',
                'Málaga',
                '29200',
                '2000-05-15',
                0,
                'raul.png'
            )";
        $bd->query($sentencia);
    }
}
