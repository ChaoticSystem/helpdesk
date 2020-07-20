<?php

require ("../clases/usuario.class.php");
require ("../clases/baseDatos.class.php");
require ("../PHPMailer/class.phpmailer.php");
require ("scriptValidaSession.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$usuario->setClave(md5($_POST['clave']));
$usuario->firstSession($conexion, $_SESSION['ticket_id']);

$conexion->close();

header("location: ../inicio-5");
?>