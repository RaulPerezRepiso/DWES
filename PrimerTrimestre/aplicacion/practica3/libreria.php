<!-- /**
* La función se encargará de añadir en el array el primer número a la posición asociativa indicada por la cadena.
* 
* Ejercico 1
* 
* @param array $array
* @param String $cadena
* @param integer $num1
* @param integer $num2
* @return bool true si todo ha ido bien y false si se ha detectado algún error
*/ -->
<?php
function cuantasVeces(array &$array, String $cadena, int $num1, int &$num2): bool
{

    // Inicializamos el valor de $num2 para que cada vez que hagamos la llamada al método sume uno en el contador
    // La hacemos static para guardar en otra clase el valor mientras llamemos al método y no reiniciemos la página
    static $cont = 0;
    $cont++;
    $num2 = $cont;

    if ($cadena == "2daw" || $cadena == "primera") {
        return false;
    } else
        $array[$cadena] = $num1;

    return true;
}

?>

<!-- /**
* Se le pasa un parámetro con valor por defecto "X" y se encarga de devolver una
* cadena de longitud la indicada cuyos caracteres son generados de forma aleatoria
* 
* Ejercico 2
*
* @param integer $num
* @return boolean
*/ -->
<?php
function generarCadenas(int $num): bool
{

    if ($num <= 0) {
        return false;
    } else
        $caracteres2 = "";
    for ($i = 1; $i < $num; $i++) {
        $caracteres2 .= chr(mt_rand(48, 126));
    }
    echo "<br>" . $caracteres2;

    return true;
}

?>

<!-- /**
 * Undocumented function
* 
* Ejercico 3
*
 * @param integer $num
 * @param array $op
 * @return integer
 */ -->
<?php
function operaciones(int $num, array $op): int
{

    $result = 0;

    if ($num == 1) {
        for ($i = 0; $i < count($op); $i++) {
            $result += $op[$i];
        }
    } elseif ($num == 2) {
        for ($i = 1; $i < count($op); $i++) {
            $result = $op[0];
            $result -= $op[$i];
        }
    } elseif ($num == 3) {
        $result = 1;
        for ($i = 0; $i < count($op); $i++) {
            $result *= $op[$i];
        }
    } else
        for ($i = 0; $i < count($op); $i++) {
            if ($i % 2 == 0) {
                $result += $op[$i];
            } else
                $result -= $op[$i];
        }
    return $result;
}

?>

<!-- /**
* Undocumented function
*
* Ejercico 4
*
* @param integer $valor
* @param integer $num1
* @param integer $num2
* @return integer
*/ -->
<?php
function devuelve(int &$valor, int $num1 = 4, int $num2 = 10): int
{

    $valor += $num1 + $num2;

    return $valor * $num1 * $num2;
}
?>

<!-- /**
*
* Ejercico 5
*
*/ -->
<?php

function suma($num1, $num2): string
{
    return "Suma: " . $num1 + $num2;
}

function resta($num1, $num2): string
{
    return "Resta: " . $num1 - $num2;
}

function multiplicacion($num1, $num2): string
{
    return "Multiplicación: " . $num1 * $num2;
}

function hacerOperacion(string $cadena, int $num1, int $num2): string|false
{
    if (!in_array($cadena, ["suma", "resta", "multiplicacion"])) {
        return false;
    }

    return $cadena($num1, $num2);
}

?>

<!-- /**
*
* Ejercicio 6
*
*/ -->
<?php
function llamadaAFuncino(int $num1, int $num2) 
{

    return "";
}
?>


<!-- /**
*
* Ejercicio 7
*
*/ -->
<?php
function ordenar()
{

    return "";
}
?>