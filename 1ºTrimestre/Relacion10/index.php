<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

$ubicacion = [
    "Inicio" => "#"
];

// Conexión BD 
$bd = @new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Consulta a la vista cons_productos 
$sentencia = "SELECT * FROM cons_productos WHERE borrado = 0 ORDER BY nombre";
$consulta = $bd->query($sentencia);

// Saca los errores en caso de que los haya
if ($bd->errno) {
    paginaError("Error al cargar productos: " . $bd->error);
    exit;
}

// Array vacío para guardar los valores de los productos y mostrarlos
$productos = [];

while ($fila = $consulta->fetch_assoc()) {
    $productos[] = $fila;
}

//dibuja la plantilla de la vista
inicioCabecera("TIENDA RELACIÓN 10");
cabecera();
finCabecera();

inicioCuerpo("RELACIÓN 10", $ubicacion);
cuerpo($productos, $acceso);
finCuerpo();

// VISTA
function cabecera() {}

//vista
function cuerpo($productos, $acceso)
{
?>
    <h2>Productos disponibles</h2>
    <div class="contenedor-productos">
        <?php foreach ($productos as $p): ?>
            <div class="tarjeta-producto">
                <img src="/imagenes/productos/<?= $p['foto'] ?>" alt="<?= $p['nombre'] ?>" class="foto-producto">
                <h3><?= $p['nombre'] ?></h3>
                <p><strong>Fabricante:</strong> <?= $p['fabricante'] ?></p>
                <p><strong>Categoría:</strong> <?= $p['categoria'] ?></p>
                <p><strong>Precio:</strong> <?= number_format($p['precio_venta'], 2) ?> €</p>
                <p><strong>Unidades:</strong> <?= $p['unidades'] ?></p>
                <?php if ($acceso->hayUsuario() && !$acceso->puedePermiso(10)): ?>
                    <form method="post" action="/aplicacion/cesta/añadirCesta.php">
                        <input type="hidden" name="cod_producto" value="<?= $p['cod_producto'] ?>">
                        <input type="number" name="unidades" min="1" max="<?= $p['unidades'] ?>" value="1">
                        <button type="submit">Añadir al carrito</button>
                    </form> <?php endif; ?>
            </div> <?php endforeach; ?>
    </div>
<?php

}