<?php
	//Si no hay un atributo en $_GET, redireccionar hacia "~/"
	if(!isset($_GET['id']))
	{
		header('Location: ./');
		die();
	}

	//Si no es un valor numerico, redireccionar igual
	if(isset($_GET['id']) && !is_finite($_GET['id']))
	{
		header('Location: ./');
		die();
	}

	$TITLE = 'CMS - Perfil';
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
		#Cargar la informacion del usuario
		$conex->execute('select * from info where id_acc=' . $_GET['id']);
		if($conex->q_err)
			$msg = 'No se pudo cargar la informacion de la Base de Datos.';
		else
			$info = $conex->getArray();

		#Cargar las publicaciones
		if(isset($info))
		{
			#4 -> act_rec1
			$conex->execute("select * from post where id=$info[4]");
			if(!$conex->q_err && ($temp = $conex->getArray()) !== null)
				$act_rec = array($temp);

			#5 -> act_rec2
			$conex->execute("select * from post where id=$info[5]");
			if(!$conex->q_err && ($temp = $conex->getArray()) !== null)
				if(isset($act_rec))
					$act_rec[] = $temp;

			#Cargar los posts con los comentarios mas recientes
			$conex->execute("call FetchPost({$_GET['id']})");
			if(!$conex->q_err)
			{
				$comm_rec = array();
				while($temp = $conex->getArray())
					$comm_rec[] = $temp;
			}

			if(isset($temp))
				unset($temp);

			if($conex->conex->more_results())
				while($conex->conex->next_result());

			$conex->execute("select user from account where id={$_GET['id']}");
			if(!$conex->q_err)
				//Nombre del usuario regular (no visitante)
				$USER = $conex->getValue();
		}

		#Cargar los posts
		$conex->execute("select * from post where id_acc={$_GET['id']} order by post_date asc");
		if($conex->q_err)
			//$msg = $conex->q_err;
			$msg = 'No se pudo cargar la informacion de la Base de Datos.';
	}
?>

<link rel="stylesheet" type="text/css" href="<?php Root('css/dashboardRoot.css') ?>">

<script type="text/javascript" src="<?php Root('js/dashboarRootScript.js') ?>"></script>

<div id="contenedorDashboard" class="col-sm-12">
	<div id="menuDashboard" class="col-sm-12">
		<a href="<?php Root(); ?>">
			<div class="col-sm-4 col-sm-offset-4">
				<img id="icono" src="images/sys/todonoticias.png">
				<strong>Todo Noticias</strong>
			</div>
		</a>
	</div>
	
	<div id="contenedorIzquierdo" class="col-sm-5">
		<div id="tablero" class="col-sm-12">
			<h3><strong>
				<?php 
					if(isset($USER))
						echo "Perfil de " . ucfirst(strtolower($USER));
					else
						echo 'Perfil';
				?>
			</strong></h3>
		</div>

		<div id="descripcionGeneral" class="col-sm-12 contenedor">
			<h4>Descripción general</h4>

			<br>

			<div id="desc" class="col-sm-12 parrafo">
				<?php
					if(isset($info))
						#1 -> desc
						echo $info[1];
					else
						echo 'Blog de noticias...';
				?>
			</div>
		</div>

		<!--Esto es un salto de línea-->
		<div class="col-sm-12">
			<br>
		</div>

		<div id="informacion" class="col-sm-12 contenedor">
			<h4>Información</h4>

			<br>
			<?php #2 -> post_cont ?>
			<?php echo isset($info) ? $info[2]: '-1' ?> Publicaciones hechas 
			<br>
			<?php #3 -> comm_cont ?>
			<?php echo isset($info) ? $info[3]: '-1' ?> Comentarios realizados
		</div>

		<!--Esto es un salto de línea-->
		<div class="col-sm-12">
			<br> 
		</div>

		<div id="actividadReciente" class="col-sm-12 contenedor">
			<h4>Actividad reciente</h4>

			<br>

			<span style="margin-bottom:5px;font-size:13pt">Publicaciones</span>

			<div id="publicaciones" class="col-sm-12">
				

			<?php
				if(isset($act_rec) && $cont = 1)
					foreach($act_rec as $a):
						$cont++;
			?>
				<div class="col-sm-5 fecha">
					<?php #3 -> post_date ?>
					<?php echo $a[3]; ?>
				</div>

				<div class="col-sm-2">
					<!--Este div no se debe borrar.-->
				</div>

				<div class="col-sm-5 publicacion">
					<?php #0 -> id ?>
					<a href="<?php Root('comment.php?id=' . $a[0]) ?>">
						<?php #1 -> title ?>
						<?php echo strlen($a[1]) > 20 ? substr($a[1], 0, 20) . '...': $a[1]; ?>
					</a>
				</div>

			<?php endforeach;

				if(isset($cont) && $cont === 1)
					echo '<div class="col-sm-12 fecha">'
					.'<span style="display:block;text-align:center">'
					. 'No hay publicaciones recientes</span></div>';
				elseif(!isset($cont))
					echo '<div class="col-sm-12 fecha">'
					.'<span style="display:block;text-align:center">'
					. 'No se pudo cargar la informacion</span></div>';
			?>

				<!--Esto es un salto de línea-->
				<div class="col-sm-12">
					<br> 
				</div>

				<h4 style="margin-bottom:5px">Comentarios</h4>

			<?php
				if(isset($comm_rec)):
					$cont = 0;

					foreach($comm_rec as $a):
						$cont++;
						if(strpos($a[2], '__') === 0)
						{
							$portada = substr($a[2], 0, strpos($a[2], '__',2)+2);
							$portada = substr($portada, 2, strlen($portada)-4);
							$a[2] = substr($a[2], strpos($a[2], '__',2)+2);
						}
						if(isset($portada)):
			?>

				<div class="col-sm-4 imagen">
					<br>
					<img class="img-responsive" src="<?php Root('images/sys/imagen.png') ?>">
				</div>

				<div class="col-sm-8 nombrePublicacion">

					<br>

					<h4 style="font-size:13pt;cursor:pointer"
					 onclick="location.href='<?php Root('comment.php?id=' . $a[0]); ?>'">
						<?php #1 -> title ?>
						<?php echo $a[1] ?>
					</h4>

					<br>

					<?php
						#2 -> body
						if(strlen($a[2]) > 123)
							echo substr($a[2], 0, 123) . '...';
						else
							echo $a[2];
					?>

				</div>

				<div class="col-sm-12">
					<br> 
				</div>

			<?php else: ?>

				<div class="col-sm-12 nombrePublicacion">

					<br>

					
					<h4 style="font-size:13pt;cursor:pointer"
					 onclick="location.href='<?php Root('comment.php?id=' . $a[0]); ?>'">
					 	<?php #1 -> title ?>
						<?php echo $a[1] ?>
					</h4>

					<br>

					<?php
						#2 -> body
						if(strlen($a[2]) > 123)
							echo substr($a[2], 0, 123) . '...';
						else
							echo $a[2];
					?>

				</div>

				<div class="col-sm-12">
					<br> 
				</div>

			<?php endif; endforeach; endif; if(isset($portada)) unset($portada);

				if(isset($cont) && $cont === 0)
					echo '<div class="col-sm-12 fecha">'
					.'<span style="display:block;text-align:center">'
					. 'No hay comentarios recientes</span></div>';
				elseif(!isset($cont))
					echo '<div class="col-sm-12 fecha">'
					.'<span style="display:block;text-align:center">'
					. 'No se pudo cargar la informacion</span></div>';
			?>

			</div>
		</div>
	</div>

	<div id="contenedorDerecho" class="col-sm-7">
		<div id="misPublicaciones" class="col-sm-12">
			<h3>Publicaciones</h3>

			<br>

			<?php #Verificar si se cargo correctamente la info de la BDD ?>
			<?php if(!isset($msg)):

				//Contador para saber si hay que hacer el salto de linea
				$cont = 0;

				while($table = $conex->getArray()):
					//2 -> body
					if(strpos($table[2], '__') === 0)
					{
						$portada = substr($table[2], 0, strpos($table[2], '__',2)+2);
						$portada = substr($portada, 2, strlen($portada)-4);
						$table[2] = substr($table[2], strpos($table[2], '__',2)+2);
					}
					
					if($cont++ > 0):
			?>

			<!--Esto es un salto de línea-->
			<div class="col-sm-12">
				<br> 
			</div>

			<?php endif; if(!isset($portada)): ?>

			<!--Este es el formato para una publicación sin foto.-->
			<div class="col-sm-12 tituloPublicacion">
				<div class="col-sm-9 titulo" style="cursor:pointer"
					onclick="location.href='<?php Root('comment.php?id='.$table[0]) ?>'">
					<?php #1 -> title ?>
					<h4><?php echo $table[1]; ?></h4>
				</div>

				<div class="col-sm-3 fecha2">
					<?php #3 -> post_date ?>
					<h5><?php echo $table[3]; ?></h5>
				</div>

				<?php
					#2 -> body
					if(strlen($table[2]) <= 123)
						echo $table[2];
					else
						echo substr($table[2], 0, 123) . '...';
				?>
			</div>

		<?php else: ?>

			<!--Este es el formato para una publicación con foto.-->
			<div class="col-sm-12 tituloPublicacion">
				<div class="col-sm-9 titulo" style="cursor:pointer"
					onclick="location.href='<?php Root('comment.php?id='.$table[0]) ?>'">
					<?php #1 -> title ?>
					<h4><?php echo $table[1]; ?></h4>
				</div>

				<div class="col-sm-3 fecha2">
					<?php #3 -> post_date ?>
					<h5><?php echo $table[3]; ?></h5>
				</div>

				<!---//	//	//	//	//	//-->

				<div class="col-sm-3 imagen">
					<img class="img-responsive" src="<?php Root($portada); ?>"
					onerror="this.src = '<?php Root('images/sys/imgnf.jpg') ?>'">
				</div>

				<div class="col-sm-9 parrafo">
					<?php
						#2 -> body
						if(strlen($table[2]) <= 138)
							echo $table[2];
						else
							echo substr($table[2], 0, 138) . '...';
					?>
				</div>
			</div>

		<?php unset($portada); endif; endwhile;

		echo isset($cont) && $cont === 0 ? '<span style="display:block;text-align:center">
				No hay informacion para mostrar!
				</span>': '';

		else: ?>
			<span style="display:block;text-align:center">
				<b>Error: </b><?php echo $msg; ?>
			</span>
		<?php endif; unset($conex); ?>

		</div>
	</div>
</div>