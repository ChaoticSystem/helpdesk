<?php

require ("scriptValidaSession.php");
require ("../clases/ticket.class.php");
require ("../clases/baseDatos.class.php");
require ("../clases/usuario.class.php");
require ("../PHPMailer/class.phpmailer.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_GET['idUser']);

$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

$usuario2 = new Usuario();

$consulta2 = $usuario2->searchUser($conexion, $_SESSION['ticket_id']);

$resultado2 = $consulta2->fetch_array(MYSQLI_ASSOC);

$ticket = new Ticket();

$ticket->setStatus(4);
$ticket->setFecha();
$ticket->changueStatus($conexion, $_GET['id'], 2, $_SESSION['ticket_id']);

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
$mail->Subject = "Ticket ReAbierto #".$_GET['id'];
if($_GET['idUser'] != $_SESSION['ticket_id']){
  $mail->Body = "

  	<div style=\"width: 800px;height: ".(150)."px;border: 1px solid #ddd;border-radius:6px;\">

    <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;\">

          <strong>Su Ticket fue ReAbierto</strong>

           <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

    </div>

    <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

      Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br> Su ticket con id: <strong>".$_GET['id']."</strong> ha sido reabierto por
      <strong>".$resultado2['personaNombre']." ".$resultado2['apellido']."</strong>.
  	<br><br>Departamento de Sistemas

    </div>

  </div>";
}
else{

  $mail->Body = "

    <div style=\"width: 800px;height: ".(150)."px;border: 1px solid #ddd;border-radius:6px;\">

    <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;\">

          <strong>Su Ticket fue ReAbierto</strong>

          <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

    </div>

    <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

      Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br> Su ticket con id: <strong>".$_GET['id']."</strong> ha sido reabierto por su persona.
    <br><br>Departamento de Sistemas

    </div>

  </div>";
}
$mail->CharSet = 'UTF-8';
$mail->AddAddress($resultado['email']);
//$mail->AddAddress(""); si queremos copia
$mail->Send();

header("location: ../checkTicket-1-".$_GET['id']." ");
?>