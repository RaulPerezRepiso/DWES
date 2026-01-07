<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
  "Index Principal" => "/index.php",
  "Login" => "#"
];

if (isset($_POST["login"])) {
  $nick = mb_strtolower(trim($_POST["nick"] ?? ""));
  $contra = $_POST["contrasena"] ?? "";

  if ($aclbd->esValido($nick, $contra)) {

    // Obtener el código del usuario
    $codUsuario = $aclbd->getCodUsuario($nick);

    // Obtener el nombre del usuario
    $nombre = $aclbd->getNombre($codUsuario);

    // Obtener permisos del usuario (ACLBase lo define así)
    $permisos = $aclbd->getPermisos($codUsuario);

    // Registrar en sesión
    $acceso->registrarUsuario($nick, $nombre, $permisos);

    // Guardar la sesión
    $_SESSION["cod_usuario"] = $codUsuario;

    header("Location: /index.php");
    exit;
  } else {
    $error = "Usuario o contraseña incorrectos";
  }
}

inicioCabecera("Login");
cabecera();
finCabecera();

inicioCuerpo("Login", $ubicacion);
cuerpo($error ?? "");
finCuerpo();

function cabecera() {}

function cuerpo($error)
{
?>
  <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
  <form method="post">
    <label for="nick">Nick:</label>
    <input type="text" id="nick" name="nick">
    <br>
    <label for="contrasena">Contraseña:</label>
    <input type="password" id="contrasena" name="contrasena">
    <br>
    <input type="submit" name="login" value="Entrar">
  </form>
<?php
}
