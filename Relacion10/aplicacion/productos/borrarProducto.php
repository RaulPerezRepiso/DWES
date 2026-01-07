<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Productos" => "/aplicacion/productos/index.php",
    "Borrar Producto" => "#",
];

// Permiso
if (!$acceso->puedePermiso(9)) {
    paginaError("No tienes permisos para borrar un Producto");
    exit;
}

// Cerrar sesión (si existiera)
if (isset($_POST["cerrarSesion"])) {
    $acceso->quitarRegistroUsuario();
    header("Location: /index.php");
    exit;
}

// Comprobar id
if (!isset($_GET["id"])) {
    paginaError("Se debe pasar un id para que funcione esta página");
    exit;
}

$codProducto = (int)$_GET["id"];

// Validación del ID usando la librería (opcional pero correcto)
if (!validaEntero($codProducto, 1, 999999, -1)) {
    paginaError("El id del producto no es válido");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// Comprobar que existe
$consulta = $bd->query("SELECT * FROM productos WHERE cod_producto = $codProducto");

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el producto indicado");
    exit;
}

$producto = $consulta->fetch_assoc();

// Procesar SI / NO
if (isset($_POST["si"])) {

    $bd->query("UPDATE productos SET borrado = 1 WHERE cod_producto = $codProducto");

    header("Location: /aplicacion/productos/index.php");
    exit;
}

if (isset($_POST["no"])) {
    header("Location: /aplicacion/productos/index.php");
    exit;
}

//VISTA
inicioCabecera("Borrar Producto");
cabecera();
finCabecera();

inicioCuerpo("Borrar Producto", $ubicacion);
cuerpo($producto);
finCuerpo();

function cabecera() {}

function cuerpo($producto)
{
?>
    <div>
        <table class="tabla">
            <tr>
                <th>Nombre</th>
                <th>Fabricante</th>
                <th>Borrado</th>
            </tr>
            <tr>
                <td><?= $producto["nombre"] ?></td>
                <td><?= $producto["fabricante"] ?></td>
                <td><?= ($producto["borrado"] == 1 ? "Sí" : "No") ?></td>
            </tr>
        </table>
    </div>

    <br>
    <form action="" method="post">
        <label>¿Estás seguro que quieres eliminar este producto?</label>
        <input type="submit" value="Si" name="si" class="boton">
        <input type="submit" value="No" name="no" class="boton">
    </form>

    <br>
    <a href="./index.php" class="boton">Volver a productos</a>
<?php
}
