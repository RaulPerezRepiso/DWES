<?php
class partidaControlador extends CControlador
{
    public array $menuizq = [];
    public array $partidas = [];
    public int $N_Partidas = 0;
    public int $N_PartidasHoy = 0;

    public function __construct()
    {
        parent::__construct();

        Sistema::app()->sesion()->crearSesion();

        if (!isset($_SESSION["Partidas"]) || !is_array($_SESSION["Partidas"]) || empty($_SESSION["Partidas"])) {
            // Si no hay partidas, las creo
            $this->inicializarPartidas();
        } else {
            // Si ya hay, las cargo
            $this->partidas = $_SESSION["Partidas"];
        }

        $this->N_Partidas = count($this->partidas);
        $this->calcularPartidasHoy();
    }

    public function accionIndex()
    {

        $this->menuizq = [
            ["texto" => "Inicio", "enlace" => ["partida"]],
        ];

        // $this->dibujaVista("index", [], "Listado de Partidas");

        $this->accionVer();
    }

    // LOGIN
    public function accionLogin()
    {
        // Debe haber 1 o más partidas HOY
        if ($this->N_PartidasHoy < 1) {
            Sistema::app()->paginaError(400, "No puedes hacer login: no hay partidas previstas para hoy.");
            return;
        }

        // Registrar usuario
        $_SESSION["usuario"] = [
            "nick" => "Raúl Pérez",
            "permisos" => [2, 4, 6]
        ];

        // $this->dibujaVista("login", [], "Login correcto");
        Sistema::app()->irAPagina("index", [], "Partidas");
    }

    // LOGOUT
    public function accionLogout()
    {
        // Debe haber usuario registrado
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "No puedes hacer logout: no hay usuario registrado.");
            return;
        }

        // Debe haber 2 o más partidas (da igual el día)
        if ($this->N_Partidas < 2) {
            Sistema::app()->paginaError(400, "No puedes hacer logout: no hay suficientes partidas.");
            return;
        }

        unset($_SESSION["usuario"]);

        // $this->dibujaVista("logout", [], "Logout correcto");
        Sistema::app()->irAPagina("index", [], "Partidas");
    }

    // INICIALIZAR PARTIDAS
    private function inicializarPartidas()
    {
        $this->partidas = [];

        // Lista completa de barajas
        $lista = listas::listaTiposBarajas();
        $codigos = array_keys($lista);

        for ($i = 1; $i <= 3; $i++) {

            $p = new partida();

            // Código de baraja válido
            $codBaraja = $codigos[$i - 1];

            // AQUÍ ESTÁ LA CLAVE: obtener datos completos
            $datosBaraja = listas::listaTiposBarajas(true, $codBaraja);
            $nombreBaraja = $datosBaraja["nombre"];

            $p->setValores([
                "cod_partida" => $i,
                "mesa" => $i + 1,
                "fecha" => date("d/m/Y", strtotime("+" . ($i - 1) . " day")),
                "cod_baraja" => $codBaraja,
                "nombre_baraja" => $nombreBaraja,
                "jugadores" => 4,
                "crupier" => "Cru-Init$i"
            ]);

            $p->guardar();

            $this->partidas[$i] = $p;
        }

        $_SESSION["Partidas"] = $this->partidas;
    }


    private function calcularPartidasHoy()
    {
        $hoy = date("d/m/Y");
        $this->N_PartidasHoy = 0;

        foreach ($this->partidas as $p) {
            if ($p->fecha === $hoy) {
                $this->N_PartidasHoy++;
            }
        }
    }

    public function accionVer()
    {
        // Obtener partidas desde sesión
        $partidas = $this->partidas;

        // Sacar crupieres distintos
        $crupieres = [];
        foreach ($partidas as $p) {
            $crupieres[$p->crupier] = $p->crupier;
        }

        // Crupier seleccionado
        $crupierSel = $_POST["crupier"] ?? "";

        // Filtrar si se ha elegido uno
        $partidasFiltradas = $partidas;
        $partidasFiltradas = array_filter($partidas, function ($p) use ($crupierSel) {
            return $p->crupier === $crupierSel;
        });

        // Mostrar vista
        $this->dibujaVista("ver", [
            "crupieres" => $crupieres,
            "crupierSel" => $crupierSel,
            "partidas" => $partidasFiltradas
        ], "Ver partidas");
    }

    public function accionNuevo()
    {
        $this->menuizq = [
            ["texto" => "Inicio", "enlace" => ["partida", "index"]]
        ];

        $modelo = new Partida();
        $nombre = $modelo->getNombre();

        $datosCodBaraja = [];
        foreach (Listas::listaTiposBarajas() as $codigo => $valor) {
            $datosCodBaraja[$codigo] = $valor;
        }

        $datosJugadores = [];
        for ($i = 2; $i <= 8; $i++) {
            $datosJugadores[] = $i;
        }

        if (isset($_POST[$nombre])) {

            // controlar que llegan jugadores
            if (!isset($_POST["jugadores"]))
                $_POST[$nombre]["jugadores"] = -1;
            else $_POST[$nombre]["jugadores"] = intval($_POST["jugadores"]) + 2;


            // si crupier tiene menos de 10 car da error
            if (mb_strlen($_POST[$nombre]["crupier"]) < 10) {
                $modelo->setError("crupier", "Crupier debe tener al menos 10 caracteres");
            }

            // controlar el cod partida
            $_POST[$nombre]["cod_partida"] = $this->obtenerPrimerCodigoLibre();

            // controlar cod baraja
            if ($_POST[$nombre]["cod_baraja"] === "") {
                $_POST[$nombre]["cod_baraja"] = -1;
            } else {
                $_POST[$nombre]["cod_baraja"] = intval($_POST[$nombre]["cod_baraja"]);
            }

            $_POST[$nombre]["nombre_baraja"] = Listas::listaTiposBarajas(false, $_POST[$nombre]["cod_baraja"]);

            // controlar fecha
            $_POST[$nombre]["fecha"] = date("d/m/Y", strtotime($_POST[$nombre]["fecha"]));

            // print_r($_POST[$nombre]);

            $modelo->setValores($_POST[$nombre]);

            if ($modelo->validar()) {
                $modelo->guardar();

                $this->partidas[] = $modelo;
                $_SESSION["Partidas"] = $this->partidas;

                Sistema::app()->irAPagina(["partida"]);
            }
        }


        $this->dibujaVista("nuevo", ["modelo" => $modelo, "datosCodBaraja" => $datosCodBaraja, "datosJugadores" => $datosJugadores], "Nueva Partida");
    }


    public function accionDescarga()
    {
        // Comprobar usuario
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
            return;
        }

        // Comprobar permiso 6
        if (!in_array(6, $_SESSION["usuario"]["permisos"])) {
            Sistema::app()->paginaError(403, "No tienes permiso para descargar partidas.");
            return;
        }

        // Comprobar que llega un código de partida
        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(400, "No se ha indicado ninguna partida.");
            return;
        }

        $id = intval($_GET["id"]);

        // Obtener la partida
        $p = "";

        foreach ($_SESSION["Partidas"] as $valor) {
            if ($valor->cod_partida == $id) {
                $p = $valor;
            }
        }

        // Comprobar que la partida existe
        if ($p === "") {
            Sistema::app()->paginaError(404, "La partida indicada no existe.");
            return;
        }

        // CABECERAS DE DESCARGA DIRECTA
        header("Content-Type: application/xml");
        header("Content-Disposition: attachment; filename=partida_{$p->cod_partida}.xml");
        header("Content-Transfer-Encoding: binary");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        // GENERAR XML DIRECTAMENTE
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        echo "<parti>\n";
        echo "    <cod_partida>{$p->cod_partida}</cod_partida>\n";
        echo "    <mesa>{$p->mesa}</mesa>\n";
        echo "    <fecha>{$p->fecha}</fecha>\n";
        echo "    <cod_baraja>{$p->cod_baraja}</cod_baraja>\n";
        echo "    <nombre_baraja>{$p->nombre_baraja}</nombre_baraja>\n";
        echo "    <jugadores>{$p->jugadores}</jugadores>\n";
        echo "    <crupier>{$p->crupier}</crupier>\n";
        echo "</parti>";

        return;
    }

    public function accionDescargaTxt()
    {
        // Comprobar usuario
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
            return;
        }

        if (!in_array(6, $_SESSION["usuario"]["permisos"])) {
            Sistema::app()->paginaError(403, "No tienes permiso para descargar partidas.");
            return;
        }

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(400, "No se ha indicado ninguna partida.");
            return;
        }

        $id = intval($_GET["id"]);

        // Buscar partida
        $p = "";
        foreach ($_SESSION["Partidas"] as $valor) {
            if ($valor->cod_partida == $id) {
                $p = $valor;
            }
        }

        if ($p === "") {
            Sistema::app()->paginaError(404, "La partida indicada no existe.");
            return;
        }

        // Cabeceras TXT
        header("Content-Type: text/plain");
        header("Content-Disposition: attachment; filename=partida_{$p->cod_partida}.txt");

        // Contenido TXT
        echo "COD PARTIDA: {$p->cod_partida}\n";
        echo "MESA: {$p->mesa}\n";
        echo "FECHA: {$p->fecha}\n";
        echo "COD BARAJA: {$p->cod_baraja}\n";
        echo "NOMBRE BARAJA: {$p->nombre_baraja}\n";
        echo "JUGADORES: {$p->jugadores}\n";
        echo "CRUPIER: {$p->crupier}\n";

        return;
    }


    public function accionDescargaCsv()
    {
        if (!isset($_SESSION["usuario"])) {
            Sistema::app()->paginaError(400, "Debes iniciar sesión para descargar.");
            return;
        }

        if (!in_array(6, $_SESSION["usuario"]["permisos"])) {
            Sistema::app()->paginaError(403, "No tienes permiso para descargar partidas.");
            return;
        }

        if (!isset($_GET["id"])) {
            Sistema::app()->paginaError(400, "No se ha indicado ninguna partida.");
            return;
        }

        $id = intval($_GET["id"]);

        $p = "";
        foreach ($_SESSION["Partidas"] as $valor) {
            if ($valor->cod_partida == $id) {
                $p = $valor;
            }
        }

        if ($p === "") {
            Sistema::app()->paginaError(404, "La partida indicada no existe.");
            return;
        }

        // Cabeceras CSV
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=partida_{$p->cod_partida}.csv");

        // Primera línea: cabeceras
        echo "cod_partida,mesa,fecha,cod_baraja,nombre_baraja,jugadores,crupier\n";

        // Segunda línea: datos
        echo "{$p->cod_partida},{$p->mesa},{$p->fecha},{$p->cod_baraja},{$p->nombre_baraja},{$p->jugadores},{$p->crupier}\n";

        return;
    }


    private function obtenerPrimerCodigoLibre()
    {
        $usados = [];

        foreach ($this->partidas as $p) {
            $usados[] = $p->cod_partida;
        }

        $codigo = 21;
        while (in_array($codigo, $usados)) {
            $codigo++;
        }

        return $codigo;
    }
}
