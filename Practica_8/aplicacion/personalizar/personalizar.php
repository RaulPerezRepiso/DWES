<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Personalizar" => "#",
];

//Guardar los colores
if (isset($_POST["subir"])) {
    $textos["texto"] = $texto;
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
?>
    <label for="colorFondo"><strong>Color de Fondo:</strong></label>
    <select name="colorFondo" id="colorFondo">
        <option value="COLORESDEFONDO[0]" selected><?= (COLORESDEFONDO[0]) ?></option>
        <option value="COLORESDEFONDO[1]"><?= (COLORESDEFONDO[1]) ?></option>
        <option value="COLORESDEFONDO[2]"><?= (COLORESDEFONDO[2]) ?></option>
        <option value="COLORESDEFONDO[3]"><?= (COLORESDEFONDO[3]) ?></option>
        <option value="COLORESDEFONDO[4]"><?= (COLORESDEFONDO[4]) ?></option>
    </select><br><br>
    <label for="color"><strong>Color de Texto:</strong></label>
    <select name="color" id="color">
        <option value="COLORESTEXTO[0]" selected><?= (COLORESTEXTO[0]) ?></option>
        <option value="COLORESTEXTO[1]"><?= (COLORESTEXTO[1]) ?></option>
        <option value="COLORESTEXTO[2]"><?= (COLORESTEXTO[2]) ?></option>
        <option value="COLORESTEXTO[3]"><?= (COLORESTEXTO[3]) ?></option>
    </select><br><br>
    <input type="submit" name="subir" value="Subir">
<?php
}
