<?php
$this->textoHead = CPager::requisitos();

echo CHTML::dibujaEtiqueta("h1", [], "Listado de Productos");

// ===============================
// FILTROS
// ===============================
echo CHTML::dibujaEtiqueta("form", [
    "method" => "get",
    "action" => Sistema::app()->generaURL(["productos", "index"])
]);

// --- FILTRO NOMBRE ---
echo CHTML::dibujaEtiqueta("label", [], "Nombre: ");
echo CHTML::campoText("nombre", $fNombre, ["size" => 20]);
echo CHTML::dibujaEtiqueta("br", []);

// --- FILTRO CATEGORÍA ---
echo CHTML::dibujaEtiqueta("label", [], "Categoría: ");
echo CHTML::campoText("categoria", $fCategoria, ["size" => 20]);
echo CHTML::dibujaEtiqueta("br", []);

// --- FILTRO BORRADO ---
echo CHTML::dibujaEtiqueta("label", [], "Borrado: ");
echo CHTML::campoListaDropDown(
    "borrado",
    $fBorrado,
    ["" => "-- Todos --", 0 => "NO", 1 => "SI"]
);

echo CHTML::dibujaEtiqueta("br", []);

// --- BOTÓN FILTRAR ---
echo CHTML::boton("Filtrar", ["type" => "submit"]);

echo CHTML::dibujaEtiquetaCierre("form");

// ===============================
// BOTÓN DESCARGAR FILTRADOS
// ===============================
$urlDescargar = Sistema::app()->generaURL([
    "productos",
    "descargar",
    "nombre" => $fNombre,
    "categoria" => $fCategoria,
    "borrado" => $fBorrado
]);

echo CHTML::dibujaEtiqueta("p", [], CHTML::link("Descargar filtrados", $urlDescargar));

// ===============================
// BOTÓN NUEVO PRODUCTO
// ===============================
$urlNuevo = Sistema::app()->generaURL(["productos", "nuevo"]);
echo CHTML::dibujaEtiqueta("p", [], CHTML::link("Nuevo producto", $urlNuevo));

// ===============================
// TARJETAS
// ===============================
echo "<div class='contenedor-tarjetas'>";

foreach ($productos as $p) {
    $this->dibujaVistaParcial("tarjeta", ["p" => $p]);
}


echo "</div>";

// ===============================
// PAGINADOR
// ===============================
$paginado = new CPager($paginador, []);
echo $paginado->dibujate();
