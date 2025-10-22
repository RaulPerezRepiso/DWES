<?php
class Persona {

    //Propiedades privadas
    private string $_nombre;
    private string $_fecha_nacimiento;
    private string $_domicilio;
    private string $_localidad;
    private EstadoCivil $_estado;

       // Llamadas a get o set
    public function getNombre(): string{return $this->_nombre;}
    public function setNombre(string $valor): void{$this->_nombre = $valor; }

    public function getFechaNacimiento(): string{return $this->_fecha_nacimiento;}
    public function setFechaNacimiento(string $valor): void{$this->_fecha_nacimiento = $valor; }

    public function getDomicilio(): string{return $this->_domicilio;}
    public function setDomicilio(string $valor): void{$this->_domicilio = $valor; }

    public function getLocalidad(): string{return $this->_localidad;}
    public function setLocalidad(string $valor): void{$this->_localidad = $valor; }

    public function getEstado(): EstadoCivil {return $this->_estado;}
    public function setEstado(EstadoCivil $valor): void{$this->_estado = $valor; }

    private function __construct()
    {
        $this->_nombre = "Prueba";
        $this->_fecha_nacimiento = "01/01/2000";
        $this->_domicilio = "Carrera 12";
        $this->_localidad = "Antequera";
        $this->_estado = EstadoCivil::Soltero;
        
    }

    public static function registrarPersona($_nombre, $_fecha_nacimiento, $_domicilio, $_localidad, $_estado)
    {
     return new Persona($_nombre, $_fecha_nacimiento, $_domicilio, $_localidad, $_estado);   
    }

    // Definición del toString
    public function __toString(): string
    {
        return "{$this->_nombre} es una persona {$this->_estado} nacida el {$this->_fecha_nacimiento} y que vive en {$this->_localidad}";
    }

}


?>