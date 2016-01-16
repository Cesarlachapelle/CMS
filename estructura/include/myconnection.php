<?php

class myconnection
{
	//Variable de conexion
	var $conex;
	//Variable que almacena el resultado de una consulta
	var $q_res;
	//Variable que notifica si hubo algun error en la conexion a la Base de Datos
	var $conx_err = false;
	//Variable para notificar si hubo un error a la hora de ejecutar un query
	var $q_err = false;

	//Constructor para incializar la conexion.
	//Orden: usuario, clave, nombre de la BD, y (opcional) direccion del servidor
	function __construct($usr,$pass,$db,$srv='localhost')
	{
		$this->conex = new mysqli($srv,$usr,$pass,$db);
		if($this->conex->connect_error)
			$this->conx_err = $this->conex->connect_error;
	}

	//Funcion para ejecutar codigo sql.
	//Se puede tomar el valor de retorno que es el resultado de la consulta,
	//pero no es necesario.
	function execute($comm)
	{
		if($this->conx_err !== false)
			return;

		$this->q_res = null;

		$res = $this->conex->query($comm);

		if($this->q_err = $this->conex->error)
			return $res;

		return $this->q_res = $res;
	}

	//Devuelve una fila completa de la consulta de una tabla como un array.
	//Es una funcion privada.
	private function getRow($row)
	{
		$res = array();

		foreach($row as $a)
			$res[] = $a;

		return $res;
	}

	//Si el resultado de la consulta posee solo una "columna", pues devuelve los valores
	//de manera individual, sino, devuelve la fila completa como un array.
	function getValue()
	{
		if($this->q_err || !$this->q_res)
			return;

		if($row = $this->q_res->fetch_assoc())
		{
			if(count($row) > 1)
				return $this->getRow($row);
			elseif(count($row) === 1)
				foreach ($row as $a) 
					return $a;
			else
				return;
		}
		else
			return $this->q_res = null;
	}

	//Funcion para devolver una fila completa de una consulta, siempre en forma de array
	function getArray()
	{
		if($this->q_err || !$this->q_res)
			return;

		if($row = $this->q_res->fetch_assoc())
			return $this->getRow($row);
		else
			return $this->q_res = null;
	}

	//Funcion que devuelve el resultado de una consulta como una tabla
	//en forma de array de arrays [[][]]
	function getTable()
	{
		if($this->q_err || !$this->q_res)
			return;

		if($this->q_res->num_rows === 1)
			return $this->q_res->fetch_assoc();

		$res = array();

		while($row = $this->q_res->fetch_assoc())
			foreach($row as $k => $a)
				$res[$k][] = $a;

		$this->q_res = null;

		return $res;
	}

	//Funcion que retorna la consulta de manera normal
	function getRaw()
	{
		if($this->q_err || !$this->q_res)
			return;

		if($row = $this->q_res->fetch_assoc())
			return $row;
		else
			return $this->q_res = null;
	}

	//Cierra la variable de conexion
	function close()
	{
		if(!$this->conx_err)
			$this->conex->close();
		unset($this->conex);
		unset($this->q_res);
		unset($this->conx_err);
		unset($this->q_err);
	}

	//Destructor para cerrar la conexion en caso de que no se haya llamado a la funcion "close"
	function __destruct()
	{
		if(isset($this->conex))
			$this->conex->close();
	}
}