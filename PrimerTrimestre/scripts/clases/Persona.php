<?php
class Persona
{

    //Propiedades privadas
    private string $_nombre;
    private string $_fecha_nacimiento;
    private string $_domicilio;
    private string $_localidad;
    private EstadoCivil $_estado;

    // Llamadas a get o set
    public function getNombre(): string
    {
        return $this->_nombre;
    }
    public function setNombre(string $valor): void
    {
        $this->_nombre = $valor;
    }

    public function getFechaNacimiento(): string
    {
        return $this->_fecha_nacimiento;
    }
    public function setFechaNacimiento(string $valor): void
    {
        $this->_fecha_nacimiento = $valor;
    }

    public function getDomicilio(): string
    {
        return $this->_domicilio;
    }
    public function setDomicilio(string $valor): void
    {
        $this->_domicilio = $valor;
    }

    public function getLocalidad(): string
    {
        return $this->_localidad;
    }
    public function setLocalidad(string $valor): void
    {
        $this->_localidad = $valor;
    }

    public function getEstado(): EstadoCivil
    {
        return $this->_estado;
    }
    public function setEstado(EstadoCivil $valor): void
    {
        $this->_estado = $valor;
    }

    private function __construct()
    {
        $this->_nombre = "Prueba";
        $this->_fecha_nacimiento = "01/01/2000";
        $this->_domicilio = "Carrera 12";
        $this->_localidad = "Antequera";
        $this->_estado = EstadoCivil::Soltero;
    }

    public static function registrarPersona($_nombre, $_fecha_nacimiento, $_domicilio, $_localidad, $_estado): static
    {
        $PersonaNueva = new Persona();
        $PersonaNueva->setNombre($_nombre);
        $PersonaNueva->setFechaNacimiento($_fecha_nacimiento);
        $PersonaNueva->setDomicilio($_domicilio);
        $PersonaNueva->setLocalidad($_localidad);
        $PersonaNueva->setEstado($_estado);

        // Se puede hacer de esta manera más facil sin llamar a los setters
        /* $PersonaNueva->_nombre = $_nombre;
        $PersonaNueva->_fecha_nacimiento = $_fecha_nacimiento;
        $PersonaNueva->_domicilio = $_domicilio;
        $PersonaNueva->_localidad = $_localidad;
        $PersonaNueva->_estado = $_estado; */
        return $PersonaNueva;
    }

    // Definición del toString
    public function __toString(): string
    {
        return "{$this->_nombre} es una persona {$this->_estado->descripcion()} nacida el {$this->_fecha_nacimiento} y que vive en {$this->_localidad}";
    }
}
