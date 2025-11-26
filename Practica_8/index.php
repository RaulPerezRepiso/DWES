<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$ubicacion = [
    "Inicio" => "/index.php",
];

// Contador de recarga de la página web guardado en una cookier
$cont = isset($_COOKIE["cont"]) ? $_COOKIE["cont"] : 0;
$cont++;
setcookie("cont", $cont);

// Establece la conexión a BD (Definir en cabecera que es el punto común para todas las páginas)
// @ Evita que se genenen Warning delante de la creacioón de algo
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

// Establece la página de códigos del cliente
$bd->set_charset("utf8");

// Comprueba si se conecta bien la base de datos
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a MySQL: " . $bd->connect_error);
    exit;
}

// Insertar algo para que la base no este vacía y comprobar que podamos entrar
/* $sql = "INSERT INTO usuarios (nick, nombre, cp, fecha_nacimiento, foto)
        VALUES ('r18', 'Raúl', '29200', '2003-03-27', 'raul.jpg')";
$bd->query($sql);

//Si da error por algún campo salta
if ($bd->errno) {
    echo "Error al insertar: " . $bd->error;
} else {
    // Sino nos dice el id del usuario insertado
    echo "Usuario insertado con ID: " . $bd->insert_id;
} */

//dibuja la plantilla de la vista
inicioCabecera("Práctica 8");
cabecera();
finCabecera();
inicioCuerpo("Práctica 8");
cuerpo($cont);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo($cont)
{
    if ($cont < 2) {
        echo "<h2>Has iniciado sesión: $cont vez</h2>";
    }else
    echo "<h2>Has iniciado sesión: $cont veces</h2>";
?>
    <h1>Ver Texto</h1>
    <ul>
        <li><a href="/aplicacion/texto/verTextos.php">Texto</a></li>
    </ul>
    <h1>Personalizar</h1>
    <ul>
        <li><a href="/aplicacion/personalizar/personalizar.php">Personalizar</a></li>
    </ul>

     <h1>Crud</h1>
    <ul>
        <li><a href="/aplicacion/usuarios/index.php">CRUD</a></li>
    </ul>
<?php

}
