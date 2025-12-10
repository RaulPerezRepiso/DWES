<?php
include_once(dirname(__FILE__) . "/../librerias/validacion.php");
include_once(dirname(__FILE__) . "/../../cabecera.php");

class Proyecto
{

    public const TIPOPROYECTO =  [10 => "Solo Software", 20 => "Solo Hardware", 30 => "Software/Hardware"];

    protected string $_nombre;
    protected string $_empresa;
    protected string|DateTime $_fecha_inicio;
    protected string|DateTime $_fecha_fin;
    protected int $_duracion;
    protected int $_tipo;
    protected string $_tipo_descripcion;

    // Nueva propiedad privada
    private Otras $_otras;

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
     * SOLO le llegan campos no calculados
     */
    public function __construct(
        string $_nombre,
        string $_empresa,
        int $_tipo = 10,
        ?DateTime $fecha_inicio = null,
        ?DateTime $fecha_fin = null
    ) {
        // Validar nombre y muestra el código correspondiente 
        if ($this->setNombre($_nombre) < 0) throw new Exception("Error en nombre");

        // Validar la empresa 
        if ($this->setEmpresa($_empresa) < 0) throw new Exception("Error en empresa");

        // Fecha inicio (por defecto hoy si no se pasa)
        if ($fecha_inicio === null) {
            $fecha_inicio = new DateTime("now");
        }
        $this->setFechaInicio($fecha_inicio);

        // Fecha fin (por defecto +6 meses si no se pasa)
        if ($fecha_fin === null) {
            $fecha_fin = (clone $this->_fecha_inicio)->modify("+6 months");
        }
        $this->setFechaFin($fecha_fin);

        // Tipo (por defecto 10 si no válido)
        $this->setTipo($_tipo);

        // Duración calculada
        $this->_duracion = $this->_fecha_fin->diff($this->_fecha_inicio)->days;



        // Inicializar objeto Otras
        $this->_otras = new Otras();
    }

    /**
     * SETTERS CON VALIDACIÓN Y RESTRICCIONES (ENUNCIADO)
     */
    /**
     * Setter para validar la cadena Nombre
     *
     * @param string $_nombre
     * @return integer 0 Todo correcto
     *                -1 Nada correcto
     *                -2 Longitud no Correcta
     */
    public function setNombre(string $_nombre): int
    {
        if (empty($_nombre)) return -1;                     // obligatorio
        if (!validaCadena($_nombre, 40, "")) return -2;      // longitud máxima
        $this->_nombre = $_nombre;
        return 0;
    }

    /**
     * Setter para validar la cadena Empresa
     *
     * @param string $_empresa
     * @return integer 0 Todo correcto
     *                -1 Nada correcto
     *                -2 Longitud no Correcta
     */
    public function setEmpresa(string $_empresa): int
    {
        if (empty($_empresa)) return -1;                    // obligatorio
        if (!validaCadena($_empresa, 35, "")) return -2;     // longitud máxima
        $this->_empresa = $_empresa;
        return 0;
    }

    /**
     * Setter para validar que la fecha sea correcta
     *
     * @param DateTime $fecha
     * @return integer 0 Corecta 
     *                -1 No válida
     */
    public function setFechaInicio(string|DateTime $fecha): int
    {
        $hoy = new DateTime("now");
        if ($fecha > $hoy) {
            $this->_fecha_inicio = $hoy; // valor por defecto
            return -1;                   // restricción incumplida
        }
        $this->_fecha_inicio = $fecha;
        return 0;
    }

    /**
     * Setter para validar que la fecha_fin sea correcta
     *
     * @param DateTime $fecha 
     * @return integer 0 Corecta 
     *                -1 No válida
     */
    public function setFechaFin(DateTime $fecha): int
    {
        $porDefecto = (clone $this->_fecha_inicio)->modify("+6 months");
        if ($fecha < $this->_fecha_inicio) {
            $this->_fecha_fin = $porDefecto; // valor por defecto
            $this->_duracion = $this->_fecha_fin->diff($this->_fecha_inicio)->days;
            return -1;                       // restricción incumplida
        }
        $this->_fecha_fin = $fecha;
        $this->_duracion = $this->_fecha_fin->diff($this->_fecha_inicio)->days;
        return 0;
    }

    /**
     * Setter que valida que el tipo sea correcto a partir de campos calculados
     *
     * @param integer $tipo
     * @return integer 0 Tipo Correcto
     *                -1 Tipo no válido
     */
    public function setTipo(int $tipo): int
    {
        if (!isset(self::TIPOPROYECTO[$tipo])) {
            $this->_tipo = 10; // valor por defecto
            $this->_tipo_descripcion = self::TIPOPROYECTO[10];
            return -1;         // tipo no válido
        }
        $this->_tipo = $tipo;
        $this->_tipo_descripcion = self::TIPOPROYECTO[$tipo];
        return 0;
    }

    /** GETTERS */
    public function getNombre(): string
    {
        return $this->_nombre;
    }
    public function getEmpresa(): string
    {
        return $this->_empresa;
    }
    public function getFechaInicio(): DateTime
    {
        return $this->_fecha_inicio;
    }
    public function getFechaFin(): DateTime
    {
        return $this->_fecha_fin;
    }
    public function getDuracion(): int
    {
        return $this->_duracion;
    }
    public function getTipo(): int
    {
        return $this->_tipo;
    }
    public function getTipoDescripcion(): string
    {
        return $this->_tipo_descripcion;
    }


    /**
     * Método aniadeOtras
     * Permite añadir propiedades dinámicas al objeto Libros
     */
    public function aniadeOtras(string $propiedad, mixed $valor, ...$mas): int
    {
        $n_prop = 0;
        $this->_otras->$propiedad = $valor;
        $n_prop++;
        for ($i = 0; $i < count($mas); $i += 2) {
            $prop = $mas[$i];
            $val = $mas[$i + 1] ?? null;
            $this->_otras->$prop = $val;
            $n_prop++;
        }
        return $n_prop;
    }

    /**
     * Devuelve descripción de todas las propiedades en Otras
     */
    public function getDescripcionOtras(): string
    {
        $desc = "";
        foreach ($this->_otras as $clave => $valor) {
            $desc .= "$clave: $valor\n";
        }
        return $desc;
    }


    /**
     * Método ToString
     *
     * @return string
     */
    public function __toString(): string
    {
        return "Proyecto {$this->_nombre} para {$this->_empresa} " .
            "que durará {$this->_duracion} días entre " .
            $this->_fecha_inicio->format("d/m/Y") . " y " .
            $this->_fecha_fin->format("d/m/Y") . " de tipo {$this->_tipo_descripcion}";
    }
}
