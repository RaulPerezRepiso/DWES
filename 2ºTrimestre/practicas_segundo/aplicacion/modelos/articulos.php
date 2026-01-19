<?php
class articulos extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "arti";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_articulo",
            "descripcion",
            "nombre",
            "cod_fabricante",
            "unidades",
            "fabricante_nombre",
            "fecha_alta"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "nombre" => "Un nombre bueno",
            "fecha_alta" => "Fecha de alta",
            "cod_fabricante" => "Fabricante",
            "nombre_fabricante" => "Fabricante"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(

                //Estos son las restricciones que le podemos asiganar a los datos que entran por teclado
                array(
                    "ATRI" => "cod_articulo,nombre,descripcion",
                    "TIPO" => "REQUERIDO",
                    "MIN" => 0,
                    "MENSAJE" => "Las unidades deber ser mayores de 0",
                    "DEFECTO" => 10
                ),
                array(
                    "ATRI" => "cod_articulo",
                    "TIPO" => "ENTERO",
                    "MIN" => 0,
                    "MENSAJE" => "Las unidades deber ser mayores de 0",
                    "DEFECTO" => 10
                ),
                array(
                    "ATRI" => "nombre",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "comprobarNombre"
                ),
                array(
                    "ATRI" => "descripcion",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 60
                ),
                // array(
                //     "ATRI" => "cod_fabricante",
                //     "TIPO" => "ENTERO",
                //     "MIN" => 0
                // ),
                // array("ATRI" => "fecha_alta", "TIPO" => "FECHA"),
                // array(
                //     "ATRI" => "fecha_alta",
                //     "TIPO" => "FUNCION",
                //     "FUNCION" => "validaFechaAlta"
                // ),
            );
    }

    protected function afterCreate():void
    {
        $this->cod_articulo = 0;
        $this->nombre = "";
        $this->descripcion = "Hola k ase";
        $this->cod_fabricante = 1;
    }

    protected function comprobarNombre()
    {

        if ($this->nombre == "Vicente") {
            $this->setError("nombre", "El nombre no puede ser ese");
        }
    }
}
