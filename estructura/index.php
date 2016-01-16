<?php
	session_start();

	if(count($_GET) > 0 && count($_GET) !== 2)
	{
		header('Location: ./');
		die();
	}
	elseif(count($_GET) > 0 && (!isset($_GET['srch']) || !isset($_GET['fltr'])))
	{
		header('Location: ./');
		die();
	}

	if(isset($_GET['fltr']))
	{
		switch($_GET['fltr'])
		{
			case 'publicacion':break;
			case 'editor':break;
			case 'categoria':break;
			case 'fecha':break;
			default:
				header('Location: ./');
				die();
			break;
		}
	}

	$TITLE = 'Todo Noticias';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array('myconnection.php');
	include "include/essentials.php";

	$conex = new myconnection('cmsuser','pass','cms');

	if($conex->conx_err)
		$msg = 'Hubo un error a la hora de realizar la conexion con la Base de Datos.';
	else
	{
		if(count($_GET) > 0)
		{
			$query = "select post.*,account.user from post inner join account "
					. "on account.id = post.id_acc where ";

			switch($_GET['fltr'])
			{
				case 'publicacion':
					$query .= "post.title like '%{$_GET['srch']}%' order by post.post_date asc";
				break;
				case 'editor':
					$query .= "account.user like '%{$_GET['srch']}%' order by post.post_date asc";
				break;
				case 'categoria':
					$query .= "post.category like '%{$_GET['srch']}%' order by post.post_date asc";
				break;
				case 'fecha':
					$query .= "post.post_date like '%{$_GET['srch']}%' order by post.post_date asc";
				break;
			}
		}
		else
			$query = "select post.*,account.user from post inner join account "
			. "on account.id = post.id_acc order by post_date asc";

		#Cargar los posts
		$conex->execute($query);
		if($conex->q_err)
			//$msg = $conex->q_err;
			$msg = 'No se pudo cargar la informacion de la Base de Datos.';
	}
?>

<link rel="stylesheet" href="css/indexRoot.css">

<script type="text/javascript" src="<?php Root('js/scriptMain.js') ?>"></script>
<script type="text/javascript" src="js/indexRootScript.js"></script>

<div id="contenedorMain" class="col-sm-12">
	<div id="menuDashboard" class="col-sm-12">
		<a href="<?php Root(); ?>">
			<div class="col-sm-4 col-sm-offset-4">
				<img id="icono" src="images/sys/todonoticias.png">
				<strong>Todo Noticias</strong>
			</div>
		</a>
	</div>

	<div id="contenedorIzquierdo" class="col-sm-3">
		<div class="form-group">
			<span id="divBuscar">
				<?php
					if(isset($_GET['fltr']))
						$fltr = $_GET['fltr'];
					else
						$fltr = 'publicacion';
				?>
				<label>Buscar:</label>
				<input id="inputBuscar" class="form-control" type="text"
					name="buscar" onkeydown="Buscar(event,this)" autofocus>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="publicacion"
					 onclick="selectChange(value)"<?php if($fltr == 'publicacion')
					 	echo ' checked="checked"' ?>>
					Publicación
				</label>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="editor" onclick="selectChange(value)"<?php
					if($fltr == 'editor') echo ' checked="checked"' ?>>
					Editor
				</label>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="categoria" onclick="selectChange(value)"<?php
					if($fltr == 'categoria') echo ' checked="checked"' ?>>
					Categoría
				</label>
				
				<br>
				
				<label>
					<input type="radio" name="tipo" value="fecha" onclick="selectChange(value)"<?php
					if($fltr == 'fecha') echo ' checked="checked"' ?>>
					Fecha
				</label>
			</span>
<input type="hidden" name='control' value=''>
			<script type="text/javascript">
				var filter = 'publicacion';
				function Buscar(evt,obj)
				{
					if(evt.keyCode === 13 && obj.value.trim().length > 0)
						location.href = '?srch=' + obj.value.trim().toLowerCase()
							+ '&fltr=' + filter;
				}

				function selectChange(val)
				{
					document.getElementById('inputBuscar').focus();
					filter = val;
				}
			</script>
			
			<hr id="linea">
			
			<h5>
				<b>Publicaciones mas populares:</b>
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
		

	<?php if(isset($msg)): ?>
		<div class="col-sm-12">
			<span style="display:block;text-align:center;font-size:14pt">
				<b>Error: </b><?php echo $msg; ?>
			</span>
		</div>
	<?php else:
		$cont = 0;
		while($table = $conex->getArray()):
			$cont++;

		//2 -> body
		if(strpos($table[2], '__') === 0)
		{
			$portada = substr($table[2], 0, strpos($table[2], '__',2)+2);
			$portada = substr($portada, 2, strlen($portada)-4);
			$table[2] = substr($table[2], strpos($table[2], '__',2)+2);
		}

		if(isset($portada)):
	?>
		<!--Este formato de publicación es el formato con foto.-->
		<div class="col-sm-12 contenedorPublicacion">
			<div class="col-sm-12">

				<div class="col-sm-12 tituloFecha">
					<div class="col-sm-6 titulo">
						<?php #1 -> title ?>
						<h4 style="cursor:pointer"
						 onclick="location.href='comment?id=<?php echo $table[0]; ?>'">
							<?php echo $table[1]; ?>
						</h4>
					</div>
					
					<div class="col-sm-6 fechaComentar">
						<?php #3 -> post_date ?>
						<h5>
							<?php echo $table[3]; ?> |
							<a href='comment?id=<?php echo $table[0]; ?>'>Comentar</a>
						</h5>
					</div>
				</div>
				
				<div class="col-sm-3 contenedorFoto">
					<!--El link de esta foto es temporal, es solo pare representar
					que en este div debe de haber una imagen.-->
					<img class="img-responsive foto" src="<?php Root($portada) ?>"
					 onerror='this.src="<?php Root("images/sys/imgnf.jpg"); ?>"'>
				</div>
				
				<div class="col-sm-9 contenedorParrafo">

				<?php #2 -> body ?>
				<?php
					if(strlen($table[2]) > 450)
						echo substr($table[2], 0, 450);
					else
						echo $table[2];
				?>
				</div>
				
				<div class="col-sm-12 editorNombre">
					<?php #5 -> id_acc ?>
					<h6>
					<?php #6 -> account.user ?>
						Editor:
						<a href="dashboard.php?id=<?php echo $table[5]; ?>">
							<?php echo ucfirst(strtolower($table[6])); ?>
						</a>
					</h6>
				</div>
			</div>
		</div>

		<!--Este div debe ponerse al final de cada contenedor de publicacion, este
		representa un salto de línea.-->
		<div class="col-sm-12">
			<br>
		</div>

	<?php unset($portada); else: ?>
		
		<!--Este formato de publicación es el formato sin foto.-->
		<div class="col-sm-12 contenedorPublicacion">
			<div class="col-sm-12">
				<div class="col-sm-12 tituloFecha">
					<div class="col-sm-6 titulo">
						<?php #1 -> title ?>
						<h4 style="cursor:pointer"
						 onclick="location.href='comment?id=<?php echo $table[0]; ?>'">
							<?php echo $table[1]; ?>
						</h4>
					</div>
					
					<div class="col-sm-6 fechaComentar">
						<?php #3 -> post_date ?>
						<h5>
							<?php echo $table[3]; ?> |
							<a href='comment?id=<?php echo $table[0]; ?>'>Comentar</a>
						</h5>
					</div>
				</div>
				
				<div class="col-sm-12 contenedorParrafo">
					<?php #2 -> body ?>
					<?php
						if(strlen($table[2]) > 450)
							echo substr($table[2], 0, 450);
						else
							echo $table[2];
					?>
				</div>
				
				<div class="col-sm-12 editorNombre">
					<?php #5 -> id_acc ?>
					<h6>
					<?php #6 -> account.user ?>
						Editor:
						<a href="dashboard.php?id=<?php echo $table[5]; ?>">
							<?php echo ucfirst(strtolower($table[6])); ?>
						</a>
					</h6>
				</div>			
			</div>
		</div>

		<!--Este div debe ponerse al final de cada contenedor de publicacion, este
		representa un salto de línea.-->
		<div class="col-sm-12">
			<br>
		</div>

	<?php endif; endwhile;

	if($cont === 0)
		echo '<div class="col-sm-12 fecha">'
		.'<span style="display:block;text-align:center;font-size:14">'
		. 'No hay publicaciones para mostrar</span></div>';

	endif; $conex->close(); ?>



	</div>
</div>