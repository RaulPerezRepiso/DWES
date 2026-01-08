<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Productos" => "#"
];

// Restricciones de acceso
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

if (!$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para acceder al CRUD de productos");
    exit;
}

// Inicializar filtros en sesión
if (!isset($_SESSION["filtro_nombre"])) $_SESSION["filtro_nombre"] = "";
if (!isset($_SESSION["filtro_categoria"])) $_SESSION["filtro_categoria"] = "";

// Procesar formulario de filtros
if (isset($_POST["filtrar"])) {

    $nombre = trim($_POST["filtro_nombre"]);
    $categoria = trim($_POST["filtro_categoria"]);

    // Validaciones según los temas
    if (validaCadena($nombre, 50, "")) {
        $_SESSION["filtro_nombre"] = $nombre;
    }

    if (validaCadena($categoria, 50, "")) {
        $_SESSION["filtro_categoria"] = $categoria;
    }
}

if (isset($_POST["borrar_filtros"])) {
    $_SESSION["filtro_nombre"] = "";
    $_SESSION["filtro_categoria"] = "";
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Cargar categorías
$categorias = [];
$resCat = $bd->query("SELECT descripcion FROM categorias ORDER BY descripcion");
while ($fila = $resCat->fetch_assoc()) {
    $categorias[] = $fila["descripcion"];
}

// Construir consulta
$where = [];

if ($_SESSION["filtro_nombre"] !== "") {
    $nombre = $_SESSION["filtro_nombre"];
    $where[] = "nombre LIKE '%$nombre%'";
}

if ($_SESSION["filtro_categoria"] !== "") {
    $cat = $_SESSION["filtro_categoria"];
    $where[] = "categoria = '$cat'";
}

$sentencia = "SELECT * FROM cons_productos";

if (!empty($where)) {
    $sentencia .= " WHERE " . implode(" AND ", $where);
}

$sentencia .= " ORDER BY nombre";

$consulta = $bd->query($sentencia);

if ($bd->errno) {
    paginaError("Error al cargar productos: " . $bd->error);
    exit;
}

$productos = [];
while ($fila = $consulta->fetch_assoc()) {
    $productos[] = $fila;
}


// VISTA 
inicioCabecera("CRUD Productos");
cabecera();
finCabecera();

inicioCuerpo("CRUD Productos", $ubicacion);
cuerpo($productos, $categorias);
finCuerpo();

function cabecera() {}

function cuerpo($productos, $categorias)
{
?>
    <h2>Gestión de Productos</h2>

    <table class="tabla">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Fabricante</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Unidades</th>
                <th>Borrado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td>
                        <img src="/imagenes/productos/<?= $p['foto'] ?>"
                            alt="<?= $p['nombre'] ?>"
                            style="width:60px; height:60px; object-fit:cover;">
                    </td>

                    <td><?= $p['nombre'] ?></td>
                    <td><?= $p['fabricante'] ?></td>
                    <td><?= $p['categoria'] ?></td>
                    <td><?= number_format($p['precio_venta'], 2) ?> €</td>
                    <td><?= $p['unidades'] ?></td>
                    <td><?= $p['borrado'] ?></td>

                    <td>
                        <a href="verProducto.php?id=<?= $p['cod_producto'] ?>">Ver</a> |
                        <a href="modificarProducto.php?id=<?= $p['cod_producto'] ?>">Modificar</a> |
                        <a href="borrarProducto.php?id=<?= $p['cod_producto'] ?>">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <br>

    <form method="post">
        Nombre:
        <input type="text" name="filtro_nombre" value="<?= $_SESSION['filtro_nombre'] ?>">

        Categoría:
        <select name="filtro_categoria">
            <option value="">-- Todas --</option>
            <?php foreach ($categorias as $c): ?>
                <option value="<?= $c ?>" <?= ($_SESSION['filtro_categoria'] == $c) ? "selected" : "" ?>>
                    <?= $c ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="filtrar" class="boton">Filtrar</button>
        <button type="submit" name="borrar_filtros" class="boton">Borrar filtros</button>
    </form>

    <br>

    <form method="post" action="descargar.php">
        <button type="submit" class="boton">Descargar TXT</button>
    </form>

    <form method="post" action="cargarFichero.php">
        <button type="submit" class="boton">Cargar fichero</button>
    </form>

    <a href="nuevoProducto.php" class="boton">Nuevo Producto</a>

<?php
}
