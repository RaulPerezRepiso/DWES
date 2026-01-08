<?php
include_once(dirname(__FILE__) . "/../cabecera.php");

$PRO = $_SESSION['PRO'] ?? [];
$id = $_GET['id'] ?? null;

if ($id === null || !isset($PRO[$id])) {
    paginaError("Proyecto no válido");
    exit;
}

$proyecto = $PRO[$id];

header("Content-Type: text/plain; charset=utf-8");
header("Content-Disposition: attachment; filename=\"proyecto_$id.txt\"");

echo $proyecto->__toString() . "\n";
echo $proyecto->getDescripcionOtras();
