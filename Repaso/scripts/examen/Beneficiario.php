<?php
class Beneficiario
{

    // Constante privada
    private const TIPOSREDUCCION = [1 => "Sin reducción", 2 => "Discapacidad", 3 => "Familia numerosa"];

    // Propiedades
    protected string $_nombre;
    protected string $_nif;
    protected int $_reduccion;
    protected int $_reduccion_texto;
    protected DateTime $_fecha_nacimiento;
    protected bool $_mayor_edad;

    public function __construct(string $_nombre, string $_nif, int $_reduccion, DateTime $_fecha_nacimiento)
    {
        //Validar el nombre
        if (!validaCadena($_nombre, 30, "")) {
            throw new Exception('Nombre no válido');
        } else {
            $this->_nombre = $_nombre;
        }

        //Validar los nif validos
        if ((!preg_match('/^([0-9]{8}[A-Z])$/', $_nif)) && (!preg_match('/^[A-Z][0-9]{7}[A-Z])$/', $_nif))) {
            throw new Exception('Nif no válido');
        } else {
            $this->_nif = $_nif;
        }

        //Validar que la reduccion este entre los valores de la constante de tipos de reduccion
        if (!validaEntero($_reduccion, 1, count(self::TIPOSREDUCCION), 1)) {
            throw new Exception('Reducción no válida');
        }else{
            $this->_reduccion = $_reduccion;
        }
        $this->_reduccion_texto = self::TIPOSREDUCCION[$_reduccion];

        // Validar fecha nacimiento
        /*   if ($_fecha_nacimiento === null) {
            $_fecha_nacimiento = new DateTime('-10 years');
        }
        if ($_fecha_nacimiento > new DateTime()) {
            throw new Exception('Fecha de nacimiento no puede ser posterior a hoy');
        }
        $this->_fecha_nacimiento = $_fecha_nacimiento; */
    }
}
