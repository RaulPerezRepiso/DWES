<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Borrar Usuario" => "/aplicacion/usuarios/borrarUsuario.php"
];

if (!$acceso->puedePermiso(2) && !$acceso->puedePermiso(3)) {
    paginaError("No tienes permisos para ver esta página");
    exit;
}

// Al darle al bototn de cerrar sesion
if (isset($_POST["cerrarSesion"])) {
    $acceso->quitarRegistroUsuario();
    header("Location: /index.php");
    exit;
}

// comprobar el nick
if (isset($_GET["nick"])) $nick = $_GET["nick"];
else {
    paginaError("Se debe pasar un nick para que funcione esta página");
}

// conexion a la base de datos
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

if ($bd->connect_errno) {
    paginaError("Fallo al contenctar a la base de datos: " . $bd->connect_error);
    exit;
}

// compruebo que el id que nos ha llegado existe
$sentencia = "select * from usuarios WHERE nick = '{$nick}'";
$consulta = $bd->query($sentencia);
if ($consulta->num_rows === 0) {
    paginaError("No existe el id introducido");
    exit;
}

$sentencia = "SELECT * FROM usuarios WHERE nick = '{$nick}'";
$consulta = $bd->query($sentencia);

$usuario;
while ($fila = $consulta->fetch_assoc()) {
    $usuario = $fila;
}

if (isset($_POST["si"])) {
    $sentencia = "UPDATE usuarios SET borrado = 1 WHERE nick = '{$nick}'";
    $bd->query($sentencia);
    header("Location: /aplicacion/usuarios/index.php");
    exit;
}
if (isset($_POST["no"])) {
    header("Location: /aplicacion/usuarios/index.php");
    exit;
}


// Dibuja la plantilla de la vista
inicioCabecera("Relación 9");
cabecera();
finCabecera();

inicioCuerpo("2 DAW - Relación 9");
cuerpo($usuario);
finCuerpo();


function cabecera() {}
//vista
function cuerpo($usuario)
{
?>
    <div class="tablabd">
        <table>
            <tr>
                <th>Nick</th>
                <th>Nombre</th>
                <th>NIF</th>
                <th>Direccion</th>
                <th>Poblacion</th>
                <th>Provincia</th>
                <th>CP</th>
                <th>Fecha_nacimiento</th>
                <th>Borrado</th>
                <th>Foto</th>
            </tr>
            <tr>
                <td><?= $usuario["nick"] ?></td>
                <td><?= $usuario["nombre"] ?></td>
                <td><?= $usuario["nif"] ?></td>
                <td><?= $usuario["direccion"] ?></td>
                <td><?= $usuario["poblacion"] ?></td>
                <td><?= $usuario["provincia"] ?></td>
                <td><?= $usuario["CP"] ?></td>
                <td><?= $usuario["fecha_nacimiento"] ?></td>
                <td><?= ($usuario["borrado"] == 1 ? "true" : "false") ?></td>
                <td><?= $usuario["foto"] ?></td>
            </tr>
        </table>
    </div>
    <a href="./index.php" style="margin-left: 10px;">Volver a usuarios</a>

    <form action="" method="post">
        <label for="">Estás seguro que quieres eliminar este usuario?</label>
        <input type="submit" value="Si" name="si">
        <input type="submit" value="No" name="no">
    </form>

<?php

}
