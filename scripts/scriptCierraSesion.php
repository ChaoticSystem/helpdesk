<?php
include 'scriptValidaSession.php';
include '../clases/baseDatos.class.php';

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

if(isset($_SESSION['ticket_usuario'])){
	 
	session_unset();
	 
	session_destroy();
}

header('Location: ../index.php' );

?>