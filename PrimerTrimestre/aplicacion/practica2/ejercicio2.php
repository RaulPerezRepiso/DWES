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
    <?php
    $len = mb_strlen($cadena);
    $char = mb_substr($cadena, $len - 1 - $i, 1);
    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($cadena, $len - 1 - $i, 1); ?>
        <p>
            <?= str_repeat("&nbsp;", $i) . ($i % 2 == 0 ? mb_strtoupper($char) : mb_strtolower($char)) ?>
        </p>
    <?php } ?>

    <h2>Seperar la cadena en partes</h2>
    <?php
    // Explode busca lo que queremos dentro de una cadena y crear en array y lo guarda
    $res = explode("a", $cadena);
    foreach ($res as $clave => $valor) { ?>
        <p>
            <?= "Parte: " . $clave . " " . $valor ?>
        </p>
    <?php } ?>

    <h2>Cambia el String niña por Mujer</h2>
    <!-- Replace busca la cadena que le damos, lo que queremos cambiar y donde -->
    <p>
        <?= str_replace("niña", "niña/mujer", $cadena) ?>
    </p>
<?php
}
