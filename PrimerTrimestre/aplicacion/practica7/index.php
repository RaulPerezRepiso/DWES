<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "../scripts/librerias/validacion.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación VII:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

//inicializaciones
$datos = [
    "x" => "",
    "y" => "",
    "color" => "",
    "grosor" => ""
];

$errores = [];

//comprobar si se ha dado a insertar
if (isset($_POST["crear"])) {
    $nombre = "";
    if (isset($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
        // $nombre = mb_strtolower(trim($nombre)); Por si nos lo piden en minuscula y sin espacios
        $nombre = trim($nombre);
    }
    if (mb_strlen($nombre) < 10) {
        $errores["nombre"][] = "El nombre debe tener al menos 10 carácteres";
    }
    $datos["nombre"] = $nombre;

    $edad = 0;
    if (isset($_POST["edad"])) {
        $edad = intval($_POST["edad"]);
    }

    if ($edad < 15) {
        $errores["edad"][] = "Debes tener al menos 15 años";
        $edad = 15;
    }
    $datos["edad"] = $edad;


    if (!$errores) //no hay errores hago la insercion
    {
        //codigo para el nuevo articulo
        $codigo = 1; //codigo

        //se guarda el articulo

        //ir a ver el articulo insertado
        echo "location: verArticulo.php?id=$codigo";
        exit;
    }
}

inicioCabecera("PRÁCTICA_7");
cabecera($datos, $errores);
finCabecera();

inicioCuerpo("PRÁCTICA_7");
cuerpo();
finCuerpo();


// **********************************************************

function cabecera() {}

function cuerpo($datos, $errores)
{
    formulario($datos, $errores);
}


function formulario($datos, $errores)
{
    if ($errores) { //mostrar los errores
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>" . PHP_EOL;
        }
        echo "</div>";
    }
?>
    <h1>Relación 7: Ficheros</h1>

    <form method="post">
        <label for="x"><strong>X:</strong></label>
        <input type="number" name="x" id="x" min="0" max="20000"><br><br>

        <label for="y"><strong>Y:</strong></label>
        <input type="number" name="y" id="y" min="0" max="20000"><br><br>

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
        <input type="radio" name="grosor" value="2" id="grosor2">
        <label for="grosor3">Grueso</label>
        <input type="radio" name="grosor" value="3" id="grosor3">
        <br><br>

        <button type="submit">Crear Punto</button>
    </form>
<?php
}
