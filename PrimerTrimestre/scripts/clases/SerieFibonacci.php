<?php
class SerieFibonacci implements Iterator
{

    //Propiedades para la funcion de fibonacci
    private int $_limite;
    private int $_claveActual;

    //Constructor
    public function __construct(int $limite)
    {
        $this->_limite = $limite;
        $this->_claveActual = 0;
    }

    /*
    * rewind(): inicia el bucle
    * valid(): comprueba si el elemento existe, si no se termina
    * key(): saca el valor en el key del foreach
    * current(): saca el valor en el value del foreach
    * next(): avanza en el bucle.
    */

    // Empieza en 0 porque la serie de finbonaci comienza con 0 
    public function rewind(): void
    {
        $this->_claveActual = 0;
    }

    // Calcula los valores de fibonacci en la funcion actual
    public function current(): mixed
    {
        switch ($this->_claveActual) {
            case 0:
                return 0;
            case 1:
                return 1;
            default:
                $a = 0;
                $b = 1;
                for ($i = 2; $i <= $this->_claveActual; $i++) {
                    $temp = $a + $b;
                    $a = $b;
                    $b = $temp;
                }
                return $b;
        }
    }

    // Avanza al siguiente indice de la serie
    public function next(): void {
        $this->_claveActual++;
    }

    // Devuelve la clave actual en la que se encuntra el iterator
    public function key(): mixed
    {
        return $this->_claveActual;
    }

    // Valida que la posciion sea correcto por lo tanto la clave tiene que ser menor o igual al limiiet
    public function valid(): bool
    {
        return $this->_claveActual <= $this->_limite;
    }

    //Funcino fFibonacci
    public static function fFibonacci($ultimo): Generator
    {
        $a = 0;
        $b = 1;

        for($i = 0; $i <= $ultimo; $i++){
            yield $a;
            $temp = $a +$b;
            $a = $b;
            $b = $temp;
        }

    }
}
