<?php
class InstrumentoBase
{

    //Apartado UNO
    //Declaramos los atributos
    private String $descripcion;

    //Llamadas a get o set
    public function getCadena(): string
    {
        return $this->descripcion;
    }
    public function setCadena(string $valor): void
    {
        $this->descripcion = $valor;
    }

    //Apartado DOS
    protected int $edad = 10;

    public function getEdad(): int
    {
        return $this->edad;
    }

    //Definción de 2 métodos abstractos
    /* abstract public function sonido(): string;
    abstract public function afinar(): array; */


    //Métodos no abstractos aún para su uso
    public function sonido(): string
    {
        return "Sonido genérico";
    }

    public function afinar(): array
    {
        return ["Paso 1", "Paso 2"];
    }

    //Método envejecer
    public function envejecer(): int
    {
        return ++$this->edad;
    }

    //Variable de clase protegida
    protected int $cont = 0;


}
