<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación V:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("PRÁCTICA_5");
cabecera();
finCabecera();

inicioCuerpo("PRÁCTICA_5");
cuerpo();
finCuerpo();


// **********************************************************

function cabecera() {}

function cuerpo()
{
?>
    <h1>Relación 2: </h1>
    <ul>
        <li> <a href="ejercicio1.php">Ejercicio 1</a></li>
        <li> <a href="ejercicio2.php">Ejercicio 2</a></li>
    </ul>
<?php
}
