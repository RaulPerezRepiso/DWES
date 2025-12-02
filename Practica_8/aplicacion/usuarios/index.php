<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// --- Restricciones de acceso ---
// Comprobar si hay Usuario
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}
// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(2)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}

// Entrar a la base de datos con usuario correcto
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

// ---Construcción dinámica de la sentencia--- 
$condiciones = [];

if (!empty($_GET['nick'])) {
    $nick = $bd->real_escape_string($_GET['nick']);
    $condiciones[] = "nick LIKE '%$nick%'";
}
if (!empty($_GET['provincia'])) {
    $provincia = $bd->real_escape_string($_GET['provincia']);
    $condiciones[] = "provincia LIKE '%$provincia%'";
}
if (isset($_GET['borrado']) && $_GET['borrado'] !== '') {
    $borrado = (int)$_GET['borrado'];
    $condiciones[] = "borrado = $borrado";
}

$sentencia = "SELECT * FROM usuarios";
if ($condiciones) {
    $sentencia .= " WHERE " . implode(" AND ", $condiciones);
}


// Ordenación segura
$orden = $_GET['orden'] ?? 'nick';
$ordenPermitidos = ['nick', 'provincia', 'nombre'];
if (!in_array($orden, $ordenPermitidos)) {
    $orden = 'nick';
}
$sentencia .= " ORDER BY $orden";

// Consulta de la sentencia creada
@$consulta = $bd->query($sentencia);

if ($bd->errno) {
    paginaError("Error en consulta: " . $bd->error);
    exit;
}

// Array con los datos
$filas = [];

// Proceso los datos y los modifico fila a fila con fetch_assoc
while ($fila = $consulta->fetch_assoc()) {
    // Ejemplo de columna calculada opcional
    $filas[] = $fila;
}

// Dibuja la plantilla de la vista
inicioCabecera("CRUD");
cabecera();
finCabecera();

inicioCuerpo("CRUD");
cuerpo($filas);
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo($filas)
{
?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nick</th>
                <th>Nombre</th>
                <th>NIF</th>
                <th>Dirección</th>
                <th>Población</th>
                <th>Provincia</th>
                <th>Código Postal</th>
                <th>Fecha Nacimiento</th>
                <th>Borrado</th>
                <th>Foto</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= $fila["nick"] ?></td>
                    <td><?= $fila["nombre"] ?></td>
                    <td><?= $fila["nif"] ?></td>
                    <td><?= $fila["direccion"] ?></td>
                    <td><?= $fila["poblacion"] ?></td>
                    <td><?= $fila["provincia"] ?></td>
                    <td><?= $fila["cp"] ?></td>
                    <td><?= $fila["fecha_nacimiento"] ?? "" ?></td>
                    <td><?= $fila["borrado"] ? "Sí" : "No" ?></td>
                    <td><?= $fila["foto"] ?></td>
                    <td>
                        <a href="verUsuario.php?id=<?= $fila['cod_usuario'] ?>">Ver</a>
                        <a href="modificarUsuario.php?id=<?= $fila['cod_usuario'] ?>">Modificar</a>
                        <a href="borrarUsuario.php?nick=<?= $fila['nick'] ?>">Borrar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <ul>
        <a href="nuevoUsuario.php">Nuevo Usuario</a><br>
    </ul>
    <form method="get" class="filtros">
        <label>Nick:
            <input type="text" name="nick" value="<?= $_GET['nick'] ?? '' ?>">
        </label>
        <label>Provincia:
            <input type="text" name="provincia" value="<?= $_GET['provincia'] ?? '' ?>">
        </label>
        <label>Borrado:
            <select name="borrado">
                <option value="0" <?= (($_GET['borrado'] ?? '') === '0') ? 'selected' : '' ?>>No</option>
                <option value="1" <?= (($_GET['borrado'] ?? '') === '1') ? 'selected' : '' ?>>Sí</option>
            </select>
        </label>
        <label>Ordenar por:
            <select name="orden">
                <option value="nick">Nick</option>
                <option value="provincia">Provincia</option>
                <option value="nombre">Nombre</option>
            </select>
        </label>
        <button type="submit" class="boton">Filtrar</button>
    </form>
<?php

}
