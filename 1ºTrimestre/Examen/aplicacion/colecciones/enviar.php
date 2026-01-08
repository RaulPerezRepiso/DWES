<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

$COLECCIONES = $_SESSION['COLECCIONES'] ?? [];
$id = $_GET['id'] ?? null;

if ($id === null || !isset($COLECCIONES[$id])) {
    paginaError("Colección no válida");
    exit;
}

$coleccion = $COLECCIONES[$id];

header("Content-Type: text/plain; charset=utf-8");
header("Content-Disposition: attachment; filename=\"colecciones_$id.txt\"");

echo $coleccion->__toString() . "\n";