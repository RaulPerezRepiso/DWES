<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Modificar Usuario" => "/aplicacion/usuarios/modificarUsuario.php"
];

// --- Permisos: necesita 2 y 3 ---
if (!$acceso->puedePermiso(2) || !$acceso->puedePermiso(3)) {
    paginaError("No tienes permisos para ver esta página");
    exit;
}

// --- Recoger id ---
if (isset($_GET["id"])) {
    $codUsuario = (int)$_GET["id"];
} else {
    paginaError("No se ha introducido ningún id");
    exit;
}

// --- Conexión BD ---
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a la base de datos: " . $bd->connect_error);
    exit;
}

// --- ACLBD ---
$aclbd = new ACLBD($servidor, $usuario, $contrasenia, $baseDatos);

// --- Comprobar que existe ---
$res = $bd->query("SELECT * FROM usuarios WHERE cod_usuario = $codUsuario");
if (!$res || $res->num_rows === 0) {
    paginaError("Usuario no existe");
    exit;
}
$usuario = $res->fetch_assoc();

// --- Rol actual desde ACL ---
$rolActual = $aclbd->getUsuarioRole($aclbd->getCodUsuario($usuario["nick"]));

// --- Procesar modificación ---
if (isset($_POST["modificar"])) {
    $nick       = $usuario["nick"]; // no se cambia
    $nombre     = $_POST["nombre"];
    $nif        = $_POST["nif"];
    $direccion  = $_POST["direccion"];
    $poblacion  = $_POST["poblacion"];
    $provincia  = $_POST["provincia"];
    $cp         = $_POST["cp"];
    $fecha      = $_POST["fechaNacimiento"];
    $borrado    = $_POST["borrado"];
    $foto       = $_POST["foto"];
    $rolNuevo   = $_POST["rol"];

    // Actualizar BD
    $sql = "UPDATE usuarios SET 
                nombre='$nombre',
                nif='$nif',
                direccion='$direccion',
                poblacion='$poblacion',
                provincia='$provincia',
                cp='$cp',
                fecha_nacimiento='$fecha',
                borrado='$borrado',
                foto='$foto'
            WHERE cod_usuario=$codUsuario";
    if ($bd->query($sql)) {
        if (!empty($_POST["contrasena"])) {
            $aclbd->setContrasenia($aclbd->getCodUsuario($nick), $_POST["contrasena"]);
        }
        if (!empty($rolNuevo)) {
            $aclbd->setUsuarioRole($aclbd->getCodUsuario($nick), $aclbd->getCodRole($rolNuevo));
        }

        header("Location: verUsuario.php?id=$codUsuario");
        exit;
    } else {
        echo "<div class='error'>Error BD: ".$bd->error."</div>";
    }
}

// --- Plantilla ---
inicioCabecera("Modificar Usuario");
cabecera();
finCabecera();

inicioCuerpo("Modificar Usuario");
formulario($usuario, $rolActual, $aclbd, $codUsuario);
finCuerpo();

function cabecera(){}

function formulario($usuario, $rolActual, $aclbd, $codUsuario){
    ?>
    <h2>MODIFICAR USUARIO</h2>
    <form method="post">
        <label>Nick:</label>
        <input type="text" value="<?= ($usuario["nick"]) ?>" readonly>
        <input type="hidden" name="nick" value="<?= ($usuario["nick"]) ?>"><br>

        <label>Contraseña (opcional):</label>
        <input type="password" name="contrasena"><br>

        <label>Rol:</label>
        <select name="rol">
            <?php foreach($aclbd->dameRoles() as $rol){
                $sel = ($rol == $rolActual) ? "selected" : "";
                echo "<option value='$rol' $sel>$rol</option>";
            } ?>
        </select><br><br>

        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= ($usuario["nombre"]) ?>"><br>

        <label>NIF:</label>
        <input type="text" name="nif" value="<?= ($usuario["nif"]) ?>"><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?= ($usuario["direccion"]) ?>"><br>

        <label>Población:</label>
        <input type="text" name="poblacion" value="<?= ($usuario["poblacion"]) ?>"><br>

        <label>Provincia:</label>
        <input type="text" name="provincia" value="<?= ($usuario["provincia"]) ?>"><br>

        <label>Código postal:</label>
        <input type="text" name="cp" value="<?= ($usuario["cp"]) ?>"><br>

        <label>Fecha de Nacimiento:</label>
        <input type="date" name="fechaNacimiento" value="<?= ($usuario["fecha_nacimiento"]) ?>"><br>

        <label>Borrado (0-no, 1-sí):</label>
        <input type="text" name="borrado" value="<?= ($usuario["borrado"]) ?>"><br>

        <label>Foto:</label>
        <input type="text" name="foto" value="<?= ($usuario["foto"]) ?>"><br>

        <input type="submit" value="Modificar usuario" name="modificar"><br>
        <a href="./index.php">Volver a usuarios</a>
        <a href="verUsuario.php?id=<?= (int)$codUsuario ?>">Cancelar</a>
    </form>
    <?php
}
