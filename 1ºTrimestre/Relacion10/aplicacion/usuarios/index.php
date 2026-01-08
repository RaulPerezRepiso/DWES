<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio"   => "/index.php",
    "Usuarios" => "#",
];

// --- Restricciones de acceso ---
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// Restriccion de permisos
if (!$acceso->puedePermiso(10)) {
    paginaError("No tienes permiso para acceder al CRUD de Usuarios");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Validar que el nick sea correcto
$nickFiltro = "";
if (isset($_GET["nick"])) {
    if (validaCadena($_GET["nick"], 50, "")) {
        $nickFiltro = $_GET["nick"];
    }
}
// Condiciones de las consultas
$condiciones = [];

if ($nickFiltro !== "") {
    $condiciones[] = "nick LIKE '%" . $nickFiltro . "%'";
}

$sentencia = "SELECT * FROM acl_usuarios";

if (count($condiciones) > 0) {
    $sentencia .= " WHERE " . implode(" AND ", $condiciones);
}

$orden = "nick";
if (isset($_GET["orden"])) {
    if ($_GET["orden"] === "nick" || $_GET["orden"] === "nombre") {
        $orden = $_GET["orden"];
    }
}

$sentencia .= " ORDER BY " . $orden;

// Ejecutamos la consulta 
$consulta = $bd->query($sentencia);

// Siempre y cuando sea válida
if ($bd->errno) {
    paginaError("Error en consulta: " . $bd->error);
    exit;
}

$filas = [];

while ($fila = $consulta->fetch_assoc()) {
    $filas[] = $fila;
}

// VISTA
inicioCabecera("CRUD Usuarios");
cabecera();
finCabecera();

inicioCuerpo("CRUD Usuarios", $ubicacion);
cuerpo($filas, $nickFiltro, $orden);
finCuerpo();

// **********************************************************
function cabecera() {}

function cuerpo($filas, $nickFiltro, $orden)
{
?>
    <form method="get">
        Nick:
        <input type="text" name="nick" value="<?= $nickFiltro ?>"><br>

        Ordenar por:
        <select name="orden">
            <option value="nick"   <?= $orden === "nick" ? "selected" : "" ?>>Nick</option>
            <option value="nombre" <?= $orden === "nombre" ? "selected" : "" ?>>Nombre</option>
        </select>

        <button type="submit">Filtrar</button>
        <a href="index.php">Borrar filtros</a>
    </form>

    <br>

    <table class="tabla">
        <tr>
            <th>Nick</th>
            <th>Nombre</th>
            <th>Borrado</th>
            <th>Acciones</th>
        </tr>

        <?php foreach ($filas as $fila): ?>
            <tr>
                <td><?= $fila["nick"] ?></td>
                <td><?= $fila["nombre"] ?></td>
                <td><?= $fila["borrado"] ?></td>
                <td>
                    <a href="verUsuario.php?id=<?= $fila["cod_acl_usuario"] ?>">Ver</a>
                    <a href="modificarUsuario.php?id=<?= $fila["cod_acl_usuario"] ?>">Modificar</a>
                    <a href="borrarUsuario.php?nick=<?= $fila["nick"] ?>">Borrar</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="nuevoUsuario.php">Nuevo Usuario</a>
<?php
}
