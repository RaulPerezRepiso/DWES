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

// Solo usuarios con permiso 8 pueden ver sus compras
if (!$acceso->puedePermiso(8)) {
    paginaError("No tienes permiso para ver las compras");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Obtener cod_usuario por nick
$nick = $acceso->getNick();

$stmt = $bd->prepare("SELECT cod_usuario FROM usuarios WHERE nick = ?");
$stmt->bind_param("s", $nick);
$stmt->execute();
$res = $stmt->get_result();

$fila = $res->fetch_assoc();
if (!$fila) {
    paginaError("Usuario no encontrado");
    exit;
}

$cod_usuario = $fila["cod_usuario"];

// Obtener compras del usuario
$sent = $bd->prepare("
    SELECT cod_compra, fecha, importe_total 
    FROM compras 
    WHERE cod_usuario = ?
    ORDER BY fecha DESC
");
$sent->bind_param("i", $cod_usuario);
$sent->execute();
$compras = $sent->get_result()->fetch_all(MYSQLI_ASSOC);

// Vista
inicioCabecera("COMPRAS");
cabecera();
finCabecera();

inicioCuerpo("COMPRAS", $ubicacion);
cuerpo($compras);
finCuerpo();

function cabecera() {}

function cuerpo($compras)
{
?>
    <h2>Mis Compras</h2>

    <table class="tabla">
        <thead>
            <tr>
                <th>Código</th>
                <th>Fecha</th>
                <th>Total</th>
                <th>Ver</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compras as $c): ?>
                <tr>
                    <td><?= $c["cod_compra"] ?></td>
                    <td><?= $c["fecha"] ?></td>
                    <td><?= number_format($c["importe_total"], 2) ?> €</td>
                    <td>
                        <a class="boton" href="verCompra.php?cod=<?= $c["cod_compra"] ?>">Ver</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php
}
