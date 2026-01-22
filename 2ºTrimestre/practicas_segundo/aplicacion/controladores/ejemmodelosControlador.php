<?php

class ejemmodelosControlador extends CControlador
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
		];

		$this->menuizq = [
			[
				"texto" => "Usuarios",
				"enlace" => ["usuarios"],
			],
			//Podemos crear más de un enlace así
			[
				"texto" => "Productos",
				"enlace" => ["productos"],
			]

		];

		$art = new articulos();

		$nombre = $art->getNombre();

		if (isset($_POST[$nombre])) {
			// Asigno un codigo de articulo por defecto
			$art->cod_articulo = 5;
			// Asigno los valores al articulo a partir de lo recogido del formulario
			$art->setValores($_POST[$nombre]);

			// Compruebo si son validos los datos del articulo
			if ($art->validar()) {

				//Son válidos los datos
				echo "Todo correcto";
				return;
			}
		}
		$this->dibujaVista("nuevo", ["modelo" => $art], "Usuarios Existentes");
	}

	public function accionTabla()
	{
		$filas = [
			[
				"nombre" => "Ramon",
				"edad" => "22",
				"direccion" => "BajoPuente"
			],
			[
				"nombre" => "Pedro",
				"edad" => "46",
				"direccion" => "Caseta de Perrsos"
			],
			[
				"nombre" => "Micaela",
				"edad" => "23",
				"direccion" => "Medica"
			],
			[
				"nombre" => "Pascal",
				"edad" => "43",
				"direccion" => "España"
			],
			[
				"nombre" => "Nathaly",
				"edad" => "21",
				"direccion" => "Esquina"
			],
			[
				"nombre" => "Ramon",
				"edad" => "22",
				"direccion" => "BajoPuente"
			],
			[
				"nombre" => "Pedro",
				"edad" => "46",
				"direccion" => "Caseta de Perrsos"
			],
			[
				"nombre" => "Micaela",
				"edad" => "23",
				"direccion" => "Medica"
			],
			[
				"nombre" => "Pascal",
				"edad" => "43",
				"direccion" => "España"
			],
			[
				"nombre" => "Nathaly",
				"edad" => "21",
				"direccion" => "Esquina"
			],
			[
				"nombre" => "Ramon",
				"edad" => "22",
				"direccion" => "BajoPuente"
			],
			[
				"nombre" => "Pedro",
				"edad" => "46",
				"direccion" => "Caseta de Perrsos"
			],
			[
				"nombre" => "Micaela",
				"edad" => "23",
				"direccion" => "Medica"
			],
			[
				"nombre" => "Pascal",
				"edad" => "43",
				"direccion" => "España"
			],
			[
				"nombre" => "Nathaly",
				"edad" => "21",
				"direccion" => "Esquina"
			],
			[
				"nombre" => "Ramon",
				"edad" => "22",
				"direccion" => "BajoPuente"
			],
			[
				"nombre" => "Pedro",
				"edad" => "46",
				"direccion" => "Caseta de Perrsos"
			],
			[
				"nombre" => "Micaela",
				"edad" => "23",
				"direccion" => "Medica"
			],
			[
				"nombre" => "Pascal",
				"edad" => "43",
				"direccion" => "España"
			],
			[
				"nombre" => "Nathaly",
				"edad" => "21",
				"direccion" => "Esquina"
			]
		];

		$cabecera = array(
			array(
				"ETIQUETA" => "Nombre ",
				"CAMPO" => "nombre"
			),
			array(
				"ETIQUETA" => "Edad ",
				"CAMPO" => "edad"
			),
			array(
				"ETIQUETA" => "Direccion ",
				"CAMPO" => "direccion"
			)
		);

		$totalRegistros = count($filas);
		$regPag = 5;
		if (isset($_GET["reg_pag"])) {
			$regPag = intval($_GET["reg_pag"]);
		}

		// $nPaginas = $totalRegistros / $regPag;
		$pag = 1;
		if (isset($_GET["pag"])) {
			$pag = intval($_GET["pag"]);
		}

		$salida = [];
		for ($cont = ($pag - 1) * $regPag; $cont < $pag * $regPag && $cont < $totalRegistros; $cont++) {
			$salida[] = $filas[$cont];
		}

		$opcPaginador = array(
			//Poner en el array el mismo nombre del controlador y en la clase que se muestra
			"URL" => Sistema::app()->generaURL(array("ejemmodelos", "tabla")),
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => array(
				5 => "5",
				10 => "10",
				20 => "20",
				30 => "30",
				40 => "40",
				50 => "50"
			),
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 7,
		);

		$this->dibujaVista("tabla", ["fill" => $salida, "cabecera" => $cabecera, "cabPag" => $opcPaginador], "ejemplo");
	}

	public function accionTablaProductos()
	{
		// 1. Obtener los productos desde el modelo
		$prod = new productos();

		// Traemos TODOS los productos
		$filas = $prod->buscarTodos([
			"select" => "*",
			"order"  => "t.cod_producto ASC"
		]);

		// 2. Cabecera para CGrid
		$cabecera = [
			[
				"ETIQUETA" => "Código",
				"CAMPO"    => "cod_producto"
			],
			[
				"ETIQUETA" => "Nombre",
				"CAMPO"    => "nombre"
			],
			[
				"ETIQUETA" => "Fabricante",
				"CAMPO"    => "fabricante"
			],
			[
				"ETIQUETA" => "Fecha de Alta",
				"CAMPO"    => "fecha_alta"
			],
			[
				"ETIQUETA" => "Unidades",
				"CAMPO"    => "unidades"
			],
			[
				"ETIQUETA" => "Precio de Venta",
				"CAMPO"    => "precio_venta"
			],[
				"ETIQUETA" => "Foto",
				"CAMPO"    => "foto"
			],
			[
				"ETIQUETA" => "Borrado",
				"CAMPO"    => "borrado"
			],
			[
				"ETIQUETA" => "Categoria",
				"CAMPO"    => "categoria"
			]
		];

		// 3. Paginación EXACTAMENTE igual que tu tabla original
		$totalRegistros = count($filas);

		$regPag = 5;
		if (isset($_GET["reg_pag"])) {
			$regPag = intval($_GET["reg_pag"]);
		}

		$pag = 1;
		if (isset($_GET["pag"])) {
			$pag = intval($_GET["pag"]);
		}

		// 4. Seleccionar solo los registros de la página actual
		$salida = [];
		for ($cont = ($pag - 1) * $regPag; $cont < $pag * $regPag && $cont < $totalRegistros; $cont++) {
			$salida[] = $filas[$cont];
		}

		// 5. Configuración del paginador
		$opcPaginador = [
			"URL" => Sistema::app()->generaURL(["ejemmodelos", "tablaProductos"]),
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => [
				5 => "5",
				10 => "10",
				20 => "20",
				30 => "30",
				40 => "40",
				50 => "50"
			],
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 7,
		];

		// 6. Dibujar la vista usando la MISMA vista "tabla"
		$this->dibujaVista(
			"tabla",
			[
				"fill"     => $salida,
				"cabecera" => $cabecera,
				"cabPag"   => $opcPaginador
			],
			"Productos"
		);
	}

	public function accionBD()
	{
		$sentencia = "select * from cons_productos";

		$contenido = Sistema::app()->BD()->crearConsulta($sentencia);

		$filas = [];
		while ($fila = $contenido->fila()) {
			$filas[] = $fila;
		}

		//Usamos esto para acceder a los productos de las BD
		$prod = new productos();
		print_r($prod->buscarTodos());

		//Ahora esta creado prod como un producto nuevo inicializado con aftercreate con lo que tenga en el modelo

		//Cargo en el modelo un equipo concreto (por ejemplo me han pasado el id)
		//Lo tengo que buscar para pasarlo


		$id = 1;

		if (!$prod->buscarPorId($id)) {
			Sistema::app()->paginaError(400, "No se encuentra el Producto");
			return;
		}
		echo $prod->nombre;
		echo "<br>";

		//Cargar en el modelo el primer producto cuyo fabricante sea Sony t es el nombre dado en CActiveRecord
		$opciones["where"] = "t.fabricante = 'Sony'";

		if (!$prod->buscarPor($opciones)) {
			Sistema::app()->paginaError(400, "Fabricante no encontrado");
			return;
		}

		echo $prod->nombre;
	}
}
