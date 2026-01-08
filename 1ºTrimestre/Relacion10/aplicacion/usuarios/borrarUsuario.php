<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Usuarios" => "/aplicacion/usuarios/index.php",
    "Borrar Usuario" => "#"
];

// Permiso correcto sea 10 
if (!$acceso->puedePermiso(10)) {
    paginaError("No tienes permisos para borrar un Usuario");
    exit;
}

//  Comprobar nick recibido
if (!isset($_GET["nick"])) {
    paginaError("Se debe pasar un nick para que funcione esta página");
    exit;
}

$nick = $_GET["nick"];

// Conexión BD 
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// Comprobar que el usuario existe
$consulta = $bd->query("SELECT * FROM acl_usuarios WHERE nick = '$nick'");
if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el usuario indicado");
    exit;
}

$usuario = $consulta->fetch_assoc();

// --- Procesar borrado ---
if (isset($_POST["si"])) {

    // Borrado lógico en ACL
    $bd->query("UPDATE acl_usuarios SET borrado = 1 WHERE nick = '$nick'");

    // Borrado lógico en tabla usuarios
    $bd->query("UPDATE usuarios SET borrado = 1 WHERE nick = '$nick'");

    header("Location: /aplicacion/usuarios/index.php");
    exit;
}

if (isset($_POST["no"])) {
    header("Location: /aplicacion/usuarios/index.php");
    exit;
}

// --- Vista ---
inicioCabecera("Borrar Usuario");
cabecera();
finCabecera();

inicioCuerpo("Borrar Usuario", $ubicacion);
cuerpo($usuario);
finCuerpo();

function cabecera() {}

function cuerpo($usuario)
{
?>
    <div>
        <table class="tabla">
            <tr>
                <th>Nick</th>
                <th>Nombre</th>
                <th>Borrado</th>
            </tr>
            <tr>
                <td><?= $usuario["nick"] ?></td>
                <td><?= $usuario["nombre"] ?></td>
                <td><?= ($usuario["borrado"] == 1 ? "Sí" : "No") ?></td>
            </tr>
        </table>
    </div>

    <br>
    <form action="" method="post">
        <label>¿Estás seguro que quieres eliminar este usuario?</label>
        <input type="submit" value="Si" name="si" class="boton">
        <input type="submit" value="No" name="no" class="boton">
    </form>

    <br>
    <a href="./index.php" class="boton">Volver a usuarios</a>
<?php
}
