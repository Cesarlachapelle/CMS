<?php
	session_start();

	$TITLE = 'CMS - Publicar';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array();
	include "../include/essentials.php";

	include("../include/wconnection.php");
	include("../include/wpost.php");

	$post = new Post();

	//if($_GET){
		//$post->editar($_GET['id']);
	//}

	if($_POST){
		$idPost = $post->obtenerID();

		if($idPost == null){
			$idPost = 1;
		}

		$texto = $_POST['editor1'];

		$rutaImagen = "__images/users/{$_SESSION['id']}/{$idPost}.png__"; // Esto se debe mejorar.

		$texto = $rutaImagen . $texto;

		$post->title =  $_POST['titulo'];
		$post->body =  $texto;
		$post->post_date =  date("d/m/y");
		$post->category =  $_POST['editor3'];
		$post->id_acc =  $_SESSION['id']; // Esto debe de mejorarse.

		$post->guardar();

		// Esto es para guardar la imagen, debe de mejorarse.
		if(isset($_FILES['foto']) && $_FILES['foto']['error'] == 0){
			$foto = $_FILES['foto'];

			mkdir("../images/users/{$_SESSION['id']}");

			move_uploaded_file($foto['tmp_name'], "../images/users/{$_SESSION['id']}/{$idPost}.png");
		}
	}
?>

<link rel="stylesheet" href="../css/newpost.css">

<script type="text/javascript" src="<?php Root('js/scriptNewpost.js') ?>"></script>
<script type="text/javascript" src="<?php Root('js/ckeditor/ckeditor.js') ?>"></script>

<div class="col-sm-12">
	<h3>Crear nueva publicación</h3>
	<br>
</div>

<div id="contenedorNewpost">
	<div id="contenidoNewpost" class="col-sm-12">
		<form action="newpost.php" enctype="multipart/form-data" method="post">
			<div id="contenedorIzquierdo" class="col-sm-8">
				<div clas="form-group">
					<label >Título de la publicación:</label>
					<input id="titulo" class="form-control" type="text" name="titulo">
				</div>
				
				<br>
				
				<div id="contenedorMultimedia" class="col-sm-12">
					<div id="botonMultimedia" class="col-sm-3">
						<div id="contenedorFoto" class="col-sm-12">
							<label class="btn btn-primary btn-block">
								+ Imagen
								<input id="foto" type="file" name="foto" val="Foto">
							</label>
						</div>
					</div>
					
					<div id="filename" class="col-sm-3">
						Sin imagen
					</div>
				</div>
				
				<div id="area1" class="col-sm-12">

					<!--Aqui es donde esta el editor CKEditon (WYSIWYG)-->

					<!--Este es el textarea que será reemplazado por el CKEditor.-->
					<textarea id="editor1" name="editor1"></textarea>

					<script>
						CKEDITOR.replace( 'editor1', {
						    language: 'es',
						    uiColor: '#FFFFFF'
						});
					</script>
				</div>
			</div>
			
			<div id="contenedorDerecho" class="col-sm-4">
				<button type="button" id="btnCategoria" class="btn btn-primary btn-block">+ Agregar categorías</button>

				<div id="contenedorSelect" class="col-sm-12">
					<select id="select" name="categoria" class="form-control">
						<option value="deportes" selected>Deportes</option>
						<option value="economía">Economía</option>
						<option value="política">Política</option>
						<option value="entretenimiento">Entretenimiento</option>
						<option value="vida">Vida</option>
					</select>

					<br>
			
					<button type="button" id="btnAceptar" class="btn btn-info btn-block">Aceptar</button>
					<button type="button" id="btnCancelar" class="btn btn-danger btn-block">Cancelar</button>
					
				</div>
				
				<br>
				
				<label>Categorías:</label>
				
				<br>
				
				<div id="divCategoria" class="col-sm-12">
					No hay categoría seleccionada.
				</div>

				<!--Este textarea esta siempre oculto.-->
				<textarea id="editor3" name="editor3"></textarea>
				
				<div class="col-sm-12">
					<br> <!--Este div representa un salto de línea.-->
				</div>				
				<button id="btnPublicar" type="submit" class="btn btn-success btn-block">Publicar</button>
			</div>
		</form>
	</div>
</div>