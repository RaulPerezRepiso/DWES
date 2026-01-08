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

//------------------------------------
// Obtener IP y navegador 
//------------------------------------
$ip = str_replace(".", "_", $_SERVER['REMOTE_ADDR'] ?? '127_0_0_1');
$nav = strtolower($_SERVER['HTTP_USER_AGENT'] ?? '');
if (strpos($nav, 'chrome') !== false && strpos($nav, 'edge') === false) {
    $navegador = 'chrome';
} elseif (strpos($nav, 'firefox') !== false) {
    $navegador = 'firefox';
} elseif (strpos($nav, 'safari') !== false && strpos($nav, 'chrome') === false) {
    $navegador = 'safari';
} else {
    $navegador = 'otro';
}


// Rutas y nombres de archivos
$nombreFichero = __DIR__ . "/puntos/punto_dir{$ip}_{$navegador}.dat";
$nombreImagen = "imagen_{$ip}_{$navegador}.jpg";
$rutaweb = "/imagenes/puntos/" . $nombreImagen;
$rutaFisicaCarpeta = RUTABASE . '/imagenes/puntos/';
$rutaFisicaImagen = $rutaFisicaCarpeta . $nombreImagen;


// ------------------ Inicializaciones ------------------
$datos = ["x" => "", "y" => "", "color" => "", "grosor" => ""];
$errores = [];

// ------------------ Funciones ------------------

/**
 * Carga los puntos en el fichero
 *
 * @param string $nombre
 * @param array $puntos
 * @return boolean
 */
function escribirFichero(string $nombre, array $puntos): bool
{
    $lineas = [];
    foreach ($puntos as $p) {
        $lineas[] = "{$p->getX()} ; {$p->getY()} ; {$p->getColor()} ; {$p->getGrosor()}";
    }
    return file_put_contents($nombre, implode(PHP_EOL, $lineas)) !== false;
}

/**
 * Carga los puntos de un fichero a la imagen
 *
 * @param string $nombre
 * @return array
 */
function cargarPuntos(string $nombre): array
{
    $puntos = [];
    if (!file_exists($nombre)) return $puntos;
    $lineas = file($nombre);
    foreach ($lineas as $linea) {
        $partes = array_map('trim', explode(";", $linea));
        if (count($partes) == 4) {
            try {
                $puntos[] = new Punto((int)$partes[0], (int)$partes[1], trim($partes[2]), (int)$partes[3]);
            } catch (Exception $e) {
                echo "<p style='color:red'>" . ($e->getMessage()) . "</p>";
            }
        }
    }
    return $puntos;
}

/**
 * GD
 * Crea imagen y la descarga
 *
 * @param array $puntos
 * @param string $rutaFisicaImagen
 * @return boolean
 */
function recrearImagen(array $puntos, string $rutaFisicaImagen): bool
{
    $ancho = 500;
    $alto = 500;
    $imagen = imagecreatetruecolor($ancho, $alto);
    if (!$imagen) return false;

    $blanco = imagecolorallocate($imagen, 255, 255, 255);
    $negro  = imagecolorallocate($imagen, 0, 0, 0);

    imagefill($imagen, 0, 0, $blanco);
    imagerectangle($imagen, 0, 0, $ancho - 1, $alto - 1, $negro);

    foreach ($puntos as $p) {
        $rgb = Punto::COLORES[$p->getColor()]['rgb'] ?? [0, 0, 0];
        $colorGD = imagecolorallocate($imagen, $rgb[0], $rgb[1], $rgb[2]);
        $diametro = $p->getGrosor() * 3;
        $x = max(0, min($ancho - 1, (int)$p->getX()));
        $y = max(0, min($alto - 1, (int)$p->getY()));
        imagefilledellipse($imagen, $x, $y, $diametro, $diametro, $colorGD);
    }

    $dir = dirname($rutaFisicaImagen);
    if (!is_dir($dir) && !mkdir($dir, 0777, true)) {
        imagedestroy($imagen);
        return false;
    }

    $ok = imagejpeg($imagen, $rutaFisicaImagen);
    imagedestroy($imagen);
    return $ok;
}

/**
 * Genera la imagen para descargarla
 *
 * @param array $puntos
 * @return void
 */
function generarImagen(array $puntos): void
{

    // Eliminar cualquier salida ya acumulada (evita "headers ya enviados")
    while (ob_get_level()) {
        ob_end_clean();
    }

    $ancho = 500;
    $alto = 500;
    $img = imagecreatetruecolor($ancho, $alto);

    $blanco = imagecolorallocate($img, 255, 255, 255);
    $negro  = imagecolorallocate($img, 0, 0, 0);

    imagefill($img, 0, 0, $blanco);
    imagerectangle($img, 0, 0, $ancho, $alto, $negro);

    foreach ($puntos as $p) {
        $rgb = Punto::COLORES[$p->getColor()]['rgb'] ?? [0, 0, 0];
        $color = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
        $diam = max(3, $p->getGrosor() * 3);
        $x = max(0, min($ancho - 1, (int)$p->getX()));
        $y = max(0, min($alto - 1, (int)$p->getY()));
        imagefilledellipse($img, $x, $y, $diam, $diam, $color);
    }

    header('Content-Type: image/jpeg');
    header('Content-Disposition: attachment; filename="imagen_' . date('Ymd_His') . '.jpg"');
    header('Cache-Control: private, max-age=0, must-revalidate');
    header('Pragma: public');

    imagejpeg($img);
}

// ------------------ Carga de puntos manual ------------------
$punto1 = new Punto(45, 78, "black", 1);
$punto2 = new Punto(435, 348, "blue", 2);
$punto3 = new Punto(145, 178, "green", 3);

//Los carga para mostrarlos en la imagen
$almacenaPuntos = cargarPuntos($nombreFichero);
if (empty($almacenaPuntos)) {
    $almacenaPuntos = [$punto1, $punto2, $punto3];
    escribirFichero($nombreFichero, $almacenaPuntos);
}

// Crear imagen física inicial si no existe
if (!file_exists($rutaFisicaImagen)) recrearImagen($almacenaPuntos, $rutaFisicaImagen);

// ------------------ Validar formularios ------------------
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

    if (empty($errores)) {
        try {
            $nuevo = new Punto($x, $y, $color, $grosor);
            $almacenaPuntos[] = $nuevo;
            escribirFichero($nombreFichero, $almacenaPuntos);
            recrearImagen($almacenaPuntos, $rutaFisicaImagen);
            echo "<h3 style='color:green'>Punto guardado correctamente</h3>";
        } catch (Exception $e) {
            echo "<p style='color:red'>" . ($e->getMessage()) . "</p>";
        }
    }
}

// Subir fichero .txt
if (isset($_POST['subir']) && isset($_FILES['fichero_puntos']) && $_FILES['fichero_puntos']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['fichero_puntos']['tmp_name'];
    $lineas = file($tmp, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $nuevos = 0;
    foreach ($lineas as $linea) {
        $partes = array_map('trim', explode(";", $linea));
        if (count($partes) === 4) {
            [$sx, $sy, $scolor, $sgrosor] = $partes;
            $x = (int)$sx;
            $y = (int)$sy;
            $color = $scolor;
            $grosor = (int)$sgrosor;
            if (
                validaEntero($x, 0, 500, 0) && validaEntero($y, 0, 500, 0)
                && array_key_exists($color, Punto::COLORES) && array_key_exists($grosor, Punto::GROSORES)
            ) {
                try {
                    $almacenaPuntos[] = new Punto($x, $y, $color, $grosor);
                    $nuevos++;
                } catch (Exception $e) {
                    echo "<p style='color:red'>" . ($e->getMessage()) . "</p>";
                }
            }
        }
    }
    if ($nuevos > 0) {
        escribirFichero($nombreFichero, $almacenaPuntos);
        recrearImagen($almacenaPuntos, $rutaFisicaImagen);
        echo "<h3 style='color:green'>Se añadieron $nuevos puntos desde el fichero</h3>";
    } else {
        echo "<p style='color:red'>No se añadieron puntos válidos</p>";
    }
}

// Descargar imagen
if ((isset($_GET['descargar']) && $_GET['descargar'] === '1') || (isset($_POST['descargar']))) {
    // Generar y enviar
    generarImagen($almacenaPuntos);
}

// Borrar punto
if (isset($_POST['borrar'])) {
    $idx = intval($_POST['idx_borrar'] ?? -1);
    if ($idx >= 0 && $idx < count($almacenaPuntos)) {
        array_splice($almacenaPuntos, $idx, 1);
        escribirFichero($nombreFichero, $almacenaPuntos);
        recrearImagen($almacenaPuntos, $rutaFisicaImagen);
        echo "<h3 style='color:orange'>Punto borrado</h3>";
    } else {
        echo "<p style='color:red'>Índice inválido</p>";
    }
}

// ------------------ Funciona de vista ------------------
mostrarImagen($almacenaPuntos, $rutaFisicaCarpeta, $nombreImagen);
cuerpo($datos, $errores, $almacenaPuntos, $rutaweb);

finCuerpo();

function cabecera() {}

function cuerpo($datos, $errores, $almacenaPuntos, $rutaweb)
{
    formulario($datos, $errores, $almacenaPuntos, $rutaweb);
}

/**
 * Formulario que recoge todo el contenido
 *
 * @param [type] $datos Datos de los puntos, color y grosor
 * @param [type] $errores Guarda si hay errores 
 * @param [type] $almacenaPuntos Almcena los puntos creados
 * @param [type] $rutaweb Ruta web del archivo
 * @return void
 */
function formulario($datos, $errores, $almacenaPuntos, $rutaweb)
{
    if (!empty($errores)) {
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error) echo ($error) . "<br>";
        }
        echo "</div>";
    }
?>
    <h1>Relación 7: Ficheros</h1>

    <form method="post" enctype="multipart/form-data">
        <label for="x"><strong>X:</strong></label>
        <input type="number" name="x" id="x" value="<?= ($datos["x"]) ?>"><br><br>

        <label for="y"><strong>Y:</strong></label>
        <input type="number" name="y" id="y" value="<?= ($datos["y"]) ?>"><br><br>

        <label for="color"><strong>Color:</strong></label>
        <select name="color" id="color">
            <option value="">Sin Seleccionar</option>
            <option value="black" <?= ($datos["color"] == "black") ? "selected" : "" ?>>Negro</option>
            <option value="yellow" <?= ($datos["color"] == "yellow") ? "selected" : "" ?>>Amarillo</option>
            <option value="blue" <?= ($datos["color"] == "blue") ? "selected" : "" ?>>Azul</option>
            <option value="green" <?= ($datos["color"] == "green") ? "selected" : "" ?>>Verde</option>
        </select><br><br>

        <label for="grosor"><strong>Grosor:</strong></label><br>
        <input type="radio" name="grosor" value="1" id="fino" <?= ($datos["grosor"] == 1) ? "checked" : "" ?>>
        <label for="fino">Fino</label>
        <input type="radio" name="grosor" value="2" id="medio" <?= ($datos["grosor"] == 2) ? "checked" : "" ?>>
        <label for="medio">Medio</label>
        <input type="radio" name="grosor" value="3" id="grueso" <?= ($datos["grosor"] == 3) ? "checked" : "" ?>>
        <label for="grueso">Grueso</label>
        <br><br>

        <button type="submit" name="crear">Crear Punto</button><br><br>

        <textarea name="areaText" rows="12" cols="100" readonly><?php
                                                                if (!empty($almacenaPuntos)) {
                                                                    foreach ($almacenaPuntos as $p) {
                                                                        $colorTexto  = Punto::COLORES[$p->getColor()]["nombre"];
                                                                        $grosorTexto = Punto::GROSORES[$p->getGrosor()];
                                                                        echo "X=" . $p->getX() . " ; Y=" . $p->getY() . " ; " . $colorTexto . " ; " . $grosorTexto . PHP_EOL;
                                                                    }
                                                                }
                                                                ?></textarea>

        <br><br>

        <img src="<?= ($rutaweb) ?>?v=<?= file_exists($GLOBALS['rutaFisicaImagen'] ?? '') ? filemtime($GLOBALS['rutaFisicaImagen']) : time() ?>" alt="Imagen de puntos" style="max-width:500px;border:1px solid #999">
        <div>
            <a href="?descargar=1">Descargar imagen a (jpg)</a>
        </div>

        <br><br>

        <h3>Eliminar punto</h3>
        <label for="idx_borrar">Selecciona punto a borrar:</label>
        <select name="idx_borrar" id="idx_borrar">
            <?php if (!empty($almacenaPuntos)): ?>
                <?php foreach ($almacenaPuntos as $i => $p):

                ?>
                    <option value="<?= $i ?>"><?=  "Punto {$i}: X={$p->getX()} Y={$p->getY()}, Color {$p->getColor()} y grosor {$p->getGrosor()}" ?></option>
                <?php endforeach; ?>
            <?php else: ?>
                <option value="">No hay puntos</option>
            <?php endif; ?>
        </select>
        <button type="submit" name="borrar">Borrar</button>

        <br><br>

        <h3>Subir fichero de puntos (.txt)</h3>
        <input type="file" name="fichero_puntos" accept=".txt">
        <button type="submit" name="subir">Subir y añadir</button>
        </fieldset>
    </form>
<?php
}

/**
 * Muestra la imagen guardada 
 *
 * @param [type] $almacenaPuntos
 * @param [type] $rutaPhp
 * @param [type] $nombreImagen
 * @return void
 */
function mostrarImagen($almacenaPuntos, $rutaphp, $nombreImagen)
{

    $rutaCompleta = $rutaphp . $nombreImagen;
    if (!recrearImagen($almacenaPuntos, $rutaCompleta)) {
        echo "<p style='color:red'>Error al guardar la imagen en $rutaCompleta</p>";
    }
}
