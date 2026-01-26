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
            "cod_categoria",
            "fabricante",
            "fecha_alta",
            "unidades",
            "precio_base",
            "iva",
            "precio_iva",
            "precio_venta",
            "foto",
            "borrado",
            "nombre_categoria"
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
                "MIN" => 0,
                "MENSAJE" => "El nuermo tiene que ser Real y mayor de 0"
            ),
            array(
                "ATRI" => "iva",
                // Validación con RANGO
                "TIPO" => "RANGO",
                "RANGO" => [4, 10, 21],
                "DEFECTO" => 21,
                "MENSAJE" => "Valor de IVA no válido"


            ),
            array(
                "ATRI" => "precio_iva",
                "TIPO" => "REAL"
            ),
            array(
                "ATRI" => "precio_venta",
                "TIPO" => "REAL"
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
        $base = floatval($this->precio_base);
        $iva = floatval($this->iva);

        $this->precio_iva = $base * $iva / 100;
        $this->precio_venta = $base + $this->precio_iva;
    }

}
