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


		$this->dibujaVista(
			"index",
			[],
			"Productos"
		);
	}
}
