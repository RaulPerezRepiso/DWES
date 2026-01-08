<?php
interface IFabricable
{

    /**
     * metodoFabricación
     *
     * @return Devuelve los pasos para fabricar el elemento
     */
    public function metodoFabricacion(): string;

    /**
     * metodoRecicaldo
     *
     * @return Devuelve el método de reciclado que se debe aplicar al elemento según su fabricación.
     * 
     */
    public function metodoRecicaldo(): string;


}
