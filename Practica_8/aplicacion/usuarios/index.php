<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Pruebas" => "#",
];

// --- Restricciones de acceso ---
// Comprobar si hay Usuario
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}
// Si tiene los permisos podrá acceder
if (!$acceso->puedePermiso(1)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}
if (!$acceso->puedePermiso(2)) {
    paginaError("No tienes permiso para acceder a esta página");
    exit;
}

// Entrar a la base de datos con usuario correcto
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);

// Creación de sentecnia
@$sentencia = "select * 
    from usuarios";

// Consulta de la sentencia creada
@$consulta = $bd->query($sentencia);

if ($bd->errno) {
    paginaError("Error en consulta: " . $bd->error);
    exit;
}

// Array con los datos
$filas = [];

// Proceso los datos y los modifico fila a fila
while ($fila = $consulta->fetch_assoc()) {
    // Ejemplo de columna calculada opcional
    $fila["descripcion"] = $fila["nombre"] . " (" . $fila["provincia"] . ")";
    $filas[] = $fila;
}

// Dibuja la plantilla de la vista
inicioCabecera("CRUD");
cabecera();
finCabecera();

inicioCuerpo("CRUD");
cuerpo($filas);
finCuerpo();

// **********************************************************

function cabecera() {}


function cuerpo($filas)
{
?>
    <table class="tabla">
        <thead>
            <tr>
                <th>Nick</th>
                <th>Nombre</th>
                <th>NIF</th>
                <th>Dirección</th>
                <th>Población</th>
                <th>Provincia</th>
                <th>Código Postal</th>
                <th>Fecha Nacimiento</th>
                <th>Borrado</th>
                <th>Foto</th>
                <th>Operaciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filas as $fila): ?>
                <tr>
                    <td><?= $fila["nick"] ?></td>
                    <td><?= $fila["nombre"] ?></td>
                    <td><?= $fila["nif"] ?></td>
                    <td><?= $fila["direccion"] ?></td>
                    <td><?= $fila["poblacion"] ?></td>
                    <td><?= $fila["provincia"] ?></td>
                    <td><?= $fila["cp"] ?></td>
                    <td><?= $fila["fecha_nacimiento"] ?? "" ?></td>
                    <td><?= $fila["borrado"] ? "Sí" : "No" ?></td>
                    <td><?= $fila["foto"] ?></td>
                        <td>
                            <a href="verUsuario.php">Ver</a>
                            <a href="modificarUsuario.php">Modificar</a>
                            <a href="borrarUsuario.php">Borrar</a>
                        </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <ul>
        <a href="nuevoUsuario.php">Nuevo Usuario</a><br>
    </ul>
<?php

}
