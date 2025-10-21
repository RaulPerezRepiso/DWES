<?php
final class Flauta extends InstrumentoViento implements IFabricable
{

    private function __construct($_edad =10, $_material="madera")
    {
        parent::__construct($_edad, $_material);
    }

    public static function crearDesdeArray(array $datos): static
    {
        $edad = $datos['edad'] ?? 0;
        $material = $datos['material'] ?? 'madera';
        return new static($edad, $material);
    }

    public function metodoFabricacion(): string
    {
        return "";
    }

    public function metodoRecicaldo(): string
    {
        return "";
    }


    public function __clone()
    {
        $this->_edad = 0;
        self::$_cont++;
        $this->setOrdenCreacion(self::$_cont);
    }
}
