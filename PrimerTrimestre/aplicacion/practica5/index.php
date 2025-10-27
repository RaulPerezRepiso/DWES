<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/Users/2daw/DWES/PrimerTrimestre/scripts/librerias/validacion.php");
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
    <h1>Relación 5: Introducción de información.</h1>
<?php
    $var = 1;
    $resultado = validaEntero($var, 5, 7, 7);

    echo "Resultado: " . ($resultado ? "válido" : "inválido") . "<br>";
    echo "Valor final: $var";
}
