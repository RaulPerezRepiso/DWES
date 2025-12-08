<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;


// Dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("PRUEBAS");
cuerpo();
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo()
{

?>
  
<?php

}

//Validación de Correo
/* $correo = "usuario@dominio.com";
if (preg_match("/^[\w\.-]+@[\w\.-]+\.[a-zA-Z]{2,6}$/", $correo)) {
    echo "Correo válido";
} else {
    echo "Correo inválido"; */

//Validación de DNI
/*$dni = "12345678Z";
if (preg_match("/^[0-9]{8}[A-Z]$/", $dni)) {
    echo "DNI válido en formato";
} else {
    echo "DNI inválido";
} */

//Validación de Tlf
/* $telefono = "612345678";
if (preg_match("/^[0-9]{9}$/", $telefono)) {
    echo "Teléfono válido";
} else {
    echo "Teléfono inválido";
} */

// Validación de Contraseña
/* $pass = "ClaveSegura1!";
if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@!%*?&\-_+])[A-Za-z\d$@!%*?&\-_+]{8,15}$/", $pass)) {
    echo "Contraseña válida";
} else {
    echo "Contraseña inválida";
} */

// Validación de URL
/* $url = "https://www.ejemplo.com";
if (preg_match("/^(https?:\/\/)?([\w\-]+\.)+[a-zA-Z]{2,6}(\/.*)?$/", $url)) {
    echo "URL válida";
} else {
    echo "URL inválida";
} */

// Deshabilitar la sobrecarga (Para activarla hay que definarla y inicializarla incluyendo en unset)
/* public function __set(string $nombre,mixed $valor){
    throw new Exception ('No existe la propiedad '.$nombre);
}
public function __get(string $nombre){
    throw new Exception ('No existe la propiedad '.$nombre);
}
public function __isset(string $nombre):bool{
    return false;
} */