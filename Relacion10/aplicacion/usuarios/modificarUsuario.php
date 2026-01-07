<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Usuarios" => "/aplicacion/usuarios/index.php",
    "Modificar Usuario" => "#"
];

// Permiso correcto: 10 
if (!$acceso->puedePermiso(10)) {
    paginaError("No tienes permisos para modificar un Usuario");
    exit;
}

//Recoger id
if (!isset($_GET["id"])) {
    paginaError("No se ha introducido ningún id");
    exit;
}

$codUsuario = (int)$_GET["id"];

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Cargar usuario
$res = $bd->query("SELECT * FROM acl_usuarios WHERE cod_acl_usuario = $codUsuario");
if (!$res || $res->num_rows === 0) {
    paginaError("Usuario no existe");
    exit;
}
$usuario = $res->fetch_assoc();

// Cargar roles
$roles = $aclbd->dameRoles(); // [cod => nombre]
$rolActual = $usuario["cod_acl_role"];

// Procesar modificación
if (isset($_POST["modificar"])) {

    $nombre   = $_POST["nombre"];
    $borrado  = $_POST["borrado"];
    $rolNuevo = (int)$_POST["rol"];
    $nick     = $usuario["nick"];

    // Actualizar tabla acl_usuarios
    $sqlAcl = "
        UPDATE acl_usuarios SET
            nombre = '$nombre',
            borrado = '$borrado',
            cod_acl_role = $rolNuevo
        WHERE cod_acl_usuario = $codUsuario
    ";

    if ($bd->query($sqlAcl)) {

        // Actualizar contraseña si se ha indicado
        if (!empty($_POST["contrasena"])) {
            $hash = password_hash($_POST["contrasena"], PASSWORD_BCRYPT);
            $bd->query("
                UPDATE acl_usuarios
                SET contrasenia = '$hash'
                WHERE cod_acl_usuario = $codUsuario
            ");
        }

        // Actualizar tabla usuarios 
        $bd->query("
            UPDATE usuarios
            SET nombre = '$nombre'
            WHERE nick = '$nick'
        ");

        header("Location: verUsuario.php?id=$codUsuario");
        exit;
    } else {
        echo "<div class='error'>Error BD: " . $bd->error . "</div>";
    }
}

// VISTAS
inicioCabecera("Modificar Usuario");
cabecera();
finCabecera();

inicioCuerpo("Modificar Usuario", $ubicacion);
formulario($usuario, $rolActual, $roles, $codUsuario);
finCuerpo();

function cabecera() {}

function formulario($usuario, $rolActual, $roles, $codUsuario)
{
?>
    <h2>MODIFICAR USUARIO</h2>
    <form method="post">

        <label>Nick:</label>
        <input type="text" value="<?= $usuario["nick"] ?>" readonly><br>

        <label>Contraseña (opcional):</label>
        <input type="password" name="contrasena"><br>

        <label>Rol:</label>
        <select name="rol">
            <?php foreach ($roles as $cod => $nombre): ?>
                <option value="<?= $cod ?>" <?= $cod == $rolActual ? "selected" : "" ?>>
                    <?= $nombre ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $usuario["nombre"] ?>"><br>

        <label>Borrado (0-no, 1-sí):</label>
        <input type="text" name="borrado" value="<?= $usuario["borrado"] ?>"><br>

        <input type="submit" value="Modificar usuario" name="modificar" class="boton"><br>

        <a href="./index.php" class="boton">Volver a usuarios</a>
        <a href="verUsuario.php?id=<?= $codUsuario ?>" class="boton">Cancelar</a>
    </form>
<?php
}
