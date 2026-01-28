<?php

class CSesion
{

    private function __construct() {}

    // Crea o carga la sesión 
    public function crearSesion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Devuelve true si hay sesión activa 
    public function haySesion(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    // Destruye la sesión 
    public function destruirSesion()
    {
        if ($this->haySesion()) {
            session_unset();
            session_destroy();
        }
    }
}
