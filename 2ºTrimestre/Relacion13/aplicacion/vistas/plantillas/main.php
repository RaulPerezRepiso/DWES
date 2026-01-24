<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php echo $titulo; ?></title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="/estilos/principal.css" />

	<link rel="icon" type="image/png" href="/imagenes/favicon.png" />
	<?php
	if (isset($this->textoHead))
		echo $this->textoHead;
	?>
</head>

<body>
	<div id="todo">
		<header>
			<div class="logo">
				<a href="/index.php"><img src="/imagenes/logo.png" width="50px" height="50px" /></a>
			</div>
			<div class="titulo">
				<a href="/index.php">
					<h1>RELACIÓN 13</h1>
				</a>
			</div>

		</header><!-- #header -->

		<!-- Método para pintar la barra de login -->
		<div class="barraLogin">
			<?php
			echo CHTML::dibujaEtiqueta("span", [], "Usuario no conectado", true).PHP_EOL;

			echo CHTML::link("Login", ["registro", "login"]);
			echo " | ";
			echo CHTML::link("Logout", "/registro/logout");
			echo " | ";
			echo CHTML::link("Registrarse", "/registro/pedirDatosRegistro");
			?>
		</div>


		<!-- // MÉTODO PARA PINTAR barraUbi //  -->
		<?php
		if (!empty($this->barraUbi)) {

			echo CHTML::dibujaEtiqueta("nav", ["class" => "barraUbi"], null, false);

			$total = count($this->barraUbi);
			$i = 0;

			foreach ($this->barraUbi as $item) {
				$i++;

				$texto = $item["texto"];
				$enlace = $item["enlace"];

				// Si NO es el último elemento → enlace + separador
				if ($i < $total) {

					// Si el enlace está vacío, solo texto
					if (empty($enlace)) {
						echo CHTML::dibujaEtiqueta("span", [], $texto, true);
					} else {
						echo CHTML::link($texto, $enlace);
					}

					// Separador
					echo CHTML::dibujaEtiqueta("span", ["class" => "sep"], "&raquo;", true);
				}

				// Último elemento → solo texto sin enlace
				else {
					echo CHTML::dibujaEtiqueta("span", ["class" => "actual"], $texto, true);
				}
			}

			echo CHTML::dibujaEtiquetaCierre("nav");
		}
		?>


		<div class="contenido">
			<aside>
				<ul>
					<?php

					if (isset($this->menuizq)) {
						foreach ($this->menuizq as $opcion) {
							echo CHTML::dibujaEtiqueta(
								"li",
								array(),
								"",
								false
							);
							echo CHTML::link(
								$opcion["texto"],
								$opcion["enlace"]
							);
							echo CHTML::dibujaEtiquetaCierre("li");
							echo CHTML::dibujaEtiqueta("br") . "\r\n";
						}
					}

					?>
				</ul>
			</aside>

			<article>
				<?php echo $contenido; ?>
			</article><!-- #content -->

		</div>
		<footer>
			<h2><span>Copyright:</span> <?php echo Sistema::app()->autor ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>Dirección:</span><?php echo Sistema::app()->direccion ?></h2>
		</footer><!-- #footer -->

	</div><!-- #wrapper -->
</body>

</html>