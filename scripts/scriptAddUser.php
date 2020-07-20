<?php

require ("scriptValidaSession.php");
require ("../clases/usuario.class.php");
require ("../clases/baseDatos.class.php");
require ("../PHPMailer/class.phpmailer.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$clave = $usuario->randomPassword();

$usuario->setNombre($_POST['nombre']);
$usuario->setApellido($_POST['apellido']);
$usuario->setCedula($_POST['cedula']);
$usuario->setEmail($_POST['email']);
$usuario->setNombreUsuario($_POST['nombreUsuario']);
$usuario->setClave(md5($clave));
$usuario->setTipo($_POST['tipo']);
$usuario->setPlataforma(isset($_POST['plataforma']) ? 1 : 0);
$usuario->setDepartamento($_POST['departamento']);
$usuario->setFecha();
$usuario->addUser($conexion, $_SESSION['ticket_id']);

$conexion->close();

//Envio de correo electronico al usuario

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail/ tls
$mail->Host = "";
$mail->Port = 465;// or 587
$mail->IsHTML(true);
$mail->Username = "";
$mail->Password = "";
$mail->SetFrom("","Sistemas");
$mail->Subject = "Nuevo Usuario en la Herramienta de Soporte";
$mail->Body = "

	<div style=\"width: 800px;height: ".(250)."px;border: 1px solid #ddd;border-radius:6px;\">

  <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
  background-color: #f5f5f5;
  border-color: #ddd;padding: 10px 15px;
  border-bottom: 1px solid transparent;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;\">

        <strong>Nuevo Usuario</strong>

        <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

  </div>

  <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

	Hola <strong>".$_POST['nombre']." ".$_POST['apellido']."</strong>,<br> Su nuevo Usuario ha sido creado satisfactoriamente en la Herramienta de
	Soporte, su usuario para acceder a nuestro sismtema es <strong>".$_POST['nombreUsuario']."</strong> y su clave <strong>".$clave."</strong>. Recordandole
	que al acceder por primera vez al sistema debe cambiar su contraseña ya que la enviada es temporal y luego cambiada no debe conceder su usuario ni clave a ninguna otra persona, 
	usted es el unico responsable sobre su cuenta.<br><br>Saludos. 
	<br>Departamento de Sistemas.

  </div>

</div>";
$mail->CharSet = 'UTF-8';
$mail->AddAddress($_POST['email']);//mail nuevo usuario
$mail->Send();

header("location: ../usuarios-3");
?>