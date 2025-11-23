<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Personalizar" => "#",
];

// --- Restricciones de acceso ---
// Comprobar si hay Usuario
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}
// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(1)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}
if (!$acceso->puedePermiso(2)) {
    paginaError("No tienes permiso para configurar colores");
    exit;
}

//Guardar los colores en cookies
if (isset($_POST["subir"])) {
    $fondo = $_POST["colorFondo"] ?? "white";
    $texto = $_POST["colorLetra"] ?? "black";

    setcookie("colorFondo", $fondo);
    setcookie("colorLetra", $texto);

    // Refrescar la página para aplicar cambios
    header("Location: personalizar.php");
    exit;
}

// Dibuja la plantilla de la vista
inicioCabecera("Personalizar");
cabecera();
finCabecera();

inicioCuerpo("Personalizar");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
    Formulario();
?>

<?php

}

function Formulario()
{
    // Valores por defecto según el enunciado
    $fondoDefecto = $_COOKIE["colorFondo"] ?? "white";
    $textoDefecto =  $_COOKIE["colorLetra"]  ?? "black";

    // Arrays asociativos: label en español => value en inglés
    $fondos = [
        "blanco" => "white",
        "rojo" => "red",
        "verde" => "green",
        "azul" => "blue",
        "cyan" => "cyan"
    ];

    $textos = [
        "negro" => "black",
        "azul" => "blue",
        "blanco" => "white",
        "rojo" => "red"
    ];

?>

    <form method="post" action="">
        <label for="colorFondo"><strong>Color de Fondo:</strong></label>
        <select name="colorFondo" id="colorFondo">
            <?php foreach ($fondos as $label => $value): ?>
                <option value="<?= $value ?>" <?= ($fondoDefecto == $value) ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="colorLetra"><strong>Color de Texto:</strong></label>
        <select name="colorLetra" id="colorLetra">
            <?php foreach ($textos as $label => $value): ?>
                <option value="<?= $value ?>" <?= ($textoDefecto == $value) ? 'selected' : '' ?>>
                    <?= $label ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" name="subir" value="Guardar">
    </form>
<?php
}
