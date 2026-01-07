<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Productos" => "/aplicacion/productos/index.php",
    "Descargar" => "#"
];

// Permisos
if (!$acceso->hayUsuario() || !$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para descargar productos");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
if ($bd->connect_errno) {
    paginaError("Error BD: " . $bd->connect_error);
    exit;
}

//Construir filtros
$where = [];

// Filtro nombre
if (!empty($_SESSION["filtro_nombre"])) {

    $nombre = $_SESSION["filtro_nombre"];

    // Validación del temario
    if (validaCadena($nombre, 50, "")) {
        $where[] = "nombre LIKE '%$nombre%'";
    }
}

// Filtro categoría
if (!empty($_SESSION["filtro_categoria"])) {

    $cat = $_SESSION["filtro_categoria"];

    // Validación del temario
    if (validaCadena($cat, 50, "")) {
        $where[] = "categoria = '$cat'";
    }
}

$sql = "SELECT * FROM cons_productos";

if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

$sql .= " ORDER BY nombre";

$res = $bd->query($sql);

//Descargar archivo
if (isset($_POST["descargar"])) {

    header("Content-Type: text/plain; charset=utf-8");
    header("Content-Disposition: attachment; filename=productos_filtrados.txt");

    while ($p = $res->fetch_assoc()) {
        echo "Nombre: {$p['nombre']}\n";
        echo "Fabricante: {$p['fabricante']}\n";
        echo "Categoría: {$p['categoria']}\n";
        echo "Fecha Alta: {$p['fecha_alta']}\n";
        echo "Unidades: {$p['unidades']}\n";
        echo "Precio: {$p['precio_venta']} €\n";
        echo "Borrado: {$p['borrado']}\n";
        echo "----------------------------------------\n";
    }
    exit;
}

//Plantilla
inicioCabecera("CRUD Productos");
cabecera();
finCabecera();

inicioCuerpo("CRUD Productos", $ubicacion);
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{
?>
    <h2>Descargar productos filtrados</h2>

    <p>¿Quieres descargar los productos filtrados en un archivo TXT?</p>

    <form method="post">
        <button type="submit" name="descargar" class="boton">Descargar</button>
        <a href="index.php" class="boton">Cancelar</a>
    </form>
<?php
}
?>
