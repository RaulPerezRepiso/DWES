<?php
echo CHTML::dibujaEtiqueta("h1", [], "Listado de Pueblos");

echo CHTML::iniciarForm("", "post");

echo CHTML::link(
    CHTML::imagen("/imagenes/16x16/nuevo.png", "", ["style" => "width:20px", "margin-op:15px"]) . "NUEVO",
    Sistema::app()->generaURL(["pueblos", "nuevo"]),
);

echo "<br>";
echo CHTML::campoListaRadioButton("modelo", $puebloSel, $guardar);

echo "<br>";

echo CHTML::campoBotonSubmit("Ver");

echo CHTML::finalizarForm();

foreach ($guardar as $p) {
    var_dump($guardar);
    $this->dibujaVistaParcial("pueblosParcial", ["p" => $p]);
}
