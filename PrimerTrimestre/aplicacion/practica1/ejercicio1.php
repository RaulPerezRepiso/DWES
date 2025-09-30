<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 1: Funciones Matemáticas");
cuerpo();

function cuerpo()
{
    // Número base para funciones
    $numero = 7.65;

    $redondeArriba = round($numero);
    $redondeAbajo = floor($numero);
    $elevar = pow(2, 3);
    $raiz = sqrt(49);
    $convertirDecimal = dechex(255);
    $baseConvert = base_convert('123', 4, 8);
    $valorAbsoluto = abs(-15);
    $valorPi = pi();

       // Variables en distintas bases
    $binario = 0b1011;      // binario (11 en decimal)
    $octal = 075;           // octal (61 en decimal)
    $hexadecimal = 0x1F;    // hexadecimal (31 en decimal)
?>
    <h2>Funcionamiento de las Funciones matemáticas</h2>
    <ul>
        <li>Valor Redondeado Arriba de <?=$numero?> es: <?= $redondeArriba?></li>
        <li>Valor Redondeado Abajo de <?=$numero?> es: <?= $redondeAbajo?></li>
        <li>Valor De elevar  $elevar = pow(2, 3) es: <?= $elevar?></li>
        <li>Valor de la raiz de $raiz = sqrt(49) es: <?= $raiz?></li>
        <li>Valor de convertir a decimal $convertirDecimal = dechex(255) es: <?= $convertirDecimal?></li>
        <li>Valor de convertir nuermo a base $baseConvert = base_convert('123', 4, 8) es: <?= $baseConvert?></li>
        <li>Valor absoluto de  $valorAbsoluto = abs(-15) es: <?= $valorAbsoluto?></li>
        <li>Valor de PI de  $valorPi = pi() <?= $valorPi?></li>
    </ul>
    <h2>Variables en distintas bases</h2>
    <ul>
        <li>Binario <code>0b1011</code> = <?= $binario ?> (decimal)</li>
        <li>Octal <code>075</code> = <?= $octal ?> (decimal)</li>
        <li>Hexadecimal <code>0x1F</code> = <?= $hexadecimal ?> (decimal)</li>
    </ul>
<?php
}
?>