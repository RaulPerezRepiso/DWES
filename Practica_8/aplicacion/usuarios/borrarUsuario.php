<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(3)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}


// Dibuja la plantilla de la vista
inicioCabecera("Borrar Usuario");
cabecera();
finCabecera();

inicioCuerpo("Borrar Usuario");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
    global $servidor, $usuario, $contrasenia, $baseDatos;
    $bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

    $nick = $bd->real_escape_string($_GET["nick"]);
    $res = $bd->query("SELECT * FROM usuarios WHERE nick='$nick'");
    if (!$res || $res->num_rows == 0) {
        echo "<div class='error'>Usuario no existe</div>";
        return;
    }
    $fila = $res->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bd->query("UPDATE usuarios SET borrado=1 WHERE nick='$nick'");
        header("Location: index.php");
        exit;
    }
?>
    <form method="post">
        ¿Seguro que quieres borrar al usuario <?= htmlspecialchars($fila["nick"]) ?>?<br>
        <button type="submit">Confirmar</button>
        <a href="index.php">Cancelar</a>
        <a href="verUsuario.php?cod_usuario=<?= $fila["cod_usuario"] ?>">Volver</a>
    </form>
<?php


}
