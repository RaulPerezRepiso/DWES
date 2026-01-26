    <?php
    // ===============================
    //  TABLA (CGrid)
    // ===============================

    $tabla = new CGrid($cabecera, $fill, ["class" => "tabla1"]);
    echo $tabla->dibujate();

    // ===============================
    //  PAGINADOR (CPager)
    // ===============================

    $paginado = new CPager($cabPag, []);
    echo $paginado->dibujate();

    // ===============================
    //  FILTROS
    // ===============================

    // Título
    echo CHTML::dibujaEtiqueta("h1", [], "Listado de Productos");

    // Formulario GET
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
    echo CHTML::dibujaEtiqueta(
        "select",
        ["name" => "borrado"],
        CHTML::dibujaEtiqueta("option", ["value" => "", "selected" => $fBorrado === "" ? "selected" : null], "-- Todos --") .
            CHTML::dibujaEtiqueta("option", ["value" => "0", "selected" => $fBorrado == "0" ? "selected" : null], "NO") .
            CHTML::dibujaEtiqueta("option", ["value" => "1", "selected" => $fBorrado == "1" ? "selected" : null], "SI")
    );
    echo CHTML::dibujaEtiqueta("br", []);

    // --- BOTÓN FILTRAR ---
    echo CHTML::boton("Filtrar", ["type" => "submit"]);

    // Cerrar formulario
    echo CHTML::dibujaEtiquetaCierre("form");

    // ===============================
    //  BOTÓN DESCARGAR FILTRADOS
    // ===============================

    $urlDescargar = Sistema::app()->generaURL([
        "productos",
        "descargar",
        "nombre" => $fNombre,
        "categoria" => $fCategoria,
        "borrado" => $fBorrado
    ]);

    echo CHTML::dibujaEtiqueta(
        "p",
        [],
        CHTML::link("Descargar filtrados", $urlDescargar)
    );

    $urlNuevo = Sistema::app()->generaURL(["productos", "nuevo"]);
    echo CHTML::dibujaEtiqueta("p", [], CHTML::link("Nuevo producto", $urlNuevo));
