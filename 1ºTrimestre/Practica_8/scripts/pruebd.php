<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

//conectar a bd

$bd=@new mysqli($servidor,$usuario,$contrasenia,$baseDatos);
//Compruebo si se ha establecido o no la conexión.
if ($bd->connect_errno)
   {
      paginaError("Fallo al conectar a la Base de Datos");
      exit;
   }

//establece la página de códigos del cliente
$bd->set_charset("utf8");


$sentSelect="*";
$sentFrom="prueba1";
$sentWhere="";
$sentOrder="cadena";

//recojo los criterios de filtrado
$sentWhere="numero<100";

//recojo ordenacion


//construyo la sentencia
$sentencia="select $sentSelect".
            "  from $sentFrom".
            "  where $sentWhere".
            "  order by $sentOrder";

$consulta=$bd->query($sentencia);
//if ($bd->errno)
if (!$consulta)   
   {
      paginaError("Fallo en el acceso a la Base de Datos");
      exit;
   }

$filas=[];
while ($fila=$consulta->fetch_assoc())
   {
      $fila["descripcion"]=$fila["cadena"].": ".$fila["numero"];
      $filas[]=$fila;
   }


//ejecucion sentencias borrado/actualizacion/insersion

if (isset($_GET["oper"]) && $_GET["oper"]==1)
   {
      //para evitar problemas de inyección

      //con tipos distintos de cadena, convertir siempre
      //el parametro recibo al tipo 
      $id="2";
      $id=intval($id);

      //para cadenas usamos la funcion de escape correspondiente a la base de datos
      $cadena="esta 'esto es el ataque'";
      $cadena=$bd->real_escape_string($cadena);


      //se puede evitar el ataque por inyeccion de codigo usando las consultas
      //parametrizadas.
      
      $sentencia="update prueba1 set".
                  "      numero=2000, ".
                  "     cadena='$cadena'".
                  "  where id=$id ";
      $consulta=$bd->query($sentencia);
      if (!$consulta)   
         {
            paginaError("Error al modificar");
            exit;
         }
      
   }

     
   if (isset($_POST["validar"]))
   {
      //ataque por inyeccion de código con cadenas
      //para evitarlo aplicar escape a todas la cadenas antes de usarlas en
      //la sentencia

      $usuario=$bd->real_escape_string($_POST["usuario"]);
      $contra=$_POST["contra"];

      $sentencia="select * ".
                  "    from usuarios".
                  "     where usuario='$usuario' and contrasenia='$contra";

      //ejecuto la sentencia
      echo $sentencia;

      //ataque inyeccion de codigo con un entero
      //para evitarlo, convertir siempre al tipo esperado
      $id=intval($_POST["id"]);

      $sentencia="select * from prueba1 where id=$id";

      $consulta=$bd->query($sentencia);
      if (!$consulta)   
         {
            paginaError("Fallo en el acceso a la Base de Datos");
            exit;
         }

      $filas=[];
      while ($fila=$consulta->fetch_assoc())
         {
            $fila["descripcion"]=$fila["cadena"].": ".$fila["numero"];
            $filas[]=$fila;
         }

      //Otra solución para la inyeccion de codigo
      //usar consultas parametrizadas
      $id=$_POST["id"];

      $sentencia="select id,cadena,numero from prueba1 where id=?";

      $sent=$bd->prepare($sentencia);
      $sent->bind_param('i',$id);

      $idres=0;
      $cadenares='';
      $numerores=0;
      $sent->bind_result($idres,$cadenares,$numerores);


      $res=$sent->execute();
      if (!$res)   
         {
            paginaError("Fallo en el acceso a la Base de Datos");
            exit;
         }

      $filas=[];
      while ($sent->fetch())
         {
            $fila=[];
            $fila["id"]=$idres;
            $filas[]=$fila;
         }


   }


//dibuja la plantilla de la vista
inicioCabecera("pruebas");
cabecera();
finCabecera();
inicioCuerpo("2DAW APLICACION");
cuerpo($filas);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{}

//vista
function cuerpo(array $filas)
{

?>
<table class="tabla">
   <thead>
      <tr>
         <th>CADENA</th><th>NUMERO</th><th>DESCRIPCION</th>
      </tr>
   </thead>
   <tbody>
      <?php
      foreach($filas as $fila)
      {
         echo "<tr>";
         echo "<td>{$fila["cadena"]}</td>";
         echo "<td>{$fila["numero"]}</td>";
         echo "<td>{$fila["descripcion"]}</td>";
         echo "</tr>";
      }
      ?>
   </tbody>

</table>
<br><br>
<a href="pruebd.php?oper=1">Modificar fila 2</a>

<form method="post">
   usuario: <input type="text" name="usuario" value=""><br>
   contraseña: <input type="password" name="contra" value=""><br>
   <br>
   id:<input type="text" name="id" value=""><br>
   <br>
   <input type="submit" name="validar" value="acceder">
   
</form>
<?php
}