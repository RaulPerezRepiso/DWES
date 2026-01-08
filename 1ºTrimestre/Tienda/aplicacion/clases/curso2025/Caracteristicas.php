<?php
class Caracteristicas implements Iterator
{
    // Array que almacena las características del objeto
    private array $caracteristicas = [];

    // Posición actual del iterador
    private int $posicion = 0;

    /**
     * Constructor que inicializa las características del objeto
     *
     * @param array $array Las devuelve en un array
     */
    public function __construct(array $array = [])
    {
        // Lista de claves obligatorias que deben estar presentes
        $clavesObl = ["ancho", "alto", "largo"];

        // Se asegura de que cada clave obligatoria esté en el array y sea un entero
        foreach ($clavesObl as $clave) {
            if (!array_key_exists($clave, $array) || !is_int($array[$clave])) {
                $array[$clave] = 100; // Valor por defecto si no está o no es entero
            }
        }

        // Si se incluye la clave 'ningunamas', se eliminan todas las claves no permitidas
        if (array_key_exists("ningunamas", $array)) {
            foreach ($array as $clave => $valor) {
                if (!in_array($clave, ["ancho", "alto", "largo", "ningunamas"])) {
                    unset($array[$clave]); // Se elimina la clave no permitida
                }
            }
        }

        // Se asigna el array final a la propiedad interna
        $this->caracteristicas = $array;
    }

    public function getCaracteristicas($clave)
    {
        return $this->caracteristicas[$clave] ?? null;
    }

    /**
     * Establece el valor de una característica
     *
     * @param [type] $clave
     * @param [type] $valor
     * @return void
     */
    public function setCaracteristicas($clave, $valor): void
    {
        // Si existe 'ningunamas', no se permite añadir nuevas claves no autorizadas
        if (
            array_key_exists("ningunamas", $this->caracteristicas) &&
            !in_array($clave, ["ancho", "alto", "largo", "ningunamas"])
        ) {
            return; // No se hace nada si la clave no está permitida
        }

        // Si la clave es obligatoria y el valor no es entero, se fuerza a 100
        if (in_array($clave, ["ancho", "alto", "largo"]) && !is_int($valor)) {
            $valor = 100;
        }

        // Se asigna el valor a la clave correspondiente
        $this->caracteristicas[$clave] = $valor;
    }

    /**
     * Reinicia el iterador al principio del array
     *
     * @return void
     */
    public function rewind(): void
    {
        $this->posicion = 0;
    }

    /**
     * Devuelve el valor actual del iterador
     *
     * @return mixed
     */
    public function current(): mixed
    {
        return array_values($this->caracteristicas)[$this->posicion];
    }

    /**
     * Avanza a la siguiente posición del iterador
     *
     * @return void
     */
    public function next(): void
    {
        $this->posicion++;
    }

    /**
     * Devuelve la clave actual del iterador
     *
     * @return mixed
     */
    public function key(): mixed
    {
        return array_keys($this->caracteristicas)[$this->posicion];
    }

    /**
     * Verifica si la posición actual es válida
     *
     * @return boolean
     */
    public function valid(): bool
    {
        return $this->posicion < count($this->caracteristicas);
    }

    /**
     *  Permite asignar dinámicamente una característica como si fuera una propiedad del objeto
     *
     * @param [type] $clave
     * @param [type] $valor
     */
    public function __set($clave, $valor)
    {
        $this->setCaracteristicas($clave, $valor);
    }

    /**
     * Permite acceder dinámicamente a una característica como si fuera una propiedad del objeto
     *
     * @param [type] $clave
     * @return void
     */
    public function __get($clave)
    {
        return $this->getCaracteristicas($clave);
    }
}
