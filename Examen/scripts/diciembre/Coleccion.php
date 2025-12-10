<?php
// Incluir la libreria de validaciones
include_once(dirname(__FILE__) . "/../librerias/validacion.php");

// Cabecera
include_once(dirname(__FILE__) . "/../../cabecera.php");


class Coleccion
{

    // public const TEMATICAS = ["cienciaficiccion" => 10, "terror" => 20, "policiaco" => 30, "comedia" => 40];
    public const TEMATICAS = [10 => "cienciaficiccion", 20 => "terror", 30 =>  "policiaco", 40 =>  "comedia"];

    protected string $_nombre;
    protected string|DateTime $_fecha_alta;
    protected int $_tematica;
    protected string $_tematica_descripcion;

    private Libro $_libros;

    /**NOR PERMITIR SOOBRECARGA DINÁMICA */
    //Sobrecarga dinámica

    public function __set(string $nombre, mixed $valor)
    {
        throw new Exception('No existe la propiedad ' . $nombre);
    }
    public function __get(string $nombre)
    {
        throw new Exception('No existe la propiedad ' . $nombre);
    }
    public function __isset(string $nombre): bool
    {
        return false;
    }

    /**
     * Constructor con validaciones y valores por defecto
     */
    public function __construct(
        string $_nombre,
        string|DateTime $_fecha_alta,
        int $_tematica

    ) {
        // Validar nombre y muestra el código correspondiente 
        if ($this->setNombre($_nombre) != 10) throw new Exception("Error en nombre");

        // Fecha Alta (por defecto 1/10/2025)
        if ($_fecha_alta === null) {
            $_fecha_alta = new DateTime("1/10/2025");
        }

        $this->setFechaAlta($_fecha_alta);

        // Temática 
        $this->setTematica($_tematica);

        // Temática Descripción Calculado a paritr de temática
        $this->_tematica_descripcion = $this::TEMATICAS[$this->_tematica];


        // Inicializar objeto Libros
        // $this->_libros[] = new Libro("nombre", "autor");
    }

    /**
     * SETTERS CON VALIDACIÓN Y RESTRICCIONES (ENUNCIADO)
     */
    /**
     * Setter para validar la cadena Nombre
     *
     * @param string $_nombre
     * @return integer 10 Todo correcto
     *                -10 Algo no esta bien
     */
    public function setNombre(string $_nombre): int
    {
        if (empty($_nombre)) return -10;                      // Obligatorio
        if (!validaCadena($_nombre, 40, "")) return -10;      // Longitud máxima
        $this->_nombre = $_nombre;
        return 10;
    }

    /**
     * Setter para validar que la _fecha_alta sea correcta
     *
     * @param DateTime $fecha 
     * @return integer 10 Todo correcto
     *                -10 Algo no esta bien
     */
    public function setFechaAlta(string|DateTime $_fecha_alta): int
    {
        $fechaHoy = new Datetime();
        if (!validaFecha($_fecha_alta, $fechaHoy->format("d/m/y"), "1/10/2025"))
            return -10;
        if (!validaFecha($_fecha_alta, date('d/m/y', strtotime("-4 year")), "1/10/2025"))
            return -10;
        $this->_fecha_alta = $_fecha_alta;
        return 10;
    }

    /**
     * Setter que valida que la tematica sea correcto a partir de campos calculados
     *
     * @param integer $_tematica
     * @return integer 10 Todo correcto
     *                -10 Algo no esta bien
     */

    public function setTematica(int $_tematica): int
    {
        if (!isset(self::TEMATICAS[$_tematica])) {
            $this->_tematica = 10; // Valor por defecto
            $this->_tematica_descripcion = self::TEMATICAS[10];
            return -10;         // Tipo no válido
        }
        $this->_tematica = $_tematica;
        $this->_tematica_descripcion = self::TEMATICAS[$_tematica];
        return 10;
    }
    /* public function setTematica(int $_tematica): int
    {
        if (!validaEntero(self::TEMATICAS[$_tematica], 10, 30, 10))
            return -10;
        else $this->_tematica = $_tematica;
        return 10;
    } */


    /** GETTERS */
    /** GETTERS */
    public function getNombre(): string
    {
        return $this->_nombre;
    }
    public function getFechaAlta(): DateTime
    {
        return $this->_fecha_alta;
    }
    public function getTematica(): int
    {
        return $this->_tematica;
    }
    public function getTematicaDescripcion(): string
    {
        return $this->_tematica_descripcion;
    }


    /**
     * Método aniadeLibros
     * Permite añadir propiedades dinámicas al objeto Libros
     */
    public function aniadirLibros(string $propiedad, mixed $valor, ...$mas): int
    {
        $n_prop = 0;
        $this->_libros->$propiedad = $valor;
        $n_prop++;
        for ($i = 0; $i < count($mas); $i += 2) {
            $prop = $mas[$i];
            $val = $mas[$i + 1] ?? null;
            $this->_libros->$prop = $val;
            $n_prop++;
        }
        return $n_prop;
    }

    /**
     * Método dameLibros muestra los libros guardados en el arrat
     *
     * @return array
     */
    function dameLibros(): array
    {
        foreach ($this->_libros as $cod => $lib) {
            $_libros[$cod] = $lib["libro"];
        }
        return $_libros;
    }

    /**
     * toString de la clase Coleccion
     *
     * @return string
     */
    public function __toString()
    {
        return "Colección " . $this->_nombre .
            " añadida el  " . $this->_fecha_alta .
            " de temática " . $this->_tematica_descripcion;
    }
}
