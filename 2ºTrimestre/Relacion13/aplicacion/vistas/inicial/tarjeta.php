<?php
echo "<div class='tarjeta'>";

echo "<h3>" . $p["nombre"] . "</h3>";
echo "<p><strong>Fabricante:</strong> " . $p["fabricante"] . "</p>";
echo "<p><strong>Categoría:</strong> " . $p["nombre_categoria"] . "</p>";
echo "<p><strong>Precio:</strong> " . $p["precio_venta"] . " €</p>";

$img = $p["foto"] ?: "base.png";
echo CHTML::dibujaEtiqueta("img", ["src" => "/imagenes/$img", "class" => "foto-prod"]);

$urlVer = Sistema::app()->generaURL(["productos", "ver"], ["id" => $p["cod_producto"]]);
$urlMod = Sistema::app()->generaURL(["productos", "modificar"], ["id" => $p["cod_producto"]]);

echo "<div class='acciones'>";
echo "<a href='$urlVer'>Ver</a> | ";
echo "<a href='$urlMod'>Modificar</a>";
echo "</div>";

echo "</div>";
