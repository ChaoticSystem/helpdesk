<?php

require ("scriptValidaSession.php");
require ("../clases/ticket.class.php");
require ("../clases/baseDatos.class.php");
require ("../clases/usuario.class.php");
require ("../PHPMailer/class.phpmailer.php");

if(strlen($_FILES['archivo']['name'])){

	$archivo = $_FILES['archivo']['name']; 
	$trozos = explode(".", $archivo); 
	$extension = end($trozos);

	if($extension != "png" && $extension != "PNG" && $extension != "jpg" && $extension != "JPG" && $extension != "jpeg" && $extension != "JPEG"){

		header("location: ../addTicket.php?active=0&archivo=0");
		exit;
	}

  if($_FILES['archivo']['size'] > 2000000){

    header("location: ../addTicket.php?active=0&archivo=1");
    exit;
  }

}

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_SESSION['ticket_id']);

$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

$ticket = new Ticket();

$ticket->setIdUsuario($_SESSION['ticket_id']);
$ticket->setTipoSolicitud($_POST['solicitud']);
$ticket->setPrioridad($_POST['prioridad']);
$ticket->setTitulo($_POST['titulo']);
$ticket->setObservacion($_POST['observacion']);
$ticket->setStatus(1);
$ticket->setFecha();
$ticket->addTicket($conexion);

$id_ticket = $ticket->getId($conexion);

if(strlen($_FILES['archivo']['name'])){

	if ($_FILES['archivo']["error"] > 0)
		echo "Error: " . $_FILES['archivo']['error'] . "<br>";

	$_FILES['archivo']['name'] = $ticket->getId($conexion).".png";

	move_uploaded_file($_FILES['archivo']['tmp_name'],"../img/imagenesTickets/".$_FILES['archivo']['name']);

	$ticket->setArchivo($_FILES['archivo']['name'], $conexion);

}

if($_POST['solicitud']==1)
	$solicitud = "Soporte";
elseif($_POST['solicitud']==2)
	$solicitud = "Reparacion";
else
	$solicitud = "Asistencia";

if($_POST['prioridad']==1)
	$prioridad = "<span class=\"label label-danger\">Alta</span>";
elseif($_POST['prioridad']==2)
	$prioridad = "<span class=\"label label-warning\">Media</span>";
else
	$prioridad = "<span class=\"label label-success\">Baja</span>";

$fecha = array();

$fecha = explode("-" ,$ticket->fecha);

$fecha[0] = $fecha[0]%1000;

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
$mail->Subject = "Nuevo Ticket #".$id_ticket;
$mail->Body = "

	<div style=\"width: 800px;height: ".(350+(strlen($_POST['observacion'])/6))."px;border: 1px solid #ddd;border-radius:6px;\">

  <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
  background-color: #f5f5f5;
  border-color: #ddd;padding: 10px 15px;
  border-bottom: 1px solid transparent;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;\">

        <strong>Nuevo Ticket</strong>

         <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

  </div>

  <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

      Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br> Has creado un nuevo ticket y ha sido enviado con exito al departamento de Sistemas.

      <table style=\"border-collapse: collapse;width: 100%;margin-bottom: 20px;\">
        <tr>
          <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Numero de Ticket</th>
          <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$id_ticket."</td>
        </tr>
        <tr>
          <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Fecha y Hora de Envio</th>
          <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">El ".$fecha[2]."/".$fecha[1]."/".$fecha[0]." a las ".$ticket->hora."</td>
        </tr>
        <tr>
          <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Estado de Su Ticket</th>
          <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">Por revisar</td>
        </tr>
        <tr>
          <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Tipo</th>
          <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$solicitud."</td>
        </tr>
        <tr>
          <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Prioridad</th>
          <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$prioridad."</td>
        </tr>
        <tr>
          <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Titulo</th>
          <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$_POST['titulo']."</td>
        </tr>

      </table>

        <fieldset>
            <legend><strong>Observación</strong></legend>
            ".$_POST['observacion']."
        </fieldset>

  </div>

</div>";
$mail->CharSet = 'UTF-8';
$mail->AddAddress($_SESSION['ticket_email']);
//$mail->AddAddress(""); si queremos copia
$mail->Send();

header("location: ../tickets-sin-revisar-1");

?>