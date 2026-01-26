<?php

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
				// Cuando la accion no se llama index la vamos a tener que especificar así
				"enlace" => ["registro", "pedirDatosRegistro"]
			]
		];
		// 1. Obtener productos desde el modelo 
		$prod = new productos();
		$filas = $prod->buscarTodos();

		// 2. Cabecera de la tabla 
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
                "ETIQUETA" => "Categoría",
                "CAMPO" => "nombre_categoria"
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
		];
		// 3. Paginación 
		$totalRegistros = count($filas);
		$regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 5;
		$pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;

		$salida = [];
		for ($i = ($pag - 1) * $regPag; $i < $pag * $regPag && $i < $totalRegistros; $i++) {
			$salida[] = $filas[$i];
		}

		$opcPaginador = [
			"URL" => Sistema::app()->generaURL([

				"productos",
				"index"
			]),
			"TOTAL_REGISTROS" => $totalRegistros,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => [5 => "5", 10 => "10", 20 => "20"],
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 7,
		];

		// 4. Dibujar la vista 
		$this->dibujaVista("index", ["fill" => $salida, "cabecera" => $cabecera, "cabPag" => $opcPaginador], "Tabla de Productos");
	}
}
