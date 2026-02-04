<?php

class registroControlador extends CControlador
{

    public array $menuizq = [];
    public array $barraUbi = [];

    public function accionPedirRegistroDatos()
    {

        $this->barraUbi = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
        ];

        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Productos",
                "enlace" => ["productos"]
            ]
        ];

        // 1. Crear el modelo
        $registro = new DatosRegistro();

        // 2. Obtener el nombre del formulario (clave del POST)
        $nombre = $registro->getNombre();
        // "datosRegistro" 
        // 3. Si llega POST → procesar datos 
        if (isset($_POST[$nombre])) {
            // 3.1 Cargar valores en el modelo 
            $registro->setValores($_POST[$nombre]);
            // 3.2 Validar 
            if ($registro->validar()) {
                // 3.3 Si todo es correcto → mostrar vista de descarga 
                $this->dibujaVista("descargarRegistro", ["modelo" => $registro], "Registros de Datos");
                return;
            }
        }

        $this->dibujaVista("pedirRegistroDatos", ["modelo" => $registro], "Registros de Datos");
    }

    public function accionLogin()
    {

        $this->barraUbi = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
            [
                "texto" => "Login",
                "enlace" => ["login"]
            ],
        ];

        $this->menuizq = [
            [
                "texto" => "Inicio",
                "enlace" => ["inicial"]
            ],
        ];

        $login = new Login();
        $nombre = $login->getNombre();

        if (isset($_POST[$nombre])) {
            $login->setValores($_POST[$nombre]);
            if ($login->validar()) {
                // El usuario ya está registrado en sesión por validarPass() 
                Sistema::app()->irAPagina(["inicial"]);
                return;
            }
        }
        $this->dibujaVista("login", ["modelo" => $login], "Login");
    }

    protected function accionLogout()
    {
        Sistema::app()->sesion()->destruirSesion();
        Sistema::app()->irAPagina(["inicial"]);
    }
}
