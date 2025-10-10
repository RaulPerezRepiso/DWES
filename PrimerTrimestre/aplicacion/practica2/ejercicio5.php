<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

// Definir la barra de ubicación
$ubicacion = [
    "Index Principal" => "../../index.php",
    "Relación II:" => "./index.php",
    "Ejercicio 5" => "ejercicio5.php"
];
$GLOBALS['ubicacion'] = $ubicacion;

$cadena = <<<HTML
    <div class="contenedor">
    <p>Este es un párrafo con número 42 y otro número 123456.</p>
    <span>Contacto: juan@example.com</span>
    <section>
        <h1>Bienvenido</h1>
        <p>Correo alternativo: maria.gomez@correo.es</p>
        <p>Otro número: 7</p>
    </section>
</div>
HTML;

$regex_etiquetas = '/<[^>]+>/';
$regex_numeros = '/\d+/';
$regex_emails = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';


inicioCabecera("EJERCICO_1");

inicioCuerpo("Ejercicio 5: Rellenar Array con un contenido definido");


cuerpo($cadena, $regex_etiquetas, $regex_numeros, $regex_emails);
finCuerpo();
function cuerpo($cadena, $regex_etiquetas, $regex_numeros, $regex_emails)
{
    preg_match_all($regex_etiquetas, $cadena, $etiquetas, PREG_OFFSET_CAPTURE);
    preg_match_all($regex_numeros, $cadena, $numeros, PREG_OFFSET_CAPTURE);
    preg_match_all($regex_emails, $cadena, $emails, PREG_OFFSET_CAPTURE);
?>
    <h2>Expresiones regulares para localizar elementos</h2>

    <h3>Para etiquetas HTML</h3>
    <ul>
        <?php foreach ($etiquetas[0] as $etiqueta) { ?>
            <li><?= htmlspecialchars($etiqueta[0]) . " Posición: " . $etiqueta[1] ?></li>
        <?php } ?>
    </ul>

    <h3>Para números</h3>
    <ul>
        <?php foreach ($numeros[0] as $numero) { ?>
            <li><?= $numero[0] . " Posición: " . $numero[1] ?></li>
        <?php } ?>
    </ul>

    <h3>Para direcciones de email</h3>
    <ul>
        <?php foreach ($emails[0] as $email) { ?>
            <li><?= $email[0] . " Posición: " . $email[1] ?></li>
        <?php } ?>
    </ul>
<?php
}
