<?php
include_once("../../scripts/librerias/validacion.php");

abstract class MueblesBase
{

    // Declración de propiedades y constantes
    public const MATERIALES_POSIBLES = ["madera", "plastico", "metal", "lana"];
    const MAXIMO_MUEBLES = 20;
    private static int $mueblesCreados;

    //Variables
    private string $nombre;
    private string $fabricante;
    private string $pais;
    private string $anio;
    private string $fechaIniVenta;
    private string $fechaFinVenta;
    private int $materialPrincipal;
    private float $precio;

    //Constructor
    protected function __construct(
        string $nombre,
        string $fabricante = '',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        string $fechaIniVenta = '01/01/2020',
        string $fechaFinVenta = '31/12/2040',
        int $materialPrincipal = 1,
        float $precio = 30.0
    ) {
        if (self::$mueblesCreados >= self::MAXIMO_MUEBLES) {
            throw new Exception("Se ha alcanzado el máximo de muebles permitidos.");
        }

        if (!$this->setNombre($nombre)) {
            throw new Exception("Nombre inválido.");
        }

        $this->setFabricante($fabricante) ?: $this->setFabricante('FMu:');
        $this->setPais($pais) ?: $this->setPais('ESPAÑA');
        $this->setAnio($anio) ?: $this->setAnio(2020);
        $this->setFechaIniVenta($fechaIniVenta) ?: $this->setFechaIniVenta('01/01/2020');
        $this->setFechaFinVenta($fechaFinVenta) ?: $this->setFechaFinVenta('31/12/2040');
        $this->setMaterialPrincipal($materialPrincipal) ?: $this->setMaterialPrincipal(1);
        $this->setPrecio($precio) ?: $this->setPrecio(30.0);

        self::$mueblesCreados++;
    }

    // Getter's & Setter's
    public function setNombre(string $valor): bool
    {
        $valor = strtoupper(trim($valor));
        if (!validaCadena($valor, 40, '')) return false;
        if ($valor === '') return false;
        $this->nombre = $valor;
        return true;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setFabricante(string $valor): bool
    {
        if (!validaCadena($valor, 30, "FMu")) return false;
        if ($valor === 'Fmu') return false;
        $this->fabricante = $valor;
        return true;
    }

    public function getFabricante(): string
    {
        return $this->fabricante;
    }

    public function setPais(string $valor): void
    {
        $this->pais = $valor;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function setAnio(string $valor): void
    {
        $this->anio = $valor;
    }

    public function getAnio(): string
    {
        return $this->anio;
    }

    public function setFechaIniVenta(string $valor): void
    {
        $this->fechaIniVenta = $valor;
    }

    public function getFechaIniVenta(): string
    {
        return $this->fechaIniVenta;
    }

    public function setFechaFinVenta(string $valor): void
    {
        $this->fechaFinVenta = $valor;
    }

    public function getFechaFinVenta(): string
    {
        return $this->fechaFinVenta;
    }

    public function setMaterialPrincipal(int $valor): void
    {
        $this->materialPrincipal = $valor;
    }

    // Método que devuelve una cadena con la descripción principal del material
    public function getMaterialPrincipal(): int
    {
        return $this->materialPrincipal;
    }

    public function setPrecio(float $valor): void
    {
        $this->precio = $valor;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }
}
