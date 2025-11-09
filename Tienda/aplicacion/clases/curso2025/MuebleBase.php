<?php
include_once("../../scripts/librerias/validacion.php");

abstract class MuebleBase
{

    // Declración de propiedades y constantes
    public const MATERIALES_POSIBLES = ["Madera", "Plástico", "Metal", "Terciopelo"];
    const MAXIMO_MUEBLES = 20;
    private static int $mueblesCreados = 0;

    //Variables
    private string $nombre;
    private string $fabricante = "FMu";
    private string $pais = "ESPAÑA";
    private int $anio = 2020;
    private string $fechaIniVenta = "01/01/2020";
    private string $fechaFinVenta = "31/12/2040";
    private int|string $materialPrincipal;
    private float $precio = 30;

    private Caracteristicas $caracteristicas;


    /**
     * Contructor en el que asiganamos datos por defecto sino los pasamos
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
     */
    protected function __construct(
        string $nombre,
        int|string $materialPrincipal,
        Caracteristicas $caracteristicas,
        string $fabricante,
        string $pais,
        int $anio,
        string $fechaIniVenta,
        string $fechaFinVenta,
        float $precio
    ) {
        if (self::$mueblesCreados >= self::MAXIMO_MUEBLES) {
            throw new Exception("Se ha alcanzado el máximo de muebles permitidos.");
        }

        if (!$this->setNombre($nombre)) {
            throw new Exception("Nombre inválido.");
        }

        if (!$this->setFabricante($fabricante)) $this->setFabricante("FMu:");
        if (!$this->setAnio($anio)) $this->setAnio(2020);
        if (!$this->setPais($pais)) $this->setPais("ESPAÑA");
        if (!$this->setMaterialPrincipal($materialPrincipal)) $this->setMaterialPrincipal(0);
        if (!$this->setPrecio($precio)) $this->setPrecio(30);
        if (!$this->setFechaIniVenta($fechaIniVenta)) $this->setFechaIniVenta("01/01/2020");
        if (!$this->setFechaFinVenta($fechaFinVenta)) $this->setFechaFinVenta("31/12/2040");
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
     * Método que carga en un array todas la propiedades de un mueble
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

    /**
     * Obtiene dinámicamente el valor de una propiedad del objeto.
     *
     * @param string $propiedades Nombre de la propiedad a consultar
     * @param integer $modo Modo de acceso: 1 = método get, 2 = acceso directo
     * @param mixed $res Variable donde se almacena el valor de la propiedad
     * @return boolean True si se obtiene el valor, false si la propiedad no existe
     */
    public function damePropiedad(string $propiedades, int $modo, mixed &$res): bool
    {
        // Lista de propiedades válidas
        $lista = $this->dameListaPropiedades();

        // Si no existe la propiedad, devolvemos false
        if (!in_array($propiedades, $lista)) {
            return false;
        }

        // MODO 1: Usando método get
        if ($modo === 1) {
            $metodo = "get" . ucfirst($propiedades);
            if (method_exists($this, $metodo)) {
                $res = $this->$metodo();
                return true;
            }
        }

        // MODO 2: Acceso directo 
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
     * Método para saber si podemos crear un nuevo mueble
     *
     * @return boolean true si se puede false si no
     */
    public function puedeCrear(): bool
    {
        $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;
        return $numero > 0;
    }

    /**
     * Método que añade caracteristicas a un mueble
     */
    public function añadir(...$args)
    {
        $total = count($args);
        if ($total < 2) {
            return;
        }
        if ($total % 2 !== 0) {
            array_pop($args);
        }

        // Recorrer los argumentos en pares
        for ($i = 0; $i < $total; $i += 2) {
            $clave = $args[$i];
            $valor = $args[$i + 1];

            $this->caracteristicas->$clave = $valor;
        }
    }

    /**
     * Método que manda las caracteristicas a una cadena
     *
     * @return string Devuelve las características
     */
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
            " con caracteristicas " . $this->exportarCaracteristicas();
    }

    // Getter's & Setter's
    /**
     * Setter que valida que el nombre sea valido y de hasta 40 caracteres de longitud sin incluir espacios para que no de errores
     *
     * @param string $valor
     * @return boolean
     */
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

    /**
     * Setter para validar el fabricante sino empieza por FMu se lo pondra delante y valida que la cadena sea de hasta 30 caracteres también  
     *
     * @param string $valor
     * @return boolean
     */
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

    /**
     * Setter que valida que la cadena sea de hasta 20 caracteres y sino tiene nada por defecto pondra España
     *
     * @param string $valor
     * @return boolean
     */
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

    /**
     * Setter que valida que el entero sea correcto entre 2020 y el año actual
     *
     * @param integer $valor
     * @return boolean
     */
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

    /**
     * Setter que valida que una cadena sea correcta para este año en adelante porque los muebles se han tenido que crear de este año en adelante
     *
     * @param string $valor
     * @return boolean
     */
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

    /**
     * Setter que válida que la fecha sea mayor a la fechaIniVenta y que la fecha sea menos a 2040 tambien
     *
     * @param string $valor
     * @return boolean
     */
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

    /**
     * Setter que establece el valor principal del mueble actual
     *
     * @param integer $valor
     * @return boolean
     */
    public function setMaterialPrincipal(int $valor): bool
    {
        if (validaRango($valor, MuebleBase::MATERIALES_POSIBLES, 2)) {
            $this->materialPrincipal = $valor;
            return true;
        } else return false;
    }


    public function getMaterialPrincipal(): int
    {
        return $this->materialPrincipal;
    }


    /**
     * Setter que valida que el precio este entre 30 y hasta 9999.
     *
     * @param float $valor
     * @return boolean
     */
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
