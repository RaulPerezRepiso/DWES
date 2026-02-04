<?php
$this->textoHead = CPager::requisitos();

echo CHTML::dibujaEtiqueta("h1", [], "Listado de Productos");

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

echo CHTML::dibujaEtiqueta("br", []);


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


$cajaFiltrado = new CCaja(
    "Criterios de filtrado (en caja)",
    "",
    array("style" => "width:80%;")
);
//dibuja el html correspondiente a apertura de caja
echo $cajaFiltrado->dibujaApertura();
//contenido de la caja
echo CHTML::iniciarForm(
    Sistema::app()->generaURL(
        array("articulos", "index"),
        array("reg_pag" => 5)
    ),
    "get",
    array()
);
echo CHTML::campoLabel("Nombre: ", "nombre");
echo CHTML::campoText(
    "nombre",
    (isset($fil["nombre"]) ? $fil["nombre"] : ""),
    array("size" => 10)
);
echo CHTML::campoLabel(" Descripci&oacute;n: ", "desc");
echo CHTML::campoText(
    "desc",
    (isset($fil["desc"]) ? $fil["desc"] : ""),
    array("size" => 10)
);
echo CHTML::campoLabel(" Fabricante: ", "fab");
echo CHTML::campoBotonSubmit("Filtrar");
echo CHTML::finalizarForm();
//cierro la caja
echo $cajaFiltrado->dibujaFin();
