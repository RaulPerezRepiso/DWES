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
			],
			[
				"texto" => "Descarga 1",
				"enlace" => ["practicas2", "descarga1"]
			],
			[
				"texto" => "Descarga 2",
				"enlace" => ["practicas2", "descarga2"]
			],
			[
				"texto" => "Pedir datos",
				"enlace" => ["practicas2", "pedirDatos"]
			],
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

	public function accionDescarga1()
	{
		//Esta acción llama directamente a la página parcial solo para descargar
		$this->dibujaVistaParcial("descarga1", [], false);
	}

	public function accionDescarga2()
	{
		$descarga = "descarga2.txt";

		// Contenido del archivo
		$contenido = "Esta es el contenido de la página de descarga2";

		header("Content-Type: text/plain");
		header("Content-Disposition: attachment; filename=\"$descarga\"");
		header("Content-Length: " . strlen($contenido));

		// Enviar el contenido
		echo $contenido;
		exit;
	}

	public function accionPedirDatos()
	{

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Practica 2",
				"enlace" => ["practicas2"]
			],
			[
				"texto" => "Pedir datos",
				"enlace" => "	"
			]
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Mi error",
				"enlace" => ["practicas2", "mierror"]
			],
			[
				"texto" => "Descarga 1",
				"enlace" => ["practicas2", "descarga1"]
			],
			[
				"texto" => "Descarga 2",
				"enlace" => ["practicas2", "descarga2"]
			],
		];
		// Si NO hay parámetros → mostrar la vista
		if (!isset($_GET["min"]) || !isset($_GET["max"]) || !isset($_GET["cadena"])) {
			$this->dibujaVista("pedirDatos", [], "AJAX");
			return;
		}

		// Si hay parámetros → generar JSON
		$min = intval($_GET["min"]);
		$max = intval($_GET["max"]);
		$cadena = $_GET["cadena"];

		// Generar números
		$numeros = [];
		for ($i = 0; $i < 10; $i++) {
			$numeros[] = mt_rand($min, $max);
		}

		// Generar palabras
		$palabras = [];
		$longitud = mb_strlen($cadena);
		$primera = mb_substr($cadena, 0, 1);
		$ultima = mb_substr($cadena, -1, 1);
		$patron = "abcdefghijklmnopkrstuvwxyz";

		for ($i = 0; $i < 10; $i++) {
			$palabra = $primera;
			for ($j = 0; $j < $longitud - 2; $j++) {
				$palabra .= $patron[mt_rand(0, strlen($patron) - 1)];
			}
			$palabra .= $ultima;
			$palabras[] = $palabra;
		}

		// Respuesta JSON
		header("Content-Type: application/json; charset=utf-8");
		echo json_encode([
			"numeros" => $numeros,
			"palabras" => $palabras
		]);
		exit;
	}
}
