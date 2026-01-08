<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "/aplicacion/pruebas/index.php",
];
// Establece la conexión a BD (Definir en cabecera que es el punto común para todas las páginas)
// @ Evita que se genenen Warning delante de la creacioón de algo
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

// Establece la página de códigos del cliente
$bd->set_charset("utf8");

// Comprueba si se conecta bien la base de datos
if ($bd->connect_errno) {
    paginaError("Fallo al conectar a MySQL: " . $bd->connect_error);
    exit;
}

// Creación de sentecnia
@$sentencia = "select * 
    from prueba1  
    where id>0
    order by cadena";

// Consulta de la sentencia creada
$consulta = $bd->query($sentencia);

// Comprobar si la sentencia es correcta
// if ($bd->errno) 
if (!$consulta) {
    paginaError("Fallo al conectar la Base de Datos: ");
    exit;
}

// Array con los datos
$filas = [];

// Proceso los datos y los modifico fila a fila
while ($fila = $consulta->fetch_assoc()) {
    $fila["descripcion"] = $fila["cadena"] . ": " . $fila["numero"];
    $filas[] = $fila;
}

// Ejecucuón sentencias Borrado/Actualización/Inserción
if (isset($_GET["oper"]) && $_GET["oper"] == 1) {

    // Para evitar problemas de inyeccion

    // Con tipos distintos de cadena, convertir siempre el parametro recibido al tipo
    $id = "2";
    $id = intval($id);

    // Para cadenas usamos la funcion de escape correspondiente a la base de datos
    $cadena ="Esta 'Esto es el ataque'";

    // Evitamos el ataque de la cadena (Los escapa y los considera una cadena)
    $cadena=$bd->real_escape_string($cadena);
    
    // Se puede evitar el ataque por inyección de codigo usando las consultas parametrizadas
    $sentencia = "update prueba1 set cadena='$cadena' where id=2";

    // Consulta de la sentencia creada
    $consulta = $bd->query($sentencia);

    // Sino se ejecuta da error
    if (!$consulta) {
        paginaError("Error al modificar");
        exit;
    }
}

// Otra manera de hacerlo (Más lioso)
/* $sentSelect = "*";
$sentFrom = "prueba1";
$sentWhere = "";
$sentOrder = "cadena";

//Recojo los elementos de filtrao
$sentWhere ="numero>10";

//Recojo ordenación

//Construyo la sentencia
$sentencia = "select $sentSelect from $sentFrom where $sentWhere order by $sentOrder"; */

// Dibuja la plantilla de la vista
inicioCabecera("PRUEBAS");
cabecera();
finCabecera();

inicioCuerpo("PRUEBAS");
cuerpo($filas);
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo($filas)
{
?>
    <table>
        <thead>
            <tr>
                <th>CADENA</th>
                <th>NÚMERO</th>
                <th>DESCRIPCIÓN</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($filas as $fila) {

                echo "<tr>";
                echo "<td>{$fila["cadena"]}</td>";
                echo "<td>{$fila["numero"]}</td>";
                echo "<td>{$fila["descripcion"]}</td> ";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <br><br>
    <!-- Enlace para actualizar la página y mofiicar el valor de la tabla -->
    <a href="pruebabd.php ? oper=1">Modificar fila 2</a>
<?php
}
