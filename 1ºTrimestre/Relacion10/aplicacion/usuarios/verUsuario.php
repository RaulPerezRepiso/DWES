<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Usuarios" => "/aplicacion/usuarios/index.php",
    "Ver Usuario" => "#",
];

// Validación del parámetro id de ese usaurio seleccionado
if (!isset($_GET["id"])) {
    paginaError("No se ha especificado id");
    exit;
}

$codUsuario = (int)$_GET["id"];

// Comprobar permisos
// Solo permiso 10 (CRUD usuarios)
if (!$acceso->puedePermiso(10)) {
    paginaError("No tienes permiso para ver los Usuarios");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// Comprobar que el usuario existe
$sentencia = "SELECT * FROM acl_usuarios WHERE cod_acl_usuario = $codUsuario";
$consulta = $bd->query($sentencia);

if (!$consulta || $consulta->num_rows === 0) {
    paginaError("No existe el usuario indicado");
    exit;
}

$usuario = $consulta->fetch_assoc();

// Vista
inicioCabecera("Ver Usuario");
cabecera();
finCabecera();

inicioCuerpo("Ver Usuario", $ubicacion);
cuerpo($usuario, $acceso);
finCuerpo();

function cabecera() {}

// Vista
function cuerpo($usuario, $acceso)
{
?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nick</th>
                <th>Nombre</th>
                <th>Borrado</th>
                <?php if ($acceso->puedePermiso(10)) echo "<th>Acciones</th>"; ?>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?= $usuario["nick"] ?></td>
                <td><?= $usuario["nombre"] ?></td>
                <td><?= $usuario["borrado"] == 1 ? "Sí" : "No" ?></td>

                <?php if ($acceso->puedePermiso(10)): ?>
                    <td>
                        <a href="modificarUsuario.php?id=<?= $usuario["cod_acl_usuario"] ?>">Modificar</a>
                        <a href="borrarUsuario.php?nick=<?= $usuario["nick"] ?>">Borrar</a>
                    </td>
                <?php endif; ?>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="./index.php" class="boton">Volver a usuarios</a>
<?php
}
