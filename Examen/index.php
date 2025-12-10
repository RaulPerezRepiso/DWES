<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

// --- LOGIN CON COOKIE ---
if (!isset($_COOKIE['logueo'])) {
    setcookie('logueo', 1, time() + 3600);
}

if (isset($_GET['accion']) && $_GET['accion'] === 'login') {
    $actual = isset($_COOKIE['logueo']) ? (int)$_COOKIE['logueo'] : 1;
    $valor = $actual + 2;
    setcookie('logueo', $valor, time() + 3600);

    if ($valor % 3 === 0) {
        $_SESSION['usuario'] = "MULTIPLO";
        $_SESSION['permiso'] = 1;
    }
    header("Location: index.php");
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}


// --- ARRAY COLECCIONES ---
$COLECCIONES = $_SESSION["COLECCIONES"] ?? [];

// --- CARGAR FICHERO ---
if (isset($_GET["accion"]) && $_GET["accion"] === "cargar") {
    $objetosCargados = [];
    cargarColeccionDesdeFichero("coleccion.txt", $objetosCargados);

    foreach ($objetosCargados as $objeto) {
        $COLECCIONES[] = $objeto;
    }
    $_SESSION["COLECCIONES"] = $COLECCIONES;
}

//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($COLECCIONES, $_SESSION['usuario'] ?? null, $_SESSION['permiso'] ?? null);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo($COLECCIONES, $usuario, $permiso)
{
?> <h2>Login</h2>
    <?php if (!empty($usuario)): ?>
        Usuario: <?= $usuario ?> (permiso <?= $permiso ?>)
        <a href="index.php?accion=logout">Cerrar sesión</a>
    <?php else: ?>
        <a href="index.php?accion=login">Loguearse</a>
        No hay usuario registrado
    <?php endif; ?>

    <h2>Listado de Colecciones</h2>
    <textarea rows="12" cols="80">

<?php
    foreach ($COLECCIONES as $i => $colecciones) {
        if ($usuario && $permiso == 1) {
            echo $colecciones->__toString() . "\n";
        } else {
            echo "sin permiso para ver otros\n";
        }
        echo "-----------------------------\n";
    }
?>
    </textarea>

    <?php if (!empty($usuario)): ?>
        <br>
        <a href="index.php?accion=cargar">Cargar Fichero</a>
        <h2>Acciones</h2>
        <ul>
            <?php foreach ($COLECCIONES as $i => $colecciones): ?>
                <li>
                    <?= $colecciones->getNombre() ?>
                    <a href="aplicacion/colecciones/modificar.php?id=<?= $i ?>">Modificar</a>
                    <a href="aplicacion/colecciones/enviar.php?id=<?= $i ?>">Enviar</a>
                </li>
            <?php endforeach; ?>

        </ul>
    <?php else: ?>
        <p style="color:red">Debes estar logeado para cargar fichero o modificar/enviar colecciones.</p>
    <?php endif; ?>
<?php
}


/**
 * Función para cargar colecciones desde un fichero de texto
 */
function cargarColeccionDesdeFichero(string $nombreFichero, array &$datos): bool
{
    $ruta = "Examen/aplicacion/fichero" . $nombreFichero;
    if (!file_exists($ruta)) return false;

    $fic = fopen($ruta, "r");
    if (!$fic) return false;

    while ($linea = fgets($fic)) {
        $linea = trim($linea);
        if ($linea === "") continue;

        $partes = explode("COLECCION=", $linea, 2);
        if (count($partes) != 2) continue;

        $payload = $partes[1];
        $pares = explode(";", $payload);

        $nombre  = "";
        $fecha = null;
        $tematica    = 10;

        foreach ($pares as $par) {
            $kv = explode(":", $par, 2);
            if (count($kv) == 2) {
                $clave = trim($kv[0]);
                $valor = trim($kv[1]);

                if ($clave == "nombre") $nombre  = $valor;
                if ($clave == "fecha") $fecha = DateTime::createFromFormat("d/m/Y", $valor);
                if ($clave == "tematica") $tematica = (int)$valor;
            }
        }

        if ($nombre === "") $nombre = "SIN_NOMBRE";
        if (!in_array($tematica, [10, 20, 30, 40])) $tematica = 10;

        try {
            $objeto = new Coleccion($nombre,  $fecha, $tematica);
            $datos[] = $objeto;
        } catch (Exception $e) {
            error_log("Error creando colección: " . $e->getMessage());
        }
    }

    fclose($fic);
    return true;
}
