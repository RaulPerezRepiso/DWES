<?php
class SerieFibonacci implements Iterator
{


    /*
    * rewind(): inicia el bucle
    * valid(): comprueba si el elemento existe, si no se termina
    * key(): saca el valor en el key del foreach
    * current(): saca el valor en el value del foreach
    * next(): avanza en el bucle.
    */
    public function rewind(): void {}
    public function current(): mixed
    {
        return "";
    }
    public function next(): void {}
    public function key(): mixed
    {
        return "";
    }
    public function valid(): bool
    {
        return true;
    }

    
}
