<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
    "Fechas" => "/aplicacion/pruebas/fechas.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// **********************************************************
$hoy = time();
$cadena = date("/d/m/Y");
$cadena2 = date("/d/m/Y", +1);

$maniana = $hoy + 24 * 60 * 60;
$cadena = date("/d/m/Y", $maniana);

$inicio = 0;
$cadena = date("d/m/Y", $inicio);

$fecha = mktime(0, 0, 0, 10, 1, 2025);
$cadena = date("d/m/Y", $fecha);

// Variables corregidas para mostrar en cuerpo()
$cadena1 = date("d/m/Y", $hoy);
$cadena2 = date("d/m/Y", $maniana);
$cadena3 = date("d/m/Y", $inicio);
$cadena4 = date("d/m/Y", $fecha);

// Dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{
    global $cadena1, $cadena2, $cadena3, $cadena4;
?>
    Estas en pruebas de sintaxis básica<br>
    Hoy: <?= $cadena1 ?><br>
    Mañana: <?= $cadena2 ?><br>
    Inicio (timestamp 0): <?= $cadena3 ?><br>
    Fecha específica: <?= $cadena4 ?><br>
<?php
}
?>
