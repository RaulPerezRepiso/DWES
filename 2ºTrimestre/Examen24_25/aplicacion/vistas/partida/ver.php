<?php

// FORMULARIO
echo CHTML::iniciarForm("", "post");

echo CHTML::campoListaDropDown("crupier", $crupierSel, $crupieres);

echo CHTML::campoBotonSubmit("Ver");

// Enlace a NUEVA PARTIDA
echo CHTML::link(
    CHTML::imagen("/imagenes/16x16/nuevo.png", "", ["style" => "width:20px", "margin-op:15px"]) . "NUEVA PARTIDA",
    Sistema::app()->generaURL(["partida", "nueva"]),
);

echo CHTML::finalizarForm();

// MOSTRAR PARTIDAS FILTRADAS
foreach ($partidas as $p) {
    $this->dibujaVistaParcial("partidaParcial", ["p" => $p]);
}
