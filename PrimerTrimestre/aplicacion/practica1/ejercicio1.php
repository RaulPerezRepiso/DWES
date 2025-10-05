<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principa" => "../../index.php",
    "Relación I: arrays, fechas, librería math" => "./index.php",
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
    echo "<h1>Funciones Matemáticas</h1>";
    $numero = 7.65;
    echo "El numero es {$numero}<br/>";

    // Funciones matemáticas
    $redondeArriba = round($numero);
    echo "Primer redondeo a la alza. {$redondeArriba}<br/>";
    $redondeAbajo = floor($numero);
    echo "Primer redondeo a la baja. {$redondeAbajo}<br/>";
    $elevar = pow(2, 3);
    echo "El resultado de elevaro 2^3 es: {$elevar}<br/>";
    $raiz = sqrt(49);
    echo "El resultado de la raiz de 49 es: {$raiz}<br/>";
    $convertirDecimal = dechex(255);
    echo "Convertir 255 de Decimal a Hexadecimal es: {$convertirDecimal}<br/>";
    $baseConvert = base_convert('123', 4, 8);
    echo "El valor de: {$baseConvert}<br/>";
    $valorAbsoluto = abs(-15);
    echo "El valor absoluto de -15 es: {$valorAbsoluto}<br/>";
    $valorPi = pi();
    echo "El valor de PI es: {$valorPi}<br/>";

    echo "<h1>Variables en distintas bases</h1>";

    //Varibles en distintas bases
    $binario = 0b1011;
    echo "Binario de 0b1011 es: {$binario}<br>";
    $octal = 075;
    echo "Octal de 075 es: {$octal}<br>";
    $hexadecimal = 0x1F;
    echo "Hexadecimal de 0x1f es: {$hexadecimal}<br>";
}
