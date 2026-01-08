<?php
include_once("../../scripts/librerias/validacion.php");

final class MuebleTradicional extends MuebleBase
{

    private float $peso = 15;
    private string $serie = "S01";

    /**
     * Setter que valida que el peso este entre 15 y 300
     *
     * @param float $valor
     * @return boolean
     */
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

    /**
     * Setter que valida que la serie sea correcta sino ponemos nada sera S01 por defecto   
     */
    public function setSerie(string $valor): bool
    {
        if (!validaCadena($valor, 10, "S01")) return false;
        $this->serie = $valor;
        return true;
    }

    public function getSerie(): string
    {
        return $this->serie;
    }

    /**
     * Contructor que devuelve los datos sino son validos devuelve los asignados por defecto
     *
     * @param string $nombre
     * @param integer|string $materialPrincipal
     * @param Caracteristicas $caracteristicas
     * @param string $fabricante
     * @param string $pais
     * @param integer $anio
     * @param string $fechaIniVenta
     * @param string $fechaFinVenta
     * @param float $precio
     * @param float $peso
     * @param string $serie
     */
    public function __construct(
        string $nombre,
        int|string $materialPrincipal,
        Caracteristicas $caracteristicas,
        string $fabricante,
        string $pais,
        int $anio,
        string $fechaIniVenta,
        string $fechaFinVenta,
        float $precio,
        float $peso,
        string $serie
    ) {
        parent::__construct($nombre, $materialPrincipal, $caracteristicas, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
        if (!$this->setPeso($peso)) {
            $this->setPeso(15);
        }
        if (!$this->setSerie($serie)) {
            $this->setSerie("S01");
        }
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

    /**
     * Obtiene dinámicamente el valor de una propiedad del objeto.
     *
     * @param string $propiedades Nombre de la propiedad a consultar
     * @param integer $modo Modo de acceso: 1 = método get, 2 = acceso directo
     * @param mixed $res Variable donde se almacena el valor de la propiedad
     * @return boolean True si se obtiene el valor, false si la propiedad no existe
     */
    public function damePropiedad(string $propiedad, int $modo, mixed &$res): bool
    {
        if ($propiedad === "peso") {
            $res = $this->getPeso();
            return true;
        }

        if ($propiedad === "serie") {
            $res = $this->getSerie();
            return true;
        }

        return parent::damePropiedad($propiedad, $modo, $res);
    }

    /**
     * ToString que devuelve la información del padre añadiendo la suya propia
     *
     * @return string
     */
    public function __toString(): string
    {
        return parent::__toString() . ", pesa un total de: " . $this->getPeso() . " y es de la serie " . $this->getSerie();
    }
}
