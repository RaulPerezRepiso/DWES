<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principa" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 1" => "ejercicio1.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");
cabecera();
finCabecera();

inicioCuerpo("Ejercicio 1: Funciones Matemáticas");
cuerpo();
finCuerpo();

function cabecera()
{
}

function cuerpo()
{

}
