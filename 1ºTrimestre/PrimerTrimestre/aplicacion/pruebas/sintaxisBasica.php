<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
    "Sintaxis Básica" => "/aplicacion/pruebas/sintaxisBasica.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// **********************************************************
error_reporting(E_ALL); // Opcional: muestra todos los errores

// Controlador
$var = 12;

if (isset($var)) // corregido: PHP es case-sensitive
    $var++;

unset($var);

$num = mt_rand(1, 10);
$nombre = 'Profesor';
$apellido = '2daw';

if ($num <= 5)
    $var = "nombre";
else
    $var = "apellido";

$resultado = $$var; // variable dinámica

$var = 12;

if (gettype($var) == "integer") {
    $resultado = "es entero";
}
$var = "esto es una cadena";

if (gettype($var) == "integer") {
    $resultado = "es entero";
}

$num = 0x1485;

$num = 123456890123456789;

$num = 123456890123456789123456789123456789;
settype($num, "float");

$num = intval("1234");
$num = intval("esto");

// Dará ERROR por ser una indeterminación
// $num=$num/0;

$cadena = "esta es la cadena 'nueva cadena'";
$cadena = "esta es la cadena \"nueva cadena\"";

$cadena = "La variable \$num tiene como valor {$num}";
$cadena = "La variable \$num tiene como valor " . $num . " entero";

// Conversión de Números
$num = 12;
$num = (float)$num;
settype($num, "string"); // corregido: no reasignar el resultado
$num = intval($num);

// Comprobación de boolean
if ($num)
    $num = 0;

if ($num)
    $num = 12;

$cadena = "";
if ($cadena)
    $num = 24;

$resultado = $num + intval("12hola");
$resultado = $num + intval("hola12");
$resultado = $num + intval("hola");

/** $var1 tendrá un acceso de memoria, $var2 tendrá un acceso de memoria con lo que tuviera $var1 pero
 * $var3 en cambio apunta al mismo sitio que &$var1 y guardará lo que guarde $var1 a menos que la 
 * inicialicemos que ya sí cambiaría y crearía un sitio en memoria con el valor que le hayamos dado */
$var1 = 100;
$var2 = $var1;
$var3 = &$var1;
$var1 = 125;

// Constantes 
$resultado = -14 <=> -12;
$resultado = -14 <=> 12;
$resultado = 12 <=> 12;
$resultado = -14 <=> 12;

//El primer valor definido es el que se asigna
$resultado = $var3 ?? -$num ?? 0;

$var3 = null;

$resultado = $var3 ?? -$num ?? 0;

// Las {} nos determinan un bloque
if ($num > 1) {
    $resultado = "Todo correcto";
    $cadena = "Ok";
}
$num = 10;

// Dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}

function cuerpo()
{
?>
    Estas en pruebas de sintaxis básica
<?php
    echo "<br>Escrito desde PHP" . PHP_EOL;
    echo "<br>Otra línea" . PHP_EOL;
    echo "<br>El Host de llamada: <strong>" . $_SERVER["HTTP_HOST"] . "</strong> usando el navegador <strong>" . $_SERVER["HTTP_USER_AGENT"] . "</strong><br>" . PHP_EOL;
}
?>
