<?php

class CCaja extends CWidget
{



    public function dibujate(): string
    {
        return $this->dibujaApertura() . $this->dibujaFin();
    }

    public function dibujaApertura(): string
    {
        ob_start();

        echo CHTML::dibujaEtiqueta(
            "div",
            $this->_atributosHTML,
            "",
            false
        );
        echo CHTML::dibujaEtiqueta(
            "table",
            $this->_atributosHTML,
            "",
            false
        );
?>
        <tr>
            <?php
            foreach ($this->_columnas as $columna) {
                $eti = $etiqueta = "th";
                if ($columna["ANCHO"] != "")
                    $etiqueta .= " width='" . $columna["ANCHO"] . "'";

                if ($columna["VISIBLE"])
                    echo "<$etiqueta>" . $columna["ETIQUETA"] . "</$eti>";
            }

            ?>
        </tr>
<?php
        $par = false;

        foreach ($this->_filas as $fila) {
            if ($par)
                echo "<tr class='par'>\n";
            else
                echo "<tr class='impar'>\n";
            $par = !$par;

            foreach ($this->_columnas as $columna) {
                $campo = "";
                if (isset($fila[$columna["CAMPO"]]))
                    $campo = $fila[$columna["CAMPO"]];
                $eti = $etiqueta = "td";

                switch ($columna["ALINEA"]) {
                    case 'izq':;
                        break;

                    case 'der':
                        $etiqueta .= " align='right'";
                        break;

                    case 'cen':
                        $etiqueta .= " align='center'";
                        break;
                }
                if ($columna["VISIBLE"])
                    echo "\t<$etiqueta>" . $campo . "</$eti>\n";
            }
            echo "</tr>\n";
        }

        echo CHTML::dibujaEtiquetaCierre("table");
        echo CHTML::dibujaEtiquetaCierre("div");

        $escrito = ob_get_contents();
        ob_end_clean();

        return $escrito;
    }

    public function dibujaFin(): string
    {
        return "";
    }
}
