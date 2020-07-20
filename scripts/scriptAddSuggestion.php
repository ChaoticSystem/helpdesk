<?php

require ("scriptValidaSession.php");
require ("../clases/sugerencia.class.php");
require ("../clases/baseDatos.class.php");
require ("../clases/usuario.class.php");
require ("../PHPMailer/class.phpmailer.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_SESSION['ticket_id']);

$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

$suggestion = new Sugerencia();

$suggestion->setIdUsuario($_SESSION['ticket_id']);
$suggestion->setTitulo($_POST['titulo']);

if(strlen($_POST['otro']) == 0)
  $suggestion->setAplica($_POST['aplica']);
else
  $suggestion->setAplica($_POST['otro']);

$suggestion->setObservacion($_POST['observacion']);
$suggestion->setFecha();
$suggestion->addsuggestion($conexion);
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
$mail->Subject = "Sugerencia";
$mail->Body = "

  <div style=\"width: 800px;height: ".(350+(strlen($_POST['observacion'])/6))."px;border: 1px solid #ddd;border-radius:6px;\">

  <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
  background-color: #f5f5f5;
  border-color: #ddd;padding: 10px 15px;
  border-bottom: 1px solid transparent;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;\">

        <strong>Nueva Sugerencia</strong>

         <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

  </div>

  <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

      Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br> Su sugerencia ha sido enviada con exito al departamento de Sistemas.
  </div>

</div>";
$mail->CharSet = 'UTF-8';
$mail->AddAddress($_SESSION['ticket_email']);
//$mail->AddAddress(""); si queremos copia
$mail->Send();

header("location: ../sugerencias-6");

?>