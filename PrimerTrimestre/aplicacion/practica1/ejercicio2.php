<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación I: arrays, fechas, librería math" => "./index.php",
    "Ejercicio 2" => "ejercicio2.php"
];
$GLOBALS['ubicacion'] = $ubicacion;
inicioCabecera("EJERCICO_2");

inicioCuerpo("Ejercicio 2: Lanzamiento de un dado");

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

cuerpo($lanzamientos6, $num_lanzamientos, $conteoCaras);
finCuerpo();
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

