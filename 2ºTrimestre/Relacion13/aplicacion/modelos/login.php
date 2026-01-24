<?php

class login extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "login";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nick",
            "contrasenia"
        );
    }

    protected function fijarRestricciones(): array
    {
        return array(
            array(
                "ATRI" => "nick, contrasenia",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "Nick y contrasenia con campos obligarios"
            ),
            array(
                "ATRI" => "nick",
                "TIPO" => "STRING",
                "MENSAJE" => "El nick tiene que ser una cadena",
                "TAMANIO" => 20
            ),
            array(
                "ATRI" => "contrasenia",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarPass",
                "TAMANIO" => 20
            )
        );
    }

    //Función para validar que la contrasenia sea c-nick
    protected function validarPass()
    {

        $valida = "c-" . $this->nick;

        if ($this->contrasenia != $valida) {
            $this->setError("contrasenia", "La contraseña debe ser c-" . $this->nick);
            return false;
        }
        return true;
    }
}
