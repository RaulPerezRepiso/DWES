<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
];
$GLOBALS['ubicacion'] = $ubicacion;

$rutaweb = "/imagenes/";
$fichero = "subido.jpg";
$rutaphp =  RUTABASE . $rutaweb;

$errores = [];
$mostrar = false;

//Verifico que ha subido un fichero
if (isset($_POST["subido"])) {
    $mostrar = true;
    if (isset($_FILES["archivo"])) {
        //Existe el archivo

        //Verifico que el fichero es correcto
        if ($_FILES["archivo"]["error"] <> 0) {
            $errores[] = "Error en la súbida del archivo";
        }
        //Exijo que tenga un tamaño
        if ($_FILES["archivo"]["size"] == 0) {
            $errores[] = "Error el fichero está vacío";
        }
        //Compruebo el tipo
        if ($_FILES["archivo"]["type"] !== "image/jpeg") {
            $errores[] = "Error solo se permiten imagenes jpg";
        }
        if (!$errores) {
            $mostrar = true;
            if (!move_uploaded_file($_FILES["archivo"]["tmp_name"], $rutaphp . $fichero))
                $errores[] = "Error al subir el archivo";
        }
    }
}

// Dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("PRUEBAS");
cuerpo($rutaweb . $fichero, $mostrar, $errores);
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo(string $fichero, bool $mostrar, array $errores)
{
    if ($mostrar) {
        foreach ($errores as $error) {
            echo "$error <br>" . PHP_EOL;
        }
    }
?>
    <form enctype="multipart/form-data" action="" method="POST">
        <!--MAX_FILE_SIZE debe preceder al campo de entrada de archivo-->
        <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
        <!-- El nombre del elemento de entrada determina el nombre en el array $_FILES -->
        Enviar este archivo: <input name="archivo" type="file" /><br>
        <input type="submit" value="Enviar fichero" name="subido" />
    </form>
<?php
    if (!$errores) {
        echo "<img src=\"{$fichero}\">";
    } else {
        $mostrar = true;
    }
}
