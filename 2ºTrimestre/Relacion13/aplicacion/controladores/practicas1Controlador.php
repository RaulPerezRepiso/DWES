<?php

class practicas1Controlador extends CControlador
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
				"texto" => "Prácticas 1",
				"enlace" => ["practicas1"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Ejercicio 1",
				"enlace" => ["practicas1", "ejercicio1"]
			],
			[
				"texto" => "Ejercicio 2",
				"enlace" => ["practicas1", "ejercicio2"]
			],
			[
				"texto" => "Ejercicio 3",
				"enlace" => ["practicas1", "ejercicio3"]
			],
			[
				"texto" => "Ejercicio 7",
				"enlace" => ["practicas1", "ejercicio7"]
			],
		];


		$this->dibujaVista(
			"miindice",
			[],
			"Pagina Prácticas 1"
		);

		// Para que los botones redirigan al botón dado
		// Sistema::app()->irAPagina("https://www.youtube.com/");
	}

	public function accionEjercicio1()
	{

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Prácticas 1",
				"enlace" => ["practicas1"]
			],
			[
				"texto" => "Ejercicio 1",
				"enlace" => ["practicas1", "ejercicio1"]
			],

		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Indice Práticas 1",
				"enlace" => ["practicas1", "index"]
			],

		];

		//Declaración de variables
		$numero = 7.65;
		$redondeoArriba = round($numero);
		$redondeoAbajo = floor($numero);
		$elevar = pow(2, 3);
		$raiz = sqrt(49);
		$convertirDecimal = dechex(255);
		$baseConvert = base_convert('123', 4, 8);
		$valorAbsoluto = abs(-15);
		$valorPi = pi();
		$binario = 0b1011;
		$octal = 075;
		$hexadecimal = 0x1F;


		//Asiganmos el valor de variables para la vista
		$this->dibujaVista(
			"ejercicio1",
			[
				"numero" => $numero,
				"redondeoArriba" => $redondeoArriba,
				"redondeoAbajo" => $redondeoAbajo,
				"elevar" => $elevar,
				"raiz" => $raiz,
				"convertirDecimal" => $convertirDecimal,
				"baseConvert" => $baseConvert,
				"valorAbsoluto" => $valorAbsoluto,
				"valorPi" => $valorPi,
				"binario" => $binario,
				"octal" => $octal,
				"hexadecimal" => $hexadecimal
			],
			"Ejercicio 1"
		);
	}

	public function accionEjercicio2()
	{

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Prácticas 1",
				"enlace" => ["practicas1"]
			],
			[
				"texto" => "Ejercicio 2",
				"enlace" => ["practicas1", "ejercicio2"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Indice Práticas 1",
				"enlace" => ["practicas1", "index"]

			],

		];

		$lanzamientos6 = [];
		for ($i = 1; $i <= 6; $i++) {
			$lanzamientos6[$i] = mt_rand(1, 6);
		}

		// Lanzamiento aleatorio de veces y conteo de caras
		define("N_lanzamientos", mt_rand(1, 1000));
		$num_lanzamientos = N_lanzamientos;
		$conteoCaras = array_fill(1, 6, 0);

		for ($i = 0; $i < $num_lanzamientos; $i++) {
			$cara = mt_rand(1, 6);
			$conteoCaras[$cara]++;
		}

		$this->dibujaVista(
			"ejercicio2",
			[
				"lanzamientos6" => $lanzamientos6,
				"num_lanzamientos" => $num_lanzamientos,
				"conteoCaras" => $conteoCaras
			],
			"Ejercicio 2"
		);
	}

	public function accionEjercicio3()
	{

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Prácticas 1",
				"enlace" => ["practicas1"]
			],
			[
				"texto" => "Ejercicio 3",
				"enlace" => ["practicas1", "ejercicio3"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Indice Práticas 1",
				"enlace" => ["practicas1", "index"]

			],


		];

		//Crear una variable de tipo Array y la rellenamos a mano
		$array1 = [];
		$array1[1] = mt_rand(1, 100);
		$array1[16] = mt_rand(1, 100);
		$array1[54] = mt_rand(1, 100);
		$array1[] = 34;
		$array1["uno"] = "cadena";
		$array1["dos"] = true;
		$array1["tres"] = 1.345;
		$array1["ultima"] = [1, 34, "nueva"];

		// Usando una sola sentencia con array 
		$array2 = array(
			1 => mt_rand(1, 100),
			16 => mt_rand(1, 100),
			54 => mt_rand(1, 100),
			"uno" => "cadena",
			"dos" => true,
			"tres" => 1.345,
			"ultima" => array(1, 34, "nueva")
		);

		// Usando una sola sentencia con []
		$array3 = [
			1 => mt_rand(1, 100),
			16 => mt_rand(1, 100),
			54 => mt_rand(1, 100),
			"uno" => "cadena",
			"dos" => true,
			"tres" => 1.345,
			"ultima" => [1, 34, "nueva"]
		];

		// Array que contiene los 3 arrays
		$arrayTodo = [
			"Array1" => $array1,
			"Array2" => $array2,
			"Array3" => $array3
		];

		$this->dibujaVista(
			"ejercicio3",
			[
				"array1" => $array1,
				"array2" => $array2,
				"array3" => $array3,
				"arrayTodo" => $arrayTodo
			],
			"Ejercicio 3"
		);
	}

	public function accionEjercicio7()
	{

		$this->barraUbi = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Prácticas 1",
				"enlace" => ["practicas1"]
			],
			[
				"texto" => "Ejercicio 7",
				"enlace" => ["practicas1", "ejercicio7"]
			],
		];

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			],
			[
				"texto" => "Indice Práticas 1",
				"enlace" => ["practicas1", "index"]
			],

		];

		$this->dibujaVista(
			"ejercicio7",
			[],
			"Ejercicio 7"
		);
	}
}
