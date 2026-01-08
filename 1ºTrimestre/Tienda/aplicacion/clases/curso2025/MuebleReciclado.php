<?php
include_once("../../scripts/librerias/validacion.php");

final class MuebleReciclado extends MuebleBase
{

    private float $porcentajeReciclado = 10;

    /**
     * Setter que valida que el porcentaje sea valido entre 0 y hasta 100
     *
     * @param float $valor
     * @return boolean
     */
    public function setPorcentajeReciclado(float $valor): bool
    {
        if (!validaReal($valor, 0, 100, 10)) return false;
        $this->porcentajeReciclado = $valor;
        return true;
    }

    public function getPorcentajeReciclado(): float
    {
        return $this->porcentajeReciclado;
    }

    /**
     * Constructor al que le llegan todos los parametros por defecto y sino lo estan les asigna el valor por defecto
     *
     * @param string $nombre
     * @param integer|string $materialPrincipal
     * @param Caracteristicas $caracteristicas
     * @param string $fabricante
     * @param string $pais
     * @param integer $anio
     * @param string $fechaIniVenta
     * @param string $fechaFinVenta
     * @param integer $precio
     * @param integer $porcentajeReciclado
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
        float $porcentajeReciclado
    ) {
        parent::__construct($nombre, $materialPrincipal, $caracteristicas, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
        if (!$this->setPorcentajeReciclado($porcentajeReciclado)) {
            $this->setPorcentajeReciclado(10);
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
        return array_merge(parent::dameListaPropiedades(), ["porcentajeReciclado"]);

        //Añadir el valor de la propieadad al array mediante push
        /* $array = parent::dameListaPropiedades();
        array_push($array, "porcentajeReciclado");
        return $array; */
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
        if ($propiedad === "porcentajeReciclado") {
            $metodo = "getPorcentajeReciclado";
            if (method_exists($this, $metodo)) {
                $res = $this->$metodo();
                return true;
            }
        }

        return parent::damePropiedad($propiedad, $modo, $res);
    }

    /**
     * Método to ToString que añade el porcentaje Reciclado al padre
     *
     * @return string
     */
    public function __toString(): string
    {
        return parent::__toString() . ", reciclado en un " . $this->getPorcentajeReciclado() . "%";
    }
}
