<?php
$nombre = "descarga1.txt";

// Contenido del archivo
$contenido = "Esta es el contenido de la página de descarga1";

header("Content-Type: text/plain");
header("Content-Disposition: attachment; filename=\"$nombre\"");
header("Content-Length: " . strlen($contenido));

// Enviar el contenido
echo $contenido;
exit;