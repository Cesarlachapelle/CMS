<?php

$temp = __FILE__;
if($temp != '/')
	$temp = str_replace($_SERVER['DOCUMENT_ROOT'], '', $temp);

if($_SERVER['REQUEST_URI'] == $temp)
	die(
"<html><head>
<title>404 Not Found</title>
</head><body> 
<h1>Not Found</h1>
<p>The requested URL {$_SERVER['PHP_SELF']} was not found on this server.</p>
<hr>
<address>{$_SERVER['SERVER_SIGNATURE']}</address>
</body></html>");

unset($temp);

$TEMP = new Template();

unset($TITLE,$PAGE_CSS,$GLOBAL,$BOOTSTRAP,$JQUERY,$INCL);

class Template
{
	function __construct()
	{
		global $TITLE,$PAGE_CSS,$GLOBAL,$BOOTSTRAP,$JQUERY;
		$CSS = basename($_SERVER['SCRIPT_NAME'],'php') . 'css';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php echo $TITLE; ?></title>
	<link rel="icon" type="image/*" href="<?php Root('images/sys/imagotipo2.png') ?>">
	<?php if($BOOTSTRAP): ?>
	<link rel="stylesheet" href="<?php Root('css/bootstrap.min.css'); ?>">
	<?php endif; if($GLOBAL): ?>
	<link rel="stylesheet" href="<?php Root('css/global.css'); ?>">
	<?php endif; if($PAGE_CSS): ?>
	<link rel="stylesheet" type="text/css" href='<?php Root("css/$CSS"); ?>'>
	<?php endif; if($JQUERY): ?>
	<script type="text/javascript" src='<?php Root("js/jquery.min.js"); ?>'></script>
	<?php endif; ?>
</head>
<body>
	<div id="menu" class="col-sm-12">
		<a href="<?php Root('admin/index.php') ?>">
			<div class="col-sm-2">
				<img class="imgMenu"  src="<?php Root("images/sys/imagotipo1.png") ?>">
			</div>
		</a>
		
	<?php if(isset($_SESSION) && isset($_SESSION['usr'])): ?>
		<a href="<?php Root("admin/newpost.php")?>">
			<div class="col-sm-2 botonMenu">
				<img class="imgMenu" src="<?php Root("images/sys/mas.png") ?>">
				Publicar
			</div>
		</a>
		
		<a href="<?php Root('admin/index.php') ?>">
			<div class="col-sm-2 botonMenu">
				<img class="imgMenu"  src="<?php Root("images/sys/publicaciones.png") ?>">
				Publicaciones
			</div>
		</a>
		
		<a href="<?php Root('index.php') ?>">
			<div class="col-sm-2 botonMenu">
				<img class="imgMenu"  src="<?php Root("images/sys/sitio.png") ?>">
				Ir a sitio
			</div>
		</a>
		
		<div class="col-sm-2 botonMenu">
			<img class="imgMenu"  src="<?php Root("images/sys/notificaciones.png") ?>">
			Notificaciones
		</div>
		<?php #De manera temporal puse el "logout" aqui directamente.
				#Hay que modificarlo luego ?>
		<a href="<?php Root('admin/logout.php'); ?>">
			<div class="col-sm-2 botonMenu">
				<img class="imgMenu"  src="<?php Root("images/sys/usuario.png") ?>">
				Salir
			</div>
		</a>
	<?php #Esto es para que solo aparezca esta opcion si se esta dentro de "~/admin/*" ?>
	<?php elseif(strpos($_SERVER['REQUEST_URI'], 'admin') !== False): ?>
		<a href="<?php Root('admin/'); ?>">
			<div class="col-sm-8">
				<!--Este div no se debe borrar-->
			</div>

			<div class="col-sm-2 botonMenu">
			<img class="imgMenu"  src="<?php Root("images/sys/usuario.png") ?>">
				Iniciar sesión
			</div>
		</a>
	<?php endif; ?>
	</div>
<?php

	}

	function __destruct()
	{
?>
	<div id="footer" class="col-sm-12">
		<h6>CMS &#169; Programación web</h6>
		<h6>ITLA 2015</h6>

		<div class="col-sm-3">
			<!--Este div no se debe borrar.-->
		</div>


		<div class="col-sm-2 nombres">
			Ismael Febles
			<br>
			2014-2228 
		</div>

		<div class="col-sm-2 nombres">
			 Wilkin Vásquez 
			 <br>
			 2013-1954
		</div>

		<div class="col-sm-2 nombres">
			César Lachapelle
			<br>
			2013-1971
		</div>

		<div class="col-sm-3">
			<!--Este div no se debe borrar.-->
		</div>
	</div>
</body>
</html>
<?php
	}
}
?>