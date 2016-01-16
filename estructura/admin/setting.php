<?php
	session_start();

	$TITLE = 'CMS - Configuración';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array('myconnection.php');
	include "../include/essentials.php";
?>

<link rel="stylesheet" type="text/css" href="<?PHP Root('css/setting.css') ?>">

<div class="col-sm-12">
	<h3>Configuración</h3>

	<div id="contenedorSetting" class="col-sm-12">
		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Nombre de usuario:
			</div>

			<div class="col-sm-4">
				<input class="form-control" type="text" name="usuario" placeholder="Usuario">
			</div>

			<div id="noCambia" class="col-sm-4">
				* No puedes cambiar este campo
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Nombre:
			</div>

			<div class="col-sm-4">
				<input class="form-control" type="text" name="nombre" placeholder="Nombre">
			</div>

			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Apellido:
			</div>

			<div class="col-sm-4">
				<input class="form-control" type="text" name="apellido" placeholder="Apellido">
			</div>

			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Apodo:
			</div>

			<div class="col-sm-4">
				<input class="form-control" type="text" name="apodo" placeholder="Apodo">
			</div>

			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Mostrar nombre como:
			</div>

			<div class="col-sm-4">
				<select name="nombreComo" class="form-control">
					<option value="usuario" selected>Usuario</option>
					<option value="nombre">Nombre</option>
					<option value="apodo">Apodo</option>
				</select>
			</div>

			<div id="nombreQueVeran" class="col-sm-4">
				* Nombre que verán los demás
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Correo:
			</div>

			<div class="col-sm-4">
				<input class="form-control" type="text" name="correo" placeholder="correo@correo.dom">
			</div>

			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				Clave:
			</div>

			<div class="col-sm-4">
				<button class="btn btn-info btn-block">Cambiar clave</button>
			</div>

			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>
		</div>

		<div class="col-sm-12 contenedorCampo">
			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>

			<div class="col-sm-4">
				<button class="btn btn-success btn-block">Guardar cambios</button>
			</div>

			<div class="col-sm-4">
				<!--Este div no se debe borrar.-->
			</div>
		</div>
	</div>
</div>
