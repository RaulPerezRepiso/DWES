<?php

	$config=array("CONTROLADOR"=> array("inicial"),
	// La ruta de aplicacion/clases la podremos omiter ya que ahora mismo no nos hace falta
				  "RUTAS_INCLUDE"=>array("aplicacion/modelos","aplicacion/clases"),
				  "URL_AMIGABLES"=>true,
				  "VARIABLES"=>array("autor"=>"Raúl Pérez Repiso",
				  					"direccion"=>"C/ Carrera - Madre Carmen, 12",
									"grupo"=>"2daw"
								),
				  "BD"=>array("hay"=>false,
								"servidor"=>"localhost",
								"usuario"=>"root",
								"contra"=>"2daw",
								"basedatos"=>"practica9") 			
				  );

