<?php

// De la misma manera que con accion claseControlador para crear páginas de llamada direfentes
class usuariosControlador extends CControlador
{
	public array $menuizq = [];
	public function accionIndex()
	{


		$this->menuizq = [
			[
				"texto" => "Inicio",
				"enlace" => ["inicial"]
			]
		];



		$this->dibujaVista("prueba", [], "Usuarios Existentes");
	}


	//Podemos cerar tantas páginas como queramos usando accionNombre que creara una página con ruta absoluta sin extensión
	public function accionNuevo()
	{
		echo "Nuevo Usuario";
	}

	public function accionModificar()
	{
		echo "Modificar Usuario";
	}

	public function accionBorrar()
	{
		$this->dibujaVista("prueba", [], "Borrar Usuarios");
	}
}
