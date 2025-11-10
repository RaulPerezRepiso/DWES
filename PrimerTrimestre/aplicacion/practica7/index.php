<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación VII:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("PRÁCTICA-7");
cabecera();
finCabecera();

inicioCuerpo("PRÁCTICA_7");
cuerpo();
finCuerpo();


// **********************************************************

function cabecera() {}

function cuerpo()
{
?>
    <h1>Relación 7: Ficheros</h1>
<?php
}
