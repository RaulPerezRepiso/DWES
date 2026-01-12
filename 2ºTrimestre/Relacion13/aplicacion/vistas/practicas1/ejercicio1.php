<?php
echo CHTML::dibujaEtiqueta("h1", [], "Funciones Matemáticas", true);

echo CHTML::dibujaEtiqueta("p", [], "El numero es {$numero}", true);

echo CHTML::dibujaEtiqueta("p", [], "Primero redondeo a la alza es: {$redondeoArriba}", true);

echo CHTML::dibujaEtiqueta("p", [], "Primero redondeo a la baja es: {$redondeoAbajo}", true);

echo CHTML::dibujaEtiqueta("p", [], "El resultado de elevaro 2^3 es:  {$elevar}", true);

echo CHTML::dibujaEtiqueta("p", [], "El resultado de la raiz de 49 es: {$raiz}", true);

echo CHTML::dibujaEtiqueta("p", [], "Convertir 255 de Decimal a Hexadecimal es: {$convertirDecimal}", true);

echo CHTML::dibujaEtiqueta("p", [], "El valor de: {$baseConvert}", true);

echo CHTML::dibujaEtiqueta("p", [], "El valor absoluto de -15 es: {$valorAbsoluto}", true);

echo CHTML::dibujaEtiqueta("p", [], "El valor de PI es: {$valorPi}", true);


echo CHTML::dibujaEtiqueta("h1", [], "Variables de Instancia", true);

echo CHTML::dibujaEtiqueta("p", [], "Binario de 0b1011 es: {$binario}", true);

echo CHTML::dibujaEtiqueta("p", [], "Octal de 075 es: {$octal}", true);

echo CHTML::dibujaEtiqueta("p", [], "Hexadecimal de 0x1f es: {$hexadecimal}", true);
