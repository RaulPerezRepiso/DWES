<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

$ubicacion = [
    "Inicio" => "/index.php",
    "Ver Texto" => "#",
];

$texto;

//Guardar el texto subido
if (isset($_POST["subir"])) {
    $textos["texto"] = $texto;
}

//dibuja la plantilla de la vista
inicioCabecera("Práctica 8");
cabecera();
finCabecera();
inicioCuerpo("Práctica 8");
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo()
{
    Formulario();
?>

<?php

}

function Formulario()
{
?>
    <form action="" method="post">
        <label for="texto">Texto: </label>
        <input type="text" id="texto">
        <input type="submit" name="subir" value="Subir">
        <input type="reset" name="subir" value="Reset">
        <textarea type="areaText" rows="12" cols="100" readonly><?php
                                                                if (!empty($textos)) {
                                                                    foreach ($textos as $p) {
                                                                        echo  $p;
                                                                    }
                                                                }
                                                                ?></textarea>
    </form>
<?php
}
