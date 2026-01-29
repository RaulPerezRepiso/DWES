<?php

$config = array(
	"CONTROLADOR" => array("inicial", "practicas1", "practicas2"),
	"RUTAS_INCLUDE" => array("aplicacion/modelos", "aplicacion/clases"),
	"URL_AMIGABLES" => true,
	"VARIABLES" => array(
		"autor" => "Raúl Pérez Repiso",
		"direccion" => "C/ Carrera - Madre Carmen, 12",
		"grupo" => "2daw"
	),
	"BD" => array(
		"hay" => true,
		"servidor" => "localhost",
		"usuario" => "root",
		"contra" => "2daw",
		"basedatos" => "practica10"
	),
	"sesion" => array("controlAutomatico" => true),
	"ACL" => array("controlAutomatico" => true)
);
