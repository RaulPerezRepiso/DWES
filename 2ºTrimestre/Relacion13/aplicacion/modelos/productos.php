<?php

class productos extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "productos";
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

    protected function fijarRestricciones(): array
    {
        return array(
            array(
                "ATRI" => "cod_producto, nombre, cod_categoria",
                "TIPO" => "REQUERIDO",
                "MENSJAE" => "Este campo es obligatorio"
            ),
            array(
                "ATRI" => "cod_producto",
                "TIPO" => "ENTERO",
                "MENSAJE" => "Este campo debe de ser entero"
            ),
            array(
                "ATRI" => "nombre",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "MENSAJE" => "Tiene que ser cadena y longitud máxima 30 caracteres"
            ),
            array(
                "ATRI" => "cod_categoria",
                "TIPO" => "ENTERO",
                "MENSAJE" => "El campo tiene que ser entero"
            ),
            array(
                "ATRI" => "fabricante",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "DEFECTO" => "",
                "MENSAJE" => "Tiene que ser una cadena de máximo 30 caracteres"
            ),
            array(
                "ATRI" => "fecha_alta",
                "TIPO" => "FECHA",
                "DEFECTO" => date("Y-m-d")
            ),
            array(
                "ATRI" => "unidades",
                "TIPO" => "ENTERO",
                "DEFECTO" => 0,
                "MENSAJE" => "Tiene que ser entero"
            ),
            array(
                "ATRI" => "precio_base",
                "TIPO" => "FUNCION",
                "DEFECTO" => 0,
                "FUNCINO" => "validaReal",
                "MENSAJE" => "El nuermo tiene que ser Real y mayor de 0"
            ),
            array(
                "ATRI" => "iva",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaIva",
                "DEFECTO" => 21,
                "MENSAJE" => "Valor de IVA no válido"
            ),
            array(
                "ATRI" => "foto",
                "TIPO" => "CADENA",
                "TAMANIO" => 40,
                "DEFECTO" => "base.png"
            ),
            array(
                "ATRI" => "borrado",
                "TIPO" => "BOOLEANO",
                "MIN" => 0,
                "MAX" => 1,
                "MENSAJE" => "Tiene que ser un Boolanos valores entre 0 y 1"
            )

        );
    }

    protected function afterCreate(): void
    {
        $this->precio_iva = $this->precio_base * $this->iva / 100;
        $this->precio_venta = $this->precio_base + $this->precio_iva;
    }


    //Método para validar que el numero sea real y mayor de 0
    protected function  validaReal(): bool
    {

        if ($this->precio_base < 0) {
            $this->setError("precio_base", "El número tiene que ser negativo");
            return false;
        }

        return true;
    }

    //Método que válida que el IVA sea valido
    protected function validaIva(): bool
    {
        if ($this->iva != 4 && $this->iva != 10 && $this->iva != 21) {
            $this->setError("iva", "Valor de iva no válido");
            return false;
        }
        return true;
    }
}
