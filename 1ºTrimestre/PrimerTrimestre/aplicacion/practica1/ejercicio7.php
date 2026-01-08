<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación I:" => "./index.php",
    "Ejercicio 7" => "ejercicio7.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 7: Fechas");

// Usando la serie de funciones
$fechaActual = time();
$fechaActual_corta = date("d/m/Y", $fechaActual);
$fechaActual_larga = "día " . date("j", $fechaActual) .
    ", mes " . date("F", $fechaActual) .
    ", año " . date("Y", $fechaActual) .
    ", día de la semana " . date("l", $fechaActual);
$horaActual = date("H:i:s", $fechaActual);

// Usando la serie de funciones con una fecha fija
$fechaFija = strtotime("2024-03-29 12:45");
$fechaFija_corta = date("d/m/Y", $fechaFija);
$fechaFija_larga = "día " . date("j", $fechaFija) .
    ", mes " . date("F", $fechaFija) .
    ", año " . date("Y", $fechaFija) .
    ", día de la semana " . date("l", $fechaFija);
$horaFija = date("H:i:s", $fechaFija);

// Usando la serie de funciones con una fecha modificada
$fechaModificada = strtotime("-12 days -4 hours");
$fechaModificada_corta = date("d/m/Y", $fechaModificada);
$fechaModificada_larga = "día " . date("j", $fechaModificada) .
    ", mes " . date("F", $fechaModificada) .
    ", año " . date("Y", $fechaModificada) .
    ", día de la semana " . date("l", $fechaModificada);
$horaModificada = date("H:i:s", $fechaModificada);

// Usando DateTime
$fechaActualDT = new DateTime();
$fechaActualDT_corta = $fechaActualDT->format("d/m/Y");
$fechaActualDT_larga = "día " . $fechaActualDT->format("j") .
    ", mes " . $fechaActualDT->format("F") .
    ", año " . $fechaActualDT->format("Y") .
    ", día de la semana " . $fechaActualDT->format("l");
$horaActualDT = $fechaActualDT->format("H:i:s");

// Usando DateTime con una fecha fija
$fechaFijaDT = new DateTime("2024-03-29 12:45");
$fechaFijaDT_corta = $fechaFijaDT->format("d/m/Y");
$fechaFijaDT_larga = "día " . $fechaFijaDT->format("j") .
    ", mes " . $fechaFijaDT->format("F") .
    ", año " . $fechaFijaDT->format("Y") .
    ", día de la semana " . $fechaFijaDT->format("l");
$horaFijaDT = $fechaFijaDT->format("H:i:s");

// Usando DateTime con una fecha modificada
$fechaModificadaDT = new DateTime();
$fechaModificadaDT->modify("-12 days -4 hours");
$fechaModificadaDT_corta = $fechaModificadaDT->format("d/m/Y");
$fechaModificadaDT_larga = "día " . $fechaModificadaDT->format("j") .
    ", mes " . $fechaModificadaDT->format("F") .
    ", año " . $fechaModificadaDT->format("Y") .
    ", día de la semana " . $fechaModificadaDT->format("l");
$horaModificadaDT = $fechaModificadaDT->format("H:i:s");

// Arrays para mostrar en el cuerpo el contenido de todo
$arrayFunciones = [
    "Fecha actual (d/m/Y)" => $fechaActual_corta,
    "Fecha actual (larga)" => $fechaActual_larga,
    "Hora actual" => $horaActual,
    "Fecha fija (d/m/Y)" => $fechaFija_corta,
    "Fecha fija (larga)" => $fechaFija_larga,
    "Hora fija" => $horaFija,
    "Fecha modificada (d/m/Y)" => $fechaModificada_corta,
    "Fecha modificada (larga)" => $fechaModificada_larga,
    "Hora modificada" => $horaModificada
];

$arrayDateTime = [
    "Fecha actual (d/m/Y)" => $fechaActualDT_corta,
    "Fecha actual (larga)" => $fechaActualDT_larga,
    "Hora actual" => $horaActualDT,
    "Fecha fija (d/m/Y)" => $fechaFijaDT_corta,
    "Fecha fija (larga)" => $fechaFijaDT_larga,
    "Hora fija" => $horaFijaDT,
    "Fecha modificada (d/m/Y)" => $fechaModificadaDT_corta,
    "Fecha modificada (larga)" => $fechaModificadaDT_larga,
    "Hora modificada" => $horaModificadaDT
];

cuerpo($arrayFunciones, $arrayDateTime);
finCuerpo();

function cuerpo($arrayFunciones, $arrayDateTime)
{
    $cont = 0;
    echo "<h2>Usando la serie de funciones</h2>";
    echo "<strong>Usando la fecha actual con funciones:</strong><br>";
    foreach ($arrayFunciones as $clave => $valor) {
        echo " - {$clave}: {$valor}<br>";
        $cont++;
        if ($cont == 3) {
            echo "<br>";
            echo "<strong>Usando la fecha fija '29/3/2024 a 12:45' :</strong><br>";
        } elseif ($cont == 6) {
            echo "<br>";
            echo "<strong>Usando la fecha modificada (Actual -12 dias y 4 horas:</strong><br>";
        }
        $cont = 0;
    }

    echo "<br><h2>Usando la clase DateTime</h2>";
    echo "<strong>Usando la fecha actual con DateTime:</strong><br>";
    foreach ($arrayDateTime as $clave => $valor) {
        echo " - {$clave}: {$valor}<br>";
        $cont++;
        if ($cont == 3) {
            echo "<br>";
            echo "<strong>Usando la fecha fija '29/3/2024 a 12:45' :</strong><br>";
        } elseif ($cont == 6) {
            echo "<br>";
            echo "<strong>Usando la fecha modificada (Actual -12 dias y 4 horas:</strong><br>";
        }
    }
}
