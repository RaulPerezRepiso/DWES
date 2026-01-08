<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

$ubicacion = [
    "Index Principal" => "/index.php",
    "Productos" => "/aplicacion/productos/index.php",
    "Cargar productos" => "#"
];

// Restricciones de acceso
if (!$acceso->hayUsuario()) {
    header("Location: /aplicacion/acceso/login.php");
    exit;
}

if (!$acceso->puedePermiso(9)) {
    paginaError("No tienes permiso para cargar productos");
    exit;
}

// Vista inicial
inicioCabecera("Cargar productos");
cabecera();
finCabecera();

inicioCuerpo("Cargar productos", $ubicacion);
cuerpo();
finCuerpo();

// Procesar fichero
if (!isset($_POST["cargar"])) exit;

if (!isset($_FILES["fichero"]) || $_FILES["fichero"]["error"] !== UPLOAD_ERR_OK) {
    paginaError("No se ha subido ningún fichero válido");
    exit;
}

$bd = new mysqli($servidor, $usuario, $contrasenia, $baseDatos);
$bd->set_charset("utf8");

$fichero = fopen($_FILES["fichero"]["tmp_name"], "r");
if (!$fichero) {
    paginaError("No se ha podido leer el fichero");
    exit;
}

$insertados = 0;
$rechazados = 0;

echo "<h2>DEPURACIÓN DE CARGA</h2>";

while (($linea = fgets($fichero)) !== false) {

    echo "<hr><strong>Línea leída:</strong> $linea<br>";

    $linea = trim($linea);
    if ($linea === "") {
        echo "→ Línea vacía, se ignora<br>";
        continue;
    }

    $partes = explode(";", $linea);
    if (count($partes) !== 6) {
        echo "→ ERROR: La línea no tiene 6 campos<br>";
        $rechazados++;
        continue;
    }

    list($nombre, $fabricante, $cod_categoria, $fecha, $unidades, $precio_venta) = $partes;

    echo "Nombre: $nombre<br>";
    echo "Fabricante: $fabricante<br>";
    echo "Categoría (num): $cod_categoria<br>";
    echo "Fecha: $fecha<br>";
    echo "Unidades: $unidades<br>";
    echo "Precio venta: $precio_venta<br>";

    //VALIDACIONES DEL TEMARIO

    // Nombre y fabricante obligatorios
    if (!validaCadena($nombre, 50, "")) {
        echo "→ ERROR: Nombre inválido<br>";
        $rechazados++;
        continue;
    }

    if (!validaCadena($fabricante, 50, "")) {
        echo "→ ERROR: Fabricante inválido<br>";
        $rechazados++;
        continue;
    }

    // Categoría numérica válida
    $catNum = (int)$cod_categoria;
    if (!validaEntero($catNum, 1, 999999, -1)) {
        echo "→ ERROR: Categoría inválida<br>";
        $rechazados++;
        continue;
    }

    // Fecha válida (el fichero trae yyyy-mm-dd)
    $trozos = explode("-", $fecha);
    if (count($trozos) !== 3) {
        echo "→ ERROR: Fecha incorrecta<br>";
        $rechazados++;
        continue;
    }

    // Convertir a dd/mm/aaaa para usar validaFecha
    $fechaForm = $trozos[2] . "/" . $trozos[1] . "/" . $trozos[0];

    if (!validaFecha($fechaForm, "")) {
        echo "→ ERROR: Fecha inválida<br>";
        $rechazados++;
        continue;
    }

    // Convertir a formato SQL usando la fecha validada
    list($d, $m, $a) = explode("/", $fechaForm);
    $fechaSQL = "$a-$m-$d";

    // Unidades
    $unid = (int)$unidades;
    if (!validaEntero($unid, 0, 999999, -1)) {
        echo "→ ERROR: Unidades inválidas<br>";
        $rechazados++;
        continue;
    }

    // Precio venta
    $precio = (float)$precio_venta;
    if (!validaReal($precio, 0, 999999, -1)) {
        echo "→ ERROR: Precio inválido<br>";
        $rechazados++;
        continue;
    }

    // Verificar categoría en BD
    $stmtCat = $bd->prepare("SELECT 1 FROM categorias WHERE cod_categoria = ?");
    $stmtCat->bind_param("i", $catNum);
    $stmtCat->execute();
    $resCat = $stmtCat->get_result();

    if ($resCat->num_rows === 0) {
        echo "→ ERROR: La categoría $catNum no existe<br>";
        $rechazados++;
        continue;
    }

    echo "→ Categoría válida<br>";

    //CONTROL DE DUPLICADOS
    $stmtDup = $bd->prepare("SELECT 1 FROM productos WHERE nombre = ?");
    $stmtDup->bind_param("s", $nombre);
    $stmtDup->execute();
    $resDup = $stmtDup->get_result();

    if ($resDup->num_rows > 0) {
        echo "→ ERROR: Ya existe un producto con el nombre '$nombre'<br>";
        $rechazados++;
        continue;
    }

    echo "→ Nombre no duplicado<br>";

    //CALCULAR PRECIOS
    $iva = 21;
    $precio_base = round($precio / (1 + $iva / 100), 2);
    $precio_iva = round($precio - $precio_base, 2);

    echo "Precio base: $precio_base<br>";
    echo "IVA (€): $precio_iva<br>";

    // INSERTAR PRODUCTO
    $stmt = $bd->prepare("
        INSERT INTO productos (
            nombre, fabricante, cod_categoria, fecha_alta, unidades,
            precio_base, iva, precio_iva, precio_venta,
            foto, borrado
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'nofoto.png', 0)
    ");

    $stmt->bind_param(
        "ssisididd",
        $nombre,
        $fabricante,
        $catNum,
        $fechaSQL,
        $unid,
        $precio_base,
        $iva,
        $precio_iva,
        $precio
    );

    if ($stmt->execute()) {
        echo "→ INSERTADO CORRECTAMENTE<br>";
        $insertados++;
    } else {
        echo "→ ERROR SQL: " . $stmt->error . "<br>";
        $rechazados++;
    }
}

fclose($fichero);

echo "<hr><h3>RESULTADO FINAL</h3>";
echo "Insertados: $insertados<br>";
echo "Rechazados: $rechazados<br>";

exit;

// Vista
function cabecera() {}

function cuerpo()
{
?>
    <h2>Cargar productos desde fichero</h2>
    <p>Formato: <em>nombre;fabricante;cod_categoria;fecha;unidades;precio_venta</em></p>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="fichero" required>
        <br><br>
        <button type="submit" name="cargar" class="boton">Cargar</button>
        <a href="index.php" class="boton">Cancelar</a>
    </form>
<?php
}
