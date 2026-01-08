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

inicioCuerpo("Ejercicio 1: Clase Abstracta");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{

    // Para clase pública
    /*   $instrumentoBase = new InstrumentoBase();
    $instrumentoBase2 = new InstrumentoBase("El viento", 12);

    echo $instrumentoBase;
    echo $instrumentoBase2;

    echo $instrumentoBase->envejecer() . "<br>";
    echo $instrumentoBase->afinar() . "<br>";
    echo $instrumentoBase->sonido() . "<br>"; */

}
