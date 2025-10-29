<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
    "Formulario" => "#"
];
$GLOBALS['ubicacion'] = $ubicacion;

//inicializaciones
$datos = [
    "nombre" => "",
    "edad" => 18
];
$errores = [];

//comprobar si se ha dado a insertar
if (isset($_POST["crear"])) {
    $nombre = "";
    if (isset($_POST["nombre"])) {
        $nombre = $_POST["nombre"];
        // $nombre = mb_strtolower(trim($nombre)); Por si nos lo piden en minuscula y sin espacios
        $nombre = trim($nombre);
    }
    if (mb_strlen($nombre) < 10) {
        $errores["nombre"][] = "El nombre debe tener al menos 10 carácteres";
    }
    $datos["nombre"] = $nombre;

    $edad = 0;
    if (isset($_POST["edad"])) {
        $edad = intval($_POST["edad"]);
    }

    if ($edad < 15) {
        $errores["edad"][] = "Debes tener al menos 15 años";
        $edad = 15;
    }
    $datos["edad"] = $edad;


    if (!$errores) //no hay errores hago la insercion
    {
        //codigo para el nuevo articulo
        $codigo = 1; //codigo

        //se guarda el articulo

        //ir a ver el articulo insertado
        echo "location: verArticulo.php?id=$codigo";
        exit;
    }
}

// Dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();

inicioCuerpo("2DAW APLICACIÓN");
cuerpo($datos, $errores);
finCuerpo();

function cabecera() {}

function cuerpo($datos, $errores)
{
?>
    <br>
    <br>
    <br>

<?php
    formulario($datos, $errores);
}

function formulario($datos, $errores)
{
    if ($errores) { //mostrar los errores
        echo "<div class='error'>";
        foreach ($errores as $clave => $valor) {
            foreach ($valor as $error)
                echo "$clave => $error<br>" . PHP_EOL;
        }
        echo "</div>";
    }

?>
    <form action="" method="post">
        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" id="nombre"
            value="<?php echo $datos["nombre"]; ?>" size=21
            maxlength="20"><br>
        <label for="precio">Edad: </label>
        <input type="text" name="edad" id="edad"
            value="<?php echo $datos["edad"]; ?>" size=3
            maxlength="3"><br>
        <input type="submit" name="crear" class="boton" value="crear">
    </form>
<?php
}
