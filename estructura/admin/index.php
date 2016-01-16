<?php
	session_start();

	//Si ya hay un usuario logueado, redireccionar a la pagina "~/admin/dashboard.php"
	if(isset($_SESSION['usr']))
	{
		header("Location: dashboard.php");
		die();
	}

	$TITLE = 'CMS - Login';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array('myconnection.php');
	include "../include/essentials.php";

	//Verificar si se envio una solicitud de inicio de sesion
	if(isset($_POST['usuario']) && isset($_POST['clave']))
	{
		$_POST['usuario'] = strtolower($_POST['usuario']);

		$usr = strtolower(trim($_POST['usuario']));
		$conex = new myconnection('cmsuser','pass','cms');

		if($conex->conx_err)
			$msg = 'Hubo un error a la hora de realizar la conexion con la Base de Datos.';
		else
		{
			$conex->execute("call Autenticate('$usr','{$_POST['clave']}')");
			if($conex->q_err)
				$msg = 'No se pudo cargar la informacion de la Base de Datos.';
			else
			{
				$resp = $conex->getValue();
				if($resp == -1)
					$msg = 'Usuario/clave incorrecta';
					//$msg = $conex->q_err;
				else
				{$_SESSION['usr'] = $usr;
					$_SESSION['id'] = $resp;
					$_SESSION['name'] = ucfirst($user);

					header('Location: dashboard.php');
				}
			}
		}
		$conex->close();
	}
?>

<link rel="stylesheet" href="<?php Root('css/login.css') ?>">
<form id="form1" method="post"></form>

<div class="col-sm-12">
	
	<h3>Login</h3>
	
	<br>
	
	<?php if(isset($msg)): ?>
		<div class="alert alert-danger col-sm-4 col-sm-offset-4">
			<b>Error:</b> <?php echo $msg; ?>
		</div>
	<?php endif; ?>

	<div id="contenedorLogin"  class="col-sm-4 col-sm-offset-4">
		<div class="form-group">
			<label>Usuario</label>
			<input id="usuario" type="text" class="form-control" name="usuario" autofocus
				form="form1" placeholder="Nombre de usuario">
		</div>
		
		<div class="form-group">
			<label>Clave</label>
			<input id="clave" type="password" class="form-control" name="clave" form="form1"
				placeholder="Palabra clave">
		</div>
		
		<br>
		
		<button class="btn btn-success btn-block btn-lg" form="form1">Ingresar</button>

		<br>

		<a href="">
			¿Olvidó la clave?
		</a>
	</div>
</div>