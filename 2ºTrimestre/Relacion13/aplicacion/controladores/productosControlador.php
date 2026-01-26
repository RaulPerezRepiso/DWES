<?php
session_start();

class productosControlador extends CControlador
{
	public array $menuizq = [];
	public array $barraUbi = [];

	public function accionIndex()
	{
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
				"enlace" => ["registro", "pedirDatosRegistro"]
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
			"TAMANIOS_PAGINA" => [5 => "5", 10 => "10", 20 => "20"],
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
				"enlace" => ["registro", "pedirDatosRegistro"]
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

		// 2. Cargar el producto
		if (!$prod->buscarPorId($id)) {
			Sistema::app()->paginaError(404, "Producto no encontrado");
		}

		// 3. Si llega el formulario, procesarlo
		if (isset($_POST["productos"])) {

			// Cargar valores enviados
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

		// 4. Dibujar vista con el modelo cargado
		$this->dibujaVista(
			"modificar",
			["modelo" => $prod],
			"Modificar producto"
		);
	}


	// --------------------------------------------------------- 
	// ACCIÓN BORRAR 
	// --------------------------------------------------------- 
	public function accionEliminar()
	{
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
				"enlace" => ["registro", "pedirDatosRegistro"]
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

		// 3. Si llega confirmación por POST → borrar
		if (isset($_POST["confirmar"]) && $_POST["confirmar"] === "SI") {

			// Aquí decides si borras físicamente o marcas borrado = 1
			$prod->borrado = 1;

			if ($prod->guardar()) {
				Sistema::app()->irAPagina(["productos", "index"]);
			}
		}

		// 4. Dibujar vista de confirmación
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
				"enlace" => ["registro", "pedirDatosRegistro"]
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

	public function accionNuevo()
	{
		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["inicial"]],
			["texto" => "Productos", "enlace" => ["productos"]],
		];

		$this->menuizq = [
			["texto" => "Inicio", "enlace" => ["inicial"]],
			["texto" => "Registro", "enlace" => ["registro", "pedirDatosRegistro"]],
		];

		// Crear modelo vacío
		$prod = new productos();

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
			["modelo" => $prod],
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
}
