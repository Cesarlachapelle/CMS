<?php
	session_start();

	$TITLE = 'CMS - Comentario';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array('myconnection.php');
	include "include/essentials.php";
?>

<link rel="stylesheet" href="css/comment.css">

<script type="text/javascript" src="<?php Root('js/scriptComment.js') ?>"></script>

<div id="contenedorComment" class="col-sm-12">
	<div id="contenedorIzquierdo" class="col-sm-3">
		<div class="form-group">
			<span id="divBuscar">
				<label>Buscar:</label>
				<input id="inputBuscar" class="form-control" type="text" name="buscar">
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="publicacion" checked="checked">
					Publicación
				</label>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="editor">
					Editor
				</label>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="categoria">
					Categoría
				</label>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="fecha">
					Fecha
				</label>
			</span>
			
			<hr id="linea">
			
			<h5>
				Publicaciones mas populares:
			</h5>
			
			<hr>
			
			<h5>
				Título de la publicación mas popular #1.
			</h5>
			
			<hr>
			
			<h5>
				Título de la publicación mas popular #2.
			</h5>
			
			<hr>
			
			<h5>
				Título de la publicación mas popular #3.
			</h5>
		</div>
	</div>
	
	<div id="contenedorDerecho" class="col-sm-9">
		<h3>Deja un comentario</h3>

		<br>

		<div id="contenedorCampos" class="col-sm-12">
			<div class="form-group">
				<label>Nombre</label>
				<input class="form-control" id="nombre" name="nombre">
			</div>

			<div class="form-group">
				<label>Correo</label>
				<input class="form-control" id="nombre" name="nombre">
			</div>

			<div class="form-group">
				<label>Comentario</label>
				<textarea class="form-control" rows="6"></textarea>
			</div>

			<div class="col-sm-12 boton">
				<div class="col-sm-4 boton">
					<button class="btn btn-success btn-block">Enviar</button>
				</div>	
			</div>
		</div>
	</div>
</div>
