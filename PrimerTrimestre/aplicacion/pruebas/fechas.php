<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
    "Fechas" => "/aplicacion/pruebas/fechas.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// Dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo();
finCuerpo();

$hoy = time();
$cadena = date("/d/m/Y");
$cadena2 = date("/d/m/Y", +1);

$maniana = $hoy+24*60*60;
$cadena = date("/d/m/Y", $maniana);

$inicio=0;
$cadena=date("d/m/Y", $inicio);

$fecha=mktime(0,0,0,10,1,2025);
$cadena=date("d/m/Y", $fecha);


function cabecera() {}

function cuerpo(){

?>
    Estas en pruebas de sintaxis básica
<?php
   
}
?>