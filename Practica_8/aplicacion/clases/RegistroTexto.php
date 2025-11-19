<?php
class RegistroTexto
{

    private string $cadena;
    private DateTime $fechaHora;

    public function __construct(string $cadena)
    {
        $this->cadena = $cadena;
        $this->fechaHora = new DateTime();
    }

    // Llamadas a metodos Get
    public function getCadena(): string
    {
        return $this->cadena;
    }

    public function getFechaHora(): string
    {
        return $this->fechaHora->format("d-m-Y H:i:s");
    }
}
