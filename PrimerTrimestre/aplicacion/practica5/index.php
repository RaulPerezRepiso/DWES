<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
include_once("/Users/2daw/DWES/PrimerTrimestre/scripts/librerias/validacion.php");
include_once("/Users/2daw/DWES/PrimerTrimestre/aplicacion/practica5/Formulario.php");

// Barra de ubicación para la página índice
$ubicacion = [
    "Index Principal" => "/index.php",
    "Relación V:" => "#",
];
$GLOBALS['ubicacion'] = $ubicacion;

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

include_once("/Users/2daw/DWES/PrimerTrimestre/scripts/librerias/validacion.php");

class Formulario
{

    //Creamos propieades privadas que guarden todo en el array
    private array $datos;
    private array $errores;

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

    public function procesarDatos(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->recogerDatos();
            $this->validarDatos();

            if ($this->errores) {
                $this->mostrarFormulario();
            } else {
                $this->mostrarResumen();
            }
        } else {
            $this->mostrarFormulario();
        }
    }

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

    public function validarDatos(): void
    {
        // Validar nombre
        $nombre = $this->datos["nombre"];
        if (!validaCadena($nombre, 25, "")) {
            $this->errores["nombre"][] = "El nombre no puede estar vacío ni superar 25 caracteres.";
        } elseif (str_starts_with(mb_strtoupper($nombre), "H")) {
            $this->errores["nombre"][] = "El nombre no puede empezar por H.";
        } else {
            $this->datos["nombre"] = mb_strtoupper($nombre);
        }

        //Validar constraseña
        $password = $this->datos["password"];
        $defecto = "";
        if (!validaCadena($password, 15, $defecto) || mb_strlen($password) < 8) {
            $this->errores["password"][] = "La contraseña debe tener entre 8 y 15 caracteres.";
        } elseif (!validaExpresion($password, '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\$_\-;<>@]).{8,15}$/', $defecto)) {
            $this->errores["password"][] = "Debe incluir al menos una mayúscula, una minúscula, una cifra y un carácter especial (\$_-;<>@).";
        } else {
            $this->datos["password"] = $password;
        }

        //Validar fechaNacimiento
        $fechaNacimiento = $this->datos["fechaNacimiento"];
        if (!validaFecha($fechaNacimiento, $defecto)) {
            $this->errores["fechaNacimiento"][] = "La fecha no es válida";
        }else{
            $this->datos["fechaNacimiento"] = $fechaNacimiento;
        }
        
        //Validar fecha de Carnet
        $fechaCarnet = $this->datos["fechaCarnet"];
        

    }

    public function mostrarFormulario(): void {}

    public function mostrarResumen(): void {}
}
