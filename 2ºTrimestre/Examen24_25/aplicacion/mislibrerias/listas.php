<?php

class listas
{
    public static function listaTiposBarajas(bool $completo = false, ?int $cod_baraja = null)
    {
        $tipos = [
            5 => ["nombre" => "española normal", "min_juga" => 2, "max_juga" => 4],
            6 => ["nombre" => "pocker", "min_juga" => 4, "max_juga" => 4],
            7 => ["nombre" => "figuras", "min_juga" => 4, "max_juga" => 8],
            8 => ["nombre" => "invent", "min_juga" => 3, "max_juga" => 7],
        ];

        //Comprobamos si hay código
        if ($cod_baraja !== null) {

            //Sino hay devolevmos false
            if (!isset($tipos[$cod_baraja])) {
                return false;
            }

            // Si existe y se pide el completo se devuelven toods los datos 
            if ($completo) {
                return $tipos[$cod_baraja];
            }
            // NO se pide completo se devuelve solo el nombre 
            return $tipos[$cod_baraja]["nombre"];
        }

        // Al no pedir el código devolvemos lista completa
        $resultado = [];
        foreach ($tipos as $codigo => $datos) {
            if ($completo) {
                // Todos los datos
                $resultado[$codigo] = $datos;
            } else {
                // Solo el nombre 
                $resultado[$codigo] = $datos["nombre"];
            }
        }
        return $resultado;
    }
}
