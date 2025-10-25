<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 7" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 7: Función ordenar()");


cuerpo();
finCuerpo();
function cuerpo()
{
    $Objeto = new ClaseMisPropiedades();
    $Objeto->propPublica = "publica";
    $Objeto->_propPrivada="privada"; //no es valida al ser privada 
    $Objeto->propiedad1 = 25;
    $Objeto->propiedad2 = "cadena de texto";
    echo "La propiedad 1 vale " . $Objeto->propiedad1 . "<br>";
    echo "La propiedad 2 vale " . $Objeto->propiedad2 . "<br>";
    echo $Objeto->propiedad3; // esto debería dar un error al no haber asignado previamente la propiedad
}
