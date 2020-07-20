<?php

class Ticket{

	private $idUsuario;
	private $tipoSolicitud;
	private $prioridad;
	private $titulo;
	private $observacion;
	private $archivo;
	private $status;
	public 	$fecha;
	private $respuesta;
	public 	$hora;

	function setIdUsuario($idUsuario){

		$this->idUsuario = $idUsuario;
	}

	function setTipoSolicitud($TipoSolicitud){

		$this->tipoSolicitud = $TipoSolicitud;
	}

	function setPrioridad($Prioridad){

		$this->prioridad = $Prioridad;
	}

	function setTitulo($Titulo){

		$this->titulo = $Titulo;
	}

	function setObservacion($Observacion){

		$this->observacion = $Observacion;
	}

	function setArchivo($Archivo, $conexion){

		$this->archivo = $Archivo;

		$consulta = mysqli_query($conexion,"UPDATE ticket SET archivo='".$this->archivo."' WHERE id=".mysqli_insert_id($conexion)." ");
	}

	function setStatus($Status){

		$this->status = $Status;
	}

	function setFecha(){

		$hora = new DateTime();
		$hora->setTimezone(new DateTimeZone('America/Caracas'));

		$this->fecha 	= date("Y-m-d");
		$this->hora 	= $hora->format("H:i:s");
	}

	function setRespuesta($respuesta){

		$this->respuesta = $respuesta;
	}

	function getId($conexion){

		return mysqli_insert_id($conexion);
	}

	function addTicket($conexion){

		mysqli_query($conexion, "INSERT INTO ticket (id_usuario, tipo_solicitud, prioridad, titulo, observacion, status, fecha_creacion, hora_creacion)
								 VALUES ('".$this->idUsuario."', '".$this->tipoSolicitud."', '".$this->prioridad."', '".$this->titulo."',
								 		 '".$this->observacion."', '".$this->status."', '".$this->fecha."', '".$this->hora."')")
								 or die("Error insertando nuevo Ticket: ".mysqli_error($conexion));
	}

	function listTicketUnrevised($conexion){

		$consulta = mysqli_query($conexion, "SELECT * FROM ticket WHERE status <> '3' ORDER BY id DESC") or die("Error listanto Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketUnrevisedSupervisor($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT *, t.id as id_ticket, u.id as user_id, t.fecha_creacion as t_fcreacion, t.hora_creacion as t_hcreacion
											 FROM ticket as t
											 JOIN usuario AS u
											 ON t.id_usuario = u.id
											 WHERE t.status <> '3' AND u.id_departamento = ".$id." ORDER BY t.id DESC ") 
											 or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketUnrevisedGerente($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT *, t.id as id_ticket, u.id as user_id, t.fecha_creacion as t_fcreacion, t.hora_creacion as t_hcreacion
											 FROM ticket as t
											 JOIN usuario AS u
											 ON t.id_usuario = u.id
											 JOIN departamento as d
											 ON u.id_departamento = d.id
											 WHERE t.status <> '3' AND d.id_cede = '".$id."' ORDER BY t.id DESC ") 
											 or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketUnrevisedEmpleado($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT * FROM ticket WHERE status <> '3'  AND id_usuario = ".$id." ORDER BY id DESC ") 
											 or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketClose($conexion){

		$consulta = mysqli_query($conexion, "SELECT *, ticket.fecha_creacion as t_fcreacion, ticket.hora_creacion as t_hcreacion
											 FROM ticket WHERE status = '3' ORDER BY id DESC ") or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketCloseSupervisor($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT *, t.id as id_ticket, u.id as user_id, t.fecha_creacion as t_fcreacion, t.hora_creacion as t_hcreacion
											 FROM ticket as t
											 JOIN usuario AS u
											 ON t.id_usuario = u.id
											 WHERE t.status = '3' AND u.id_departamento = ".$id." ORDER BY t.id DESC ") 
											 or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketCloseGerente($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT *, t.id as id_ticket, u.id as user_id, t.fecha_creacion as t_fcreacion, t.hora_creacion as t_hcreacion
											 FROM ticket as t
											 JOIN usuario AS u
											 ON t.id_usuario = u.id
											 JOIN departamento as d
											 ON u.id_departamento = d.id
											 WHERE t.status = '3' AND d.id_cede = '".$id."' ORDER BY t.id DESC ") 
											 or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function listTicketCloseEmpleado($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT *, ticket.fecha_creacion as t_fcreacion, ticket.hora_creacion as t_hcreacion
											 FROM ticket WHERE status = '3' AND id_usuario = ".$id." ORDER BY id DESC ") 
											 or die("Error listando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function searchTicket($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT * FROM ticket WHERE id = ".$id." ") or die("Error buscando Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function changueStatus($conexion, $id, $modo, $id_usuario){

		if(!$modo)
			mysqli_query($conexion, "UPDATE 
									 ticket 
									 SET 
									 status 				= '".$this->status."', 
									 id_usuario_cerrador 	= ".$id_usuario.", 
									 fecha_cierre 			= '".$this->fecha."',
									 hora_cierre 			= '".$this->hora."'
									 WHERE id 				= ".$id." ") 
									 or die ("Error Cerrando Ticket: ".mysqli_error($conexion));
		elseif($modo == 1)
			mysqli_query($conexion, "UPDATE 
									 ticket 
									 SET 
									 status 			= '".$this->status."', 
									 fecha_revicion 	= '".$this->fecha."',
									 hora_revicion 		= '".$this->hora."'
									 WHERE id 			= ".$id." ")
									 or die ("Error Revisando Ticket: ".mysqli_error($conexion));
		elseif($modo == 2)
			mysqli_query($conexion, "UPDATE 
									 ticket 
									 SET 
									 status 					= '".$this->status."', 
									 id_usuario_reaperturador 	= ".$id_usuario.",
									 fecha_reapertura 			= '".$this->fecha."',
									 hora_reapertura 			= '".$this->hora."'
									 WHERE id 					= ".$id." ") 
									 or die ("Error Reabriendo Ticket: ".mysqli_error($conexion));
		elseif($modo == 3)
			mysqli_query($conexion, "UPDATE 
									 ticket 
									 SET 
									 status 					= '".$this->status."'
									 WHERE id 					= ".$id." ") 
									 or die ("Error Reabriendo Ticket: ".mysqli_error($conexion));
		elseif($modo == 4)
			mysqli_query($conexion, "UPDATE 
									 ticket 
									 SET 
									 status 					= '".$this->status."', 
									 id_usuario_autoriza	 	= ".$id_usuario.",
									 fecha_autoriza 			= '".$this->fecha."',
									 hora_autoriza 				= '".$this->hora."',
									 autorizado 				= 1
									 WHERE id 					= ".$id." ") 
									 or die ("Error Reabriendo Ticket: ".mysqli_error($conexion));
		elseif($modo == 5)
			mysqli_query($conexion, "UPDATE 
									 ticket 
									 SET 
									 status 					= '".$this->status."', 
									 id_usuario_autoriza	 	= ".$id_usuario.",
									 fecha_autoriza 			= '".$this->fecha."',
									 hora_autoriza 				= '".$this->hora."'
									 WHERE id 					= ".$id." ") 
									 or die ("Error Reabriendo Ticket: ".mysqli_error($conexion));
	}

	function addResponse($conexion, $id_ticket){

		mysqli_query($conexion, "INSERT INTO respuestas (id_ticket, id_usuario, respuesta, fecha, hora) 
								 VALUES (".$id_ticket.", ".$this->idUsuario.", '".$this->respuesta."', '".$this->fecha."', '".$this->hora."')") 
								 or die("Error Insertando Respuesta: ".mysqli_error($conexion));
	}

	function listResponse($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT * FROM respuestas WHERE id_ticket = ".$id." ") or die("Error Listando Respuestas: ".mysqli_error($conexion));

		return $consulta;
	}

	function numSlope($conexion, $id){

		$consulta = mysqli_query($conexion, "SELECT * FROM ticket WHERE id_usuario = ".$id." AND status = '5' ") or die("Error Listando Respuestas: ".mysqli_error($conexion));
		return $consulta;
	}

	function listTicketRefresh($conexion){

		$consulta = mysqli_query($conexion, "SELECT * FROM ticket WHERE status = '1' ORDER BY id DESC") or die("Error listanto Ticket: ".mysqli_error($conexion));

		return $consulta;
	}

	function filtro($conexion){

		$this->idUsuario > 0 ? $usuario = "id_usuario = '".$this->idUsuario."'" : $usuario = '';

		$this->tipoSolicitud > 0 ? $solicitud = "tipo_solicitud = '".$this->tipoSolicitud."'" : $solicitud = '';

		strlen($this->titulo) > 0 ? $titulo = "titulo LIKE '%".$this->titulo."%'" : $titulo = '';

		strlen($this->observacion) > 0 ? $observacion = "observacion LIKE '%".$this->observacion."%'" : $observacion = '';

		if((strlen($solicitud)>0 || strlen($titulo)>0 || strlen($observacion)>0) && strlen($usuario)>0)
			$usuario.=' AND';
		if((strlen($titulo)>0 || strlen($observacion)>0) && strlen($solicitud)>0)
			$solicitud.=' AND';
		if(strlen($observacion)>0 && strlen($titulo)>0)
			$titulo.=' AND';

		if(strlen($usuario)>0 || strlen($solicitud)>0 || strlen($titulo)>0 || strlen($observacion)>0){

			$consulta = mysqli_query($conexion, "SELECT * FROM ticket
												 WHERE
												 ".$usuario." 
												 ".$solicitud." 
												 ".$titulo." 
												 ".$observacion." 
								    ") or die("Error filtrando: ".mysqli_error($conexion));
			return $consulta;
		}else{

			$consulta = mysqli_query($conexion, "SELECT * FROM ticket") or die("Error filtrando: ".mysqli_error($conexion));

			return $consulta;
		}
	}

	function closeInactivity($conexion){

		mysqli_query($conexion, "UPDATE ticket
								 set 
								 status 				= '3', 
								 id_usuario_cerrador 	= 777, 
								 fecha_cierre 			= '".$this->fecha."',
								 hora_cierre 			= '".$this->hora."'
								 WHERE TIMESTAMPDIFF(DAY, fecha_creacion, CURDATE()) >= 3 
								 AND status = '5'")  
								 or die("Error en cierre de tickets por inactividad: ".mysqli_error($conexion));
	}

	function informar($conexion, $id){

		mysqli_query($conexion, "UPDATE ticket
								 set 
								 informe = 1
								 WHERE id = ".$id."")  
								 or die("Error enviando informe: ".mysqli_error($conexion));
	}
}

?>