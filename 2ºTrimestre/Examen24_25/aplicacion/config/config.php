<?php

$config = array(
	"CONTROLADOR" => array("partida"),
	"RUTAS_INCLUDE" => array("aplicacion/modelos", "aplicacion/mislibrerias"),
	"URL_AMIGABLES" => true,
	"VARIABLES" => array(
		"autor" => "Raúl Pérez Repiso",
		"direccion" => "C/ Carrera - Madre Carmen, 12",
		"grupo" => "2DAW",
	),
	"BD" => array(
		"hay" => false,
		"servidor" => "localhost",
		"usuario" => "vicente",
		"contra" => "2daw",
		"basedatos" => "practica9"
	),
	"sesion" => array("controlAutomatico" => true),

);
