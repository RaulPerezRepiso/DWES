<?php

class partida extends CActiveRecord
{

    protected function fijarNombre(): string
    {
        return "partida";
    }

    protected function fijarTabla(): string
    {
        return "partidas";
    }

    protected function fijarId(): string
    {
        return "cod_partida";
    }

    protected function fijarAtributos(): array
    {
        return array(
            "cod_partida",
            "mesa",
            "fecha",
            "cod_baraja",
            "nombre_baraja",
            "jugadores",
            "crupier"
        );
    }

    protected function fijarRestricciones(): array
    {
        return array(
            array(
                "ATRI" => "cod_partida, cod_baraja",
                "TIPO" => "REQUERIDO",
                "MENSAJE" => "Parti-Este campo es obligario"
            ),
            array(
                "ATRI" => "mesa",
                "TIPO" => "ENTERO",
                "MIN" => 1,
                "MAX" => 20,
                "DEFECTO" => 1,
                "MENSAJE" => "Parti-Tiene que ser un entero entre 1 y 20"
            ),
            array(
                "ATRI" => "fecha",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaFecha",
                "DEFECTO" => date("d/m/Y", strtotime("+1 day")),
                "MENSAJE" => "Parti-La fecha no puede ser menos a un día menos"
            ),
            array(
                "ATRI" => "cod_baraja",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaCodBaraja",
                "DEFECTO" => $this->sacarLista(),
                "MENSAJE" => "Parti-Tiene que ser entero y mayor de 20"
            ),
            array(
                "ATRI" => "nombre_baraja",
                "TIPO" => "CADENA",
                "MAX" => 30,
                "MENSAJE" => "Parti-El nombre de la baraja no es válido"
            ),
            array(
                "ATRI" => "jugadores",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaJugadores",
                "MENSAJE" => "Parti-Número de jugadores no válido"
            ),
            array(
                "ATRI" => "crupier",
                "TIPO" => "FUNCION",
                "FUNCION" => "validaCrupier",
                "DEFECTO" => "Cru-Juan",
                "MENSAJE" => "Parti-Nombre de crupier no válido"
            ),
        );
    }

    //Asigna los valores por defecto necesarios en algunos campos
    protected function afterCreate(): void
    {
        // Si cod_baraja está vacío, no podemos obtener datos
        if ($this->cod_baraja === "" || $this->cod_baraja === null) {
            return;
        }

        // Convertir a entero
        $cod = (int)$this->cod_baraja;

        // Obtener datos completos de la baraja
        $datos = listas::listaTiposBarajas(true, $cod);

        if ($datos === false) {
            return; // código inválido, no hacemos nada
        }

        // Asignar nombre de la baraja
        $this->nombre_baraja = $datos["nombre"];

        // Asignar jugadores por defecto (mínimo)
        if (empty($this->jugadores)) {
            $this->jugadores = $datos["min_juga"];
        }

        // Asignar crupier por defecto
        if (empty($this->crupier)) {
            $this->crupier = "Cru-Juan";
        }
    }



    // Valida que la fehca sea valida 
    public function validaFecha(): bool
    {
        $campo = "fecha";

        // Comprobar que viene algo
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
        $hoy = new DateTime("today");

        if ($fecha < $hoy) {
            $this->setError($campo, "La fecha no puede ser anterior a hoy");
            return false;
        }

        return true;
    }


    //Válida que el codBaraja sea válido
    public function validaCodBaraja(): bool
    {
        $campo = "cod_baraja";

        if ($this->$campo === "" || $this->$campo === null) {
            $this->setError($campo, "El código de baraja es obligatorio");
            return false;
        }

        if (!ctype_digit((string)$this->$campo)) {
            $this->setError($campo, "Debe ser un número entero");
            return false;
        }

        $this->$campo = (int)$this->$campo;

        $lista = listas::listaTiposBarajas();
        $codigosValidos = array_keys($lista);

        if (!in_array($this->$campo, $codigosValidos)) {
            $this->setError($campo, "El código de baraja no existe");
            return false;
        }

        return true;
    }


    //Sacar el por defecto de cod_baraja
    public function sacarLista()
    {
        //Saca los valores de la lista
        $lista = listas::listaTiposBarajas();

        //Saca las claves del array
        $codigo = array_keys($lista);

        //Saca la posición media
        $posicionMedia = floor(count($codigo) / 2);

        return $codigo[$posicionMedia];
    }

    //Validar que los jugadores sean los adecuados segun el jeugo
    public function validaJugadores(): bool
    {
        $campo = "jugadores";

        if (!ctype_digit((string)$this->$campo)) {
            $this->setError($campo, "Debe ser un número entero");
            return false;
        }

        $this->$campo = (int)$this->$campo;

        // Obtener límites según la baraja
        $datos = listas::listaTiposBarajas(true, $this->cod_baraja);

        if ($this->$campo < $datos["min_juga"] || $this->$campo > $datos["max_juga"]) {
            $this->setError($campo, "El número de jugadores debe estar entre {$datos['min_juga']} y {$datos['max_juga']}");
            return false;
        }

        return true;
    }

    //Validar que el nombre del crupier se válido
    public function validaCrupier(): bool
    {
        if (strpos($this->crupier, "Cru-") !== 0) {
            $this->setError("crupier", "El crupier debe empezar por Cru-");
            return false;
        }
        return true;
    }
}
