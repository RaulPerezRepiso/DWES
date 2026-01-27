<?php

echo CHTML::dibujaEtiqueta("h2", [], "Modificar Producto");

echo CHTML::iniciarForm("", "post", ["enctype" => "multipart/form-data"]);

// -----------------------------
// NOMBRE
// -----------------------------
echo CHTML::modeloLabel($modelo, "nombre") . "<br>";
echo CHTML::modeloText($modelo, "nombre", ["maxlength" => 40, "size" => 40]);
echo CHTML::modeloError($modelo, "nombre");
echo "<br><br>";

// -----------------------------
// FABRICANTE
// -----------------------------
echo CHTML::modeloLabel($modelo, "fabricante") . "<br>";
echo CHTML::modeloText($modelo, "fabricante", ["maxlength" => 40, "size" => 40]);
echo CHTML::modeloError($modelo, "fabricante");
echo "<br><br>";

// -----------------------------
// FECHA ALTA
// -----------------------------
echo CHTML::modeloLabel($modelo, "fecha_alta") . "<br>";
echo CHTML::modeloText($modelo, "fecha_alta");
echo CHTML::modeloError($modelo, "fecha_alta");
echo "<br><br>";

// -----------------------------
// UNIDADES
// -----------------------------
echo CHTML::modeloLabel($modelo, "unidades") . "<br>";
echo CHTML::modeloNumber($modelo, "unidades");
echo CHTML::modeloError($modelo, "unidades");
echo "<br><br>";

// -----------------------------
// PRECIO BASE
// -----------------------------
echo CHTML::modeloLabel($modelo, "precio_base") . "<br>";
echo CHTML::modeloNumber($modelo, "precio_base", ["step" => "0.01"]);
echo CHTML::modeloError($modelo, "precio_base");
echo "<br><br>";

// -----------------------------
// IVA
// -----------------------------
echo CHTML::modeloLabel($modelo, "iva") . "<br>";
echo CHTML::modeloListaDropDown($modelo, "iva", [4 => "4%", 10 => "10%", 21 => "21%"]);
echo CHTML::modeloError($modelo, "iva");
echo "<br><br>";

// -----------------------------
// FOTO
// -----------------------------
echo CHTML::modeloLabel($modelo, "foto") . "<br>";
echo CHTML::modeloText($modelo, "foto", ["maxlength" => 40, "size" => 40]);
echo CHTML::modeloError($modelo, "foto");
echo "<br>";

if ($modelo->foto) {
    echo CHTML::dibujaEtiqueta(
        "img",
        ["src" => "/imagenes/" . $modelo->foto, "width" => "120"],
        ""
    );
}
echo "<br><br>";

// -----------------------------
// BORRADO (SI/NO)
// -----------------------------
echo CHTML::modeloLabel($modelo, "borrado") . "<br>";
echo CHTML::modeloListaDropDown(
    $modelo,
    "borrado",
    [0 => "NO", 1 => "SI"]
);
echo CHTML::modeloError($modelo, "borrado");
echo "<br><br>";

// ----------------------------- 
// CATEGORÍA 
// ----------------------------- 
echo CHTML::modeloLabel($modelo, "cod_categoria") . "<br>";
echo CHTML::modeloListaDropDown($modelo, "cod_categoria", $categorias);
echo CHTML::modeloError($modelo, "cod_categoria");
echo "<br><br>";

// -----------------------------
// BOTÓN GUARDAR
// -----------------------------
echo CHTML::campoBotonSubmit("Guardar cambios");

echo CHTML::finalizarForm();
