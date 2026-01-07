<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Cesta" => "#",
];

// Restricciones de acceso
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// Solo usuarios con permiso 8 pueden comprar
if (!$acceso->puedePermiso(8)) {
    paginaError("No tienes permiso para acceder a la Cesta");
    exit;
}
 
// Si no hay cesta, pasar array vacío
$cesta = isset($_SESSION["cesta"]) ? $_SESSION["cesta"] : [];

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Cargar productos de la cesta
$productos = [];
$total = 0;

foreach ($cesta as $cod => $uds) {

    $codVal = (int)$cod;
    $udsVal = (int)$uds;

    if (!validaEntero($codVal, 1, 999999, -1)) continue;
    if (!validaEntero($udsVal, 1, 999999, -1)) continue;

    $stmt = $bd->prepare("SELECT * FROM cons_productos WHERE cod_producto = ?");
    $stmt->bind_param("i", $codVal);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) continue;

    $p = $res->fetch_assoc();
    $p["uds"] = $udsVal;
    $p["subtotal"] = $p["precio_venta"] * $udsVal;

    $total += $p["subtotal"];

    $productos[] = $p;
}

// VISTA
inicioCabecera("CESTA");
cabecera();
finCabecera();

inicioCuerpo("CESTA", $ubicacion);
cuerpo($productos, $total);
finCuerpo();


function cabecera() {}

function cuerpo($productos, $total)
{
    if (empty($productos)) {
        echo "<p>No hay productos en la cesta.</p>";
        return;
    }

    echo '<div class="contenedor-productos">';

    foreach ($productos as $p): ?>

        <div class="tarjeta-producto">
            <img src="/imagenes/productos/<?= $p['foto'] ?>" class="foto-producto">
            <h3><?= $p['nombre'] ?></h3>
            <p><strong>Precio:</strong> <?= number_format($p['precio_venta'], 2) ?> €</p>
            <p><strong>Unidades:</strong> <?= $p['uds'] ?></p>
            <p><strong>Subtotal:</strong> <?= number_format($p['subtotal'], 2) ?> €</p>

            <form method="post" action="quitarCesta.php">
                <input type="hidden" name="cod_producto" value="<?= $p['cod_producto'] ?>">
                <button type="submit" class="boton">Quitar</button>
            </form>
        </div>

    <?php endforeach;

    echo "</div>";

    echo "<h3>Total de la cesta: " . number_format($total, 2) . " €</h3>";
    ?>

    <form method="post" action="finalizarCompra.php">
        <h3>Forma de pago</h3>
        <select name="forma_pago" required>
            <option value="tarjeta">Tarjeta</option>
            <option value="transferencia">Transferencia</option>
        </select>

        <br><br>

        <label>Datos de pago:</label>
        <input type="text" name="datos_pago" required>

        <br><br>

        <button type="submit" class="boton">Finalizar compra</button>
    </form>

<?php
}
