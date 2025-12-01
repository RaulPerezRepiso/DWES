<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(3)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}


// Dibuja la plantilla de la vista
inicioCabecera("Modificar Usuario");
cabecera();
finCabecera();

inicioCuerpo("Modificar Usuario");
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $bd->real_escape_string($_POST["nombre"]);
        $provincia = $bd->real_escape_string($_POST["provincia"]);
        $sql = "UPDATE usuarios SET nombre='$nombre', provincia='$provincia' WHERE cod_usuario=$id";
        if ($bd->query($sql)) {
            header("Location: verUsuario.php?cod_usuario=$id");
            exit;
        } else {
            echo "<div class='error'>Error: " . $bd->error . "</div>";
        }
    }
?>
    <form method="post">
        Nick: <input type="text" value="<?= $fila["nick"] ?>" readonly><br>
        Nombre: <input type="text" name="nombre" value="<?= $fila["nombre"] ?>"><br>
        Provincia: <input type="text" name="provincia" value="<?= $fila["provincia"] ?>"><br>
        <button type="submit">Guardar</button>
        <a href="index.php">Cancelar</a>
        <a href="verUsuario.php?cod_usuario=<?= $id ?>">Volver</a>
    </form>
    <?php
    ?>

<?php

}
