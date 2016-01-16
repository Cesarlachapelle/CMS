<?php
	session_start();

	//Si no hay un usuario logueado, redireccionar hacia "~/"
	if(!isset($_SESSION['usr']))
	{
		header('Location: ' . Root());
		die();
	}

	$TITLE = 'CMS - Tablero';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array('myconnection.php');
	include "../include/essentials.php";

	$conex = new myconnection('cmsuser','pass','cms');

	if($conex->conx_err)
		$msg = 'Hubo un error a la hora de realizar la conexion con la Base de Datos';
	else
	{
		$conex->execute('select * from post');
		if($conex->q_err)
			$msg = 'No se pudo cargar la informacion de la Base de Datos';
		else
			$table = $conex->getTable();

		$conex->close();
	}

	unset($conex);
?>

<link rel="stylesheet" type="text/css" href="<?php Root('css/dashboard.css') ?>">

<div id="contenedorDashboard" class="col-sm-12">
	<div id="contenedorIzquierdo" class="col-sm-5">
		<div id="tablero" class="col-sm-6">
			<h3><strong>Tablero</strong></h3>
		</div>

		<div id="descripcionGeneral" class="col-sm-12 contenedor">
			<h4>Descripción general</h4>

			<br>

			<div id="desc" class="col-sm-12 parrafo">
				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt 
				ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation 
				ullamco laboris nisi ut aliquip ex ea commodo consequat.(max=230)
			</div>

			<div id="editar" class="col-sm-12">
				<a style="cursor:pointer;" onclick="editDesc()">
					Editar
				</a>
			</div>
		</div>

		<!--Script para manejar la "Descripcion general"-->
		<script type="text/javascript">

			//toggle para activar/desactivar el modo de edicion de la descripcion
			var descEditMode = true;
			//Backup para guardar el texto original de la descripcion
			var textoDesc = '';
			//Backup de los controles del div #editar
			var editar_backup = document.getElementById('editar').innerHTML;

			<?php #Funcion para hacer crecer el textarea automaticamente ?>
			function autoGrow(obj)
			{
				obj.style.height = '1px';
				obj.style.height = (25+obj.scrollHeight) + 'px';
			}

			<?php #Funcion para editar la descripcion ?>
			function editDesc(cancel)
			{
				descEditMode = !descEditMode;
				var desc = document.getElementById('desc');
				if(!descEditMode)
				{
					desc.innerHTML = '<textarea id="txtarea" style="resize:none" '
					+'class="form-control" maxlength="230" onkeyup="autoGrow(this)">'
					+ (textoDesc = desc.innerText) + '</textarea>';

					document.getElementById('editar').innerHTML = '<a style="cursor:pointer;" '
					+'onclick="editDesc(true)">'
					+'Cancelar</a>&nbsp;&nbsp;&nbsp;' + editar_backup;

					var txtarea = document.getElementById('txtarea');
					autoGrow(txtarea);
					txtarea.focus();
				}
				else
				{
					if(!cancel)
					{
						// * Modificar descripcion con AJAX *

						desc.innerText = document.getElementById('txtarea').value;
					}
					else
					{
						desc.innerText = textoDesc;
						textoDesc = '';
					}
					document.getElementById('editar').innerHTML = editar_backup;
				}
			}
		</script>

		<!--Esto es un salto de línea-->
		<div class="col-sm-12">
			<br>
		</div>

		<div id="informacion" class="col-sm-12 contenedor">
			<h4>Información</h4>

			<br>

			X Publicaciones hechas 
			<br>
			X Comentarios realizados
		</div>

		<!--Esto es un salto de línea-->
		<div class="col-sm-12">
			<br> 
		</div>

		<div id="actividadReciente" class="col-sm-12 contenedor">
			<h4>Actividad reciente</h4>

			<br>

			Publicaciones

			<div id="publicaciones" class="col-sm-12">
				<div class="col-sm-5 fecha">
					dd/mm/aa
				</div>

				<div class="col-sm-2">
					<!--Este div no se debe borrar.-->
				</div>

				<div class="col-sm-5 publicacion">
					<a href="<?php #codigo php ?>">
						Publicación 1
					</a>
				</div>

				<!--//	//	//	//	//	//-->

				<div class="col-sm-5 fecha">
					dd/mm/aa
				</div>

				<div class="col-sm-2">
					<!--Este div no se debe borrar.-->
				</div>

				<div class="col-sm-5 publicacion">
					<a href="<?php #codigo php ?>">
						Publicación 2
					</a>
				</div>

				<!--Esto es un salto de línea-->
				<div class="col-sm-12">
					<br> 
				</div>

				<h4>Comentarios</h4>

				<div class="col-sm-4 imagen">
					<br>
					<img class="img-responsive" src="<?php Root('images/sys/imagen.png') ?>">
				</div>

				<div class="col-sm-8 nombrePublicacion">

					<br>

					<h4>Nombre de publicación</h4>

					<br>

					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt 
					ut labore et dolore magna aliqua. (max=123)
				</div>
			</div>
		</div>
	</div>

	<div id="contenedorDerecho" class="col-sm-7">
		<div id="misPublicaciones" class="col-sm-12">
			<h3>Mis publicaciones</h3>

			<br>

			<!--Este es el formato para una publicación sin foto.-->
			<div class="col-sm-12 tituloPublicacion">
				<div class="col-sm-6 titulo" style="cursor:pointer"
					onclick="location.href='<?php #codigo php ?>'">
					<h4>Título de la publicación</h4>
				</div>

				<div class="col-sm-6 fecha2">
					<h5>dd/mm/aa</h5>
				</div>

				Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt 
				ut labore et dolore magna aliqua. (max=123)

				<div class="col-sm-12 editar">
					<a href="<?php #codigo php ?>">
						<h5>Editar</h5>
					</a>
				</div>
			</div>

			<!--Esto es un salto de línea-->
			<div class="col-sm-12">
				<br> 
			</div>

			<!--Este es el formato para una publicación con foto.-->
			<div class="col-sm-12 tituloPublicacion">
				<div class="col-sm-6 titulo" style="cursor:pointer"
					onclick="location.href='<?php #codigo php ?>'">
					<h4>Título de la publicación</h4>
				</div>

				<div class="col-sm-6 fecha2">
					<h5>dd/mm/aa</h5>
				</div>

				<!---//	//	//	//	//	//-->

				<div class="col-sm-3 imagen">
					<img class="img-responsive" src="<?php Root('images/sys/imagen.png') ?>">
				</div>

				<div class="col-sm-9 parrafo">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt 
					ut labore et dolore magna aliqua adipiscing elit. (max=138)
				</div>

				<div class="col-sm-12 editar">
					<a href="<?php #codigo php ?>">
						<h5>Editar</h5>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>