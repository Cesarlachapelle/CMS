
<?php
	class Instancia{
		public $con;

		function __construct(){
			$this->con = mysqli_connect("localhost","cmsuser","pass","cms") or die("Falló conexión.");
		}

		function __destruct(){
			mysqli_close($this->con);
		}
	}

	class Conexion{
		public static $instancia = null;

		static function obtenerConexion(){
			if(Conexion::$instancia == null){
				Conexion::$instancia = new Instancia();
			}

			return Conexion::$instancia->con;
		}
	}
?>