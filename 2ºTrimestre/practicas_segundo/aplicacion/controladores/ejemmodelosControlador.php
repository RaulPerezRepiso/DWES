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
}
