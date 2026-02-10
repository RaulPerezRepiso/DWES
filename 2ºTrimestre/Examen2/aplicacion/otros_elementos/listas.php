<?php

class listas
{

    /**
     * Listas de los objetos
     *
     * @param integer|null $cod_tipo
     * @param boolean $soloCodigo
     */
    public static function listaTiposElemento(?int $cod_tipo = null, bool $soloCodigo = false)
    {

        $tipos = [
            1 => "Monumento",
            2 => "Gastronomico",
            3 => "Sitio de interés",
            4 => "Costumbre"
        ];


        if ($soloCodigo === true) {
            return $tipos[$soloCodigo];
        } else

            $resultado = [];
        foreach ($tipos as $codigo => $datos) {
            //Comprobamos si hay código
            if ($cod_tipo !== null) {
                $resultado[$codigo] = $datos;
            } else {
                if (isset($tipos[$soloCodigo])) {
                    return true;
                } else
                    return false;
            }
        }
        return $resultado;
    }
}
