<?php

$config = array(
	"CONTROLADOR" => array("pueblos"),
	"RUTAS_INCLUDE" => array("aplicacion/modelos", "aplicacion/otros_elementos"),
	"URL_AMIGABLES" => true,
	"VARIABLES" => array(
		"autor" => "Raúl Pérez",
		"direccion" => "C/ Carrera - Madre Carmen, 12",
		"grupo" => "2DAW"
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
