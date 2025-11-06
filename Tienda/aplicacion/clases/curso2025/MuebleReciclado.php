<?php
include_once("../../scripts/librerias/validacion.php");

final class MuebleReciclado extends MueblesBase
{

    private int $porcentajeReciclado;

    public function setPorcentajeReciclado(int $valor): bool
    {
        if (!validaEntero($valor, 0, 100, 10)) return false;
        $this->porcentajeReciclado = $valor;
        return true;
    }

    public function getPorcentajeReciclado(): int
    {
        return $this->porcentajeReciclado;
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
        int $porcentajeReciclado
    ) {

        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $materialPrincipal, $precio);
        $this->setPorcentajeReciclado($porcentajeReciclado);
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

    public function damePropiedad(string $propiedad, int $modo, mixed &$res): bool
    {
        if ($propiedad === "porcentajeReciclado") {
            $res = ($modo === 1) ? $this->getPorcentajeReciclado() : $this->porcentajeReciclado;
            return true;
        }

        return parent::damePropiedad($propiedad, $modo, $res);
    }

    public function __toString(): string
    {
        return parent::__toString() . ", reciclado en un " . $this->getPorcentajeReciclado() . "%";
    }
}
