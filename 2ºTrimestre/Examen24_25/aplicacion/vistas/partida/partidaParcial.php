<?php

echo CHTML::dibujaEtiqueta(
    "div",
    ["class" => "tarjeta"],

    CHTML::dibujaEtiqueta("h3", [], "Partida #" . $p->cod_partida) .
        CHTML::dibujaEtiqueta("p", [], "Mesa: " . $p->mesa) .
        CHTML::dibujaEtiqueta("p", [], "Fecha: " . $p->fecha) .
        CHTML::dibujaEtiqueta("p", [], "Código baraja: " . $p->cod_baraja) .
        CHTML::dibujaEtiqueta("p", [], "Baraja: " . $p->nombre_baraja) .
        CHTML::dibujaEtiqueta("p", [], "Jugadores: " . $p->jugadores) .
        CHTML::dibujaEtiqueta("p", [], "Crupier: " . $p->crupier) .
        CHTML::link(
            "Descargar",
            Sistema::app()->generaURL(["partida", "descarga"], ["id" => $p->cod_partida])
        ) . " | " .
        CHTML::link(
            "Descargar2",
            Sistema::app()->generaURL(["partida", "descargaTxt"], ["id" => $p->cod_partida])
        ) . " | " .
        CHTML::link(
            "Descargar3",
            Sistema::app()->generaURL(["partida", "descargaCsv"], ["id" => $p->cod_partida])
        )
);
