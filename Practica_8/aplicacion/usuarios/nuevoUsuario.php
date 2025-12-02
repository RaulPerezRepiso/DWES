<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// Permisos: necesita 2 y 3
if (!$acceso->puedePermiso(2) || !$acceso->puedePermiso(3)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// Datos iniciales
$datos = [
    "nick" => "",
    "nombre" => "",
    "nif" => "",
    "direccion" => "",
    "poblacion" => "",
    "provincia" => "",
    "cp" => "00000",
    "fecha_nacimiento" => "",
    "borrado" => 0,
    "foto" => "",
    "contrasena" => ""
];
$errores = [];

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($datos as $campo => $valor) {
        if (isset($_POST[$campo])) $datos[$campo] = trim($_POST[$campo]);
    }
    $confirm = $_POST["contrasenaConfirm"] ?? "";

    // Validaciones básicas
    if ($datos["nick"] === "") $errores["nick"][] = "El nick es obligatorio";
    else {
        $res = $bd->query("SELECT 1 FROM usuarios WHERE nick='" . $bd->$datos["nick"] . "'");
        if ($res && $res->num_rows > 0) $errores["nick"][] = "El nick ya existe";
    }

    if ($datos["nombre"] === "") $errores["nombre"][] = "El nombre es obligatorio";
    if ($datos["contrasena"] === "" || $confirm === "") $errores["contrasena"][] = "Debes introducir contraseña y confirmación";
    else if ($datos["contrasena"] !== $confirm) $errores["contrasena"][] = "Las contraseñas no coinciden";

    // Foto
    $foto = "default.jpg";
    if (!empty($_FILES["foto"]["name"])) {
        $nombreFoto = bin2hex(random_bytes(10)) . ".jpg"; // 20 caracteres
        $destino = __DIR__ . "/../../imagenes/fotos/" . $nombreFoto;
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $destino)) {
            $foto = $nombreFoto;
        }
    }
    $datos["foto"] = $foto;

    // Insertar si no hay errores
    if (empty($errores)) {
        $sql = "INSERT INTO usuarios (nick,nombre,nif,direccion,poblacion,provincia,cp,fecha_nacimiento,borrado,foto)
                VALUES (
                    '{$bd->$datos["nick"]}',
                    '{$bd->$datos["nombre"]}',
                    '{$bd->$datos["nif"]}',
                    '{$bd->$datos["direccion"]}',
                    '{$bd->$datos["poblacion"]}',
                    '{$bd->$datos["provincia"]}',
                    '{$bd->$datos["cp"]}',
                    '{$bd->$datos["fecha_nacimiento"]}',
                    {$datos["borrado"]},
                    '{$bd->$datos["foto"]}'
                )";
        if ($bd->query($sql)) {
            $id = $bd->insert_id;

            // ACL coherente
            $rol = $_POST["rol"];
            $aclbd->anadirUsuario($datos["nombre"], $datos["nick"], $datos["contrasena"], $aclbd->getCodRole($rol));

            header("Location: verUsuario.php?id=$id");
            exit;
        } else {
            echo "<div class='error'>Error BD: " . $bd->error . "</div>";
        }
    }
}

// Plantilla
inicioCabecera("Nuevo Usuario");
cabecera();
finCabecera();

inicioCuerpo("Nuevo Usuario");
cuerpo($datos, $errores, $acl);
finCuerpo();

// **********************************************************

function cabecera() {}

function cuerpo($datos, $errores, $acl)
{
    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $campo => $lista) {
            foreach ($lista as $e) echo "$campo: $e<br>";
        }
        echo "</div>";
    }
?>
    <h2>Nuevo Usuario</h2>
    <form method="post" enctype="multipart/form-data">
        Nick: <input type="text" name="nick" value="<?= $datos["nick"] ?>"><br>
        Contraseña: <input type="password" name="contrasena"><br>
        Confirmar contraseña: <input type="password" name="contrasenaConfirm"><br>
        Rol:
        <select name="rol">
            <?php foreach ($acl->dameRoles() as $rol) {
                echo "<option value='$rol'>$rol</option>";
            } ?>
        </select><br><br>

        Nombre: <input type="text" name="nombre" value="<?= $datos["nombre"] ?>"><br>
        NIF: <input type="text" name="nif" value="<?= $datos["nif"] ?>"><br>
        Dirección: <input type="text" name="direccion" value="<?= $datos["direccion"] ?>"><br>
        Población: <input type="text" name="poblacion" value="<?= $datos["poblacion"] ?>"><br>
        Provincia: <input type="text" name="provincia" value="<?= $datos["provincia"] ?>"><br>
        CP: <input type="text" name="cp" value="<?= $datos["cp"] ?>"><br>
        Fecha nacimiento: <input type="date" name="fecha_nacimiento" value="<?= $datos["fecha_nacimiento"] ?>"><br>
        Borrado (0-no,1-sí): <input type="text" name="borrado" value="<?= $datos["borrado"] ?>"><br>
        Foto: <input type="file" name="foto"><br><br>

        <button type="submit">Registrar usuario</button>
        <a href="index.php">Cancelar</a>
    </form>
<?php
}
