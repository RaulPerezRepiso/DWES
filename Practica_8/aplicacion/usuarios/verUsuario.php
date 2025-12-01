<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(2)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}


// Dibuja la plantilla de la vista
inicioCabecera("Ver Usuario");
cabecera();
finCabecera();

inicioCuerpo("Ver Usuario");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
    global $servidor, $usuario, $contrasenia, $baseDatos;
    $bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

    $id = (int)$_GET["cod_usuario"];
    $res = $bd->query("SELECT * FROM usuarios WHERE cod_usuario=$id");
    if (!$res || $res->num_rows == 0) {
        echo "<div class='error'>Usuario no existe</div>";
        return;
    }
    $fila = $res->fetch_assoc();
?>
    <form>
        Nick: <input type="text" value="<?= htmlspecialchars($fila["nick"]) ?>" readonly><br>
        Nombre: <input type="text" value="<?= htmlspecialchars($fila["nombre"]) ?>" readonly><br>
        Provincia: <input type="text" value="<?= htmlspecialchars($fila["provincia"]) ?>" readonly><br>
        Foto: <img src="/imagenes/fotos/<?= htmlspecialchars($fila["foto"]) ?>" width="80"><br>
        <a href="index.php">Volver</a>
        <?php if ($GLOBALS['acceso']->puedePermiso(3)): ?>
            <a href="modificarUsuario.php?cod_usuario=<?= $id ?>">Modificar</a>
            <a href="borrarUsuario.php?nick=<?= urlencode($fila["nick"]) ?>">Borrar</a>
        <?php endif; ?>
    </form>
    <?php
    ?>
<?php

}
