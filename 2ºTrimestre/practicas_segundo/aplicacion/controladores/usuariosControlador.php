<?php

// De la misma manera que con accion claseControlador para crear páginas de llamada direfentes
class usuariosControlador extends CControlador
{
	public array $menuizq = [];
	public int $valor = 15;

	public array $barraUbi = [];


	public function accionIndex()
	{

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Usuarios",
				"enlace" => ["usuarios"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			]
		];

		$this->dibujaVista("prueba", [], "Usuarios Existentes");
	}
}
