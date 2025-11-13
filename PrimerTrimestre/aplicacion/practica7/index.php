<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/../../scripts/librerias/validacion.php");

// Barra de ubicación
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación VII:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

inicioCabecera("PRÁCTICA_7");
cabecera();
finCabecera();
inicioCuerpo("PRÁCTICA_7");

// Array inicial con 3 puntos
$punto1 = new Punto(45, 78, "black", 1);
$punto2 = new Punto(435, 348, "blue", 2);
$punto3 = new Punto(145, 178, "green", 3);

$almacenaPuntos = [$punto1, $punto2, $punto3];

//------------------------------------
// Obtener IP y navegador
$ip = str_replace(".", "_", $_SERVER['REMOTE_ADDR']);
$ua = strtolower($_SERVER['HTTP_USER_AGENT']);
if (strpos($ua, 'chrome') !== false) {
    $navegador = 'chrome';
} elseif (strpos($ua, 'firefox') !== false) {
    $navegador = 'firefox';
} elseif (strpos($ua, 'safari') !== false && strpos($ua, 'chrome') === false) {
    $navegador = 'safari';
} else {
    $navegador = 'otro';
}

$nombreImagen = __DIR__ . "/imagenes/puntos/imagen_{$ip}_{$navegador}.jpg";
$rutaweb = "imagenes/puntos/imagen_{$ip}_{$navegador}.jpg";

// Inicializaciones
$datos = ["x" => "", "y" => "", "color" => "", "grosor" => ""];
$errores = [];

// Procesar formulario
if (isset($_POST["crear"])) {
    $x = intval($_POST["x"] ?? 0);
    if (!validaEntero($x, 0, 500, 0)) $errores["x"][] = "El punto X tiene que estar entre 0 y 500";
    $datos["x"] = $x;

    $y = intval($_POST["y"] ?? 0);
    if (!validaEntero($y, 0, 500, 0)) $errores["y"][] = "El punto Y tiene que estar entre 0 y 500";
    $datos["y"] = $y;

    $color = $_POST["color"] ?? "";
    if (!array_key_exists($color, Punto::COLORES)) $errores["color"][] = "Color no válido";
    $datos["color"] = $color;

    $grosor = intval($_POST["grosor"] ?? 0);
    if (!array_key_exists($grosor, Punto::GROSORES)) $errores["grosor"][] = "Grosor no válido";
    $datos["grosor"] = $grosor;

    if (!$errores) {
        try {
            $nuevo = new Punto($x, $y, $color, $grosor);
            $almacenaPuntos[] = $nuevo;
            echo "<h3 style='color:green'>Punto guardado correctamente</h3>";
        } catch (Exception $e) {
            echo "<p style='color:red'>" . $e->getMessage() . "</p>";
        }
    }
}
mostrarImagen($almacenaPuntos, $nombreImagen);
cuerpo($datos, $errores, $almacenaPuntos, $rutaweb);
finCuerpo();

// **********************************************************

function cabecera() {}

function cuerpo($datos, $errores, $almacenaPuntos, $rutaweb)
{
    formulario($datos, $errores, $almacenaPuntos, $rutaweb);
}

function formulario($datos, $errores, $almacenaPuntos, $rutaweb)
{
    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error) echo "$error<br>" . PHP_EOL;
        }
        echo "</div>";
    }
?>
    <h1>Relación 7: Ficheros</h1>

    <form method="post">
        <label for="x"><strong>X:</strong></label>
        <input type="number" name="x" id="x" value="<?= $datos["x"]; ?>"><br><br>

        <label for="y"><strong>Y:</strong></label>
        <input type="number" name="y" id="y" value="<?= $datos["y"]; ?>"><br><br>

        <label for="color"><strong>Color:</strong></label>
        <select name="color" id="color">
            <option>Sin Seleccionar</option>
            <option value="black" <?= $datos["color"] == "black" ? "selected" : "" ?>>Negro</option>
            <option value="yellow" <?= $datos["color"] == "yellow" ? "selected" : "" ?>>Amarillo</option>
            <option value="blue" <?= $datos["color"] == "blue" ? "selected" : "" ?>>Azul</option>
            <option value="green" <?= $datos["color"] == "green" ? "selected" : "" ?>>Verde</option>
        </select><br><br>

        <label for="grosor"><strong>Grosor:</strong></label><br>
        <input type="radio" name="grosor" value="1" id="fino" <?= $datos["grosor"] == 1 ? "checked" : "" ?>>
        <label for="fino">Fino</label>
        <input type="radio" name="grosor" value="2" id="medio" <?= $datos["grosor"] == 2 ? "checked" : "" ?>>
        <label for="medio">Medio</label>
        <input type="radio" name="grosor" value="3" id="grueso" <?= $datos["grosor"] == 3 ? "checked" : "" ?>>
        <label for="grueso">Grueso</label>
        <br><br>

        <button type="submit" name="crear">Crear Punto</button><br><br>

        <textarea name="areaText" rows="20" cols="100"><?php
                                                        if (!empty($almacenaPuntos)) {
                                                            foreach ($almacenaPuntos as $p) {
                                                                $colorTexto  = Punto::COLORES[$p->getColor()]["nombre"];
                                                                $grosorTexto = Punto::GROSORES[$p->getGrosor()];
                                                                echo "Punto X en " . $p->getX() .
                                                                    " punto Y en " . $p->getY() .
                                                                    " de color " . $colorTexto .
                                                                    " y con un grosor " . $grosorTexto . "\n";
                                                            }
                                                        }
                                                        ?></textarea>

        <br><br>
        <img src="<?= $rutaweb ?>" alt="Imagen de puntos">
    </form>
<?php
}

function mostrarImagen($almacenaPuntos, $nombreImagen)
{

    // Crear imagen con GD y dibujar puntos
    $ancho = 500;
    $alto = 500;
    $imagen = imagecreatetruecolor($ancho, $alto);
    if (!$imagen) {
        exit;
    }

    // Colores básicos
    $blanco = imagecolorallocate($imagen, 255, 255, 255);
    $negro  = imagecolorallocate($imagen, 0, 0, 0);

    // Fondo blanco
    imagefill($imagen, 0, 0, $blanco);

    // Marco negro
    imagerectangle($imagen, 0, 0, $ancho - 1, $alto - 1, $negro);

    // Dibujar cada punto del array
    foreach ($almacenaPuntos as $p) {
        //Asiganar el color dependiendo de la selección
        $rgb = Punto::COLORES[$p->getColor()]['rgb'];
        $colorGD = imagecolorallocate($imagen, $rgb[0], $rgb[1], $rgb[2]);

        // Traducir grosor a diámetro
        $diametro = $p->getGrosor() * 5;

        imagefilledellipse($imagen, $p->getX(), $p->getY(), $diametro, $diametro, $colorGD);
    }

    $dir = dirname($nombreImagen);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    imagejpeg($imagen, $nombreImagen);
    imagedestroy($imagen);
}

/* function escribirFichero(string $nombre, array $datos): bool {} */
