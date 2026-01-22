<?php
class productos extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "prod";
    }

    protected function fijarTabla(): string
    {
        return "cons_productos";
    }

    protected function fijarId(): string
    {
        return "cod_producto";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_producto",
            "nombre",
            "fabricante",
            "fecha_alta",
            "unidades",
            "precio_venta",
            "foto",
            "borrado",
            "categoria"
        );
    }

    protected function fijarDescripciones(): array
    {
        return array(
            "cod_producto" => "Código",
            "nombre" => "Nombre",
            "fabricante" => "Fabricante"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(

                //Estos son las restricciones que le podemos asiganar a los datos que entran por teclado
                array(
                    "ATRI" => "cod_producto,nombre,fabricante",
                    "TIPO" => "REQUERIDO",
                    "MIN" => 0,
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

    protected function afterCreate(): void
    {
        $this->cod_producto = 0;
        $this->nombre = "";
        $this->fabricante = "El fabricante Pepe";
    }

    protected function comprobarNombre()
    {

        // if ($this->nombre == "Vicente") {
        //     $this->setError("nombre", "El nombre no puede ser ese");
        // }
    }
}
