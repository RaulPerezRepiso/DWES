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
                "MENSAJE" => "Nick y contraseña son campos obligarios"
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

        
        $ACL = Sistema::app()->ACL();

        if (!$ACL->esValido($this->nick, $this->contrasenia)) {
            $this->setError("contrasenia", "Usuario o contraseña incorrectos");
        }
    }

    public function autenticar()
    {
        $datos["cod"] = Sistema::app()->ACL()->getCodUsuario($this->nick);
        $datos["usuario"] = $this->nick;
        $datos["nombre"] = Sistema::app()->ACL()->getNombre(Sistema::app()->ACL()->getCodUsuario($this->nick));
        $datos["contrasenia"] = $this->contrasenia;
        $permisos = Sistema::app()->acl()->getPermisos($datos["cod"]);

        if ($permisos === false) {
            $permisos = [];
        }

        $datos["permisos"] = $permisos;
        Sistema::app()->acceso()->registrarUsuario($datos["usuario"], $datos["nombre"], $datos["permisos"]);

        Sistema::app()->irAPagina("/index.php");
    }
}
