<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Perfil" => "#",
];

// Restricciones de acceso 
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// Conexión BD
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Obtener nick del usuario logeado
$nick = $acceso->getNick();

// Consulta a la tabla usuarios
$sentencia = $bd->prepare("SELECT * FROM usuarios WHERE nick = ?");
$sentencia->bind_param("s", $nick);
$sentencia->execute();
$resultado = $sentencia->get_result();

$usuario = $resultado->fetch_assoc();

// VISTA
inicioCabecera("PERFIL");
cabecera();
finCabecera();

inicioCuerpo("PERFIL", $ubicacion);
cuerpo($usuario);
finCuerpo();

function cabecera() {}

function cuerpo($usuario)
{
?>
    <h2>Mi Perfil</h2>

    <table class="tabla">
        <thead>
            <tr>
                <th>Campo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Nick</td>
                <td><?= $usuario["nick"] ?></td>
            </tr>
            <tr>
                <td>Nombre</td>
                <td><?= $usuario["nombre"] ?></td>
            </tr>
        </tbody>
    </table>

    <br>
    <a href="modificarPerfil.php" class="boton">Modificar Perfil</a>

<?php
}
