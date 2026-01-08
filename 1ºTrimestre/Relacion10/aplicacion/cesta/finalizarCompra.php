<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Compras" => "#",
];

// Restricciones de acceso
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

if (!$acceso->puedePermiso(8)) {
    paginaError("No tienes permiso para finalizar compras");
    exit;
}

// Validar que haya cesta
if (!isset($_SESSION["cesta"]) || empty($_SESSION["cesta"])) {
    paginaError("La cesta está vacía");
    exit;
}

// Recoger forma de pago y datos
$modo_pago = $_POST["forma_pago"] ?? "";
$datos_pago = $_POST["datos_pago"] ?? "";

if (!validaCadena($modo_pago, 20, "")) {
    paginaError("Debes indicar la forma de pago");
    exit;
}

if (!validaCadena($datos_pago, 100, "")) {
    paginaError("Debes indicar los datos de pago");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Obtener cod_usuario
$nick = $acceso->getNick();

$stmtUser = $bd->prepare("SELECT cod_usuario FROM usuarios WHERE nick = ?");
$stmtUser->bind_param("s", $nick);
$stmtUser->execute();
$resUser = $stmtUser->get_result();

if ($resUser->num_rows === 0) {
    paginaError("Usuario no encontrado");
    exit;
}

$cod_usuario = $resUser->fetch_assoc()["cod_usuario"];

// Validar stock y calcular totales
$importe_base_total = 0;
$importe_iva_total = 0;
$importe_total = 0;
$iva_porcentaje = 0.21;
$lineas = [];

foreach ($_SESSION["cesta"] as $cod => $uds) {

    $codVal = (int)$cod;
    $udsVal = (int)$uds;

    if (!validaEntero($codVal, 1, 999999, -1)) {
        paginaError("Producto inválido en la cesta");
        exit;
    }

    if (!validaEntero($udsVal, 1, 999999, -1)) {
        paginaError("Unidades inválidas en la cesta");
        exit;
    }

    $stmtP = $bd->prepare("SELECT unidades, precio_venta, nombre FROM productos WHERE cod_producto = ?");
    $stmtP->bind_param("i", $codVal);
    $stmtP->execute();
    $resP = $stmtP->get_result();

    if ($resP->num_rows === 0) {
        paginaError("Producto no encontrado");
        exit;
    }

    $p = $resP->fetch_assoc();

    if ($p["unidades"] < $udsVal) {
        paginaError("No hay suficientes unidades de " . $p["nombre"]);
        exit;
    }

    $precio = $p["precio_venta"];
    $base = $precio * $udsVal;
    $iva = round($base * $iva_porcentaje, 2);
    $total = round($base + $iva, 2);

    $importe_base_total += $base;
    $importe_iva_total += $iva;
    $importe_total += $total;

    $lineas[] = [
        "cod_producto" => $codVal,
        "orden" => count($lineas) + 1,
        "unidades" => $udsVal,
        "precio_unidad" => $precio,
        "iva" => $iva_porcentaje,
        "importe_base" => $base,
        "importe_iva" => $iva,
        "importe_total" => $total
    ];
}

// Insertar compra
$fecha = date("Y-m-d");

$stmt = $bd->prepare("
    INSERT INTO compras (
        cod_usuario, fecha, importe_base, importe_iva, importe_total,
        modo_pago, datos_pago
    ) VALUES (?, ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issddss",
    $cod_usuario,
    $fecha,
    $importe_base_total,
    $importe_iva_total,
    $importe_total,
    $modo_pago,
    $datos_pago
);

$stmt->execute();
$cod_compra = $bd->insert_id;

// Insertar líneas y actualizar stock
foreach ($lineas as $l) {

    $stmt = $bd->prepare("
        INSERT INTO compra_lineas (
            cod_compra, cod_producto, orden, unidades, precio_unidad,
            iva, importe_base, importe_iva, importe_total
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "iiiiddddd",
        $cod_compra,
        $l["cod_producto"],
        $l["orden"],
        $l["unidades"],
        $l["precio_unidad"],
        $l["iva"],
        $l["importe_base"],
        $l["importe_iva"],
        $l["importe_total"]
    );

    $stmt->execute();

    $stmtU = $bd->prepare("UPDATE productos SET unidades = unidades - ? WHERE cod_producto = ?");
    $stmtU->bind_param("ii", $l["unidades"], $l["cod_producto"]);
    $stmtU->execute();
}

// Vaciar cesta
unset($_SESSION["cesta"]);

// ARRAY DE DATOS PARA LA VISTA
$datos = [
    "cod_compra" => $cod_compra,
    "fecha" => $fecha,
    "modo_pago" => $modo_pago,
    "datos_pago" => $datos_pago,
    "importe_base" => $importe_base_total,
    "importe_iva" => $importe_iva_total,
    "importe_total" => $importe_total
];

// Plantilla
inicioCabecera("Compra realizada");
cabecera();
finCabecera();

inicioCuerpo("Compra realizada", $ubicacion);
cuerpo($datos);
finCuerpo();


// VISTA 

function cabecera() {}

function cuerpo($datos)
{
?>
    <h2>Compra realizada correctamente</h2>

    <p><strong>Código de compra:</strong> <?= $datos["cod_compra"] ?></p>
    <p><strong>Fecha:</strong> <?= $datos["fecha"] ?></p>
    <p><strong>Forma de pago:</strong> <?= $datos["modo_pago"] ?></p>
    <p><strong>Datos de pago:</strong> <?= htmlspecialchars($datos["datos_pago"]) ?></p>
    <p><strong>Importe base:</strong> <?= number_format($datos["importe_base"], 2) ?> €</p>
    <p><strong>IVA:</strong> <?= number_format($datos["importe_iva"], 2) ?> €</p>
    <p><strong>Total:</strong> <?= number_format($datos["importe_total"], 2) ?> €</p>

    <br>
    <a href="/index.php" class="boton">Volver a la tienda</a>
<?php
}
