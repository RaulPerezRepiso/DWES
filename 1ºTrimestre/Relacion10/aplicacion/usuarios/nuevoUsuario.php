<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Usuarios" => "/aplicacion/usuarios/index.php",
    "Nuevo Usuario" => "#"
];

// Validacion para usuario con permiso válido
if (!$acceso->puedePermiso(10)) {
    paginaError("No tienes permiso para crear un nuevo Usuario");
    exit;
}

$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

//Datos que tenemos que cargar para crear un nuevo usuario
$datos = [
    "nick" => "",
    "nombre" => "",
    "contrasena" => "",
    "contrasenaConfirm" => "",
    "rol" => ""
];

//Almacenamos si es que hay errores
$errores = [];

$roles = $aclbd->dameRoles();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    foreach ($datos as $campo => $valor) {
        $datos[$campo] = trim($_POST[$campo] ?? "");
    }

    // El campo nick tiene que ser obligatorio
    if ($datos["nick"] === "") {
        $errores["nick"][] = "El nick es obligatorio";
    } else {
        $res = $bd->query("SELECT 1 FROM usuarios WHERE nick='" . $datos["nick"] . "'");
        if ($res && $res->num_rows > 0) {
            $errores["nick"][] = "El nick ya existe";
        }
    }

    //Comprobamos que los campos on esten vacios o sean válidos
    if ($datos["nombre"] === "") {
        $errores["nombre"][] = "El nombre es obligatorio";
    }

    if ($datos["contrasena"] === "") {
        $errores["contrasena"][] = "La contraseña es obligatoria";
    }

    if ($datos["contrasena"] !== $datos["contrasenaConfirm"]) {
        $errores["contrasenaConfirm"][] = "Las contraseñas no coinciden";
    }

    if (!array_key_exists($datos["rol"], $roles)) {
        $errores["rol"][] = "Rol no válido";
    }

    // Sino hay errrores guardamos los datosy los insertamos
    if (empty($errores)) {

        $nick   = $datos["nick"];
        $nombre = $datos["nombre"];
        $hash   = password_hash($datos["contrasena"], PASSWORD_BCRYPT);
        $rol    = intval($datos["rol"]);

        // Insertar en usuarios
        $sql1 = "INSERT INTO usuarios (nick, nombre) VALUES ('$nick', '$nombre')";
        $bd->query($sql1);

        // Insertar en acl_usuarios
        $sql2 = "INSERT INTO acl_usuarios (nick, nombre, contrasenia, cod_acl_role, borrado)
                 VALUES ('$nick', '$nombre', '$hash', $rol, 0)";
        $bd->query($sql2);

        header("Location: index.php");
        exit;
    }
}

inicioCabecera("Nuevo Usuario");
cabecera();
finCabecera();

inicioCuerpo("Crear Usuario", $ubicacion);
cuerpo($datos, $errores, $roles);
finCuerpo();

function cabecera() {}

function cuerpo($datos, $errores, $roles)
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
    <form method="post">

        Nick: <input type="text" name="nick" value="<?= $datos["nick"] ?>"><br>
        Nombre: <input type="text" name="nombre" value="<?= $datos["nombre"] ?>"><br>
        Contraseña: <input type="password" name="contrasena"><br>
        Confirmar contraseña: <input type="password" name="contrasenaConfirm"><br>

        Rol:
        <select name="rol">
            <option value="">-- Selecciona rol --</option>
            <?php foreach ($roles as $cod => $nombre): ?>
                <option value="<?= $cod ?>" <?= $datos["rol"] == $cod ? "selected" : "" ?>>
                    <?= $nombre ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <button type="submit">Registrar usuario</button>
        <a href="index.php">Cancelar</a>
    </form>
<?php
}
