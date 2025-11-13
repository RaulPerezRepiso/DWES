<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

$rutaweb = "/imagenes/";
$fichero = "creado.jpg";
$rutaphp =  RUTABASE . $rutaweb;
if (!file_exists($rutaphp . $fichero)) {
    //Creo la imagen
    $gd = imagecreatetruecolor(200, 200);
        if (!$gd) {
        exit;
    }
    $color = imagecolorallocate($gd, 160, 226, 252);
    imagefilledrectangle($gd, 0, 0, 200, 200, $color);

    $color = imagecolorallocate($gd, 0, 0, 0);
    imageline($gd, 0, 0, 200, 200, $color);

    imagejpeg($gd, $rutaphp . $fichero);
    imagedestroy($gd);
}

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
    <img src="/imagenes/creado.jpg" alt="Imagen creada">
<?php

}
