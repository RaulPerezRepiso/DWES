<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

inicioCabecera("EJERCICO_2");

// Lanzamiento de dado 6 veces
$lanzamientos6 = [];
for ($i = 1; $i <= 6; $i++) {
    $lanzamientos6[$i] = mt_rand(1, 6);
}

// Lanzamiento aleatorio de veces y conteo de caras
define ("N_lanzamientos", mt_rand(1, 1000));
$num_lanzamientos = N_lanzamientos;
$conteoCaras = array_fill(1, 6, 0);

for ($i = 0; $i < $num_lanzamientos; $i++) {
    $cara = mt_rand(1, 6);
    $conteoCaras[$cara]++;
}
inicioCuerpo("Ejercicio 2: Lanzamiento de un dado");
cuerpo($lanzamientos6, $num_lanzamientos, $conteoCaras);
?>

<?php
function cuerpo($lanzamientos6, $num_lanzamientos, $conteoCaras)
{
    echo "<h1>Lanzamiento de dado 6 veces</h1>";
    for ($i = 1; $i <= 6; $i++) {
        echo "Lanzamiento {$i}: {$lanzamientos6[$i]}<br/>";
    }

    echo "<h1>Lanzamiento del dado {$num_lanzamientos} veces</h1>";
    for ($cara = 1; $cara <= 6; $cara++) {
        $frecuencia = $conteoCaras[$cara];
        $porcentaje = round(($frecuencia / $num_lanzamientos) * 100, 1);
        echo "El {$cara} ha salido {$frecuencia} veces, 
        con una frecuencia de {$porcentaje}%<br/>";
    }
}
?>

