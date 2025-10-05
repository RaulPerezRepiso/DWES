<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
    "Arrays" => "/aplicacion/pruebas/arrays.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// Dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo($dat);
finCuerpo();
// **********************************************************
/* $valor[0] = 18;
$valor[1] = "Hola";
$valor[2] = true;
$valor[3] = 3.4;
$valor[5] = 25;
$valor["primera"] = "esta es la primera posición del Array";

$valor[] = 100; */

/* for ($cont=0; $cont<=$cont($valor); $cont++){
    $aux=$valor[$cont];
} */

/* foreach ($valor as $indice => $valor) {
    $aux = $valor;
}

$valor1 = array(19, "Hola", true, 3.4 => array(25), "primera" => "Esta es la primera posición", 100);
$valor2 = [19, "Hola", true, 3.4 => array(25), "primera" => "Esta es la primera posición", 100];

$aux = $valor2[5][0];

$capital = array(
    "Castilla y León" => "Valladolid",
    "Asturias" => "Oviedo",
    "Aragón" => "Zaragoza"
);
while (key($capital) != NULL) {
    echo current($capital) . "<br />";
    next($capital);
} */

$dat = [
    "array" => $array,
    "aux" => $aux
];

function cabecera() {}

function cuerpo(array $datos)
{
?>
    Estas en pruebas de sintaxis básica
<?php
    foreach ($datos["array"]as $indice=>$valor)
        echo "en el array posocion $indice, valor $valor<br>".PHP_EOL;

    echo "la variable auxiliar vale {$datos["aux"]}<br>";

}
?>
