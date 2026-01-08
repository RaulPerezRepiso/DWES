<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Inicio" => "/index.php",
    "Productos" => "/aplicacion/productos/index.php",
    "Nuevo Producto" => "#",
];

// Permisos
if (!$acceso->hayUsuario() || !$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para crear productos");
    exit;
}

// Conexión BD
$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

// Cargar categorías
$categorias = [];
$res = $bd->query("SELECT * FROM categorias ORDER BY descripcion");
while ($fila = $res->fetch_assoc()) {
    $categorias[$fila["cod_categoria"]] = $fila["descripcion"];
}

//DATOS INICIALES
$datos = [
    "nombre"        => "",
    "fabricante"    => "",
    "cod_categoria" => "",
    "fecha_alta"    => "",
    "unidades"      => "",
    "precio_base"   => "",
    "iva"           => "21",
];

$errores = [];

// PROCESAR FORMULARIO   
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    foreach ($datos as $campo => $valor) {
        if (isset($_POST[$campo])) {
            $datos[$campo] = trim($_POST[$campo]);
        }
    }

    // VALIDACIONES

    // Nombre obligatorio
    if (!validaCadena($datos["nombre"], 50, "")) {
        $errores["nombre"][] = "El nombre es obligatorio y debe tener máximo 50 caracteres.";
    } else {
        // No puede haber dos productos con el mismo nombre
        $stmt = $bd->prepare("SELECT 1 FROM productos WHERE nombre = ?");
        $stmt->bind_param("s", $datos["nombre"]);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errores["nombre"][] = "Ya existe un producto con ese nombre.";
        }
    }

    // Fabricante obligatorio
    if (!validaCadena($datos["fabricante"], 50, "")) {
        $errores["fabricante"][] = "El fabricante es obligatorio.";
    }

    // Categoría válida
    if (!validaRango($datos["cod_categoria"], $categorias, 2)) {
        $errores["cod_categoria"][] = "La categoría seleccionada no es válida.";
    }

    // Fecha válida (dd/mm/aaaa)
    if (!validaFecha($datos["fecha_alta"], "")) {
        $errores["fecha_alta"][] = "La fecha debe tener formato dd/mm/aaaa.";
    } else {
        list($d, $m, $a) = explode("/", $datos["fecha_alta"]);
        $fechaSQL = "$a-$m-$d";

        if ($fechaSQL < "2010-02-28" || $fechaSQL > date("Y-m-d")) {
            $errores["fecha_alta"][] = "La fecha debe ser posterior a 28/02/2010 y no superior a hoy.";
        }
    }

    // Unidades >= 0
    $unidades = (int)$datos["unidades"];
    if (!validaEntero($unidades, 0, 999999, -1)) {
        $errores["unidades"][] = "Las unidades deben ser un entero mayor o igual a 0.";
    }

    // Precio base >= 0
    $precio_base = (float)$datos["precio_base"];
    if (!validaReal($precio_base, 0, 999999, -1)) {
        $errores["precio_base"][] = "El precio base debe ser un número positivo.";
    }

    // IVA >= 0
    $iva = (float)$datos["iva"];
    if (!validaReal($iva, 0, 100, -1)) {
        $errores["iva"][] = "El IVA debe ser un número positivo.";
    }

    // Foto opcional
    $nombreFoto = null;
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] === UPLOAD_ERR_OK) {
        $nombreFoto = time() . "_" . basename($_FILES["foto"]["name"]);
        $rutaDestino = $_SERVER["DOCUMENT_ROOT"] . "/imagenes/productos/" . $nombreFoto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino);
    }

    // INSERTAR    
    if (empty($errores)) {

        // Calcular precios
        $precio_iva   = $precio_base + ($precio_base * $iva / 100);
        $precio_venta = $precio_iva;

        // Insertar
        $stmt = $bd->prepare("
            INSERT INTO productos 
            (cod_categoria, nombre, fabricante, fecha_alta, unidades, precio_base, iva, precio_iva, precio_venta, foto, borrado)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)
        ");

        $stmt->bind_param(
            "isssidddss",
            $datos["cod_categoria"],
            $datos["nombre"],
            $datos["fabricante"],
            $fechaSQL,
            $unidades,
            $precio_base,
            $iva,
            $precio_iva,
            $precio_venta,
            $nombreFoto
        );

        if ($stmt->execute()) {
            header("Location: index.php");
            exit;
        } else {
            echo "<div class='error'>Error BD: " . $bd->error . "</div>";
        }
    }
}

//  VISTA 
inicioCabecera("Nuevo Producto");
cabecera();
finCabecera();

inicioCuerpo("Nuevo Producto", $ubicacion);
cuerpo($datos, $errores, $categorias);
finCuerpo();


function cabecera() {}

function cuerpo($datos, $errores, $categorias)
{
    if ($errores) {
        echo "<div class='error'>";
        foreach ($errores as $campo => $lista) {
            foreach ($lista as $e) echo "$campo: $e<br>";
        }
        echo "</div>";
    }
?>
    <h2>Nuevo Producto</h2>

    <form method="post" enctype="multipart/form-data">

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

        Fecha alta (dd/mm/aaaa): <input type="text" name="fecha_alta" value="<?= $datos['fecha_alta'] ?>"><br><br>

        Unidades: <input type="text" name="unidades" value="<?= $datos['unidades'] ?>"><br><br>

        Precio base (€): <input type="text" name="precio_base" value="<?= $datos['precio_base'] ?>"><br><br>

        IVA (%): <input type="text" name="iva" value="<?= $datos['iva'] ?>"><br><br>

        Foto (opcional): <input type="file" name="foto"><br><br>

        <button type="submit" class="boton">Crear producto</button>
        <a href="index.php" class="boton">Cancelar</a>
    </form>

<?php
}
