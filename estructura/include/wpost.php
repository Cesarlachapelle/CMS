
<?php
	class Post{
		public $id;
		public $title;
		public $body;
		public $post_date;
		public $category;
		public $id_acc;

		function guardar(){
			$sql = "INSERT INTO `post` (`title`,`body`,`post_date`,`category`,`id_acc`)
			 VALUES ('{$this->title}','{$this->body}','{$this->post_date}','{$this->category}','{$this->id_acc}')";

			$con = Conexion::obtenerConexion();

			mysqli_query($con, $sql);
		}

		function obtenerID(){
			$sql = "select (select id from post order by id desc limit 1) + 1 as 'id'";
			$con = Conexion::obtenerConexion();
			$rs = mysqli_query($con, $sql);
			$temp = mysqli_fetch_assoc($rs);

			return $temp['id'];
			//return mysqli_fetch_assoc($rs)['id'];
		}

		function obtenerPost($idPost){
			$sql = "select body where id = {$idPost}";
			$con = Conexion::obtenerConexion();
			$rs = mysqli_query($con, $sql);
			$temp = mysqli_fetch_assoc($rs);

			return $temp['id'];
		}

		function editar($idPost){
			$sql = "";
			$con = Conexion::obtenerConexion();
			$rs = mysqli_query($con, $sql);
		}
	}
?>