<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 1" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");
cabecera();
finCabecera();

inicioCuerpo("Ejercicio 1: Función cuentaVeces()");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{
   $instrumentoBase = new InstrumentoBase();
   echo $instrumentoBase;

}
