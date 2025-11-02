<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("../../scripts/librerias/validacion.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación V:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

class Formulario
{

    //Creamos propieades privadas que guarden todo en el array
    private array $datos;
    private array $errores;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->datos = [
            "nombre" => "",
            "password" => "",
            "fechaNacimiento" => "",
            "fechaCarnet" => [
                "dia" => "",
                "mes" => "",
                "anio" => ""
            ],
            "hora" => "",
            "estado" => "",
            "estudios" => [],
            "hermanos" => 0,
            "sueldo" => 1100

        ];

        $this->errores = [];
    }

    /**
     * Funcion que se encarga de procesar las funciones para recoger, validar y mostrar todo
     *
     * @return void
     */
    public function procesarDatos(): void
    {
        // Si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->recogerDatos();     // Captura los datos del formulario
            $this->validarDatos();     // Valida los datos

            // Si hay errores, se vuelve a mostrar el formulario con los datos corregidos
            if (!empty($this->errores)) {
                $this->mostrarFormulario($this->datos, $this->errores);
            } else {
                //Sino muestra el Resumen de los datos recogidos
                $this->mostrarResumen($this->datos);
            }
        } else {
            // Primera carga del formulario
            $this->mostrarFormulario($this->datos, []);
        }
    }

    /**
     * Recogida de datos
     *
     * @return void
     */
    public function recogerDatos(): void
    {
        //Nombre
        // $this->datos["datos"] = $_POST["nombre"] ?? "";
        if (isset($_POST["nombre"])) {
            $nombre = trim($_POST["nombre"]);
            $this->datos["nombre"] = $nombre;
        } else {
            $this->datos["nombre"] = "";
        }

        // Constraseña
        if (isset($_POST["password"])) {
            $password = trim($_POST["password"]);
            $this->datos["password"] = $password;
        } else {
            $this->datos["password"] = "";
        }

        // Fecha de Nacimiento
        if (isset($_POST["fechaNacimiento"])) {
            $fechaNacimiento = $_POST["fechaNacimiento"];
            $this->datos["fechaNacimiento"] = $fechaNacimiento;
        } else {
            $this->datos["fechaNacimiento"] = "";
        }

        // Fecha de Carnet
        if (isset($_POST["dia"])) {
            $this->datos["fechaCarnet"]["dia"] = trim($_POST["dia"]);
        } else {
            $this->datos["fechaCarnet"]["dia"] = "";
        }
        if (isset($_POST["mes"])) {
            $this->datos["fechaCarnet"]["mes"] = trim($_POST["mes"]);
        } else {
            $this->datos["fechaCarnet"]["mes"] = "";
        }
        if (isset($_POST["anio"])) {
            $this->datos["fechaCarnet"]["anio"] = trim($_POST["anio"]);
        } else {
            $this->datos["fechaCarnet"]["anio"] = "";
        }

        // Hora
        if (isset($_POST["hora"])) {
            $hora = $_POST["hora"];
            $this->datos["hora"] = $hora;
        } else {
            $this->datos["hora"] = "";
        }

        // Estado
        if (isset($_POST["estado"])) {
            $estado = trim($_POST["estado"]);
            $this->datos["estado"] = $estado;
        } else {
            $this->datos["estado"] = "";
        }

        // Estudios
        if (isset($_POST["estudios"]) && is_array($_POST["estudios"])) {
            $this->datos["estudios"] = $_POST["estudios"];
        } else {
            $this->datos["estudios"] = [];
        }

        // Hermanos
        if (isset($_POST["hermanos"])) {
            $hermanos = intval($_POST["hermanos"]);
            $this->datos["hermanos"] = $hermanos;
        } else {
            $this->datos["hermanos"] = 0;
        }

        // Sueldo
        if (isset($_POST["sueldo"])) {
            $sueldo = floatval($_POST["sueldo"]);
            $this->datos["sueldo"] = $sueldo;
        } else {
            $this->datos["sueldo"] = 1100;
        }
    }

    /**
     * Validación de datos recogidos
     *
     * @return void
     */
    public function validarDatos(): void
    {
        // Validar Nombre
        $defecto = "";
        $nombre = $this->datos["nombre"];
        if (!validaCadena($nombre, 25, $defecto)||mb_strlen($nombre)<1) {
            $this->errores["nombre"][] = "El nombre no puede estar vacío ni superar 25 caracteres.";
        } elseif (str_starts_with(mb_strtoupper($nombre), "H")) {
            $this->errores["nombre"][] = "El nombre no puede empezar por H.";
        } else {
            $this->datos["nombre"] = mb_strtoupper($nombre);
        }

        //Validar Constraseña
        $password = $this->datos["password"];
        if (!validaCadena($password, 15, $defecto) || mb_strlen($password) < 8) {
            $this->errores["password"][] = "La contraseña debe tener entre 8 y 15 caracteres.";
        } elseif (!validaExpresion($password, '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\$_\-;<>@]).{8,15}$/', $defecto)) {
            $this->errores["password"][] = "Debe incluir al menos una mayúscula, una minúscula, una cifra y un carácter especial (\$_-;<>@).";
        } else {
            $this->datos["password"] = $password;
        }

        //Validar Fecha de Nacimiento
        $fechaNacimiento = $this->datos["fechaNacimiento"];
        if (!validaFecha($fechaNacimiento, $defecto)) {
            $this->errores["fechaNacimiento"][] = "La fecha no es válida";
        } else {
            $this->datos["fechaNacimiento"] = $fechaNacimiento;
        }

        // Validar Fecha de Carnet
        $dia = trim($this->datos["fechaCarnet"]["dia"] ?? "");
        $mes = trim($this->datos["fechaCarnet"]["mes"] ?? "");
        $anio = trim($this->datos["fechaCarnet"]["anio"] ?? "");

        if ($dia === "" || $mes === "" || $anio === "") {
            $this->errores["fechaCarnet"][] = "Debes completar día, mes y año.";
        } else {
            // Convertir a enteros
            $diaInt = (int)$dia;
            $mesInt = (int)$mes;
            $anioInt = (int)$anio;

            // Validar fecha con checkdate
            if (!checkdate($mesInt, $diaInt, $anioInt)) {
                $this->errores["fechaCarnet"][] = "La fecha del carnet no es válida.";
            } else {
                // Guardar los valores formateados en el array original
                $this->datos["fechaCarnet"]["dia"] = str_pad($diaInt, 2, "0", STR_PAD_LEFT);
                $this->datos["fechaCarnet"]["mes"] = str_pad($mesInt, 2, "0", STR_PAD_LEFT);
                $this->datos["fechaCarnet"]["anio"] = $anioInt;

                // Construir la fecha compuesta para validaciones
                $fechaCarnet = $this->datos["fechaCarnet"]["dia"] . "/" .
                    $this->datos["fechaCarnet"]["mes"] . "/" .
                    $this->datos["fechaCarnet"]["anio"];

                // Validar mayoría de edad si la fecha de nacimiento es válida
                if (empty($this->errores["fechaNacimiento"])) {
                    $nacimiento = DateTime::createFromFormat("d/m/Y", $this->datos["fechaNacimiento"]);
                    $carnet = DateTime::createFromFormat("d/m/Y", $fechaCarnet);

                    // Calcular diferencia
                    $intervalo = $nacimiento->diff($carnet);

                    if ($intervalo->y < 18 || $intervalo->invert === 1) {
                        $this->errores["fechaCarnet"][] = "Debes tener al menos 18 años en la fecha del carnet.";
                    }
                }
            }
        }

        //Validar Hora
        $hora = $this->datos["hora"];
        if (!validaHora($hora, $defecto)) {
            $this->errores["hora"][] = "La Hora no es válida";
        } else {
            $this->datos["hora"] = $hora;
        }

        //Valida Estado
        $estado = $this->datos["estado"];
        $estadosValidos = ["1", "2", "3", "4"];

        if (!validaRango($estado, $estadosValidos, 2)) {
            $this->errores["estado"][] = "El estado seleccionado no es válido.";
        } else {
            $this->datos["estado"] = $estado;
        }

        //Valida Estudios
        $estudios = $this->datos["estudios"] ?? [];
        $estudiosValidos = ["0", "1", "2", "3", "4", "5"];

        if (empty($estudios)) {
            $this->errores["estudios"][] = "Debes seleccionar al menos una opción.";
        } else {
            foreach ($estudios as $valor) {
                if (!validaRango($valor, $estudiosValidos)) {
                    $this->errores["estudios"][] = "Opción de estudios no válida: $valor.";
                    break;
                }
            }

            if (in_array("0", $estudios) && count($estudios) > 1) {
                $this->errores["estudios"][] = "Si seleccionas 'Sin estudios', no puedes marcar otras opciones.";
            }

            if (empty($this->errores["estudios"])) {
                $this->datos["estudios"] = $estudios;
            }
        }

        //Valida Hermanos
        $hermanos = (int)$this->datos["hermanos"];
        if (!validaEntero($hermanos, 0, 20, 0)) {
            $this->errores["hermanos"][] = "El número de hermanos no es válido";
        } else {
            $this->datos["hermanos"] = $hermanos;
        }

        //Valida Sueldo 
        $sueldo = (float)$this->datos["sueldo"];
        if (!validaReal($sueldo, 1000, 150000, 1100)) {

            $this->errores["sueldo"][] = "El sueldo no es válido";
        } else {
            $this->datos["sueldo"] = $sueldo;
        }
    }

    /**
     * Mostrar los datos del formulario
     *
     * @param array $datos
     * @param array $errores
     * @return void
     */
    public function mostrarFormulario(array $datos, array $errores): void
    {
        $this->datos = $datos;
        $this->errores = $errores;
?>
        <form method="post">
            <!-- Nombre -->
            <label for="">Nombre: </label>
            <input type="text" name="nombre" value="<?= $this->datos["nombre"] ?>">
            <?php $this->mostrarErrores("nombre"); ?><br>

            <!-- Contraseña -->
            <label for="">Contraseña: </label>
            <input type="password" name="password" value="<?= $this->datos["password"] ?>">
            <?php $this->mostrarErrores("password"); ?><br>

            <!-- Fecha de Nacimiento -->
            <label for="">Fecha de Nacimiento:</label>
            <input type="text" name="fechaNacimiento" value="<?= $this->datos["fechaNacimiento"] ?>">
            <?php $this->mostrarErrores("fechaNacimiento"); ?><br>

            <!-- Fecha del Carnet -->
            <label for="">Fecha de Carnet:</label>
            Día: <input type="text" name="dia" value="<?= $this->datos["fechaCarnet"]["dia"] ?>">
            Mes: <input type="text" name="mes" value="<?= $this->datos["fechaCarnet"]["mes"] ?>">
            Año: <input type="text" name="anio" value="<?= $this->datos["fechaCarnet"]["anio"] ?>">
            <?php $this->mostrarErrores("fechaCarnet"); ?><br>

            <!-- Hora -->
            <label for="">Hora: </label>
            <input type="text" name="hora" value="<?= $this->datos["hora"] ?>">
            <?php $this->mostrarErrores("hora"); ?><br>
            <!-- Estado -->
            <label>Estado: </label><br>
            <?php
            $estados = [
                "1" => "Estudiante",
                "2" => "En paro",
                "3" => "Trabajando",
                "4" => "Jubilado"
            ];
            foreach ($estados as $clave => $texto) {
                $checked = ($this->datos["estado"] == $clave) ? "checked" : "";
                echo "<input type='radio' name='estado' value='$clave' $checked> $texto<br>";
            }
            $this->mostrarErrores("estado"); ?><br>

            <!-- Estudios -->
            <label>Estudios: </label><br>
            <?php
            $estudios = [
                "0" => "Sin Estudios",
                "1" => "Primaria",
                "2" => "Secundaria",
                "3" => "Bachillerato",
                "4" => "Ciclo Formativo",
                "5" => "Universitarios"
            ];
            foreach ($estudios as $clave => $texto) {
                $checked = in_array($clave, $this->datos["estudios"]) ? "checked" : "";
                echo "<input type='checkbox' name='estudios[]' value='$clave' $checked> $texto<br>";
            }
            $this->mostrarErrores("estudios"); ?><br>

            <!-- Hermanos -->
            <label for="">Hermanos: </label>
            <input type="number" name="hermanos" value="<?= $this->datos["hermanos"] ?>">
            <?php $this->mostrarErrores("hermanos"); ?><br>

            <!-- Sueldo -->
            <label for="">Sueldo: </label>
            <input type="number" name="sueldo" value="<?= $this->datos["sueldo"] ?>">
            <?php $this->mostrarErrores("sueldo"); ?><br>

            <br><input type="submit" value="Enviar">
        </form>
    <?php
    }

    /**
     * Función para lanzar los errores cada vez que al validar el campo no es el correcto
     *
     * @param string $campo
     * @return void
     */
    private function mostrarErrores(string $campo): void
    {
        if (!empty($this->errores[$campo])) {
            foreach ($this->errores[$campo] as $error) {
                echo "<p style='color:red;'>$error</p>";
            }
        }
    }

    /**
     * Mostrar el Resumen cuando esta todo introducido
     *
     * @param array $datos
     * @return void
     */
    public function mostrarResumen(array $datos): void
    {
        $this->datos = $datos;

        echo "<h2>Resumen de datos introducidos</h2>";
        echo "<ul>";
        echo "<li><strong>Nombre:</strong> " . $this->datos["nombre"] . "</li>";
        echo "<li><strong>Contraseña:</strong> " . str_repeat("*", mb_strlen($this->datos["password"])) . "</li>";
        echo "<li><strong>Fecha de nacimiento:</strong> " . $this->datos["fechaNacimiento"] . "</li>";

        $fc = $this->datos["fechaCarnet"];
        echo "<li><strong>Fecha de carnet:</strong> " . ($fc["dia"] . "/" . $fc["mes"] . "/" . $fc["anio"]) . "</li>";
        echo "<li><strong>Hora de levantarse:</strong> " . $this->datos["hora"] . "</li>";

        // Mostrar Estado
        $estadosValidos = [
            "1" => "Estudiante",
            "2" => "En paro",
            "3" => "Trabajando",
            "4" => "Jubilado"
        ];
        $estadoClave = $this->datos["estado"];
        $estadoTexto = $estadosValidos[$estadoClave] ?? "No especificado";
        echo "<li><strong>Estado:</strong> " . $estadoTexto . "</li>";

        // Estudios
        echo "<li><strong>Estudios:</strong> ";
        $estudiosTexto = [
            "0" => "Sin estudios",
            "1" => "Primaria",
            "2" => "Secundaria",
            "3" => "Bachillerato",
            "4" => "Ciclo formativo",
            "5" => "Universitarios"
        ];
        $seleccionados = [];
        if (is_array($this->datos["estudios"])) {
            foreach ($this->datos["estudios"] as $codigo) {
                if (isset($estudiosTexto[$codigo])) {
                    $seleccionados[] = $estudiosTexto[$codigo];
                }
            }
        }
        echo !empty($seleccionados) ? implode(", ", $seleccionados) : "No especificado";
        echo "</li>";

        echo "<li><strong>Número de hermanos:</strong> " . $this->datos["hermanos"] . "</li>";
        echo "<li><strong>Sueldo:</strong> " . $this->datos["sueldo"] . " €</li>";
        echo "</ul>";
    }
}

inicioCabecera("PRÁCTICA_5");
cabecera();
finCabecera();

inicioCuerpo("PRÁCTICA_5");
cuerpo();
finCuerpo();


// **********************************************************

function cabecera() {}

function cuerpo()
{
    ?>
    <h1>Relación 5: Introducción de información.</h1>
<?php
    $formulario = new Formulario();
    $formulario->procesarDatos();
}
