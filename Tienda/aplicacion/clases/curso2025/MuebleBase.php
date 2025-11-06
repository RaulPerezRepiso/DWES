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
    private int $anio;
    private string $fechaIniVenta;
    private string $fechaFinVenta;
    private int|string $materialPrincipal;
    private float $precio;

    private Caracteristicas $caracteristicas;


    //Constructor
    protected function __construct(
        string $nombre,
        string $fabricante = "FMu",
        string $pais = "ESPAÑA",
        int $anio = 2020,
        string $fechaIniVenta = "01/01/2020",
        string $fechaFinVenta = "31/12/2040",
        int|string $materialPrincipal,
        float $precio = 30,
        Caracteristicas $caracteristicas
    ) {
        if (self::$mueblesCreados >= self::MAXIMO_MUEBLES) {
            throw new Exception("Se ha alcanzado el máximo de muebles permitidos.");
        }

        if (!$this->setNombre($nombre)) {
            throw new Exception("Nombre inválido.");
        }

        $this->setFabricante($fabricante);
        $this->setPais($pais);
        $this->setAnio($anio);
        $this->setFechaIniVenta($fechaIniVenta);
        $this->setFechaFinVenta($fechaFinVenta);
        $this->materialPrincipal = self::getMaterialDescripcion($materialPrincipal);
        $this->setPrecio($precio);
        $this->caracteristicas = $caracteristicas;

        self::$mueblesCreados++;
    }

    /**
     * Devuelve una cadena con la descripción correspondiente al material
     *
     * @return string
     */
    public function getMaterialDescripcion(): string
    {
        return self::MATERIALES_POSIBLES[$this->materialPrincipal] ?? "Desconocido";
    }

    /**
     * Método que da una lista de todas las propiedades de un mueble
     *
     * @return array Con todos los valores que le correspondan
     */
    public function dameListaPropiedades(): array
    {
        return [
            "nombre",
            "fabricante",
            "pais",
            "anio",
            "fechaIniVenta",
            "fechaFinVenta",
            "materialPrincipal",
            "precio"
        ];
    }

    public function damePropiedad(string $propiedades, int $modo, mixed &$res): bool
    {
        // Lista de propiedades válidas
        $lista = $this->dameListaPropiedades();

        // Si no existe la propiedad, devolvemos false
        if (!in_array($propiedades, $lista)) {
            return false;
        }

        // MODO 1: Usar método getX()
        if ($modo === 1) {
            $metodo = "get" . ucfirst($propiedades);
            if (method_exists($this, $metodo)) {
                $res = $this->$metodo();
                return true;
            }
        }

        // MODO 2: Acceso directo (no posible en clase base, así que usamos el getter)
        if ($modo === 2) {
            $metodo = "get" . ucfirst($propiedades);
            if (method_exists($this, $metodo)) {
                $res = $this->$metodo();
                return true;
            }
        }

        return false;
    }

    /**
     * Método para saber si podemos crear un nuevo mueble o no
     *
     * @return boolean true si se puede false si no
     */
    public function puedeCrear(): bool
    {
        $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;
        return $numero > 0;
    }

    public function añadir(...$args)
    {
        $total = count($args);
        if ($total < 2) {
            return;
        }
        if ($total % 2 == 0) {
            array_pop($args);
        }

        // Recorrer los argumentos en pares
        for ($i = 0; $i < $total; $i += 2) {
            $clave = $args[$i];
            $valor = $args[$i + 1];

            $this->caracteristicas->$clave = $valor;
        }
    }

    public function exportarCaracteristicas(): string
    {
        $cadena = "";
        foreach ($this->caracteristicas as $clave => $valor) {
            $cadena .= "$clave : $valor\n";
        }
        return $cadena;
    }

    /**
     * ToString
     *
     * @return string devuelvo la cadena con toda la información
     */
    public function __toString(): string
    {
        return "MUEBLE de clase " . get_class($this) .
            " con nombre " . $this->getNombre() .
            ", fabricante " . $this->getFabricante() .
            ", fabricado en " . $this->getPais() .
            " a partir del año " . $this->getAnio() .
            ", vendido desde " . $this->getFechaIniVenta() .
            " hasta " . $this->getFechaFinVenta() .
            ", precio " . $this->getPrecio() .
            " de material " . $this->getMaterialDescripcion() .
            " con caracteristicas" . $this->exportarCaracteristicas();
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
        $valor = trim($valor);
        if (!str_starts_with($valor, "FMu")) $valor = "FMu" . $valor;
        if (!validaCadena($valor, 30, "FMu")) return false;
        if ($valor === 'FMu') return false;
        $this->fabricante = $valor;
        return true;
    }

    public function getFabricante(): string
    {
        return $this->fabricante;
    }

    public function setPais(string $valor): bool
    {
        $valor = trim($valor);
        if (!validaCadena($valor, 20, "ESPAÑA")) return false;
        $this->pais = $valor;
        return true;
    }

    public function getPais(): string
    {
        return $this->pais;
    }

    public function setAnio(int $valor): bool
    {
        $actual = (int)date("Y");
        if (!validaEntero($valor, 2020, $actual, 2020)) return false;
        $this->anio = $valor;
        return true;
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function setFechaIniVenta(string $valor): bool
    {
        $limite = "01/01/" . $this->anio;
        if (!validaFecha($valor, $limite)) return false;
        $fechaIni = DateTime::createFromFormat("d/m/Y", $valor);
        $fechaLimite = DateTime::createFromFormat("d/m/Y", $limite);
        if ($fechaIni < $fechaLimite) return false;

        $this->fechaIniVenta = $valor;
        return true;
    }

    public function getFechaIniVenta(): string
    {
        return $this->fechaIniVenta;
    }

    public function setFechaFinVenta(string $valor): bool
    {
        if (!validaFecha($valor, "31/12/2040")) return false;
        $fechaFin = DateTime::createFromFormat("d/m/Y", $valor);
        $fechaIni = DateTime::createFromFormat("d/m/Y", $this->fechaIniVenta);
        if ($fechaFin < $fechaIni) return false;

        $this->fechaFinVenta = $valor;
        return true;
    }

    public function getFechaFinVenta(): string
    {
        return $this->fechaFinVenta;
    }

    public function setMaterialPrincipal(int $valor): bool
    {
        if (validaRango($valor, MueblesBase::MATERIALES_POSIBLES, 2)) {
            $this->materialPrincipal = $valor;
            return true;
        } else return false;
    }


    public function getMaterialPrincipal(): int
    {
        return $this->materialPrincipal;
    }


    public function setPrecio(float $valor): bool
    {
        if (!validaReal($valor, 30, 9999, 30)) return false;
        $this->precio = $valor;
        return true;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }
}
