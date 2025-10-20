<?php
abstract class InstrumentoBase
{

    // Apartado UNO
    // Declaramos los atributos
    private string $_descripcion;

    // Llamadas a get o set
    public function getCadena(): string
    {
        return $this->_descripcion;
    }

    public function setCadena(string $valor): void
    {
        $this->_descripcion = $valor;
    }

    // Apartado DOS
    protected int $_edad = 10;

    public function getEdad(): int
    {
        return $this->_edad;
    }

    // Definción de 2 métodos abstractos
    abstract public function sonido(): string;
    abstract public function afinar(): string;


    // Métodos no abstractos aún para su uso
    /* public function sonido(): string
    {
        return "Sonido genérico";
    }

    public function afinar(): string
    {
        return "Paso 1";
    } */

    // Método envejecer
    public function envejecer(): int
    {
        return ++$this->_edad;
    }

    // Variable de clase protegida
    protected static int $_cont = 0;
    protected int $_ordenCreacion;


    // Definición del constructor
    public function __construct(string $_descripcion = "Descripcioón por defecto", int $_edad = 10)
    {
        $this->_descripcion = $_descripcion;
        $this->_edad = $_edad;
        self::$_cont++;
        $this->_ordenCreacion =self::$_cont;
    }

    // Definición del toString
    public function __toString(): string
    {
        return "Instrumento con descripción:  {$this->_descripcion}, instancia {$this->_ordenCreacion} de un total de " .self::$_cont.  ". Tiene  {$this->_edad} años. La clase es ". get_class($this) ."<br>";
    }
}
