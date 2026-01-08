<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");


//Controlador
$ubicacion = [
    "Inicio" => "/index.php",
    "Ver Texto" => "#",
];

// Redirigir si no hay usuario validado
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

// Comprobar permiso 1 para acceso general
if (!$acceso->puedePermiso(1)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}

// Recuperar textos de la sesión
$textos = $_SESSION["textos"] ?? [];

// Procesar formulario
if (isset($_POST["subir"]) && $_POST["subir"] === "Subir" && !empty($_POST["texto"])) {
    $nuevo = new RegistroTexto($_POST["texto"]);
    $textos[] = $nuevo;
}

if (isset($_POST["limpiar"]) && $_POST["limpiar"] === "Reset") {
    $textos = [];
}

// Guardar en sesión y refrescar
if (isset($_POST["subir"]) || isset($_POST["limpiar"])) {
    $_SESSION["textos"] = $textos;
    header("Location: verTextos.php");
    exit;
}

//Dibuja la plantilla de la vista
inicioCabecera("Ver Textos");
cabecera();
finCabecera();
inicioCuerpo("Ver Textos");
cuerpo($textos);  //Llamo a la vista
finCuerpo();
// **********************************************************

// Vista
function cabecera() {}

// Vista
function cuerpo($textos)
{
    Formulario($textos);
?>

<?php

}

// Formulario
function Formulario($textos)
{
?>
    <form action="" method="post">
        <label for="texto">Texto: </label>
        <input type="text" id="texto" name="texto">
        <input type="submit" name="subir" value="Subir">
        <input type="submit" name="limpiar" value="Reset">
        <textarea type="areaText" rows="12" cols="100" readonly><?php
                                                                if (!empty($textos)) {
                                                                    foreach ($textos as $p) {
                                                                        echo $p->getFechaHora() . " - " . $p->getCadena() . "\n";
                                                                    }
                                                                }
                                                                ?></textarea>
    </form>
<?php
}
