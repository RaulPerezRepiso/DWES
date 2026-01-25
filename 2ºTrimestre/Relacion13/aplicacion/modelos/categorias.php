<?php

class categorias extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "categorias";
    }

    protected function fijarTabla(): string
    {
        return "categorias";
    }

    protected function fijarId(): string
    {
        return "cod_categoria";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_categoria",
            "descripcion"
        );
    }

    protected function fijarRestricciones(): array
    {
        return array(
            array(
                "ATRI" => "cod_categoria, descripcion",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "Este campo es obligario"
            ),
            array(
                "ATRI" => "cod_categoria",
                "TIPO" => ">ENTERO",
                "MENSAJE" => "Tiene que ser entero"
            ),
            array(
                "ATRI" => "descripcion",
                "TIPO" => "CADENA",
                "TAMANIO" => 40,
                "MENSAJE" => "No puede tener más de 40 caracteres"
            )
        );
    }

    //Función que asigna la categoria con el rango codigo a partir de la base de datos
    public static function dameCategorias($cod_categoria = null)
    {
        // Acceso a la BD
        $bd = Sistema::app()->BD();

        // Si no se pasa código >> devolver todas
        if ($cod_categoria === null) {

            $sql = "SELECT cod_categoria, descripcion 
                FROM categorias 
                ORDER BY descripcion";

            $filas = $bd->crearConsulta($sql)->filas();

            $categorias = [];
            foreach ($filas as $fila) {
                $categorias[$fila["cod_categoria"]] = $fila["descripcion"];
            }

            return $categorias;
        }

        // Si se pasa código >> devolver solo esa categoría
        // Aquí usamos directamente el valor en la consulta
        $sql = "SELECT descripcion 
            FROM categorias 
            WHERE cod_categoria = $cod_categoria";

        // Aquí NO se pasamos parámetros porque no hay marcadores
        $fila = $bd->crearConsulta($sql)->fila();

        return $fila ? $fila["descripcion"] : false;
    }
}
