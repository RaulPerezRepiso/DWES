<?php

class inicialControlador extends CControlador
{
	public array $menuizq = [];
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
			],
			[
				"texto" => "modelos",
				"enlace" => ["ejemmodelos"],
			]

		];

		//Ver más adelante
		$direccion = Sistema::app()->generaURL(["usuarios", "modificar"], ["id" => 12, "nombre" => "Raúl"]);

		$cadena = "mi nombre";
		$entero = 12;

		// echo $direccion;

		$this->dibujaVista("index", ["c" => $cadena, "n" => $entero, "direccion" => $direccion], "Pagina principal");

		// Este clase dibuja la Vista sin la plantilla
		// $contenido = $this->dibujaVistaParcial("index", ["c"=>$cadena, "n"=>$entero], true);
		// echo $contenido;

	}


	//Podemos cerar tantas páginas como queramos usando accionNombre que creara una página con ruta absoluta sin extensión
	public function accionNuevo()
	{
		echo "Nueva pagina del sitio";
	}

	public function accionPatata()
	{
		echo "Nueva pagina del sitio PATATA";
	}
}
