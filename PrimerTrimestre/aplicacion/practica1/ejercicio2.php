<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

define("NUM_LANZAMIENTOS", mt_rand(1, 1000));

// Lanzamiento de dado 6 veces
$lanzamientos6 = [];
for ($i = 0; $i < 6; $i++) {
    $lanzamientos6[] = mt_rand(1, 6);
}

// Lanzamiento aleatorio de veces y conteo de caras
$conteoCaras = array_fill(1, 6, 0); // Inicializa del 1 al 6 con 0

for ($i = 0; $i < NUM_LANZAMIENTOS; $i++) {
    $cara = mt_rand() % 6 + 1; // mt_rand() sin parámetros
    $conteoCaras[$cara]++;
}

inicioCabecera("EJERCICO_2");

inicioCuerpo("Ejercicio 2: Lanzamiento de un dado");
cuerpo($lanzamientos6, $conteoCaras);


function cuerpo($lanzamientos6, $conteoCaras)
{
?>
    <h2>Lanzamiento de dado (6 veces)</h2>
    <ul>
        <?php foreach ($lanzamientos6 as $i => $valor): ?>
            <li>Lanzamiento <?= $i + 1 ?>: <?= $valor ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Dado lanzado <?= NUM_LANZAMIENTOS ?> veces</h2>
    <ul>
        <?php foreach ($conteoCaras as $cara => $cantidad): ?>
            <li>Cara <?= $cara ?> salio <?= $cantidad ?> veces con un porcentaje de <?= $porcentaje=$cantidad/10 ?>%</li>
        <?php endforeach; ?>
    </ul>
<?php
}
?>