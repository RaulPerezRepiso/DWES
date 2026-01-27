<?php

class inicialControlador extends CControlador
{
	public array $menuizq = [];
	public array $barraUbi = [];

	public function accionIndex()
	{
		$this->barraUbi = [
			["texto" => "Inicio", "enlace" => ["inicial"]],
			["texto" => "Productos", "enlace" => ["productos"]],
		];

		$this->menuizq = [
			["texto" => "Inicio", "enlace" => ["inicial"]],
			["texto" => "Registro", "enlace" => ["registro", "pedirDatosRegistro"]],
		];

		// -----------------------------
		// 1. FILTROS
		// -----------------------------
		if (isset($_GET["nombre"]) || isset($_GET["categoria"]) || isset($_GET["borrado"])) {
			$_SESSION["fNombre"] = $_GET["nombre"] ?? "";
			$_SESSION["fCategoria"] = $_GET["categoria"] ?? "";
			$_SESSION["fBorrado"] = $_GET["borrado"] ?? "";
		}

		$fNombre = $_SESSION["fNombre"] ?? "";
		$fCategoria = $_SESSION["fCategoria"] ?? "";
		$fBorrado = $_SESSION["fBorrado"] ?? "";

		// -----------------------------
		// 2. CONDICIÓN SQL
		// -----------------------------
		$cond = "1=1";

		if ($fNombre !== "") {
			$cond .= " AND nombre LIKE '%$fNombre%'";
		}

		if ($fCategoria !== "") {
			$cond .= " AND nombre_categoria LIKE '%$fCategoria%'";
		}

		if ($fBorrado !== "") {
			$cond .= " AND borrado = $fBorrado";
		}

		// -----------------------------
		// 3. OBTENER PRODUCTOS
		// -----------------------------
		$prod = new productos();
		$filas = $prod->buscarTodos([
			"where" => $cond,
			"order" => "nombre"
		]);

		// -----------------------------
		// 4. PAGINACIÓN
		// -----------------------------
		$total = count($filas);
		$regPag = isset($_GET["reg_pag"]) ? intval($_GET["reg_pag"]) : 6;
		$pag = isset($_GET["pag"]) ? intval($_GET["pag"]) : 1;

		$inicio = ($pag - 1) * $regPag;
		$salida = array_slice($filas, $inicio, $regPag);

		$opcPaginador = [
			"URL" => Sistema::app()->generaURL([
				"productos",
				"index",
				"nombre" => $fNombre,
				"categoria" => $fCategoria,
				"borrado" => $fBorrado
			]),
			"TOTAL_REGISTROS" => $total,
			"PAGINA_ACTUAL" => $pag,
			"REGISTROS_PAGINA" => $regPag,
			"TAMANIOS_PAGINA" => [6 => "6", 12 => "12", 24 => "24"],
			"MOSTRAR_TAMANIOS" => true,
			"PAGINAS_MOSTRADAS" => 7,
		];

		// -----------------------------
		// 5. DIBUJAR VISTA
		// -----------------------------
		$this->dibujaVista(
			"index",
			[
				"productos" => $salida,
				"paginador" => $opcPaginador,
				"fNombre" => $fNombre,
				"fCategoria" => $fCategoria,
				"fBorrado" => $fBorrado
			],
			"Listado de productos"
		);
	}
}
