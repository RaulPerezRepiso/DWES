<?php

class Pueblo extends CActiveRecord
{
    protected function fijarNombre(): string
    {
        return "pueblo";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "nombre",
            "cod_tipo_elemento",
            "descripcion_tipo",
            "elemento",
            "reconocido_unesco",
            "fecha_reconocimiento"
        );
    }

    protected function fijarRestricciones(): array
    {
        return array(
            array(
                "ATRI" => "nombre",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "El nombre es obligatorio"
            ),
            array(
                "ATRI" => "nombre",
                "TIPO" => "CADENA",
                "TAMANIO" => 25,
                "DEFECTO" => "Pueblo",
                "MENSAJE"  => "El nombre es obligatorio"
            ),
            array(
                "ATRI" => "cod_tipo_elemento",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarCod",
                "DEFECTO" => 0,
            ),
            array(
                "ATRI" => "descripcion_tipo",
                "TIPO" => "CADENA",
                "TAMANIO" => 30,
                "DEFECTO" => null,
            ),
            array(
                "ATRI" => "elemento",
                "TIPO" => "CADENA",
                "TAMANIO" => 35,
                "DEFECTO" => "Ele-",
                "MENSAJE" => "Cadena no válida"
            ),
            array(
                "ARTI" => "reconocido_unesco",
                "TIPO" => "ENTERO",
                "MIN" => 0,
                "MAX" => 1,
                "DEFECTO" => 0,
                "MENESAJE" => "Valor no valido"
            ),
            array(
                "ATRI" => "fecha_reconocimiento",
                "TIPO" => "FUNCION",
                "FUNCION" => "validarFecha",
                "DEFECTO" => date("1958-07-15"),
                "MENSAJE" => "Campo fecha no válido"
            )
        );
    }

    protected function fijarDescripciones(): array
    {
        return [
            "nombre"  => "Nombre",
            "cod_tipo_elemento" => "Tipo de elemento",
            "descripcion_tipo" => "Descripción",
            "elemento"         => "Elemento",
            "reconocido_unesco"    => "Reconocido por la Unesco",
            "fecha_reconocimiento"      => "Fecha del Reconocimiento",
        ];
    }

    protected function afterCreate(): void
    {
        if ($this->cod_tipo_elemento === "" || $this->cod_tipo_elemento === null) {
            return;
        }

        $cod = (int)$this->cod_tipo_elemento;

        $datos = listas::listaTiposBarajas(true, $cod);

        if ($datos === false) {
            return;
        }

        // Asignar nombre de la baraja
        $this->nombre = $datos["nombre"];
    }

    public function validarFecha(): bool
    {
        $campo = "fecha_reconocimiento";

        // Comprobar que viene algo y no está vacío
        if (empty($this->$campo)) {
            $this->setError($campo, "La fecha es obligatoria");
            return false;
        }

        // Si viene en formato HTML5 (YYYY-MM-DD), convertirlo a dd/mm/YYYY
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->$campo)) {
            $this->$campo = date("d/m/Y", strtotime($this->$campo));
        }

        // Intentar crear la fecha en formato dd/mm/YYYY
        $fecha = DateTime::createFromFormat('d/m/Y', $this->$campo);

        if ($fecha === false) {
            $this->setError($campo, "La fecha no tiene un formato válido (dd/mm/yyyy)");
            return false;
        }

        // Fecha mínima 
        $fechaMin = DateTime::createFromFormat('d/m/Y', '01/01/1973');

        // Fecha máxima 
        $fechaHoy = new DateTime();

        // Validar rango
        if ($fecha < $fechaMin) {
            $this->setError("fecha_reconocimiento", "La fecha no puede ser anterior a 01/01/1973");
            return false;
        }

        if ($fecha > $fechaHoy) {
            $this->setError("fecha_reconocimiento", "La fecha no puede ser posterior a hoy");
            return false;
        }

        return true;
    }


    public function validarCod(): bool
    {
        $campo = "cod_tipo_elemento";

        if ($this->$campo === "" || $this->$campo === null) {
            $this->setError($campo, "El código de tipo de elemento es obligatorio");
            return false;
        }

        if (!ctype_digit((string)$this->$campo)) {
            $this->setError($campo, "Debe ser un número entero");
            return false;
        }

        // $lista = listas::listaTiposElemento();
        // $codigosValidos = array_keys($lista);

        // if (!in_array($this->$campo, $codigosValidos)) {
        //     $this->setError($campo, "El código de elemento no existe");
        //     return false;
        // }

        return true;
    }
}
