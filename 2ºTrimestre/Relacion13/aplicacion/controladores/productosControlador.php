<?php
class productosControlador extends CControlador
{
	public array $menuizq = [];
	public array $barraUbi = [];

	public function accionIndex()
	{

		if (!Sistema::app()->acceso()->hayUsuario()) {
			Sistema::app()->irAPagina(["registro", "login"]);
			return;
		}
		if (!Sistema::app()->acceso()->puedePermiso(9)) {
			Sistema::app()->paginaError(001, "No tienes permisos para entrar en esta pagina");
			return;
		}

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos"]
			]
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Registro",
				"enlace" => ["registro", "pedirRegistroDatos"]
			],
			[
				"texto" => "Generar Pdf",
				"enlace" => ["productos", "informe"]
			]
		];

		// Cabecera de la tabla 
		$cabecera = [
			[
				"ETIQUETA" => "Nombre",
				"CAMPO" => "nombre"
			],
			[
				"ETIQUETA" => "Fabricante",
				"CAMPO" => "fabricante"
			],
			[
				"ETIQUETA" => "Fecha de Alta",
				"CAMPO" => "fecha_alta"
			],
			[
				"ETIQUETA" => "Unidades",
				"CAMPO" => "unidades"
			],
			[
				"ETIQUETA" => "Precio Base",
				"CAMPO" => "precio_base"
			],
			[
				"ETIQUETA" => "IVA",
				"CAMPO" => "iva"
			],
			[
				"ETIQUETA" => "Precio IVA",
				"CAMPO" => "precio_iva"
			],
			[
				"ETIQUETA" => "Precio de venta",
				"CAMPO" => "precio_venta"
			],
			[
				"ETIQUETA" => "Foto",
				"CAMPO" => "foto"
			],
			[
				"ETIQUETA" => "Borrado",
				"CAMPO" => "borrado"
			],
			[
				"ETIQUETA" => "Descripción",
				"CAMPO" => "nombre_categoria"
			],
			[
				"ETIQUETA" => "Operaciones",
				"CAMPO" => "operaciones"
			]
		];
		// Modelo 
		$prod = new productos();

		// ----------------------------- 
		// 1. FILTROS 
		// ----------------------------- 
		// Si el usuario envía filtros → guardarlos en sesión
		if (isset($_GET["nombre"]) || isset($_GET["categoria"]) || isset($_GET["borrado"])) {
			$_SESSION["fNombre"] = $_GET["nombre"] ?? "";
			$_SESSION["fCategoria"] = $_GET["categoria"] ?? "";
			$_SESSION["fBorrado"] = $_GET["borrado"] ?? "";
		}
		// Recuperar filtros desde sesión si existen 
		$fNombre = $_SESSION["fNombre"] ?? "";
		$fCategoria = $_SESSION["fCategoria"] ?? "";
		$fBorrado = $_SESSION["fBorrado"] ?? "";

		$cond = "1=1";

		if ($fNombre !== "") $cond .= " AND nombre LIKE '%$fNombre%'";
		if ($fCategoria !== "") $cond .= " AND nombre_categoria LIKE '%$fCategoria%'";
		if ($fBorrado !== "") $cond .= " AND borrado = $fBorrado";

		// Obtener datos filtrados 
		$filas = $prod->buscarTodos(["where" => $cond, "order" => "nombre"]);

		// Añadir la tabla a la página 
		$totalRegistros = count($filas);
		$regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 5;
		$pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;

		// Crear $salida con paginación 
		$salida = [];

		for ($i = ($pag - 1) * $regPag; $i < $pag * $regPag && $i < $totalRegistros; $i++) {
			$salida[] = $filas[$i];
		}

		//Para que se guarde lleno
		$_SESSION["productos_filtrados"] = $salida;


		foreach ($salida as &$f) {
			$id = $f["cod_producto"];

			// URLs generadas por el framework
			$urlModificar = Sistema::app()->generaURL(["productos", "modificar"], ["id" => $id]);
			$urlEliminar  = Sistema::app()->generaURL(["productos", "eliminar"], ["id" => $id]);
			$urlVer       = Sistema::app()->generaURL(["productos", "ver"], ["id" => $id]);

			// Enlaces HTML
			$f["operaciones"] =
				"<a href='$urlModificar'>Modificar</a> | " .
				"<a href='$urlEliminar'>Borrar</a> | " .
				"<a href='$urlVer'>Ver</a>";

			// Borrado SI/NO
			$f["borrado"] = (intval($f["borrado"]) === 1) ? "SI" : "NO";
		}

		$opcPaginador = [
			"URL" => Sistema::app()->generaURL([
				"productos",
				"index",
				"nombre" => $fNombre,
				"categoria" => $fCategoria,
				"borrado" => $fBorrado
			]),
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => [5 => "5", 10 => "10", 20 => "20", 30 => "30", 40 => "40", 50 => "50"],
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 7,
		];

		// ----------------------------- 
		// 5. DIBUJAR VISTA 
		// ----------------------------- 
		$this->dibujaVista("index", ["fill" => $salida, "cabecera" => $cabecera, "cabPag" => $opcPaginador, "fNombre" => $fNombre, "fCategoria" => $fCategoria, "fBorrado" => $fBorrado], "Listado de productos");
	}

	// --------------------------------------------------------- 
	// ACCIÓN MODIFICAR 
	// --------------------------------------------------------- 
	public function accionModificar()
	{
		Sistema::app()->acceso()->hayUsuario() ? null : Sistema::app()->irAPagina(["registro", "login"]);
		if (!Sistema::app()->acceso()->puedePermiso(10)) {
			Sistema::app()->paginaError(001, "No tienes permisos para modificar los productos");
			return;
		}

		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["inicial"]],
			["texto" => "Productos", "enlace" => ["productos"]],
		];

		$this->menuizq = [
			["texto" => "Inicio", "enlace" => ["inicial"]],
			["texto" => "Registro", "enlace" => ["registro", "pedirRegistroDatos"]],
			["texto" => "Productos", "enlace" => ["productos", "index"]],
		];

		// 1. Comprobar ID
		if (!isset($_GET["id"])) {
			Sistema::app()->paginaError(404, "Producto no encontrado");
		}

		$id = intval($_GET["id"]);
		$prod = new productos();

		// 2. Cargar producto
		if (!$prod->buscarPorId($id)) {
			Sistema::app()->paginaError(404, "Producto no encontrado");
		}

		// 3. Cargar categoría asociada
		$cat = new categorias();
		$nombreCategoria = "";

		if ($cat->buscarPorId($prod->cod_categoria)) {
			$nombreCategoria = $cat->descripcion;   // nombre real del campo
		}

		// Campo virtual para la vista
		$prod->nombre_categoria = $nombreCategoria;

		// 4. Procesar POST
		if (isset($_POST["productos"])) {

			$prod->setValores($_POST["productos"]);

			if ($prod->validar()) {
				if ($prod->guardar()) {
					Sistema::app()->irAPagina(["productos", "index"]);
				}
			}
		}

		// 5. Cargar lista completa de categorías para un <select>
		$cat = new categorias();
		$lista = $cat->buscarTodos();

		$categorias = [];
		foreach ($lista as $fila) {
			$categorias[$fila["cod_categoria"]] = $fila["descripcion"];
		}

		// 6. Dibujar vista
		$this->dibujaVista(
			"modificar",
			[
				"modelo" => $prod,
				"categorias" => $categorias
			],
			"Modificar producto"
		);
	}



	// --------------------------------------------------------- 
	// ACCIÓN BORRAR 
	// --------------------------------------------------------- 
	public function accionEliminar()
	{
		Sistema::app()->acceso()->hayUsuario() ? null : Sistema::app()->irAPagina(["registro", "login"]);
		if (!Sistema::app()->acceso()->puedePermiso(10)) {
			Sistema::app()->paginaError(001, "No tienes permisos para eliminar un producto");
			return;
		}
		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Registro",
				"enlace" => ["registro", "pedirRegistroDatos"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos", "index"]
			]
		];

		// 1. Comprobar ID
		if (!isset($_GET["id"])) {
			Sistema::app()->paginaError(404, "Producto no encontrado");
		}

		$id = intval($_GET["id"]);
		$prod = new productos();

		// 2. Cargar producto
		if (!$prod->buscarPorId($id)) {
			Sistema::app()->paginaError(404, "Producto no encontrado");
		}

		// 3. Si llega confirmación por POST → cambiar 0/1
		if (isset($_POST["confirmar"]) && $_POST["confirmar"] === "SI") {

			// Obtener valor actual
			$valorActual = $prod->borrado;

			// Alternar 0 ↔ 1
			$nuevoValor = ($valorActual == 0) ? 1 : 0;

			// UPDATE directo
			$sql = "UPDATE productos SET borrado = $nuevoValor WHERE cod_producto = $id";
			sistema::app()->BD()->crearConsulta($sql);

			// Volver al listado
			Sistema::app()->irAPagina(["productos", "index"]);
		}

		// 4. Dibujar vista
		$this->dibujaVista(
			"eliminar",
			["modelo" => $prod],
			"Eliminar producto"
		);
	}


	// --------------------------------------------------------- 
	// ACCIÓN CONSULTAR 
	// --------------------------------------------------------- 
	public function accionVer()
	{

		Sistema::app()->acceso()->hayUsuario() ? null : Sistema::app()->irAPagina(["registro", "login"]);
		if (!Sistema::app()->acceso()->puedePermiso(10)) {
			Sistema::app()->paginaError(001, "No tienes permisos para ver los productos");
			return;
		}
		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Registro",
				"enlace" => ["registro", "pedirRegistroDatos"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos", "index"]
			]
		];

		// 1. Comprobar ID
		if (!isset($_GET["id"])) {
			Sistema::app()->paginaError(404, "ID no introducido");
		}

		$id = intval($_GET["id"]);
		$productos = new productos();

		// 2. Cargar la fila del producto
		$filas = $productos->buscarTodos(["where" => "cod_producto=$id"]);

		if (!$filas || count($filas) === 0) {
			Sistema::app()->paginaError(404, "Producto no encontrado");
		}

		// 3. Preparar la fila (igual que en Index)
		foreach ($filas as &$fila) {

			// Acciones
			$urlModificar = Sistema::app()->generaURL(["productos", "modificar"], ["id" => $id]);
			$urlBorrar    = Sistema::app()->generaURL(["productos", "eliminar"], ["id" => $id]);

			$fila["operaciones"] =
				"<a href='$urlModificar'>Modificar</a> | " .
				"<a href='$urlBorrar'>Borrar</a>";

			// Borrado SI/NO
			$fila["borrado"] = ($fila["borrado"] == 1) ? "SI" : "NO";
		}

		// 4. Cabecera (MISMA que en Index)
		$cabecera = [
			["ETIQUETA" => "Nombre",            "CAMPO" => "nombre"],
			["ETIQUETA" => "Fabricante",        "CAMPO" => "fabricante"],
			["ETIQUETA" => "Fecha de Alta",     "CAMPO" => "fecha_alta"],
			["ETIQUETA" => "Unidades",          "CAMPO" => "unidades"],
			["ETIQUETA" => "Precio Base",       "CAMPO" => "precio_base"],
			["ETIQUETA" => "IVA",               "CAMPO" => "iva"],
			["ETIQUETA" => "Precio IVA",        "CAMPO" => "precio_iva"],
			["ETIQUETA" => "Precio Venta",      "CAMPO" => "precio_venta"],
			["ETIQUETA" => "Foto",              "CAMPO" => "foto"],
			["ETIQUETA" => "Borrado",           "CAMPO" => "borrado"],
			["ETIQUETA" => "Descripción",       "CAMPO" => "nombre_categoria"],
			["ETIQUETA" => "Operaciones",       "CAMPO" => "operaciones"],
		];

		// 5. Dibujar vista (SOLO UNA FILA)
		$this->dibujaVista(
			"ver",
			["fill" => $filas, "cabecera" => $cabecera],
			"Consultar producto"
		);
	}

	// --------------------------------------------------------- 
	// ACCIÓN NUEVO 
	// --------------------------------------------------------- 
	public function accionNuevo()
	{
		Sistema::app()->acceso()->hayUsuario() ? null : Sistema::app()->irAPagina(["registro", "login"]);
		if (!Sistema::app()->acceso()->puedePermiso(10)) {
			Sistema::app()->paginaError(001, "No tienes permisos para crear un producto");
			return;
		}
		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Registro",
				"enlace" => ["registro", "pedirRegistroDatos"]
			],
			[
				"texto" => "Productos",
				"enlace" => ["productos", "index"]
			]
		];

		// Crear modelo vacío
		$prod = new productos();

		// Cargar categorías
		$cat = new categorias();
		$lista = $cat->buscarTodos();

		$categorias = [];
		foreach ($lista as $fila) {
			$categorias[$fila["cod_categoria"]] = $fila["descripcion"];
		}

		// Si llega el formulario
		if (isset($_POST["productos"])) {

			// Cargar valores
			$prod->setValores($_POST["productos"]);

			// Validar
			if ($prod->validar()) {

				// Guardar en BD
				if ($prod->guardar()) {

					// Volver al listado
					Sistema::app()->irAPagina(["productos", "index"]);
				}
			}
		}

		// Dibujar vista
		$this->dibujaVista(
			"nuevo",
			[
				"modelo" => $prod,
				"categorias" => $categorias
			],
			"Nuevo producto"
		);
	}


	// --------------------------------------------------------- 
	// ACCIÓN DESCARGAR (exporta filtrados) 
	// --------------------------------------------------------- 
	public function accionDescargar()
	{

		$filas = $_SESSION["productos_filtrados"] ?? [];

		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=productos.txt");

		foreach ($filas as $f) {
			echo "{$f['nombre']},"
				. "{$f['fabricante']},"
				. "{$f['fecha_alta']},"
				. "{$f['precio_base']},"
				. "{$f['iva']},"
				. "{$f['precio_iva']},"
				. "{$f['precio_venta']},"
				. "{$f['foto']},"
				. (intval($f['borrado']) === 1 ? 'SI' : 'NO') . ","
				. "{$f['nombre_categoria']}"
				. "\n";
		}

		return;
	}
	public function accionInforme($modo = "ver")
	{
		require_once __DIR__ . '/../../scripts/TCPDF/tcpdf.php';

		// 1. Obtener productos
		$prod = new productos();
		$productos = $prod->buscarTodos();

		// 2. Crear PDF
		$pdf = new pdf();
		$pdf->SetMargins(15, 35, 15);
		$pdf->AddPage();

		// 3. Construir tabla
		$html = '
        <h2 style="text-align:center;">Listado de Productos</h2>
        <table border="1" cellpadding="5">
            <thead>
                <tr style="background-color:#f0f0f0;">
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Fabricante</th>
                    <th>Precio Venta</th>
                </tr>
            </thead>
            <tbody>
    ';

		foreach ($productos as $p) {
			$html .= "
            <tr>
                <td>{$p['cod_producto']}</td>
                <td>{$p['nombre']}</td>
                <td>{$p['fabricante']}</td>
                <td>{$p['precio_venta']}</td>
            </tr>
        ";
		}

		$html .= '</tbody></table>';

		$pdf->writeHTML($html);


		// 4. Decidir según la URL
		$pdf->Output('informe_productos.pdf', 'D'); // Descargar

		exit;
	}
}
