<?php
class Caracteristicas implements Iterator
{

    private array $caracteristicas = [];
    private int $posicion = 0;

    public function __construct(...$args)
    {
        return $this->setCaracteristicas($args);
    }

    public function getCaracterisitcas(){
        return $this->caracteristicas;
    }

    public function setCaracteristicas(array $array): void
    {
        // Array con las claves que debe de tener el array
        $clavesObl = ["ancho", "alto", "largo"];

        // si en el array que nos dan no tiene las claves ancho alto o largo se inicializan a 100
        foreach ($clavesObl as $clave) {
            if (!array_key_exists($clave, $array)) $array[$clave] = 100;
            else if (!is_int($array[$clave])) $array[$clave] = 100;
        }
        // si existe la clave ningunamas no puede tener mas aparte de las obligatorias
        if (array_key_exists("ningunamas", $array)) {
            foreach ($array as $clave => $valor) {
                if ($clave != "ancho" && $clave != "alto" && $clave != "largo" && $clave != "ningunamas") unset($array[$clave]);
            }
        }

        $this->caracteristicas = $array;
    }



    // Para qeu veuelva a empezar en 0
    /**
     * Rewind
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->posicion = 0;
    }

    // Devuevle los valors de caracteristicas para esa posicion
    /**
     * Current
     *
     * @return mixed
     */
    public function current(): mixed
    {
        return array_values($this->caracteristicas)[$this->posicion];
    }

    // Avanza a la siguiente posición de las caracteristicas
    /**
     * Next
     *
     * @return void
     */
    public function next(): void
    {
        $this->posicion++;
    }

    // Devuelve la clave actual en la que se encuntra el iterator
    /**
     * Key
     *
     * @return mixed
     */
    public function key(): mixed
    {
        return array_keys($this->caracteristicas)[$this->posicion];
    }

    // Valida que la posciion sea correcto por lo tanto la clave tiene que ser menor o igual al limiiet
    /**
     * Valid
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return $this->posicion <= count($this->caracteristicas);
    }
}
