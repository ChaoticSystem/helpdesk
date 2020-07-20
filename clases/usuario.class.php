<?php

class Usuario{

	private $nombre;
	private $apellido;
	private $cedula;
	private $email;
	private $nombreUsuario;
	private $clave;
	private $tipo;
	private $plataforma;
	private $departamento;
	private $fecha;
	private $hora;

	function setNombre($nombre){

		$this->nombre = $nombre;
	}

	function setApellido($apellido){

		$this->apellido = $apellido;
	}

	function setCedula($cedula){

		$this->cedula = $cedula;
	}

	function setEmail($email){

		$this->email = $email;
	}

	function setNombreUsuario($nombreUsuario){

		$this->nombreUsuario = $nombreUsuario;
	}

	function setClave($clave){

		$this->clave = $clave;
	}

	function setTipo($tipo){

		$this->tipo = $tipo;
	}

	function setPlataforma($plataforma){

		$this->plataforma = $plataforma;
	}

	function setDepartamento($departamento){

		$this->departamento = $departamento;
	}

	function setFecha(){

		$hora = new DateTime();
		$hora->setTimezone(new DateTimeZone('America/Caracas'));

		$this->fecha 	= date("Y-m-d");
		$this->hora 	= $hora->format("H:i:s");
	}

	function addUser($conexion, $id){

		mysqli_query($conexion, "INSERT INTO persona (nombre, apellido, cedula, email) 
								 values('".$this->nombre."', '".$this->apellido."', '".$this->cedula."', '".$this->email."')")
								 or die("Error insertando nueva Persona: ".mysqli_error($conexion));

		mysqli_query($conexion, "INSERT INTO usuario (id_persona, id_departamento, nombre, clave, tipo, id_usuario_creador, hora_creacion, fecha_creacion, plataforma) 
								 values(".mysqli_insert_id($conexion).", ".$this->departamento.", '".$this->nombreUsuario."', '".$this->clave."', '".$this->tipo."'
								 		, ".$id.", '".$this->hora."', '".$this->fecha."', ".$this->plataforma.")")
								 or die("Error insertando nuevo Usuario: ".mysqli_error($conexion));
	}

	function listUser($conexion){

		$consulta = (mysqli_query($conexion, "SELECT *, p.nombre as personaNombre, p.id as idPersona, d.nombre as nombreDepartamento, u.id as idUsuario, u.nombre as nombreUsuario
											  FROM persona as p
											  JOIN usuario as u
											  on p.id = u.id_persona
											  JOIN departamento as d
											  on u.id_departamento = d.id
											  ORDER BY p.nombre ASC")) or die("Error listando Usuarios: ".mysqli_error($conexion));
		
		return $consulta;
	}

	function listUserPersonal($conexion, $id){

		$consulta = (mysqli_query($conexion, "SELECT *, p.nombre as personaNombre, p.id as idPersona, d.nombre as nombreDepartamento, u.id as idUsuario, u.nombre as nombreUsuario
											  FROM persona as p
											  JOIN usuario as u
											  on p.id = u.id_persona
											  JOIN departamento as d
											  on u.id_departamento = d.id
											  WHERE u.id = ".$id." ")) or die("Error listando Usuarios: ".mysqli_error($conexion));
		
		return $consulta;
	}

	function listUserForDepartament($conexion, $departamento){

		$consulta = (mysqli_query($conexion, "SELECT *, p.nombre as personaNombre, p.id as idPersona, d.nombre as nombreDepartamento, u.nombre as nombreUsuario
											  FROM persona as p
											  JOIN usuario as u
											  on p.id = u.id_persona
											  JOIN departamento as d
											  on u.id_departamento = d.id
											  WHERE id_departamento = ".$departamento." ")) 
											  or die("Error listando Usuarios: ".mysqli_error($conexion));
		
		return $consulta;
	}

	function searchUser($conexion, $id){

		$consulta = (mysqli_query($conexion, "SELECT *, p.nombre as personaNombre, p.id as idPersona, d.nombre as nombreDepartamento, u.id as idUsuario, u.nombre as nombreUsuario
											  FROM persona as p
											  JOIN usuario as u
											  on p.id = u.id_persona
											  JOIN departamento as d
											  on u.id_departamento = d.id
											  WHERE u.id = ".$id." ")) or die("Error buscando Usuarios: ".mysqli_error($conexion));
		
		return $consulta;
	}

	function editUser($conexion, $id, $id_usuario){

		mysqli_query($conexion, "UPDATE persona 
				      SET nombre ='".$this->nombre."', apellido='".$this->apellido."', cedula='".$this->cedula."',
				      email='".$this->email."' WHERE id=".$id." ") or die("Error editando Persona: ".mysqli_error($conexion));

		mysqli_query($conexion, "UPDATE usuario 
				      			SET 
				      			tipo 					='".$this->tipo."',
				      			plataforma 				= ".$this->plataforma.",
				      			id_usuario_modificador	=".$id_usuario.",
				      			hora_modificacion		='".$this->hora."',
				      			fecha_modificacion		='".$this->fecha."'
				      			WHERE id_persona		=".$id." ") 
								or die("Error editando Usuario: ".mysqli_error($conexion));
	}

	function deactivate($conexion, $id){
		
		mysqli_query($conexion, "UPDATE usuario SET activo = '0' WHERE id=".$id."") or die("Error Desactivando Usuario: ".mysqli_error($conexion));
	}

	function active($conexion, $id){
		
		mysqli_query($conexion, "UPDATE usuario SET activo = '1' WHERE id=".$id."") or die("Error Activando Usuario: ".mysqli_error($conexion));
	}

	function validaUsuario($conexion, $usuario, $clave){

		$consulta = mysqli_query($conexion, "SELECT *, p.nombre as personaNombre, u.nombre usuarioNombre, p.id as personaId, u.id as usuarioId
											 FROM usuario as u
											 JOIN persona as p
											 ON u.id_persona = p.id
											 JOIN departamento as d
											 ON u.id_departamento = d.id
											 WHERE u.nombre = '".$usuario."' AND clave = '".$clave."' ") 
											 or die("Error Validando: ".mysqli_error($conexion));

		return $consulta;
	}

	function firstSession($conexion, $id){

		mysqli_query($conexion, "UPDATE usuario SET clave = '".$this->clave."', primer_login = '1' WHERE id = ".$id."") or die("Error: ".mysqli_error($conexion));
	}

	function resetUser($conexion, $id){

		mysqli_query($conexion, "UPDATE usuario SET clave = 'e10adc3949ba59abbe56e057f20f883e', primer_login = '0' WHERE id = ".$id."") or die("Error: ".mysqli_error($conexion));
	}

	function searchEmail($conexion){

		$consulta = mysqli_query($conexion, "SELECT email FROM persona WHERE email = '".$this->email."' ");

		return $consulta->num_rows;
	}

	function randomPassword($length=6,$uc=TRUE,$n=TRUE,$sc=FALSE){

		$source = 'abcdefghijklmnopqrstuvwxyz';
	    if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    if($n==1) $source .= '1234567890';
	    if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
	    if($length>0){
	        $rstr = "";
	        $source = str_split($source,1);
	        for($i=1; $i<=$length; $i++){
	            mt_srand((double)microtime() * 1000000);
	            $num = mt_rand(1,count($source));
	            $rstr .= $source[$num-1];
	        }
	 
	    }

	    return $rstr;
	}

	function resetForEmail($conexion, $clave){

		mysqli_query($conexion, "UPDATE usuario
								 JOIN persona
								 on usuario.id_persona = persona.id 
								 SET usuario.clave = '".$clave."', primer_login = '0' 
								 WHERE persona.email = '".$this->email."'") or die("Error: ".mysqli_error($conexion));
	}

	function searchForEmail($conexion){

		$consulta = mysqli_query($conexion, "SELECT *, p.nombre as personaNombre, u.nombre usuarioNombre, p.id as personaId, u.id as usuarioId
											 FROM usuario as u
											 JOIN persona as p
											 ON u.id_persona = p.id
											 WHERE p.email = '".$this->email."' ") 
											 or die("Error Validando: ".mysqli_error($conexion));

		return $consulta;
	}
}

?>