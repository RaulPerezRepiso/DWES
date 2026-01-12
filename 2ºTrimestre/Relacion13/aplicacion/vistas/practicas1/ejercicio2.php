 <?php
    echo CHTML::dibujaEtiqueta("h1", [], "Lanzamiento de dado 6 veces", true);

    for ($i = 1; $i <= 6; $i++) {
        $texto = "Lanzamiento $i: " . $lanzamientos6[$i];
        echo CHTML::dibujaEtiqueta("p", [], $texto, true);
    }

    echo CHTML::dibujaEtiqueta("h1", [], "Lanzamiento del dado {$num_lanzamientos} veces", true);

    for ($cara = 1; $cara <= 6; $cara++) {
        $frecuencia = $conteoCaras[$cara];
        $porcentaje = round(($frecuencia / $num_lanzamientos) * 100, 1);
        // Construimos el texto ANTES 
        $texto = "El $cara ha salido $frecuencia veces (frecuencia: $porcentaje%)";
        // Ahora sí lo imprimimos con CHTML 
        echo CHTML::dibujaEtiqueta("p", [], $texto, true);
    }
