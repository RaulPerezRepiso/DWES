<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 1" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

// Coma
$c1 = ",";
$c2 = ',';

// HEREDOC
$textoC1 = <<<fin1
$c1 <br />
fin1;

// NOWDOC
$textoC2 = <<<'fin2'
$c1 <br />
fin2;

// A con tilde
$a1 = "á";
$a2 = 'á';

// HEREDOC 
$textoA1 = <<<fin1
$a1 <br />
fin1;

// NOWDOC 
$textoA2 = <<<'fin2'
$a1 <br />
fin2;

// E con tilde
$e1 = "é";
$e2 = 'é';

// HEREDOC 
$textoE1 = <<<fin1
$e1 <br />
fin1;

// NOWDOC
$textoE2 = <<<'fin2'
$e1 <br />
fin2;

// Ñ
$n1 = "ñ";
$n2 = 'ñ';

// HEREDOC 
$textoN1 = <<<fin1
$n1 <br />
fin1;

// NOWDOC 
$textoN2 = <<<'fin2'
$n1 <br />
fin2;

// Array con todo las variables declaradas para usarlas en el cuerpo
$array = [
    'coma' => [
        'c1' => $c1,
        'c2' => $c2,
        'heredoc' => $textoC1,
        'nowdoc' => $textoC2
    ],
    'a' => [
        'a1' => $a1,
        'a2' => $a2,
        'heredoc' => $textoA1,
        'nowdoc' => $textoA2
    ],
    'e' => [
        'e1' => $e1,
        'e2' => $e2,
        'e4' => $e4,
        'heredoc' => $textoE1,
        'nowdoc' => $textoE2
    ],
    'n' => [
        'n1' => $n1,
        'n2' => $n2,
        'heredoc' => $textoN1,
        'nowdoc' => $textoN2
    ]
];

inicioCabecera("EJERCICO_1");
cabecera();
finCabecera();

inicioCuerpo("Ejercicio 1: Formas para Candeas");
cuerpo($array);
finCuerpo();

function cabecera() {}

function cuerpo($array)
{
?>
    <div>
        <p>Valor de $c1: <strong><?= $array['coma']['c1'] ?></strong></p>
        <p>Valor de $c2: <strong><?= $array['coma']['c2'] ?></strong></p>
        <p>Contenido generado con HEREDOC: <strong><?= $array['coma']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['coma']['nowdoc'] ?></strong></p>
    </div><br />

    <div>
        <p>Valor de $a1: <strong><?= $array['a']['a1'] ?></strong></p>
        <p>Valor de $a2: <strong><?= $array['a']['a2'] ?></strong></p>
        <p>Contenido generado con HEREDOC: <strong><?= $array['a']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['a']['nowdoc'] ?></strong></p>
    </div><br />

    <div>
        <p>Valor de $e1: <strong><?= $array['e']['e1'] ?></strong></p>
        <p>Valor de $e2: <strong><?= $array['e']['e2'] ?></strong></p>
        <p>Contenido generado con HEREDOC: <strong><?= $array['e']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['e']['nowdoc'] ?></strong></p>
    </div><br />

    <div>
        <p>Valor de $n1: <strong><?= $array['n']['n1'] ?></strong></p>
        <p>Valor de $n2: <strong><?= $array['n']['n2'] ?></strong></p>
        <p>Contenido generado con HEREDOC: <strong><?= $array['n']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['n']['nowdoc'] ?></strong></p>
    </div>
<?php

}
