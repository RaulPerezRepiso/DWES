<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación IV:" => "./index.php",
    "Ejercicio 5" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 5: Función hacerOperacion()");


cuerpo();
finCuerpo();
function cuerpo()
{
    // Obtener todos los casos posibles del enum EstadoCivil
    $estados = EstadoCivil::cases();

    // Seleccionar uno aleatoriamente
    $estadoAleatorio = $estados[array_rand($estados)];

    // Mostrarlo llamando a registrarPersona dandole parámetros para todo y el estado aleatorio
    $obj = Persona::registrarPersona("Pepe", "12/07/2002", "Calle fuente albilla", "Antequera", $estadoAleatorio);
    echo $obj;

}
