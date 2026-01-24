<?php
class datosRegistro extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "datosRegistro";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nick",
            "nif",
            "fecha_nacimiento",
            "provincia",
            "estado",
            "contrasenia",
            "confirmar_contrasenia"
        );
    }

    protected function fijarRestricciones(): array
    {
        return
            array(

                //Estos son las restricciones que le podemos asiganar a los datos que entran por teclado
                array(
                    "ATRI" => "nick,nif",
                    "TIPO" => "REQUERIDO",
                    "MENSAJE" => "Estos campos son obligatorios",
                ),
                array(
                    "ATRI" => "nick",
                    "TIPO" => "CADENA",
                    "TAMANIO" => 40,
                    "MENSAJE" => "Este campo deber ser tipo String y Tamaño 40",
                ),
                array(
                    "ATRI" => "nif",
                    "TIPO" => "CADENA",
                    "MENSAJE" => "Este campo tiene que ser tipo Cadena"
                ),
                array(
                    "ATRI" => "fecha_nacimiento",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validaFecha",
                    "DEFECTO" => date(
                        "d/m/Y",
                        strtotime("-18 years")
                    )
                ),
                array(
                    "ATRI" => "provincia",
                    "TIPO" => "CADENA",
                    "MENSAJE" => "Este campo tiene que ser tipo Cadena y Tamaño 30",
                    "DEFECTO" => "MALAGA",
                    "TAMANIO" => 30
                ),
                array(
                    "ATRI" => "estado",
                    "TIPO" => "ENTERO",
                    "MIN" => 0,
                    "MAX" => 4,
                    "DEFECTO" => 0
                ),
                array(
                    "ATRI" => "contrasenia",
                    "TIPO" => "FUNCION",
                    "FUNCION" => "validarContrasenia"
                ),
                array(
                    "ATRI" => "contrasenia,confirmar_contrasenia",
                    "TIPO" => "REQUERIDO",
                    "MENSAJE" => "Las contraseñas son obligatorias"
                ),
            );
    }


    // Valida que la fehca sea valida entre el 1/1/1900 y menos que fecha actual
    public function validaFecha(): bool
    {
        // Si el campo viene vacío, no podemos validar nada
        if (empty($this->fecha_nacimiento)) {
            $this->setError("fecha_nacimiento", "La fecha es obligatoria");
            return false;
        }

        // Si viene en formato HTML5 (YYYY-MM-DD), convertirlo a dd/mm/YYYY
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->fecha_nacimiento)) {
            $this->fecha_nacimiento = date("d/m/Y", strtotime($this->fecha_nacimiento));
        }

        // Intentar crear la fecha con el formato esperado
        $fecha = DateTime::createFromFormat('d/m/Y', $this->fecha_nacimiento);

        // Si no es válida, error
        if ($fecha === false) {
            $this->setError("fecha_nacimiento", "La fecha no tiene un formato válido (dd/mm/yyyy)");
            return false;
        }

        // Fecha mínima permitida
        $fechaMin = DateTime::createFromFormat('d/m/Y', '01/01/1900');

        // Fecha máxima (hoy)
        $fechaHoy = new DateTime();

        // Validar rango
        if ($fecha < $fechaMin) {
            $this->setError("fecha_nacimiento", "La fecha no puede ser anterior a 01/01/1900");
            return false;
        }

        if ($fecha > $fechaHoy) {
            $this->setError("fecha_nacimiento", "La fecha no puede ser posterior a hoy");
            return false;
        }

        return true;
    }


    // Funcion para validar que las contraseñas coinciandan
    protected function validarContrasenia(): bool
    {
        if ($this->contrasenia != $this->confirmar_contrasenia) {
            $this->setError("confirmar_contrasenia", "Las contraseñas no coinciden");
            return false;
        }
        return true;
    }

    //Función que asigna el estado con el rango válido o si es null los da todos
    public static function dameEstados($cod_estado = null)
    {
        //Cargamos los estados es un Array
        $estados = array(
            0 => "no se sabe",
            1 => "estudiando",
            2 => "trabajando",
            3 => "en paro",
            4 => "jubilado"
        );

        //Si esun los devuelve todos
        if ($cod_estado === null) {
            return $estados;
        }

        //Sino es null devulve el codigo concreto si es válido
        return $estados[$cod_estado] ?? false;
    }
}
