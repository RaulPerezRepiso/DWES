<?php
echo CHTML::dibujaEtiqueta("h1",[],"Petición de Datos AJAX");

echo CHTML::dibujaEtiqueta("label",[],"Introduce valor Mínimo: ");
echo CHTML::campoNumber("min","",["id"=>"min"]);

echo CHTML::dibujaEtiqueta("br",[]);

echo CHTML::dibujaEtiqueta("label",[],"Introduce valor Máximo: ");
echo CHTML::campoNumber("max","",["id"=>"max"]);

echo CHTML::dibujaEtiqueta("br",[]);

echo CHTML::dibujaEtiqueta("label",[],"Introduce una Cadena de caracteres: ");
echo CHTML::campoText("cadena","",["id"=>"cadena"]);

echo CHTML::dibujaEtiqueta("br",[]);

echo CHTML::boton("Pedir datos", ["id"=>"idBoton"]);

echo CHTML::dibujaEtiqueta("div",["id"=>"idDiv"]);

// añadir enlace al script en la cabecera
$this->textoHead=CHTMl::scriptFichero("/scripts/pedirDatos.js",["defer"=>"defer"]);