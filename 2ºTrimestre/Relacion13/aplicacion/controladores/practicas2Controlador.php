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
			]
		];



		$this->dibujaVista(
			"index",
			[],
			"Pagina Prácticas 2"
		);
	}
}
