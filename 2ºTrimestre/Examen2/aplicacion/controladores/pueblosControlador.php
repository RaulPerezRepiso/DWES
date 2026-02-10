<?php

class pueblosControlador extends CControlador
{
	public array $menuizq = [];
	private array $_MisPueblos = [];
	public int $N_Pueblos = 0;
	public int $N_PueblosUnesco = 0;

	public function __construct()
	{
		parent::__construct();

		Sistema::app()->sesion()->crearSesion();

		if (!isset($_SESSION["Pueblos"]) || !is_array($_SESSION["Pueblos"]) || empty($_SESSION["Pueblos"])) {
			$this->inicializarPueblos();
		} else {
			$this->_MisPueblos = $_SESSION["Pueblos"];
		}


		$this->N_Pueblos = count($this->_MisPueblos);
		$this->calcularPueblosDeLaUnesco();
	}

	public function accionIndex()
	{
		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["pueblos"]
			]
		];


		$this->accionPuebloInicial();
	}

	// LOGIN
	public function accionConectar()
	{

		$numero = rand(1, 1000);
		if (($numero / 6) % 2 != 0) {
			Sistema::app()->irAPagina("index", [], "Pueblos");
			// Sistema::app()->paginaError(400,$numero);
			return;
		}

		// Registrar usuario
		$_SESSION["usuario"] = [
			"nick" => "pueblo",
			"permisos" => [5]
		];

		Sistema::app()->irAPagina("index", [], "Pueblos");
	}

	// LOGOUT
	public function accionDesconectar()
	{
		// Debe haber usuario registrado
		if (!isset($_SESSION["usuario"])) {
			Sistema::app()->irAPagina("index", [], "Pueblos");
			return;
		}

		unset($_SESSION["usuario"]);

		Sistema::app()->irAPagina("index", [], "Pueblos");
	}

	public function accionPuebloInicial()
	{
		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["pueblos"]
			]
		];

		$pueblos = $this->_MisPueblos;

		//Sacamos si es o no renococido por la Unesco
		$guardar = [];
		foreach ($pueblos as $p) {
			$guardar[$p->reconocido_unesco] = $p->reconocido_unesco;
		}

		$puebloSel = $_POST["reconocido_unesco"] ?? "";

		// Filtrar si se ha elegido uno
		$pueblosFil = $pueblos;
		$pueblosFil = array_filter($pueblos, function ($p) use ($puebloSel) {
			return $p->reconocido_unesco === $puebloSel;
		});

		$this->dibujaVista("index", [
			"guardar" => $guardar,
			"puebloSel" => $puebloSel,
			"pueblosFil" => $pueblosFil
		], "Pueblos");
	}

	public function accionNuevo()
	{

		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["pueblos"]
			]
		];
		$modelo = new Pueblo();
		$nombre = $modelo->getNombre();

		if (isset($_POST[$nombre])) {

			if (mb_strlen($_POST[$nombre]["nombre"]) < 5) {
				$modelo->setError("nombre", "Nombre debe tener al menos 5 caracteres");
			}

			if (!preg_match('/\-/', $_POST[$nombre]["nombre"])) {
				$modelo->setError("nombre", "Debe contener al menos una -");
			}
			$modelo->setValores($_POST[$nombre]);

			if ($modelo->validar()) {
				$modelo->guardar();

				$this->_MisPueblos[] = $modelo;
				$_SESSION["Pueblos"] = $this->_MisPueblos;

				Sistema::app()->irAPagina(["pueblos"]);
			}
		}


		$this->dibujaVista("nuevo", ["modelo" => $modelo], "Nuevo");
	}


	public function accionDescarga()
	{
		// Comprobar usuario
		if (!isset($_SESSION["usuario"])) {
			Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
			return;
		}

		// Comprobar permiso 6
		if (!in_array(5, $_SESSION["usuario"]["permisos"])) {
			Sistema::app()->paginaError(403, "No tienes permiso para descargar pueblos.");
			return;
		}

		//COMO NO ME ENCUENTA LOS DATOS NO ME SALE LA DESCARGA PERO FUNCIONA SI LOS ENCONTRASE NO SE QUE LE PASA PERO SI CREO
		// LA PARTIDA AUNQUE NO SEA VALIDA SI LA DESCARGA BIEN AUNQUE NO COGE LOS VALORES POR DEFECTO

		// Comprobar que llega un código de pueblo para descargar
		if (!isset($_GET["id"])) {
			Sistema::app()->paginaError(400, "No se ha indicado ningún pueblo.");
			return;
		}

		$id = intval($_GET["id"]);

		// Obtener el pueblo
		$p = $this->_MisPueblos;

		foreach ($_SESSION["Pueblos"] as $valor) {
			if ($valor->cod_tipo_elemento == $id) {
				$p = $valor;
			}
		}

		// Comprobar que el pueblo es correcto existe
		if ($p === "") {
			Sistema::app()->paginaError(404, "El pueblo indicado no existe.");
			return;
		}

		// CABECERAS DE DESCARGA DIRECTA
		header("Content-Type: application/xml");
		header("Content-Disposition: attachment; filename=pueblo_{$p->nombre}.xml");

		// GENERAR XML DIRECTAMENTE
		echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		echo "<pueblo>\n";
		echo "    <nombre>{$p->nombre}</nombre>\n";
		echo "    <cod_tipo_elemento>{$p->cod_tipo_elemento}</cod_tipo_elemento>\n";
		echo "    <descripcion_tipo>{$p->descripcion_tipo}</descripcion_tipo>\n";
		echo "    <elemento>{$p->elemento}</elemento>\n";
		echo "    <reconocodo_unesco>{$p->reconocodo_unesco}</reconocodo_unesco>\n";
		echo "    <fecha_reconocimiento>{$p->fecha_reconocimiento}</fecha_reconocimiento>\n";
		echo "</pueblo>";

		return;
	}

	// INICIALIZAR PUEBLOS
	private function inicializarPueblos()
	{
		$this->_MisPueblos = [];

		for ($i = 1; $i <= 2; $i++) {

			$p = new pueblo();

			$p->setValores([
				"nombre" => "Pueblo" . $i,
				"cod_tipo_elemento" => $i,
				"descripcion_tipo" => "Hola",
				"elemento" => "Ele-Adaw",
				"reconocido_unesco" => $i - 1,
				"fecha_reconocimiento" => date("d/m/Y")
			]);

			$p->guardar();

			$this->_MisPueblos[$i] = $p;
		}

		$_SESSION["Pueblos"] = $this->_MisPueblos;
	}

	private function calcularPueblosDeLaUnesco()
	{

		$this->N_PueblosUnesco = 0;

		foreach ($this->_MisPueblos as $p) {
			if ($p->reconocido_unesco === 0) {
				$this->N_PueblosUnesco++;
			}
		}
	}
}
