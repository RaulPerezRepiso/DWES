<?php

class ClaseMisPropiedades implements Iterator
{

    //Definición de propiedades
    private array $_propiedades;
    public mixed $_propPublica;
    private mixed $_propPrivado = 25;

    //Getter's & Setter's
    public function __set($nombre, $valor)
    {
        if ($nombre === '_propPrivada') {
            echo "No puedes modificar _propPrivada dinámicamente<br>";
            return;
        }
        $this->_propiedades[$nombre] = $valor;
    }

    public function __get($nombre)
    {
        if (array_key_exists($nombre, $this->_propiedades)) {
            return $this->_propiedades[$nombre];
        }
        echo "La propiedad '$nombre' no existe<br>";
        return null;
    }

    public function __construct()
    {
        $this->_propPublica = null; // o cualquier valor por defecto
        $this->_propiedades = [];   // también recomendable inicializar este array
        $this->_cont = 0;           // inicializar el contador del Iterator
    }

    /*
    * //Métodos de la clase Iterator
    *
    * rewind(): inicia el bucle
    * valid(): comprueba si el elemento existe, si no se termina
    * key(): saca el valor en el key del foreach
    * current(): saca el valor en el value del foreach
    * next(): avanza en el bucle.
    */

    // Propiedad para que funcione el iterable
    private int $_cont;

    /**
     * Método privado que devuelve un array combinado con propiades que añade el usuario más las declaradas en pública o privada
     *
     * @return array
     */
    private function getTodo(): array
    {
        return array_merge(
            $this->_propiedades,
            [
                '_propPublica' => $this->_propPublica,
                '_propPrivado' => $this->_propPrivado
            ]
        );
    }

    public function current(): mixed
    {
        $valores = $this->getTodo();
        return array_values($valores)[$this->_cont];
    }

    public function next(): void
    {
        $this->_cont++;
    }

    public function key(): mixed
    {
        $clave = array_keys($this->getTodo());
        return "oi_" . $clave[$this->_cont];
    }

    public function valid(): bool
    {
        return $this->_cont < count($this->getTodo());
    }

    public function rewind(): void
    {
        $this->_cont = 0;
    }
}
