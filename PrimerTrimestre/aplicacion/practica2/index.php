<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación II:" => "/aplicacion/practica1/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("PRÁCTICA_2");
cabecera();
finCabecera();

inicioCuerpo("PRÁCTICA_2");
cuerpo();
finCuerpo();


// **********************************************************

function cabecera() {}

function cuerpo()
{
?>
    <h1>Relación 2: String</h1>
    <ul>
        <li> <a href="ejercicio1.php">Ejercicio 1</a></li>
        <li> <a href="ejercicio2.php">Ejercicio 2</a></li>
        <li> <a href="ejercicio3.php">Ejercicio 3</a></li>
        <li> <a href="ejercicio4.php">Ejercicio 4</a></li>
        <li> <a href="ejercicio5.php">Ejercicio 5</a></li>
    </ul>
<?php
}
