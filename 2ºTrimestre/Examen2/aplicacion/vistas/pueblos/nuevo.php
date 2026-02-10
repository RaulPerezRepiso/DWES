<?php

echo CHTML::iniciarForm(["pueblos", "nuevo"]);

echo CHTML::modeloLabel($modelo, "nombre") . PHP_EOL;
echo CHTML::modeloText($modelo, "nombre");
echo CHTML::modeloError($modelo, "nombre");

echo "<br>";

echo CHTML::modeloLabel($modelo, "cod_tipo_elemento") . PHP_EOL;
echo CHTML::modeloListaDropDown($modelo, "cod_tipo_elemento", [1,2,3]);
echo CHTML::modeloError($modelo, "cod_tipo_elemento");

echo "<br>";

echo CHTML::modeloLabel($modelo, "elemento"). PHP_EOL;
echo CHTML::modeloText($modelo, "elemento") ;
echo CHTML::modeloError($modelo, "elemento");

echo "<br>";

echo CHTML::modeloLabel($modelo, "reconocido_unesco"). PHP_EOL;
echo CHTML::modeloListaRadioButton($modelo, "reconocido_unesco", ["SI", "NO"]) ;
echo CHTML::modeloError($modelo, "reconocido_unesco");

echo "<br>";

echo CHTML::modeloLabel($modelo, "fecha_reconocimiento"). PHP_EOL;
echo CHTML::modeloDate($modelo, "fecha_reconocimiento") ;
echo CHTML::modeloError($modelo, "fecha_reconocimiento");


echo "<br>";
echo CHTML::campoBotonSubmit("Crear Pueblo");
echo CHTML::finalizarForm();
