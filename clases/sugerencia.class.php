<?php

class Sugerencia{

	private $idUsuario;
	private $titulo;
	private $aplica;
	private $observacion;
	private $fecha;
	private $hora;

	function setIdUsuario($idUsuario){

		$this->idUsuario = $idUsuario;
	}

	function setTitulo($titulo){

		$this->titulo = $titulo;
	}

	function setAplica($aplica){

		$this->aplica = $aplica;
	}

	function setObservacion($observacion){

		$this->observacion =$observacion;
	}

	function setFecha(){

		$hora = new DateTime();
		$hora->setTimezone(new DateTimeZone('America/Caracas'));

		$this->fecha 	= date("Y-m-d");
		$this->hora 	= $hora->format("H:i:s");
	}

	function addSuggestion($conexion){

		mysqli_query($conexion, "INSERT INTO sugerencias 
					  (id_usuario, titulo, aplica, observacion, fecha, hora)
					  VALUES(".$this->idUsuario.", '".$this->titulo."', '".$this->aplica."', '".$this->observacion."', '".$this->fecha."', '".$this->hora."')")
					  or die("Error insertando nueva Sugerencia: ".mysqli_error($conexion));
	}

	function listSuggestionAdmin($conexion){

		$consulta = mysqli_query($conexion, "SELECT *, s.id as id_sugerencia FROM sugerencias as s
											 JOIN usuario as u 
											 ON s.id_usuario = u.id
											 JOIN persona as p 
											 ON u.id_persona = p.id") 
											 or die("Error listando Sugerencias: ".mysqli_error($conexion));

		return $consulta;
	}

	function listSuggestion($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT *, s.id as id_sugerencia FROM sugerencias as s
											 JOIN usuario as u 
											 ON s.id_usuario = u.id
											 JOIN persona as p 
											 ON u.id_persona = p.id
											 WHERE u.id = ".$id." ") 
											 or die("Error listando Sugerencias: ".mysqli_error($conexion));

		return $consulta;
	}

	function closeSuggestion($conexion, $id){

		mysqli_query($conexion, "UPDATE 
								 sugerencias 
								 SET 
								 estado = '1'
								 WHERE id = ".$id." ") 
								 or die ("Error cerrando Sugerencia: ".mysqli_error($conexion));
	}
}

?>