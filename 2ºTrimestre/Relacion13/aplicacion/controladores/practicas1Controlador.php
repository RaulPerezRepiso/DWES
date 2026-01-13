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
			[
				"texto" => "Ejercicio 5",
				"enlace" => ["practicas1", "vistaejer5"]
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
		$array1["uno"] = "cadena";
		$array1["dos"] = true;
		$array1["tres"] = 1.345;
		$array1["ultima"] = [1, 34, "nueva"];
		$array1[] = 34;

		// Usando una sola sentencia con array 
		$array2 = array(
			1 => mt_rand(1, 100),
			16 => mt_rand(1, 100),
			54 => mt_rand(1, 100),
			"uno" => "cadena",
			"dos" => true,
			"tres" => 1.345,
			"ultima" => array(1, 34, "nueva"),
			55 => 34
		);

		// Usando una sola sentencia con []
		$array3 = [
			1 => mt_rand(1, 100),
			16 => mt_rand(1, 100),
			54 => mt_rand(1, 100),
			"uno" => "cadena",
			"dos" => true,
			"tres" => 1.345,
			"ultima" => [1, 34, "nueva"],
			55 => 34
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

		// Usando la serie de funciones
		$fechaActual = time();
		$fechaActual_corta = date("d/m/Y", $fechaActual);
		$fechaActual_larga = "día " . date("j", $fechaActual) .
			", mes " . date("F", $fechaActual) .
			", año " . date("Y", $fechaActual) .
			", día de la semana " . date("l", $fechaActual);
		$horaActual = date("H:i:s", $fechaActual);

		// Usando la serie de funciones con una fecha fija
		$fechaFija = strtotime("2024-03-29 12:45");
		$fechaFija_corta = date("d/m/Y", $fechaFija);
		$fechaFija_larga = "día " . date("j", $fechaFija) .
			", mes " . date("F", $fechaFija) .
			", año " . date("Y", $fechaFija) .
			", día de la semana " . date("l", $fechaFija);
		$horaFija = date("H:i:s", $fechaFija);

		// Usando la serie de funciones con una fecha modificada
		$fechaModificada = strtotime("-12 days -4 hours");
		$fechaModificada_corta = date("d/m/Y", $fechaModificada);
		$fechaModificada_larga = "día " . date("j", $fechaModificada) .
			", mes " . date("F", $fechaModificada) .
			", año " . date("Y", $fechaModificada) .
			", día de la semana " . date("l", $fechaModificada);
		$horaModificada = date("H:i:s", $fechaModificada);

		// Usando DateTime
		$fechaActualDT = new DateTime();
		$fechaActualDT_corta = $fechaActualDT->format("d/m/Y");
		$fechaActualDT_larga = "día " . $fechaActualDT->format("j") .
			", mes " . $fechaActualDT->format("F") .
			", año " . $fechaActualDT->format("Y") .
			", día de la semana " . $fechaActualDT->format("l");
		$horaActualDT = $fechaActualDT->format("H:i:s");

		// Usando DateTime con una fecha fija
		$fechaFijaDT = new DateTime("2024-03-29 12:45");
		$fechaFijaDT_corta = $fechaFijaDT->format("d/m/Y");
		$fechaFijaDT_larga = "día " . $fechaFijaDT->format("j") .
			", mes " . $fechaFijaDT->format("F") .
			", año " . $fechaFijaDT->format("Y") .
			", día de la semana " . $fechaFijaDT->format("l");
		$horaFijaDT = $fechaFijaDT->format("H:i:s");

		// Usando DateTime con una fecha modificada
		$fechaModificadaDT = new DateTime();
		$fechaModificadaDT->modify("-12 days -4 hours");
		$fechaModificadaDT_corta = $fechaModificadaDT->format("d/m/Y");
		$fechaModificadaDT_larga = "día " . $fechaModificadaDT->format("j") .
			", mes " . $fechaModificadaDT->format("F") .
			", año " . $fechaModificadaDT->format("Y") .
			", día de la semana " . $fechaModificadaDT->format("l");
		$horaModificadaDT = $fechaModificadaDT->format("H:i:s");

		// Arrays para mostrar en el cuerpo el contenido de todo
		$arrayFunciones = [
			"Fecha actual (d/m/Y)" => $fechaActual_corta,
			"Fecha actual (larga)" => $fechaActual_larga,
			"Hora actual" => $horaActual,
			"Fecha fija (d/m/Y)" => $fechaFija_corta,
			"Fecha fija (larga)" => $fechaFija_larga,
			"Hora fija" => $horaFija,
			"Fecha modificada (d/m/Y)" => $fechaModificada_corta,
			"Fecha modificada (larga)" => $fechaModificada_larga,
			"Hora modificada" => $horaModificada
		];

		$arrayDateTime = [
			"Fecha actual (d/m/Y)" => $fechaActualDT_corta,
			"Fecha actual (larga)" => $fechaActualDT_larga,
			"Hora actual" => $horaActualDT,
			"Fecha fija (d/m/Y)" => $fechaFijaDT_corta,
			"Fecha fija (larga)" => $fechaFijaDT_larga,
			"Hora fija" => $horaFijaDT,
			"Fecha modificada (d/m/Y)" => $fechaModificadaDT_corta,
			"Fecha modificada (larga)" => $fechaModificadaDT_larga,
			"Hora modificada" => $horaModificadaDT
		];

		$cont = 0;

		$this->dibujaVista(
			"ejercicio7",
			[
				"arrayFunciones" => $arrayFunciones,
				"arrayDateTime" => $arrayDateTime,
				"cont" => $cont
			],
			"Ejercicio 7"
		);
	}


	public function accionVistaejer5()
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
				"texto" => "Ejercicio 5",
				"enlace" => ["practicas1", "ejercicio5"]
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

		//Contenido del array
		$vector = array();
		$vector[1] = "esto es una cadena";
		$vector["posi1"] = 25.67;
		$vector[] = false;
		$vector["ultima"] = array(2, 5, 96);
		$vector[56] = 23;


		$this->dibujaVista(
			"vistaejer5",
			[
				"vector" => $vector
			],
			"Ejercicio 5"
		);
	}
}
