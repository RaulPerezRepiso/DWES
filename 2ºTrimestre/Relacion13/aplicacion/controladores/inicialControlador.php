<?php

class inicialControlador extends CControlador
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
				"texto" => "Prácticas 1",
				"enlace" => ["practicas1"]
			],
			[
				"texto" => "Prácticas 2",
				"enlace" => ["practicas2"]
			]
		];




		$this->dibujaVista(
			"index",
			[],
			"Pagina principal"
		);
	}
}
