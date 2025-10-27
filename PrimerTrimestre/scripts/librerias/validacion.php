<?php

/**
 * Esta función comprueba que $var contiene un entero cuyo valor 
 * está entre $min y $max
 *
 * @param integer $var
 * @param integer $min
 * @param integer $max
 * @param integer $defecto
 * @return boolean
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool
{
    if (is_int($var) && $var >= $min && $var <= $max) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var contiene un real cuyo valor 
 * está entre $min y $max. 
 *
 * @param float $var
 * @param float $min
 * @param float $max
 * @param float $defecto
 * @return boolean
 */
function validaReal(float &$var, float $min, float $max, float $defecto): bool
{
    if (is_float($var) && $var >= $min && $var <= $max) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var contiene una fecha 
 * correcta en el formato dd/mm/aaaa.
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaFecha(string &$var, string $defecto): bool
{
    $fecha = mb_split("/", $var);

    // Validar que hay tres partes
    if (count($fecha) !== 3) {
        $var = $defecto;
        return false;
    }

    //Validar como se muestra
    if (strlen($fecha[0]) == 1) {
        $fecha[0] = "0" . $fecha[0];
    }
    if (strlen($fecha[1]) == 1) {
        $fecha[1] = "0" . $fecha[1];
    }

    if (checkdate($fecha[1], $fecha[0], $fecha[2])) {
        $var = $fecha[0] . "/" . $fecha[1] . "/" . $fecha[2];
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var contiene  
 * una hora correcta en el formato hh:mm:ss 
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaHora(string &$var, string $defecto): bool
{

    $hora = mb_split(":", $var);

    // Validar que hay tres partes
    if (count($hora) !== 3) {
        $var = $defecto;
        return false;
    }

    //Validar como se muestra
    if (mb_strlen($hora[0]) == 1) {
        $hora[0] = "0" . $hora[0];
    }
    if (mb_strlen($hora[1]) == 1) {
        $hora[1] = "0" . $hora[1];
    }

    if (mb_strlen($hora[2]) == 1) {
        $hora[2] = "0" . $hora[2];
    }

    $h = (int)$hora[0];
    $m = (int)$hora[1];
    $s = (int)$hora[2];

    if ($h >= 0 && $h <= 23 && $m >= 0 && $m <= 59 && $s >= 0 && $s <= 59) {
        $var = $hora[0] . ":" . $hora[1] . ":" . $hora[2];
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var contiene
 * un email correcto en el formato aaaaa@bbbb.ccc.
 *
 * @param string $var
 * @param string $defecto
 * @return boolean
 */
function validaEmail(string &$var, string $defecto): bool
{
    // Eliminar espacios y caracteres invisibles
    $var = trim($var);

    $email = '/^[\w-]+@[\w\-]+\.\w{2,}$/';

    if (preg_match($email, $var)) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var contiene una cadena
 * de longitud máxima $longitud.
 * @param string $var
 * @param integer $longitud
 * @param string $defecto
 * @return boolean
 */
function validaCadena(string &$var, int $longitud, string $defecto): bool
{
    if (mb_strlen($var) <= $longitud) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var cumple con la 
 * expresión regular $expresion.
 *
 * @param string $var
 * @param string $expresion
 * @param string $defecto
 * @return boolean
 */
function validaExpresion(string &$var, string $expresion, string $defecto): bool
{
    if (preg_match($expresion, $var))   return true;
    else {
        $var = $defecto;
        return false;
    }
}

/**
 * Esta función comprueba que $var sea igual a uno de los 
 * elementos del array $posibles ($tipo=1) o a una de las 
 * claves del array $posibles ($tipo=2). 
 *
 * @param mixed $var
 * @param array $posibles
 * @param integer $tipo
 * @return boolean
 */
function validaRango(mixed $var, array $posibles, int $tipo = 1): bool
{
    if ($tipo === 1) {
        return in_array($var, $posibles, true); 
    }

    if ($tipo === 2) {
        return array_key_exists($var, $posibles);
    }

    return false;
}
