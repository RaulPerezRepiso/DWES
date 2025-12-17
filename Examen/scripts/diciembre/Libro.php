<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

class Libro implements Iterator
{
    // Propiedades privadas 
    private string $_nombre = "";
    private string $_autor = "";

    // Array asociativo con las propiedades dinámicas
    private array $_otras = [];

    // Puntero para iteración
    private int $_position = 0;
    private array $_keys = [];

    /**
     * CONSTRUCTOR
     * Inicializa el KEYS vacío
     */
    public function __construct(string $_nombre, string $_autor, ...$_mas)
    {
        $this->$_nombre = $_nombre;
        $this->$_autor = $_autor;
        // El primer elemento es el nombre, el último es el autor.
        $this->keys = ['nombre'];

        // Procesar las propiedades dinámicas
        for ($i = 0; $i < count($_mas); $i += 2) {
            $nombre_prop = $_mas[$i] ?? null;
            $valor_prop = $_mas[$i + 1] ?? null;

            // 1. Comprobar que el nombre_propiedad es de tipo cadena
            if (is_string($nombre_prop)) {
                // 2. Almacenar internamente en minúscula con el último carácter en mayúscula
                $nombre_almacenado = substr($nombre_prop, 0, -1) . strtoupper(substr($nombre_prop, -1));

                // Si no hay valor, se asigna null
                $this->_otras[$nombre_almacenado] = $valor_prop;

                // Añadir la clave dinámica a la lista de claves a iterar
                $this->keys[] = strtolower($nombre_prop);
            }
            // Si no es string, se ignora ese par, y la iteración avanza $i += 2
        }

        // El autor es el último en la iteración.
        $this->keys[] = "autor";
    }


    /**
     * Método mágico __set()
     * Permite definir nuevas propiedades dinámicas o modificar existentes usando ->.
     *
     * @param string $name Nombre de la propiedad a establecer.
     * @param mixed $value Valor a asignar.
     */
    public function __set(string $name, mixed $value)
    {
        $name = mb_strtolower($name);
        $ulitmo = mb_strtoupper(mb_substr($name, -1));

        $name = mb_substr($name, 0, mb_strlen($name) - 1) . $ulitmo;

        $nombre = mb_strtolower($name);
        if ($nombre === 'nombre') {
            $this->_nombre = $value;
            return;
        }
        if ($nombre === 'autor') {
            $this->_autor = $value;
            return;
        }

        $this->_otras[$name] = $value;
    }

    /**
     * Método mágico __get()
     * Permite acceder a propiedades privadas y dinámicas usando ->.
     *
     * @param string $name Nombre de la propiedad a obtener (ej: anIo, NoMbRe, Autor).
     * @return mixed El valor de la propiedad, o null si no existe.
     */
    public function __get($name)
    {
        $nombre = strtolower($name);

        if ($nombre === 'nombre') {
            return $this->_nombre;
        } elseif ($nombre === 'autor') {
            return $this->_autor;
        }

        $nombre_almacenado = substr($nombre, 0, -1) . strtoupper(substr($nombre, -1));

        if (array_key_exists($nombre_almacenado, $this->_otras)) {
            return $this->_otras[$nombre_almacenado];
        }

        return null;
    }

    public function convertirNombre(string $nombre): String
    {
        $name = mb_strtolower($nombre);
        $ulitmo = mb_strtoupper(mb_substr($name, -1));

        $name = mb_substr($name, 0, mb_strlen($name) - 1) . $ulitmo;

        return $name;
    }
    
    // --- Implementación de la Interfaz Iterator ---
    /**
     * Retorna el valor del elemento actual.
     * @return mixed
     */
    public function current(): mixed
    {
        $current_key = $this->_keys[$this->_position];
        // Usamos __get para obtener el valor correctamente
        return $this->__get($current_key);
    }

    /**
     * Retorna la clave del elemento actual (en minúscula).
     * @return scalar
     */
    public function key(): mixed
    {
        // La clave debe devolverse toda en minúscula
        return $this->_keys[$this->_position];
    }

    /**
     * Mueve el puntero a la siguiente propiedad.
     */
    public function next(): void
    {
        $this->_position++;
    }

    /**
     * Devuelve el puntero al inicio de la iteración.
     */
    public function rewind(): void
    {
        $this->_position = 0;
    }

    /**
     * Comprueba si la posición actual es válida.
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->keys[$this->_position]);
    }
}
