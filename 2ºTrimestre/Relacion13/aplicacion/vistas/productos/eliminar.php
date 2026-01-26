<?php

// Título
echo CHTML::dibujaEtiqueta("h2", [], "Eliminar Producto");

// Mensaje de confirmación
echo CHTML::dibujaEtiqueta("p", [], "¿Seguro que deseas eliminar este producto?");

// Mostrar datos del producto en modo lectura
echo CHTML::dibujaEtiqueta("div", ["style" => "margin-bottom:20px;"], "");

// Nombre
echo CHTML::modeloLabel($modelo, "nombre") . "<br>";
echo CHTML::modeloText($modelo, "nombre", ["readonly" => "readonly"]);
echo "<br><br>";

// Fabricante
echo CHTML::modeloLabel($modelo, "fabricante") . "<br>";
echo CHTML::modeloText($modelo, "fabricante", ["readonly" => "readonly"]);
echo "<br><br>";

// Precio venta
echo CHTML::modeloLabel($modelo, "precio_venta") . "<br>";
echo CHTML::modeloText($modelo, "precio_venta", ["readonly" => "readonly"]);
echo "<br><br>";

// Foto si existe
if ($modelo->foto) {
    echo CHTML::dibujaEtiqueta(
        "img",
        ["src" => "/imagenes/" . $modelo->foto, "width" => "120"],
        ""
    );
}

echo CHTML::dibujaEtiqueta("div", [], ""); // cerrar div

// FORMULARIO DE CONFIRMACIÓN
echo CHTML::iniciarForm("", "post");

// Campo oculto para confirmar
echo CHTML::dibujaEtiqueta("input", [
    "type" => "hidden",
    "name" => "confirmar",
    "value" => "SI"
], "");

// Botón de eliminar
echo CHTML::campoBotonSubmit("Sí, eliminar", ["style" => "background:red; color:white; padding:8px;"]);

// Cerrar formulario
echo CHTML::finalizarForm();

// Botón cancelar
echo "<br>";
echo CHTML::dibujaEtiqueta(
    "a",
    ["href" => Sistema::app()->generaURL(["productos", "index"])],
    "Cancelar"
);
?>
