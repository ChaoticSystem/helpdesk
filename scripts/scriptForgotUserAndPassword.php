<?php

require ("../clases/usuario.class.php");
require ("../clases/baseDatos.class.php");
require ("../PHPMailer/class.phpmailer.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$usuario->setEmail($_POST['email']);

$clave = $usuario->randomPassword();

if($usuario->searchEmail($conexion)){

	$consulta = $usuario->searchForEmail($conexion);

	$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

	//Envio de correo electronico al usuario

	$mail = new PHPMailer(); // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug 	= 0; // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth 	= true; // authentication enabled
	$mail->SMTPSecure 	= 'ssl'; // secure transfer enabled REQUIRED for GMail/ tls
	$mail->Host 		= "";
	$mail->Port 		= 465;// or 587
	$mail->IsHTML(true);
	$mail->Username 	= "";
	$mail->Password 	= "";
	$mail->SetFrom("","Sistemas");
	$mail->Subject 		= "Recuperacion de Usuario o Contraseña.";
	$mail->Body 		= "Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong> su Usuario es : <strong>".$resultado['usuarioNombre']."</strong>
						   y su clave provisional es: <strong>".$clave."</strong> la cual debe cambiar al acceder nuevamente al sistema. 
						   <br><br>Departamento de Sistemas";
	$mail->Body = "

	<div style=\"width: 800px;height: ".(150)."px;border: 1px solid #ddd;border-radius:6px;\">

	  <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
	  background-color: #f5f5f5;
	  border-color: #ddd;padding: 10px 15px;
	  border-bottom: 1px solid transparent;
	  border-top-left-radius: 3px;
	  border-top-right-radius: 3px;\">

	        <strong>Usuario y Contraseña</strong>

	        <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

	  </div>

	  <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

		Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br> Su Usuario es : <strong>".$resultado['usuarioNombre']."</strong>
		y su clave provisional es: <strong>".$clave."</strong> la cual debe cambiar al acceder nuevamente al sistema. 
		<br><br>Departamento de Sistemas.

	  </div>

	</div>";
	$mail->CharSet = 'UTF-8';
	$mail->AddAddress($resultado['email']);//mail usuario
	$mail->Send();

	$usuario->resetForEmail($conexion, md5($clave));

	header("location: ../index-1");
}
else
	header("location: ../index-0");



$conexion->close();

?>