<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

/* $ubicacion = [
    "Index Principal" => "/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion; */

// Dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("PRUEBAS");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}
//vista
function cuerpo()
{
?>
    <h2>Creación de clase MuebleReciclado</h2>
    <?php
    $carac = new Caracteristicas();
    $mueblebase = new MuebleReciclado("Raúl", 2, $carac, "SIU", "Portugal", 2025, "27/03/2025", "12/11/2030", 12.34, 95.3);
    $mueblebase->añadir("Arte", "Romana", "Gótica", "Corintia");
    echo "<p>$mueblebase</p>";
    ?>

    <h2>Creación de clase MuebleTradicional</h2>
    <?php
    $carac2 = new Caracteristicas([
        "Color" => "Blanco",
        "estilo" => "moderno",
        "ancho" => 200,
        "largo" => 150,
        "alto" => 222,
        "ningunamas" => "si"
    ]);
    $muebletradicional = new MuebleTradicional("Raúl", 2, $carac2, "SIU", "Portugal", 2025, "27/03/2025", "12/11/2030", 12.34, 95.3,"awdawdawdwawd");
    echo "<p>$muebletradicional</p>";
    ?>

<?php
}
