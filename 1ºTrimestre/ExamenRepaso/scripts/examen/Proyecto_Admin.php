    <?php
    include_once(dirname(__FILE__) . "/../../cabecera.php");

    final class Proyecto_Admin extends Proyecto
    {

        //Propiedades
        protected string $_expediente;

        /**
         * Constructor
         */
        public function __construct(
            string $_nombre,
            string $_empresa,
            int $_tipo = 10,
            string $_expediente = "2024/00001",
            ?DateTime $fecha_inicio = null,
            ?DateTime $fecha_fin = null
        ) {

            // Llamada al constructor padre
            parent::__construct($_nombre, $_empresa, $_tipo, $fecha_inicio, $fecha_fin);
            
            // Validar expediente
            if (($this->setExpediente($_expediente)) < 0) {
                throw new Exception("Expediente no válido");
            }

            // Incrementar fecha_fin en 20 días
            $this->_fecha_fin->modify("+20 days");
            $this->_duracion = $this->_fecha_fin->diff($this->_fecha_inicio)->days;
        }

        /**
         * Getter expediente
         */
        public function getExpediente(): string
        {
            return $this->_expediente;
        }

        /**
         * Setter expediente
         *
         * @param string $expediente
         * @return int 0 correcto | -1 formato incorrecto | -2 longitud incorrecta
         */
        public function setExpediente(string $_expediente): int
        {
            if (!validaCadena($_expediente, 10, "2024/00001")) return -2; // longitud incorrecta
            if (!validaExpresion($_expediente, "/^[0-9]{4}\\/[0-9]{5}$/", "2024/00001")) return -1; // formato incorrecto
            $this->_expediente = $_expediente;
            return 0;
        }

        /**
         * Método ToString
         */
        public function __toString(): string
        {
            return parent::__toString() . " con expediente {$this->_expediente}";
        }
    }
