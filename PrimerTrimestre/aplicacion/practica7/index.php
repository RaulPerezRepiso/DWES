<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación VII:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("PRÁCTICA_7");
cabecera();
finCabecera();
inicioCuerpo("PRÁCTICA_7");


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
    $x = $_POST["x"] ?? 0;
    if (isset($_POST["x"])) {
        $x = intval($_POST["x"]);
    }
    if (!validaEntero($x, 0, 500, 0)) {
        $errores["x"][] = "El punto X tiene que estar entre 0 y 20000";
    }
    $datos["x"] = $x;

    $y = $_POST["y"] ?? 0;
    if (isset($_POST["y"])) {
        $y = intval($_POST["y"]);
    }
    if (!validaEntero($y, 0, 500, 0)) {
        $errores["y"][] = "El punto Y tiene que estar entre 0 y 20000";
    }
    $datos["y"] = $y;

    $color = $_POST["color"] ?? "";
    if (array_key_exists($color, Punto::COLORES)) {
        $color = $_POST["color"];
    } else {
        $errores["color"][] = "Color no válido";
    }
    $datos["color"] = $color;

    $grosor = $_POST["grosor"] ?? "";
    if (array_key_exists($grosor, Punto::GROSORES)) {
        $grosor = intval($_POST["grosor"]);
    } else {
        $errores["grosor"][] = "Grosor no válido";
    }
    $datos["grosor"] = $grosor;

    if (!$errores) {
        try {
            $nuevo = new Punto($x, $y, $color, $grosor);
            $GLOBALS['Puntos'][] = $nuevo;
            echo "<h3 style='color:green'>Punto guardado correctamente</h3>";
        } catch (Exception $e) {
            echo "<p style='color:red'>" . $e->getMessage() . "</p>";
        }
    }
}


cuerpo($datos, $errores);
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
                echo "$error<br>" . PHP_EOL;
        }
        echo "</div>";
    }
?>
    <h1>Relación 7: Ficheros</h1>

    <form method="post">
        <label for="x"><strong>X:</strong></label>
        <input type="number" name="x" id="x" value="<?php echo $datos["x"]; ?>"><br><br>

        <label for="y"><strong>Y:</strong></label>
        <input type="number" name="y" id="y" value="<?php echo $datos["y"]; ?>"><br><br>

        <label for="color"><strong>Color:</strong></label>
        <select name="color" id="color">
            <option>Sin Seleccionar</option>
            <option value="black" <?= $datos["color"] == "black" ? "selected" : "" ?>>Negro</option>
            <option value="yellow" <?= $datos["color"] == "yellow" ? "selected" : "" ?>>Amarillo</option>
            <option value="blue" <?= $datos["color"] == "blue" ? "selected" : "" ?>>Azul</option>
            <option value="green" <?= $datos["color"] == "green" ? "selected" : "" ?>>Verde</option>
        </select><br><br>

        <label for="grosor"><strong>Grosor:</strong></label><br>
        <input type="radio" name="grosor" value="1" id="grosor1" <?= $datos["grosor"] == 1 ? "checked" : "" ?>>
        <label for="grosor1">Fino</label>

        <input type="radio" name="grosor" value="2" id="grosor2" <?= $datos["grosor"] == 2 ? "checked" : "" ?>>
        <label for="grosor2">Medio</label>

        <input type="radio" name="grosor" value="3" id="grosor3" <?= $datos["grosor"] == 3 ? "checked" : "" ?>>
        <label for="grosor3">Grueso</label>
        <br><br>

        <button type="submit" name="crear">Crear Punto</button>
    </form>
<?php
}
