<?php

session_start();

require ("../clases/usuario.class.php");
require ("../clases/ticket.class.php");
require ("../clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

if(isset($_POST['usuario'])){

	$usuario = new Usuario();

	$consulta = $usuario->validaUsuario($conexion, addslashes($_POST['usuario']), md5($_POST['clave']));

	$valido = $consulta->num_rows;

	if($valido){

		$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

		if($resultado['activo']){

			$_SESSION['ticket_usuario'] 			= $resultado['usuarioNombre'];

			$_SESSION['ticket_tipo']				= $resultado['tipo'];

			$_SESSION['ticket_activo']				= $resultado['activo'];

			$_SESSION['ticket_id']					= $resultado['usuarioId'];

			$_SESSION['ticket_id_departamento'] 	= $resultado['id_departamento'];

			$_SESSION['ticket_email'] 				= $resultado['email'];

			$_SESSION['ticket_id_cede'] 			= $resultado['id_cede'];

			$_SESSION['ticket_plataforma'] 			= $resultado['plataforma'];

			if($resultado['primer_login']){
				$ticket = new Ticket();
				$ticket->setFecha();
				$ticket->closeInactivity($conexion);
				header("location: ../inicio-5");
			}
			else
				header("location: ../changuePass.php");
		}
		else
			header("location: ../index.php?error=2");
		
	}
	else
		header("location: ../index.php?error=1");
}
		

?>