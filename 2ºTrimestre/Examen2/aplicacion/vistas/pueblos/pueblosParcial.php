<?php

echo CHTML::dibujaEtiqueta(
    "div",
    [],

    CHTML::dibujaEtiqueta("h3", [], "Nombre: " . $p->nombre) .
        CHTML::dibujaEtiqueta("p", [], "Tipo De Elemento: " . $p->cod_tipo_elemento) .
        CHTML::dibujaEtiqueta("p", [], "Descripcion: " . $p->descripcion_tipo) .
        CHTML::dibujaEtiqueta("p", [], "Elemento: " . $p->elemento) .
        CHTML::dibujaEtiqueta("p", [], "Renocido por la Unesco Unesco: " . $p->reconocido_unesco) .
        CHTML::dibujaEtiqueta("p", [], "Fecha de Reconocimiento: " . $p->fecha_reconocimiento) .
        CHTML::link(
            "Descargar",
            Sistema::app()->generaURL(["pueblos", "descarga"], ["id" => $p->nombre])
        )
);
echo "<br>";
