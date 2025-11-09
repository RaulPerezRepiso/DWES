<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/muebles.php");

inicioCabecera("Acción sobre Mueble");
cabecera();
finCabecera();

inicioCuerpo("Acción sobre Mueble");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{
    global $muebles;

    $indice = $_GET['indice'] ?? null;
    $botones = $_GET['botones'] ?? null;

    echo '<div id="documento">';

    if (!isset($muebles[$indice])) {
        echo "<p>Mueble no válido.</p>";
        echo '<p><a href="index.php">Volver al índice</a></p>';
        echo '</div>';
        return;
    }

    $mueble = $muebles[$indice];

    if ($botones === "mostrar") {
        echo "<h2>Propiedades del Mueble $indice</h2>";
        $propiedades = $mueble->dameListaPropiedades();

        echo '<table style="width:100%; border-collapse: collapse; margin-top: 20px;">';
        echo '<thead><tr><th style="text-align:left; padding: 10px; background:#f0f0f0;">Propiedad</th><th style="text-align:left; padding: 10px; background:#f0f0f0;">Valor</th></tr></thead><tbody>';

        foreach ($propiedades as $clave) {
            $valor = null;
            $mueble->damePropiedad($clave, 1, $valor);
            echo "<tr><td style='padding: 10px;'>$clave</td><td style='padding: 10px;'>$valor</td></tr>";
        }

        echo '</tbody></table>';
        echo '<p style="margin-top: 20px;"><a href="index.php">Volver al índice</a></p>';
    } elseif ($botones === "modificar") {
        echo "<h2>Modificar Mueble $indice</h2>";
        $materiales = MuebleBase::MATERIALES_POSIBLES;

        $nombre = $fabricante = $pais = $anio = $matActual = "";
        $mueble->damePropiedad("nombre", 1, $nombre);
        $mueble->damePropiedad("fabricante", 1, $fabricante);
        $mueble->damePropiedad("pais", 1, $pais);
        $mueble->damePropiedad("anio", 1, $anio);
        $mueble->damePropiedad("material", 1, $matActual);
?>
        <form method="post" action="guardar.php" style="margin-top: 20px;">
            <input type="hidden" name="indice" value="<?= $indice ?>">
            <fieldset style="border: none;">
                <div class="form-group">
                    <label>Nombre: <input type="text" name="nombre" value="<?= $nombre ?>" class="form-input"></label>
                </div>
                <div class="form-group">
                    <label>Fabricante: <input type="text" name="fabricante" value="<?= $fabricante ?>" class="form-input"></label>
                </div>
                <div class="form-group">
                    <label>País: <input type="text" name="pais" value="<?= $pais ?>" class="form-input"></label>
                </div>
                <div class="form-group">
                    <label>Año: <input type="number" name="anio" value="<?= $anio ?>" class="form-input"></label>
                </div>
                <div class="form-group">
                    <label>Material:
                        <select name="material" class="form-select">
                            <?php foreach ($materiales as $id => $mat): ?>
                                <option value="<?= $id ?>" <?= ($matActual == $mat) ? "selected" : "" ?>><?= $mat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
                <button type="submit">Guardar cambios</button>
            </fieldset>
        </form>
        <p style="margin-top: 20px;"><a href="index.php">Volver al índice</a></p>
<?php
    } else {
        echo "<p>Acción no reconocida.</p>";
        echo '<p><a href="index.php">Volver al índice</a></p>';
    }

    echo '</div>';
}