<?php
$this->textoHead = CHTML::scriptFichero("/js/main.js", ["defer" => "defer"]);

echo CHTML::iniciarForm("", "get", ["id" => "id_from"]);
echo "texto: " . CHTML::campoText("par1", "", ["id" => "id"]) . "<br>" . PHP_EOL;
echo CHTML::campoBotonSubmit("enviar", ["id" => "id_bot"]);
echo CHTML::finalizarForm();

echo "<br>" . PHP_EOL;
echo CHTML::dibujaEtiqueta("p", ["id" => "resultado"], "resultado");
