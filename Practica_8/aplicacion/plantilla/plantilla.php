<?php
function paginaError(string $mensaje)
{
    header("HTTP/1.0 404 $mensaje");
    inicioCabecera("PRACTICA");
    finCabecera();
    inicioCuerpo("ERROR");
    echo "<br />\n";
    echo $mensaje;
    echo "<br />\n";
    echo "<br />\n";
    echo "<br />\n";
    echo "<a href='/index.php'>Ir a la pagina principal</a>\n";

    finCuerpo();
}
function inicioCabecera(string $titulo)
{
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="utf-8">
        <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame Remove this if you use the .htaccess -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $titulo ?></title>
        <meta name="description" content="">
        <meta name="author" content="Administrador">
        <meta name="viewport" content="width=device-width; initialscale=1.0">
        <!-- Replace favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
        <link rel="shortcut icon" href="/favicon.ico">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="stylesheet" type="text/css" href="../../estilos/base.css">
    <?php

    if (!isset($_COOKIE["colorFondo"]))
        setcookie("colorFondo", "white");

    if (!isset($_COOKIE["colorLetra"]))
        setcookie("colorLetra", "black");
}
function finCabecera()
{
    ?>
    </head>
<?php
}
function inicioCuerpo(string $cabecera)
{
    global $acceso;

    //Colores por defecto
    $colorFondo = $_COOKIE["colorFondo"] ?? "white";
    $colorLetra  = $_COOKIE["colorLetra"] ?? "black";

?>

    <body>
        <div id="documento">

            <header>
                <h1 style="background-color: <?= $colorFondo ?>; color: <?= $colorLetra ?>;" id="titulo"><?php echo $cabecera; ?></h1>
                <div id="menuPrincipal">
                    <ul>
                        <li><a href="/index.php">Inicio</a></li>
                        <li><a href="/aplicacion/texto/verTextos.php">Ver Texto</a></li>
                        <li><a href="/aplicacion/personalizar/personalizar.php">Personalizar</a></li>
                    </ul>
                </div>
            </header>

            <div id="barraLogin">
                <?php
                if ($acceso->hayUsuario()) {
                    echo "Bienvenido, " . $acceso->getNombre() .
                        " [ <a href='/aplicacion/acceso/logout.php'>Cerrar sesión</a> ]";
                } else {
                    echo "<a href='/aplicacion/acceso/login.php'>Iniciar sesión</a>";
                }
                ?>
            </div>

            <div id="barraMenu">
                <ul>
                    <?php
                    if (isset($GLOBALS['ubicacion'])) {
                        mostrarBarraUbicacion($GLOBALS['ubicacion']);
                    }
                    ?>
                </ul>
            </div>
        <?php
    }
    function finCuerpo()
    {
        ?>
            <br />
            <br />
            <footer>
                <hr width="90%" />
                <div>
                    <strong>&copy; Copyright by Rául Pérez Repiso</strong>
                </div>
            </footer>
        </div>
    </body>

    </html>
<?php
    }

    function mostrarBarraUbicacion(array $ubicacion)
    {
        echo "<nav class='barraModdle'>";
        $total = count($ubicacion);
        $contador = 0;

        foreach ($ubicacion as $nombre => $url) {
            $contador++;
            if ($contador < $total) {
                echo "<a href='{$url}'>{$nombre}</a> &raquo; ";
            } else {
                echo "<span>{$nombre}</span>";
            }
        }

        echo "</nav><br>";
    }
