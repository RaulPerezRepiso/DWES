<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 3" => "ejercicio3.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

// Caracteres para generar la constraseña
$caracteres = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'));

inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 3: Arrays");



cuerpo($caracteres);
finCuerpo();


function cuerpo($caracteres)
{
?>
    <!--Bucle que guarda cada caracter aleatorio en un arry y lo muestra-->
    <h2>Rellenar la cadena con 20 caracteres aleatorios</h2>
    <?php
    for ($i = 0; $i < 20; $i++) {
        $aux = mt_rand(0, count($caracteres) - 1);
        echo $caracteres[$aux];;
    }
    ?>
<?php
}
