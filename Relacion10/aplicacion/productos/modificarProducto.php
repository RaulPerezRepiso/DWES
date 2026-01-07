<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Productos" => "/aplicacion/productos/index.php",
    "Modificar Producto" => "#"
];

// Recoger ID para poder modificar el producto
if (!isset($_GET["id"])) {
    paginaError("No se ha especificado id");
    exit;
}

$codProducto = (int)$_GET["id"];

// Permisos
if (!$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para modificar productos");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Cargar categorías
$categorias = [];
$resCat = $bd->query("SELECT * FROM categorias ORDER BY descripcion");
while ($fila = $resCat->fetch_assoc()) {
    $categorias[$fila["cod_categoria"]] = $fila["descripcion"];
}

// Cargar datos del producto
$sent = $bd->query("SELECT * FROM productos WHERE cod_producto = $codProducto");
if (!$sent || $sent->num_rows === 0) {
    paginaError("No existe el producto indicado");
    exit;
}

$producto = $sent->fetch_assoc();

// Datos iniciales
$datos = [
    "nombre"        => $producto["nombre"],
    "fabricante"    => $producto["fabricante"],
    "cod_categoria" => $producto["cod_categoria"],
    "fecha_alta"    => date("d/m/Y", strtotime($producto["fecha_alta"])),
    "unidades"      => $producto["unidades"],
    "precio_venta"  => $producto["precio_venta"],
    "borrado"       => $producto["borrado"],
];

$errores = [];

// ===============   PROCESAR FORMULARIO   ==============
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    foreach ($datos as $campo => $valor) {
        if (isset($_POST[$campo])) {
            $datos[$campo] = trim($_POST[$campo]);
        }
    }

    // Validación nombre
    if (!validaCadena($datos["nombre"], 50, "")) {
        $errores["nombre"][] = "El nombre es obligatorio y debe tener máximo 50 caracteres.";
    }

    // Validación fabricante
    if (!validaCadena($datos["fabricante"], 50, "")) {
        $errores["fabricante"][] = "El fabricante es obligatorio.";
    }

    // Validación fecha (dd/mm/aaaa)
    $fechaOriginal = $datos["fecha_alta"];
    if (!validaFecha($datos["fecha_alta"], "")) {
        $errores["fecha_alta"][] = "La fecha no tiene un formato válido (dd/mm/aaaa).";
    } else {
        // Convertir a Y-m-d
        list($d, $m, $a) = explode("/", $datos["fecha_alta"]);
        $fechaSQL = "$a-$m-$d";

        if ($fechaSQL < "2010-02-28" || $fechaSQL > date("Y-m-d")) {
            $errores["fecha_alta"][] = "La fecha debe ser posterior a 28/02/2010 y no superior a hoy.";
        }
    }

    // Validación unidades
    $unidades = (int)$datos["unidades"];
    if (!validaEntero($unidades, 0, 999999, -1)) {
        $errores["unidades"][] = "Las unidades deben ser un entero mayor o igual a 0.";
    }

    // Validación precio
    $precio = (float)$datos["precio_venta"];
    if (!validaReal($precio, 0, 999999, -1)) {
        $errores["precio_venta"][] = "El precio debe ser un número positivo.";
    }

    // Validación categoría
    if (!validaRango($datos["cod_categoria"], $categorias, 2)) {
        $errores["cod_categoria"][] = "La categoría seleccionada no es válida.";
    }

    // Validación borrado
    if (!validaRango($datos["borrado"], [0,1], 1)) {
        $errores["borrado"][] = "El borrado debe ser 0 o 1.";
    }

    // Si no hay errores, actualizar
    if (empty($errores)) {

        $stmt = $bd->prepare("
            UPDATE productos SET 
                nombre = ?, 
                fabricante = ?, 
                cod_categoria = ?, 
                fecha_alta = ?, 
                unidades = ?, 
                precio_venta = ?,
                borrado = ?
            WHERE cod_producto = ?
        ");

        $stmt->bind_param(
            "ssisdiii",
            $datos["nombre"],
            $datos["fabricante"],
            $datos["cod_categoria"],
            $fechaSQL,
            $unidades,
            $precio,
            $datos["borrado"],
            $codProducto
        );

        if ($stmt->execute()) {
            header("Location: verProducto.php?id=$codProducto");
            exit;
        } else {
            echo "<div class='error'>Error BD: " . $bd->error . "</div>";
        }
    }
}

// VISTA 
inicioCabecera("Modificar Producto");
cabecera();
finCabecera();

inicioCuerpo("Modificar Producto", $ubicacion);
cuerpo($datos, $errores, $categorias, $codProducto);
finCuerpo();


function cabecera() {}

function cuerpo($datos, $errores, $categorias, $codProducto)
{
    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $campo => $lista) {
            foreach ($lista as $e) echo "$campo: $e<br>";
        }
        echo "</div>";
    }
?>
    <h2>Modificar Producto</h2>

    <form method="post">

        Nombre: <input type="text" name="nombre" value="<?= $datos['nombre'] ?>"><br><br>

        Fabricante: <input type="text" name="fabricante" value="<?= $datos['fabricante'] ?>"><br><br>

        Categoría:
        <select name="cod_categoria">
            <?php foreach ($categorias as $cod => $desc): ?>
                <option value="<?= $cod ?>" <?= ($datos['cod_categoria'] == $cod) ? "selected" : "" ?>>
                    <?= $desc ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        Fecha alta (dd/mm/aaaa):
        <input type="text" name="fecha_alta" value="<?= $datos['fecha_alta'] ?>"><br><br>

        Unidades: <input type="text" name="unidades" value="<?= $datos['unidades'] ?>"><br><br>

        Precio venta (€): <input type="text" name="precio_venta" value="<?= $datos['precio_venta'] ?>"><br><br>

        Borrado (0 = No, 1 = Sí):  
        <input type="text" name="borrado" value="<?= $datos['borrado'] ?>"><br><br>

        <button type="submit" class="boton">Guardar cambios</button>
        <a href="verProducto.php?id=<?= $codProducto ?>" class="boton">Cancelar</a>
    </form>

<?php
}
