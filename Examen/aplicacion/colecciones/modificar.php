<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// controlador
$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar Coleccion" => "#"
];

$COLECCIONES = &$_SESSION['COLECCIONES'];
$id = $_POST['colecciones'] ?? $_GET['id'] ?? null;

if ($id === null || !isset($COLECCIONES[$id])) {
    paginaError("Colección no válida");
    exit;
}

$colecciones = $COLECCIONES[$id];
$errores = [];
$ok = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    if ($colecciones->setNombre(trim($_POST['nombre'])) < 0) $errores[] = "Nombre incorrecto";

    $tematica = (int)($_POST['tematica'] ?? 10);
    if (!in_array($tematica, array_keys(Coleccion::TEMATICAS))) {
        $errores[] = "Temática incorrecto";
    } else {
        $colecciones->setTipo($tematica);
    }

    $f1 = DateTime::createFromFormat("d/m/Y", $_POST['fecha'] ?? "");
    if ($f1) {
        $colecciones->setFechaInicio($f1);
    } else {
        $colecciones[] = "Fechas incorrectas";
    }

    if (empty($errores)) {
        $COLECCIONES[$id] = $colecciones;
        $_SESSION['COLECCIONES'] = $COLECCIONES;
        $ok = "Colección actualizada correctamente";
    }
}

// dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Modificar Colección");
cuerpo($ubicacion, $coleeciones, $errores, $ok, $id);
finCuerpo();

// **********************************************************

// vista
function cabecera() {}

// vista
function cuerpo(array $ubicacion, $colecciones, array $errores, string $ok, $id)
{
    echo "<nav><ul>";
    foreach ($ubicacion as $nombre => $url) {
        echo "<li><a href='{$url}'>{$nombre}</a></li>";
    }
    echo "</ul></nav>";

    // mensajes
    if (!empty($errores)) {
        echo "<div style='color:red'>" . implode("<br>", $errores) . "</div>";
    }
    if (!empty($ok)) {
        echo "<div style='color:green'>{$ok}</div>";
    }

    // formulario
?>
    <form method="post">
        <input type="hidden" name="colecciones" value="<?= $id ?>">
        <label>Nombre:
            <input type="text" name="nombre" value="<?= $colecciones->getNombre() ?>">
        </label><br>
        <label>Fecha Alta:
            <input type="text" name="fecha" value="<?= $colecciones->getFechaInicio()->format("d/m/Y") ?>">
        </label><br>
        <label>Tipo:
            <input type="number" name="tematicas" value="<?= $colecciones->getTematica() ?>">
        </label><br><br>
        <button type="submit" name="guardar">Guardar</button>
        <a href="/index.php">Volver</a>
    </form>
<?php
}
