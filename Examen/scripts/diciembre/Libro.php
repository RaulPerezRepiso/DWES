<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

class Libro implements Iterator
{
    private string $_nombre;
    private string $_autor;

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

        // $this->$_mas = $_mas;

        $this->resetKeys();
    }

    /**
     * Método mágico SET
     * Guarda propiedades en mayúsculas
     */
    public function __set(string $nombre, mixed $valor): void
    {
        $clave = strtolower($nombre);

        if (strlen($clave) > 1) {
            strtolower(substr($clave, 1, -1)) .
                strtoupper(substr($clave, -1));
        } else {
            strtoupper($clave);
        }

        $this->_otras[$clave] = $valor;
        $this->resetKeys();
    }

    /**
     * Método mágico GET
     */
    public function __get(string $nombre): mixed
    {
        $clave = strtolower($nombre);
        if (isset($this->_otras[$clave]))
            return $this->_otras[$clave];
        else
            //si no existe lanza una excepción
            throw new Exception('No existe la propiedad.');
    }

    /**
     * Método mágico ISSET
     */
    public function __isset(string $nombre): bool
    {
        $clave = strtolower($nombre);
        return (isset($this->_otras[$clave]));
    }

    /**
     * Método mágico UNSET
     */
    public function __unset(string $nombre): void
    {
        $clave = strtolower($nombre);
        unset($this->_otras[$clave]);
    }


    /**
     * Iterador: preparar claves
     */
    private function resetKeys(): void
    {
        $this->_keys = array_keys($this->_otras);
        $this->_position = 0;
    }

    // ITERATOR
    /**
     * Vuelve a la posición inicial
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->_position = 0;
    }

    /**
     * Valida que la clave este en una posicion
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return isset($this->_keys[$this->_position]);
    }

    /**
     * Devuelve la posicion de la clave actual
     *
     * @return mixed
     */
    public function current(): mixed
    {
        $clave = $this->_keys[$this->_position];
        return $this->_otras[$clave];
    }

    /**
     * Muestra la clave en minúscula
     *
     * @return mixed
     */
    public function key(): mixed
    {
        $clave = $this->_keys[$this->_position];
        return strtolower($clave);
    }

    /**
     * Avanza de posición
     *
     * @return void
     */
    public function next(): void
    {
        ++$this->_position;
    }
}
