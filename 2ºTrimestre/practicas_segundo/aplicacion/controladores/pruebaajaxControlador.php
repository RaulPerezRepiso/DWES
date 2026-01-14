<?php

class pruebaajaxControlador extends CControlador
{
    public array $menuizq = [];
    public string $nombre = "2daw";

    public function accionIndex()
    {

        $this->dibujaVista("index", [], "prueba Ajax");
    }


    //Podemos cerar tantas páginas como queramos usando accionNombre que creara una página con ruta absoluta sin extensión
    public function accionDatosajax()
    {
        $texto=$_POST["p1"];
        
        $resultado = "esto funciona";

        echo json_decode($resultado, JSON_PRETTY_PRINT);
    }
}
