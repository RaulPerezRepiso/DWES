<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(RUTABASE . "/scripts/librerias/validacion.php");

// Permisos
if (!$acceso->hayUsuario() || !$acceso->puedePermiso(8)) {
    paginaError("No tienes permiso para comprar productos");
    exit;
}

// Recoger datos
$id = isset($_POST["cod_producto"]) ? (int)$_POST["cod_producto"] : -1;
$unidades = isset($_POST["unidades"]) ? (int)$_POST["unidades"] : -1;

// Validaciones del temario
if (!validaEntero($id, 1, 999999, -1)) {
    paginaError("Producto no válido");
    exit;
}

if (!validaEntero($unidades, 1, 999999, -1)) {
    paginaError("Unidades no válidas");
    exit;
}

// Inicializar cesta si no existe
if (!isset($_SESSION["cesta"])) {
    $_SESSION["cesta"] = [];   // cod_producto => unidades
}

// Añadir o incrementar
if (!isset($_SESSION["cesta"][$id])) {
    $_SESSION["cesta"][$id] = $unidades;
} else {
    $_SESSION["cesta"][$id] += $unidades;
}

// Redirigir a la cesta
header("Location: /aplicacion/cesta/index.php");
exit;
