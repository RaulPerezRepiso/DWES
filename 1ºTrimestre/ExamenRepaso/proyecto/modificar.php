<?php
include_once(dirname(__FILE__) . "/../cabecera.php");

// controlador
$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar Proyecto" => "/aplicacion/proyectos/modificar.php"
];

$PRO = &$_SESSION['PRO'];
$id = $_POST['proyecto'] ?? $_GET['id'] ?? null;

if ($id === null || !isset($PRO[$id])) {
    paginaError("Proyecto no válido");
    exit;
}

$proyecto = $PRO[$id];
$errores = [];
$ok = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
    if ($proyecto->setNombre(trim($_POST['nombre'])) < 0) $errores[] = "Nombre incorrecto";
    if ($proyecto->setEmpresa(trim($_POST['empresa'])) < 0) $errores[] = "Empresa incorrecta";

    $tipo = (int)($_POST['tipo'] ?? 10);
    if (!in_array($tipo, array_keys(Proyecto::TIPOPROYECTO))) {
        $errores[] = "Tipo incorrecto";
    } else {
        $proyecto->setTipo($tipo);
    }

    $f1 = DateTime::createFromFormat("d/m/Y", $_POST['fecha1'] ?? "");
    $f2 = DateTime::createFromFormat("d/m/Y", $_POST['fecha2'] ?? "");
    if ($f1 && $f2) {
        $proyecto->setFechaInicio($f1);
        $proyecto->setFechaFin($f2);
    } else {
        $errores[] = "Fechas incorrectas";
    }

    if (empty($errores)) {
        $PRO[$id] = $proyecto;
        $_SESSION['PRO'] = $PRO;
        $ok = "Proyecto actualizado correctamente";
    }
}

// dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Modificar Proyecto");
cuerpo($ubicacion, $proyecto, $errores, $ok, $id);
finCuerpo();

// **********************************************************

// vista
function cabecera() {}

// vista
function cuerpo(array $ubicacion, $proyecto, array $errores, string $ok, $id)
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
        <input type="hidden" name="proyecto" value="<?= $id ?>">
        <label>Nombre:
            <input type="text" name="nombre" value="<?= htmlspecialchars($proyecto->getNombre()) ?>">
        </label><br>
        <label>Empresa:
            <input type="text" name="empresa" value="<?= htmlspecialchars($proyecto->getEmpresa()) ?>">
        </label><br>
        <label>Fecha inicio:
            <input type="text" name="fecha1" value="<?= $proyecto->getFechaInicio()->format("d/m/Y") ?>">
        </label><br>
        <label>Fecha fin:
            <input type="text" name="fecha2" value="<?= $proyecto->getFechaFin()->format("d/m/Y") ?>">
        </label><br>
        <label>Tipo:
            <input type="number" name="tipo" value="<?= $proyecto->getTipo() ?>">
        </label><br><br>
        <button type="submit" name="guardar">Guardar</button>
        <a href="/index.php">Volver</a>
    </form>
    <?php
}
