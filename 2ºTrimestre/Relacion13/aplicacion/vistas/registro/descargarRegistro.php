<?php
// Construir el contenido del archivo
$contenido  = "Datos de Registro\n";
$contenido .= "------------------\n";
$contenido .= "Nick: " . $modelo->nick . "\n";
$contenido .= "NIF: " . $modelo->nif . "\n";
$contenido .= "Fecha de nacimiento: " . $modelo->fecha_nacimiento . "\n";
$contenido .= "Provincia: " . $modelo->provincia . "\n";
$contenido .= "Estado: " . DatosRegistro::dameEstados($modelo->estado) . "\n";
$contenido .= "Contraseña: " . $modelo->contrasenia . "\n";

// Nombre del archivo
$nombre = "registroDatos.txt";

// Cabeceras de descarga
header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$nombre\"");
header("Content-Length: " . strlen($contenido));

// Enviar el contenido y detener el framework
echo $contenido;
exit;
