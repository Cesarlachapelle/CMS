<?php
	session_start();

	$TITLE = 'CMS - Crear usuario';
	$PAGE_CSS = true;
	$GLOBAL = true;
	$BOOTSTRAP = true;
	$JQUERY = true;
	$INCL = array('myconnection.php');
	include "../include/essentials.php";
?>
<?php

	if(isset($_POST['usuario']))
	{
		$conex = new myconnection("cmsuser","pass","cms");

		if ($conex->conx_err)
			$msg="error al conectar a la base de datos";
		else{
			$conex->execute("call CreateUsers('" . $_POST['usuario'] . "," . $_POST['clave'] . "," . $_POST['email'] . "')");
	}
	}
	/*if (isset($_POST)) {
		echo "debe llenar los campos";
	}
	elseif ($_POST['clave']==$_POST['conclave']) {
		# code...
		$conex = new myconnection("cmsuser","pass","cms");
	if ($conex->conx_err)
		$msg="error al conectar a la base de datos";
	else{
		$conex->execute("call CreateUsers('" . $_POST['usuario'] . "," . $_POST['clave'] . "," . $_POST['email'] . "')");
	}

	}*/
	

 ?>

<?php #A esta pagina solo tiene acceso el usuario administrador ("admin") ?>

<div id="center_body" style="margin:10px">
	<div class="container">
		<div class="text-center"><h1>registrarse</h1></div>		

	<div class="col-sm-4 col-sm-offset-4">
		<form method="post" name="formulario" action="create.php">
			<div class="form-group">
			
			<label for="nombre">Usuario</label>
				<input type="text" class="form-control" placeholder="" required name="usuario">
			</div>	
			<div class="form-group">
			<label for="apellido">Correo</label>
				<input type="email" class="form-control" placeholder="ejemplo@ejemplo.com" required name="email">
			</div>
			<div class="form-group">
			<label for="nombre">Nombre</label>
				<input type="text" class="form-control" placeholder="" required name="nombre">
			</div>
			<div class="form-group">
			<label for="nombre">Apellido</label>
				<input type="text" class="form-control" placeholder="" required name="apellido">
			</div>
			<div class="form-group">
			<label for="nombre">clave </label>
				<input type="password" class="form-control" placeholder="" required name="clave">
			</div>
			<div class="form-group">
			<label for="nombre">confirmar la clave </label>
				<input type="password" class="form-control" placeholder="" required name="conclave">
			</div>
			
			<div class="form-group">
				<input type="submit" class="form-control btn btn-primary" >
			</div>
			</form>
			</div>
	</div>

</body>
</html>
	<!--code-->
</div>