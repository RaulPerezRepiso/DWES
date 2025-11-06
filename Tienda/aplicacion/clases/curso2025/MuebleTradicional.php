<?php
include_once("../../scripts/librerias/validacion.php");

final class MuebleTradicional extends MueblesBase
{

    private float $peso;
    private string $serie;

    public function setPeso(float $valor): bool
    {
        if (!validaReal($valor, 15, 300, 15)) return false;
        $this->peso = $valor;
        return true;
    }

    public function getPeso(): float
    {
        return $this->peso;
    }
    public function setSerie(string $valor): bool
    {
        if (!validaCadena($valor, 100, "S01")) return false;
        $this->serie = $valor;
        return true;
    }

    public function getSerie(): string
    {
        return $this->serie;
    }

    public function __construct(
        string $nombre,
        string $fabricante,
        string $pais,
        int $anio,
        string $fechaIniVenta,
        string $fechaFinVenta,
        int|string $materialPrincipal,
        float $precio,
        float $peso,
        string $serie

    ) {

        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $materialPrincipal, $precio);
        $this->setPeso($peso);
        $this->setSerie($serie);
    }

    /**
     * Método que da una lista de todas las propiedades de un mueble
     *
     * @return array Con todos los valores que le correspondan
     */
    public function dameListaPropiedades(): array
    {
        // Método facil con merge para añadir cosas al array
        return array_merge(parent::dameListaPropiedades(), ["peso", "serie"]);
    }

    public function damePropiedad(string $propiedad, int $modo, mixed &$res): bool
    {
        if ($propiedad === "peso") {
            $res = ($modo === 1) ? $this->getPeso() : $this->peso;
            return true;
        }

        if ($propiedad === "serie") {
            $res = ($modo === 1) ? $this->getSerie() : $this->serie;
            return true;
        }

        return parent::damePropiedad($propiedad, $modo, $res);
    }

    public function __toString(): string
    {
        return parent::__toString() . ", pesa un total de: " . $this->getPeso() . " y es de la serie ".$this->getSerie();
    }
}
