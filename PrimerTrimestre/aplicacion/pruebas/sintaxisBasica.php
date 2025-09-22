<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
// Controlador

$var=12;

$var++;


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
// br para Salto de linea
    echo "<br>Escrito desde PHP".PHP_EOL;
    echo "<br>Otra linea".PHP_EOL;
    echo "<br>El Host de llamada ".$_SERVER["HTTP_HOST"]." Usando el navegador ".$_SERVER["HTTP_USER_AGENT"]."<br>".PHP_EOL;

}