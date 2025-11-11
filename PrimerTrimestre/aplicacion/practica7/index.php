<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación VII:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

function Formulario()
{
?>
    <h1>Relación 7: Ficheros</h1>

    <form method="post">
        <label for="x"><strong>X:</strong></label>
        <input type="number" name="x" id="x" min="0" max="20000" required><br><br>

        <label for="y"><strong>Y:</strong></label>
        <input type="number" name="y" id="y" min="0" max="20000" required><br><br>

        <label for="color"><strong>Color:</strong></label>
        <select name="color" id="color">
            <option value="black">Negro</option>
            <option value="yellow">Amarillo</option>
            <option value="blue">Azul</option>
            <option value="green">Verde</option>
        </select><br><br>

        <label for="grosor"><strong>Grosor:</strong></label><br>
        <label for="grosor1">Fino</label>
        <input type="radio" name="grosor" value="1" id="grosor1">
        <label for="grosor2">Medio</label>
        <input type="radio" name="grosor" value="1" id="grosor2">
        <label for="grosor3">Grueso</label>
        <input type="radio" name="grosor" value="1" id="grosor3">
        <br><br>

        <button type="submit">Crear Punto</button>
    </form>
<?php
}

inicioCabecera("PRÁCTICA_7");
cabecera();
finCabecera();

inicioCuerpo("PRÁCTICA_7");
cuerpo();
finCuerpo();


// **********************************************************

function cabecera() {}

function cuerpo()
{
    echo Formulario();
}
