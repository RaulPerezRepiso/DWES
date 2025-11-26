<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// Dibuja la plantilla de la vista
inicioCabecera("CRUD");
cabecera();
finCabecera();

inicioCuerpo("CRUD");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{
?>
    <a href="verUsuario.php">Ver Usuario</a><br>
    <a href="nuevoUsuario.php">Nuevo Usuario</a><br>
    <a href="modificarUsuario.php">Modificar Usuario</a><br>
    <a href="borrarUsuario.php">Borrar Usuario</a><br>
<?php

}
