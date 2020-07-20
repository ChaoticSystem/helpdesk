<?php

class Departamento{

	private $cede;
	private $nombre;
	private $fecha;
	private $hora;

	function setCede($cede){

		$this->cede = $cede;
	}

	function setNombre($nombre){

		$this->nombre = $nombre;
	}

	function setFecha(){

		$hora = new DateTime();
		$hora->setTimezone(new DateTimeZone('America/Caracas'));

		$this->fecha 	= date("Y-m-d");
		$this->hora 	= $hora->format("H:i:s");
	}

	function addDepartament($conexion, $id){

		mysqli_query($conexion, "INSERT INTO departamento (id_cede, nombre, id_usuario_creador, hora_creacion, fecha_creacion) 
								 values('".$this->cede."', '".$this->nombre."', ".$id.", '".$this->hora."', '".$this->fecha."') ")
								 or die("Error Insertando Departamento: ".mysqli_error($conexion));
	}

	function listDepartament($conexion, $cede){

		$consulta = mysqli_query($conexion, "SELECT * FROM departamento WHERE id_cede=".$cede." ") 
											 or die("Error Listando Departamento: ".mysqli_error($conexion));

		return $consulta;
	}

	function searchDepartament($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT * FROM departamento WHERE id=".$id." ") 
											 or die("Error Buscando Departamento: ".mysqli_error($conexion));

		return $consulta;
	}

	function editDepartament($conexion, $id, $id_usuario){

		$consulta = mysqli_query($conexion, "UPDATE 
											 departamento 
											 SET 
											 nombre 				= '".$this->nombre."',
											 id_usuario_modificador = ".$id_usuario.",
											 hora_modificacion		= '".$this->hora."',
											 fecha_modificacion		= '".$this->fecha."'
											 WHERE id= ".$id." ") 
								  or die("Error Editando Departamento: ".mysqli_error($conexion));
	}
}

?>