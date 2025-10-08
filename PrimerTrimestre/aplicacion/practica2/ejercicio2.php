<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 2" => "ejercicio2.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

$cadena = "Está la niña en casa";

inicioCabecera("EJERCICO_2");

inicioCuerpo("Ejercicio 2: Lanzamiento de un dado");

cuerpo($cadena);
finCuerpo();
?>

<?php
function cuerpo($cadena)
{
?>
    <!--Cadena spliteadas  -->
    <h2>Prueba mb_str_split</h2>
    <?php foreach (mb_str_split($cadena) as $i => $valor) { ?>
        <p>
            <?= str_repeat("&nbsp;", $i) . htmlspecialchars($valor) ?>
        </p>
    <?php } ?>
    <h2>Prueba mb_substr</h2>
    <?php for ($i = 0; $i < mb_strlen($cadena); $i++) { ?>
        <p>
            <?= str_repeat("&nbsp;", $i) . mb_substr($cadena, $i, 1) ?>
        </p>
    <?php } ?>
    <h2>Prueba substr</h2>
    <?php for ($i = 0; $i < strlen($cadena); $i++) { ?>
        <p>
            <?= str_repeat("&nbsp;", $i) . substr($cadena, $i, 1) . "<br>" ?>
        </p>
    <?php } ?>

    <!--Cadena inversas spliteadas  -->
    <h2>mb_substr con orden inverso y alteración de cadena</h2>
    <?php for ($i = mb_strlen($cadena); mb_strlen($cadena) >= 0; $i--) { ?>
        <p>
            <?= str_repeat("&nbsp;", $i) . mb_substr($cadena, $i, 1) ?>
        </p>
    <?php } ?>
<?php
}
