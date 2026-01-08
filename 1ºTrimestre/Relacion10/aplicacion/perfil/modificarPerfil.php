<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Perfil" => "/aplicacion/perfil/index.php",
    "Modificar Perfil" => "#",
];

// Restricciones 
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Obtener nick del usuario logeado
$nick = $acceso->getNick();


// PROCESAR FORMULARIO
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre = trim($_POST["nombre"] ?? "");
    $pass1  = $_POST["pass1"] ?? "";
    $pass2  = $_POST["pass2"] ?? "";

    $errores = [];

    if ($nombre === "") {
        $errores[] = "El nombre no puede estar vacío.";
    }

    if ($pass1 !== "" || $pass2 !== "") {
        if ($pass1 !== $pass2) {
            $errores[] = "Las contraseñas no coinciden.";
        }
    }

    if ($errores) {
        paginaError(implode("<br>", $errores));
        exit;
    }

    //  Actualizar tabla usuarios 
    $sent = $bd->prepare("UPDATE usuarios SET nombre = ? WHERE nick = ?");
    $sent->bind_param("ss", $nombre, $nick);
    $sent->execute();

    //  Actualizar tabla acl_usuarios
    $sent3 = $bd->prepare("UPDATE acl_usuarios SET nombre = ? WHERE nick = ?");
    $sent3->bind_param("ss", $nombre, $nick);
    $sent3->execute();

    //  Actualizar contraseña si procede 
    if ($pass1 !== "") {
        $hash = password_hash($pass1, PASSWORD_DEFAULT);

        $sent2 = $bd->prepare("UPDATE acl_usuarios SET contrasenia = ? WHERE nick = ?");
        $sent2->bind_param("ss", $hash, $nick);
        $sent2->execute();
    }

    // Redirigir al perfil
    header("Location: /aplicacion/perfil/index.php");
    exit;
}


// MOSTRAR FORMULARIO

// Cargar datos actuales del usuario
$sentencia = $bd->prepare("SELECT * FROM usuarios WHERE nick = ?");
$sentencia->bind_param("s", $nick);
$sentencia->execute();
$resultado = $sentencia->get_result();
$usuario = $resultado->fetch_assoc();


// VISTA
inicioCabecera("Modificar Perfil");
cabecera();
finCabecera();

inicioCuerpo("Modificar Perfil", $ubicacion);
cuerpo($usuario);
finCuerpo();

function cabecera() {}

function cuerpo($usuario)
{
?>
    <h2>Modificar Perfil</h2>

    <form method="post" action="modificarPerfil.php">

        <label>Nick (no modificable):</label><br>
        <input type="text" value="<?= $usuario['nick'] ?>" readonly><br><br>

        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= $usuario['nombre'] ?>"><br><br>

        <label>Nueva contraseña (opcional):</label><br>
        <input type="password" name="pass1"><br><br>

        <label>Repetir contraseña:</label><br>
        <input type="password" name="pass2"><br><br>

        <button type="submit" class="boton">Guardar cambios</button>
    </form>

<?php
}
