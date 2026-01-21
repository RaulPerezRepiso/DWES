<?php

class ejemmodelosControlador extends CControlador
{
	public array $menuizq = [];
	public array $barraUbi = [];
	public string $nombre = "2daw";

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
			]
		];

		$cabecera = array(
			array(
				"ETIQUETA" => "el nombre",
				"CAMPO" => "nombre"
			),
			array(
				"ETIQUETA" => "la edad",
				"CAMPO" => "edad"
			),
			array(
				"ETIQUETA" => "la direccion",
				"CAMPO" => "direccion"
			)
		);

		$totalRegistros = count($filas);
		$regPag = 5;
		if (isset($_GET["reg_pag"]))
			$regPag = intval($_GET["reg_pag"]);

		$nPaginas = $totalRegistros / $regPag;
		$pag = 1;
		if(isset($_GET["pag"]))
			$pag=intval($_GET["pag"]);

		$salida=[];
		for($cont=($pag-1)*$regPag; $cont<$pag*$regPag; $cont++)
			$salida[]=$filas[$cont];

		$opcPaginador = array(
			"URL" => Sistema::app()->generaURL(array("ejenmodelos", "tabla")),
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

		$this->dibujaVista("tabla", ["fill" => $salida, "cabecera" => $cabecera, "cabPag" => $opcPaginador, "ejemplo"]);
	}
}
