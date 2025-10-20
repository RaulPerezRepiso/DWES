<?php

class InstrumentoViento extends InstrumentoBase
{

    /**
     * Llamada de método de la clase Padre
     *
     * @return string
     */
    public function sonido(): string
    {
        return "Sonido";
    }


    /**
     * Llamada de método de la clase Padre
     *
     * @return string
     */
    public final function afinar(): string
    {
        return "Afinar";
    }


    // Atributo del material
    protected string $_material;

    /**
     * Constructor heredado
     *
     * @param [type] $_edad
     */
    public function __construct($_edad = 15, string $_material = "Madera")
    {
        parent::__construct("Instrumento de Viento", $_edad);
        $this->_material = $_material;
    }

    // Definición del toString
    public function __toString(): string
    {
        return parent::__toString(). "Intrumento de Material {$this->_material}";
    }


}
