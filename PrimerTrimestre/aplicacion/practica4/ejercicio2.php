<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include("libreria.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 2" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;
inicioCabecera("EJERCICO_2");

inicioCuerpo("Ejercicio 2: Función generarCadena()");


cuerpo();
finCuerpo();
?>

<?php
function cuerpo()
{

}
