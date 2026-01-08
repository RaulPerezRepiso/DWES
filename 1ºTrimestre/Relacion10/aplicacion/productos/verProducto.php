<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Productos" => "/aplicacion/productos/index.php",
    "Ver Producto" => "#",
];

// Recoger el id del producto
if (isset($_GET["id"])) {
    $codProducto = (int)$_GET["id"];
} else {
    paginaError("No se ha especificado id");
    exit;
}

// Comprobar permisos (solo permiso 9)
if (!$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para ver productos");
    exit;
}

// Conexión a la base de datos
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// Comprobar que el producto existe
$sentencia = "SELECT * FROM cons_productos WHERE cod_producto = {$codProducto}";
$consulta = $bd->query($sentencia);

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el producto indicado");
    exit;
}

// Obtener datos del producto
$producto = $consulta->fetch_assoc();

// Dibujar la plantilla
inicioCabecera("Ver Producto");
cabecera();
finCabecera();

inicioCuerpo("Ver Producto", $ubicacion);
cuerpo($producto, $acceso);
finCuerpo();

// **********************************************************

function cabecera() {}

// vista
function cuerpo($p, $acceso)
{
?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Fabricante</th>
                <th>Categoría</th>
                <th>Fecha Alta</th>
                <th>Unidades</th>
                <th>Precio Venta</th>
                <th>Borrado</th> <?php if ($acceso->puedePermiso(9)) echo "<th>Acciones</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td> <img src="/imagenes/productos/<?= $p["foto"] ?>" alt="<?= $p["nombre"] ?>" style="width:80px; height:80px; object-fit:cover;"> </td>
                <td><?= $p["nombre"] ?></td>
                <td><?= $p["fabricante"] ?></td>
                <td><?= $p["categoria"] ?></td>
                <td><?= $p["fecha_alta"] ?></td>
                <td><?= $p["unidades"] ?></td>
                <td><?= number_format($p["precio_venta"], 2) ?> €</td>
                <td><?= ($p['borrado'] == 1 ? "Sí" : "No") ?></td>
                <?php if ($acceso->puedePermiso(9)) {
                    echo "<td> <a href='modificarProducto.php?id={$p["cod_producto"]}'>Modificar</a>
                    <a href='borrarProducto.php?id={$p["cod_producto"]}'>Borrar</a> </td>";
                } ?>
            </tr>
        </tbody>
    </table>

    <a href="./index.php" class="boton">Volver a productos</a>
<?php
}
