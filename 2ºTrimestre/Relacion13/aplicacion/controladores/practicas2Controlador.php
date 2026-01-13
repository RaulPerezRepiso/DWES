<?php

class practicas2Controlador extends CControlador
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
				"texto" => "Prácticas 2",
				"enlace" => ["practicas2"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Mi Error",
				"enlace" => ["practicas2", "mierror"]
			]
		];



		$this->dibujaVista(
			"index",
			[],
			"Pagina Prácticas 2"
		);
	}

	public function accionMierror()
	{
		//Esta acción llama directamente a la página de error con un número de error y mensaje concreto
		Sistema::app()->paginaError(001, "No seas malo, No accedas a esta página");
	}
}
