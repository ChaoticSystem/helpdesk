<?php
require ("../clases/usuario.class.php");
require ("../clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario 	= new Usuario();

$consulta 	= $usuario->searchUser($conexion, $_GET['id']);

if(mysqli_num_rows($consulta) == 0) die ("Error no se encontro el usuario con id: ".$_GET['id']);

$resultado 	= $consulta->fetch_array(MYSQLI_ASSOC);

if($resultado['activo']==1)
	$usuario->deactivate($conexion, $resultado['idUsuario']);
elseif($resultado['activo']==0)
	$usuario->active($conexion, $resultado['idUsuario']);

$conexion->close();

header("location: ../usuarios-3");
?>