<?php

class CCaja extends CWidget
{

    private $_titulo;
    private $_contenido;
    private $_atributosHTML = array();

    /**
     * Constructor CCaja
     * @param string $titulo Título de la caja
     * @param string $contenido Contenido de la caja 
     * @param array $atributosHTML Atributos HTML  
     */
    public function __construct($titulo, $contenido = "", $atributosHTML = array())
    {
        $this->_titulo = $titulo;
        $this->_contenido = $contenido;

        // Mantener los atributos y añadir clase por defecto
        $this->_atributosHTML = $atributosHTML;
        if (!isset($this->_atributosHTML["class"])) {
            $this->_atributosHTML["class"] = "caja";
        }
    }

    /**
     * Dibuja la caja completa
     * @return string HTML de 
     */
    public function dibujate(): string
    {
        return $this->dibujaApertura() . $this->dibujaFin();
    }

    /**
     * Dibuja la apertura de la caja 
     * @return string HTML de la apertura 
     */
    public function dibujaApertura(): string
    {

        ob_start();

        // Dibuja la Tabla 
        echo CHTML::dibujaEtiqueta("table", $this->_atributosHTML, "", false);
        echo "<tr>\n";
        echo CHTML::dibujaEtiqueta("td", array("class" => "titulo"), $this->_titulo, false);
        echo "<button id='mostrar'>Ocultar/mostrar</button>";
        echo "</tr>\n";

?>
        <!-- Script que muestra o no la caja dependiendo de si le damos -->
        <script defer>
            document.getElementById("mostrar").onclick = function() {

                let estilos = window.getComputedStyle(document.getElementsByClassName("cuerpo")[0]);

                estilos.display == "none" ? document.getElementsByClassName("cuerpo")[0].style.display = "block" :
                    document.getElementsByClassName("cuerpo")[0].style.display = "none"
            }
        </script>
<?php

        // Cuerpo de la caja
        echo "<tr>\n";
        echo CHTML::dibujaEtiqueta("td", array("class" => "cuerpo"), "", false);

        // Mostrar si existe contenido o no
        if (!empty($this->_contenido)) {
            echo $this->_contenido;
        }

        $escrito = ob_get_contents();
        ob_end_clean();

        return $escrito;
    }

    /**
     * Cierre de la caja
     * @return string HTML 
     */
    public function dibujaFin(): string
    {
        ob_start();

        echo CHTML::dibujaEtiquetaCierre("td");

        echo "</tr>\n";

        echo CHTML::dibujaEtiquetaCierre("table");

        $escrito = ob_get_contents();
        ob_end_clean();

        return $escrito;
    }
}
