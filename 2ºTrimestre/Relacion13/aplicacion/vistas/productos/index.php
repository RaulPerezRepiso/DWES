<?php
$tabla = new CGrid($cabecera, $fill, ["class" => "tabla1"]);
$paginado = new CPager($cabPag, []);

echo $tabla->dibujate();
echo $paginado->dibujate();
