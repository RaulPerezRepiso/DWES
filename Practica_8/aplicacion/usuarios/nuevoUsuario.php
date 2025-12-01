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
inicioCabecera("Nuevo Usuario");
cabecera();
finCabecera();

inicioCuerpo("Nuevo Usuario");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
    // Si se ha enviado el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        global $servidor, $usuario, $contrasenia, $baseDatos;
        $bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

        $nick = $bd->real_escape_string($_POST["nick"]);
        $nombre = $bd->real_escape_string($_POST["nombre"]);
        $provincia = $bd->real_escape_string($_POST["provincia"]);
        $cp = $bd->real_escape_string($_POST["cp"]);
        $fecha = $bd->real_escape_string($_POST["fecha_nacimiento"]);

        // Foto
        $foto = "default.jpg";
        if (!empty($_FILES["foto"]["name"])) {
            $nombreFoto = bin2hex(random_bytes(10)) . ".jpg";
            move_uploaded_file($_FILES["foto"]["tmp_name"], __DIR__ . "/../../imagenes/fotos/" . $nombreFoto);
            $foto = $nombreFoto;
        }

        $sql = "INSERT INTO usuarios (nick,nombre,provincia,cp,fecha_nacimiento,foto)
                VALUES ('$nick','$nombre','$provincia','$cp','$fecha','$foto')";
        if ($bd->query($sql)) {
            $id = $bd->insert_id;
            header("Location: verUsuario.php?cod_usuario=$id");
            exit;
        } else {
            echo "<div class='error'>Error: " . $bd->error . "</div>";
        }
    }
?>
    <form method="post" enctype="multipart/form-data">
        Nick: <input type="text" name="nick" required><br>
        Nombre: <input type="text" name="nombre"><br>
        Provincia: <input type="text" name="provincia"><br>
        CP: <input type="text" name="cp" value="00000"><br>
        Fecha nacimiento: <input type="date" name="fecha_nacimiento"><br>
        Foto: <input type="file" name="foto"><br>
        <button type="submit">Guardar</button>
        <a href="index.php">Cancelar</a>
    </form>

    ?>

<?php

}
