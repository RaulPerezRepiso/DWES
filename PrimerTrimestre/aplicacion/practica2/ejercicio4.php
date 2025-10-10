<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 4" => "ejercicio4.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

$num1 = 17.5;
$num2 = 379987.24;

// Formateo con number_format
$formateado1 = number_format($num1, 1, ',', '.'); // "17,50"
$formateado2 = number_format($num2, 2, ',', '.'); // "379.987,24"

// Ajuste a 15 caracteres con relleno
$valor1_final = str_pad($formateado1, 15, '0', STR_PAD_LEFT);
$valor2_final = str_pad($formateado2, 15, ' ', STR_PAD_RIGHT);


inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 4: Array de valores");

cuerpo($valor1_final, $valor2_final);
finCuerpo();

function cuerpo($valor1_final, $valor2_final)
{
?>
    <h2>Números mostrados con 15 caracteres totales</h2>
 
    <h3>Primer valor con 0</h3>
    <?= "<pre>$valor1_final</pre>"; ?>

    <h3>Segundo valor con espacios</h3>
    <?= "<pre>$valor2_final</pre>"; ?>

    
<?php
}
