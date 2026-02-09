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

        if (isset($_SESSION["Partidas"])) {
            $this->partidas = $_SESSION["Partidas"];
        } else {
            $this->inicializarPartidas();
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
            "nick" => "RaulPerez",
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

    //Acciçon que muestra la vista de nueva
    public function accionNueva()
    {
        $this->menuizq = [
            ["texto" => "Inicio", "enlace" => ["partida"]],
        ];

        $this->dibujaVista("nueva", [], "Nueva Partida");
    }

    public function accionDescarga()
    {
        $this->menuizq = [
            ["texto" => "Inicio", "enlace" => ["partida"]],
        ];

        $this->dibujaVista("descarga", [], "Descargar");
    }
}
