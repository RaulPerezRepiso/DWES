<?php
include_once(dirname(__FILE__) . "/cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

// Dibuja la plantilla de la vista
inicioCabecera("2DAW APLICACIÓN");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo();
finCuerpo();



// **********************************************************

function cabecera() {}
//vista
function cuerpo()
{
?>
    <h1>Ejercicios</h1>
    <ul>
        <li><a href="/aplicacion/practica1/index.php">Relación I</a></li>
        <li><a href="/aplicacion/practica2/index.php">Relación II</a></li>
        <li><a href="/aplicacion/practica3/index.php">Relación III</a></li>
        <li><a href="/aplicacion/practica4/index.php">Relación IV</a></li>
        <li><a href="/aplicacion/practica5/index.php">Relación V</a></li>
    </ul>
    <h1>Pruebas</h1>
    <ul>
        <li><a href="/aplicacion/pruebas/index.php">Pruebas</a></li>
    </ul>
<?php
}
