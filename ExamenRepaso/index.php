<?php
include_once(dirname(__FILE__) . "/cabecera.php");

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
    } else {
        $_SESSION['usuario'] = "NOMUL";
        $_SESSION['permiso'] = 2;
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

// --- ARRAY PROYECTOS ---
$PRO = $_SESSION["PRO"] ?? [];

// --- CARGAR FICHERO ---
if (isset($_GET["accion"]) && $_GET["accion"] === "cargar") {
    $objetosCargados = [];
    cargarProyectosDesdeFichero("pro.txt", $objetosCargados);

    foreach ($objetosCargados as $objeto) {
        $PRO[] = $objeto;
    }
    $_SESSION["PRO"] = $PRO;
}

// --- VISTA ---
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($PRO, $_SESSION['usuario'] ?? null, $_SESSION['permiso'] ?? null);
finCuerpo();

// --- FUNCIONES VISTA ---
function cabecera() {}

function cuerpo($PRO, $usuario, $permiso)
{
?>
    <h2>Login</h2>
    <?php if (!empty($usuario)): ?>
        Usuario: <?= $usuario ?> (permiso <?= $permiso ?>)
        <a href="index.php?accion=logout">Cerrar sesión</a>
    <?php else: ?>
        <a href="index.php?accion=login">Loguearse</a>
        No hay usuario registrado
    <?php endif; ?>

    <h2>Listado de Proyectos</h2>
    <textarea rows="12" cols="80">
<?php
    foreach ($PRO as $i => $proyecto) {
        echo $proyecto->__toString() . "\n";
        if ($usuario && $permiso == 1) {
            echo $proyecto->getDescripcionOtras() . "\n";
        } else {
            echo "sin permiso para ver otros\n";
        }
        echo "-----------------------------\n";
    }
?>
    </textarea>

    <?php if (!empty($usuario)): ?>
        <a href="index.php?accion=cargar">Cargar Fichero</a>

        <h2>Acciones</h2>
        <ul>
            <?php foreach ($PRO as $i => $proyecto): ?>
                <li>
                    <?= $proyecto->getNombre() ?>
                    [<a href="proyecto/modificar.php?id=<?= $i ?>">Modificar</a>]
                    [<a href="proyecto/datospro.php?id=<?= $i ?>">Exportar</a>]
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p style="color:red">Debes estar logeado para cargar fichero o modificar/exportar proyectos.</p>
    <?php endif; ?>
<?php
}

/**
 * Función para cargar proyectos desde un fichero de texto
 */
function cargarProyectosDesdeFichero(string $nombreFichero, array &$datos): bool
{
    $ruta = RUTABASE . "/ficheros/" . $nombreFichero;
    if (!file_exists($ruta)) return false;

    $fic = fopen($ruta, "r");
    if (!$fic) return false;

    while ($linea = fgets($fic)) {
        $linea = trim($linea);
        if ($linea === "") continue;

        $partes = explode("PROYECTO=", $linea, 2);
        if (count($partes) != 2) continue;

        $payload = $partes[1];
        $pares = explode(";", $payload);

        $nombre  = "";
        $empresa = "";
        $fecha1  = null;
        $fecha2  = null;
        $tipo    = 10;

        foreach ($pares as $par) {
            $kv = explode(":", $par, 2);
            if (count($kv) == 2) {
                $clave = trim($kv[0]);
                $valor = trim($kv[1]);

                if ($clave == "nombre")  $nombre  = $valor;
                if ($clave == "empresa") $empresa = $valor;
                if ($clave == "fecha1")  $fecha1  = DateTime::createFromFormat("d/m/Y", $valor);
                if ($clave == "fecha2")  $fecha2  = DateTime::createFromFormat("d/m/Y", $valor);
                if ($clave == "tipo")    $tipo    = (int)$valor;
            }
        }

        if ($nombre === "") $nombre = "SIN_NOMBRE";
        if (!in_array($tipo, [10, 20, 30])) $tipo = 10;

        try {
            $objeto = new Proyecto($nombre, $empresa, $tipo, $fecha1, $fecha2);
            $datos[] = $objeto;
        } catch (Exception $e) {
            error_log("Error creando proyecto: " . $e->getMessage());
        }
    }

    fclose($fic);
    return true;
}
