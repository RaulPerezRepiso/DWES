<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 1" => "ejercicio1.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// Coma
$c1 = ",";
$c2 = ',';
$c3 = ",";

// HEREDOC (interpolación activa)
$textoC1 = <<<fin1
$c3 <br />
fin1;

// NOWDOC (sin interpolación)
$c4 = ",";
$textoC2 = <<<'fin2'
$c4 <br />
fin2;

// A con tilde
$a1 = "á";
$a2 = 'á';
$a3 = "á";

// HEREDOC (interpolación activa)
$textoA1 = <<<fin1
$a3 <br />
fin1;

// NOWDOC (sin interpolación)
$a4 = "á";
$textoA2 = <<<'fin2'
$a4 <br />
fin2;

// E con tilde
$e1 = "é";
$e2 = 'é';
$e3 = "é";

// HEREDOC (interpolación activa)
$textoE1 = <<<fin1
$e3 <br />
fin1;

// NOWDOC (sin interpolación)
$e4 = "é";
$textoE2 = <<<'fin2'
$e4 <br />
fin2;

// Ñ
$n1 = "ñ";
$n2 = 'ñ';
$n3 = "ñ";

// HEREDOC (interpolación activa)
$textoN1 = <<<fin1
$n3 <br />
fin1;

// NOWDOC (sin interpolación)
$n4 = "ñ";
$textoN2 = <<<'fin2'
$n4 <br />
fin2;

// Array con todo
$array = [
    'coma' => [
        'c1' => $c1,
        'c2' => $c2,
        'c4' => $c4,
        'heredoc' => $textoC1,
        'nowdoc' => $textoC2
    ],
    'a' => [
        'a1' => $a1,
        'a2' => $a2,
        'a4' => $a4,
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
        'n4' => $n4,
        'heredoc' => $textoN1,
        'nowdoc' => $textoN2
    ]
];

inicioCabecera("EJERCICO_1");
cabecera();
finCabecera();

inicioCuerpo("Ejercicio 1: Funciones Matemáticas");
cuerpo($array);
finCuerpo();

function cabecera() {}

function cuerpo($array)
{
?>
    <div>
        <p>Contenido generado con HEREDOC: <strong><?= $array['coma']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['coma']['nowdoc'] ?></strong></p>
        <p>Valor de $c1: <strong><?= $array['coma']['c1'] ?></strong></p>
        <p>Valor de $c2: <strong><?= $array['coma']['c2'] ?></strong></p>
    </div><br />

    <div>
        <p>Contenido generado con HEREDOC: <strong><?= $array['a']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['a']['nowdoc'] ?></strong></p>
        <p>Valor de $a1: <strong><?= $array['a']['a1'] ?></strong></p>
        <p>Valor de $a2: <strong><?= $array['a']['a2'] ?></strong></p>
    </div><br />

    <div>
        <p>Contenido generado con HEREDOC: <strong><?= $array['e']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['e']['nowdoc'] ?></strong></p>
        <p>Valor de $e1: <strong><?= $array['e']['e1'] ?></strong></p>
        <p>Valor de $e2: <strong><?= $array['e']['e2'] ?></strong></p>
    </div><br />

    <div>
        <p>Contenido generado con HEREDOC: <strong><?= $array['n']['heredoc'] ?></strong></p>
        <p>Contenido generado con NOWDOC: <strong><?= $array['n']['nowdoc'] ?></strong></p>
        <p>Valor de $n1: <strong><?= $array['n']['n1'] ?></strong></p>
        <p>Valor de $n2: <strong><?= $array['n']['n2'] ?></strong></p>
    </div>
<?php

}
