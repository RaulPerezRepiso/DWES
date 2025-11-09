<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once(dirname(__FILE__) . "/muebles.php");

inicioCabecera("Gestión de Muebles");
cabecera();
finCabecera();

inicioCuerpo("Gestión de Muebles");
cuerpo();
finCuerpo();

function cabecera() {}

function cuerpo()
{
    global $muebles;
?>
    <h2>Listado de Muebles</h2>
    <table>
        <tr>
            <th>Índice</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Fabricante</th>
            <th>País</th>
            <th>Año</th>
        </tr>
        <?php foreach ($muebles as $i => $mueble): ?>
            <?php
            $nombre = $fabricante = $pais = $anio = "?";
            $mueble->damePropiedad("nombre", 1, $nombre);
            $mueble->damePropiedad("fabricante", 1, $fabricante);
            $mueble->damePropiedad("pais", 1, $pais);
            $mueble->damePropiedad("anio", 1, $anio);
            ?>
            <tr>
                <td><?= $i ?></td>
                <td><?= get_class($mueble) ?></td>
                <td><?= $nombre ?></td>
                <td><?= $fabricante ?></td>
                <td><?= $pais ?></td>
                <td><?= $anio ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Acciones sobre Muebles</h2>
    <form method="get" action="/aplicacion/principal/botones.php">
        <label for="indice">Selecciona un mueble:</label>
        <select name="indice" id="indice">
            <?php foreach ($muebles as $i => $mueble): ?>
                <?php $nombre = "?";
                $mueble->damePropiedad("nombre", 1, $nombre); ?>
                <option value="<?= $i ?>">Mueble <?= $i ?> - <?= $nombre ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <button type="submit" name="botones" value="mostrar">Mostrar Mueble</button>
        <button type="submit" name="botones" value="modificar">Modificar Mueble</button>
    </form>
<?php
}
