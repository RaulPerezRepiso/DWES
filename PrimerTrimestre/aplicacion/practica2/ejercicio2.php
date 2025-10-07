<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 2" => "ejercicio2.php"
];
$GLOBALS['ubicacion'] = $ubicacion;
inicioCabecera("EJERCICO_2");

inicioCuerpo("Ejercicio 2: Lanzamiento de un dado");

$cadena = "Está la niña en casa";
$array = str_split($cadena, 1);

foreach($array as $valor){
    echo $valor;
}


cuerpo();
finCuerpo();
?>

<?php
function cuerpo()
{
    
}

