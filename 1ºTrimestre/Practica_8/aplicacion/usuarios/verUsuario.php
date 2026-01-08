<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "verUsuario" => "/aplicacion/usuarios/verUsuario.php"
];

// Recoger el id del usuario
if (isset($_GET["id"])) {
    $codUsuario = (int)$_GET["id"];
} else {
    paginaError("No se ha especificado id");
    exit;
}

// Comprobar permisos
if (!$acceso->puedePermiso(2)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}

// Conexión a la base de datos
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// Comprobar que el id existe del usuario selecionado existe
$sentencia = "SELECT * FROM usuarios WHERE cod_usuario = {$codUsuario}";
$consulta = $bd->query($sentencia);
if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el id introducido");
    exit;
}

// Obtener datos del usuario
$usuario = $consulta->fetch_assoc();

// Dibujar la plantilla
inicioCabecera("Ver Usuario");
cabecera();
finCabecera();

inicioCuerpo("Ver Usuario");
cuerpo($usuario, $acceso);
finCuerpo();

// **********************************************************

function cabecera() {}

// vista
function cuerpo($usuario, $acceso)
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
                <th>CP</th>
                <th>Fecha nacimiento</th>
                <th>Borrado</th>
                <th>Foto</th>
                <?php if ($acceso->puedePermiso(3)) echo "<th>Acciones</th>"; ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?= $usuario["nick"] ?></td>
                <td><?= $usuario["nombre"] ?></td>
                <td><?= $usuario["nif"] ?></td>
                <td><?= $usuario["direccion"] ?></td>
                <td><?= $usuario["poblacion"] ?></td>
                <td><?= $usuario["provincia"] ?></td>
                <td><?= $usuario["cp"] ?></td>
                <td><?= $usuario["fecha_nacimiento"] ?></td>
                <td><?= $usuario["borrado"] == 1 ? "Sí" : "No" ?></td>
                <td>
                    <img src="/imagenes/fotos/<?= ($usuario["foto"] ?: 'default.jpg') ?>" width="80" alt="foto usuario">
                </td>
                <?php if ($acceso->puedePermiso(3)) echo "<td>
                    <a href='modificarUsuario.php?id={$usuario["cod_usuario"]}'>Modificar</a>
                    <a href='borrarUsuario.php?nick={$usuario["nick"]}'>Borrar</a>
                </td>"; ?>
            </tr>
        </tbody>
    </table>
    <a href="./index.php">Volver a usuarios</a>
<?php
}
