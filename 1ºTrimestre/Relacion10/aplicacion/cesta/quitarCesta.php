<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

// Validar usuario
if (!$acceso->hayUsuario() || !$acceso->puedePermiso(8)) {
    paginaError("No tienes permiso para modificar la cesta");
    exit;
}

// Recoger y validar datos
$cod = isset($_POST["cod_producto"]) ? (int)$_POST["cod_producto"] : -1;

if (!validaEntero($cod, 1, 999999, -1)) {
    paginaError("Producto no válido");
    exit;
}

// Quitar producto de la cesta
if (isset($_SESSION["cesta"][$cod])) {
    unset($_SESSION["cesta"][$cod]);
}

// Redirigir a la cesta
header("Location: /aplicacion/cesta/index.php");
exit;
