<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Compras" => "/aplicacion/cesta/index.php",
    "Detalle" => "#",
];

// Restricciones
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

if (!isset($_GET["cod"])) {
    paginaError("Compra no especificada");
    exit;
}

// Obtenemos el código de la compra seleccionada para mostrarlar
$cod_compra = intval($_GET["cod"]);

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Obtener compra
$stmt = $bd->prepare("
    SELECT * FROM compras WHERE cod_compra = ?
");
$stmt->bind_param("i", $cod_compra);
$stmt->execute();
$compra = $stmt->get_result()->fetch_assoc();

if (!$compra) {
    paginaError("La compra no existe");
    exit;
}

// Obtener líneas
$stmt = $bd->prepare("
    SELECT cl.*, p.nombre 
    FROM compra_lineas cl
    JOIN productos p ON cl.cod_producto = p.cod_producto
    WHERE cl.cod_compra = ?
    ORDER BY orden
");
$stmt->bind_param("i", $cod_compra);
$stmt->execute();
$lineas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Vista
inicioCabecera("Detalle Compra");
cabecera();
finCabecera();

inicioCuerpo("Detalle Compra", $ubicacion);
cuerpo($compra, $lineas);
finCuerpo();

function cabecera() {}

function cuerpo($compra, $lineas)
{
?>
    <h2>Detalle de la Compra <?= $compra["cod_compra"] ?></h2>

    <p><strong>Fecha:</strong> <?= $compra["fecha"] ?></p>
    <p><strong>Forma de pago:</strong> <?= $compra["modo_pago"] ?></p>
    <p><strong>Datos de pago:</strong> <?= htmlspecialchars($compra["datos_pago"]) ?></p>
    <p><strong>Total:</strong> <?= number_format($compra["importe_total"], 2) ?> €</p>

    <h3>Productos</h3>

    <table class="tabla">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Unidades</th>
                <th>Precio</th>
                <th>IVA</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lineas as $l): ?>
                <tr>
                    <td><?= $l["nombre"] ?></td>
                    <td><?= $l["unidades"] ?></td>
                    <td><?= number_format($l["precio_unidad"], 2) ?> €</td>
                    <td><?= number_format($l["importe_iva"], 2) ?> €</td>
                    <td><?= number_format($l["importe_total"], 2) ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php
}
