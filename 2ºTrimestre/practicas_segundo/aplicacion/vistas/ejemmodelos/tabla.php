<?php
$tabla = new CGrid($cabecera, $fill, ["class" => "tabla1"]);
$paginado = new CPager($cabPag, []);

//Dibija la tabla tantas veces como se haga el hecho
echo $tabla->dibujate();
echo $paginado->dibujate();

