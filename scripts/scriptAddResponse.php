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

if($_POST['cierre_parcial'] == 1)
$cierrep = "Favor validar y Cerrar.";
else
$cierrep = " ";

$ticket = new Ticket();

$ticket->setIdUsuario($_SESSION['ticket_id']);

$respuesta = $_POST['respuesta']." ".$cierrep;

$ticket->setRespuesta($respuesta);
$ticket->setFecha();
$ticket->addResponse($conexion, $_GET['id']);

if($_POST['cierre_parcial'] == 1 && ($_SESSION['ticket_tipo'] == 1 || $_SESSION['ticket_tipo'] > 3)){

  $ticket->setStatus(5);
  $ticket->changueStatus($conexion, $_GET['id'], 1, 0);
  $cierrep = "Favor validar y Cerrar.";
}
else{

  $ticket->setStatus(2);
  $ticket->changueStatus($conexion, $_GET['id'], 3, 0);
}

//Usuario que creo el ticket

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_GET['idUser']);

$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

//Usuario que da la respuesta

$usuario2 = new Usuario();

$consulta2 = $usuario2->searchUser($conexion, $_SESSION['ticket_id']);

$resultado2 = $consulta2->fetch_array(MYSQLI_ASSOC);

$fecha = array();

$fecha = explode("-" ,$ticket->fecha);

$fecha[0] = $fecha[0]%1000;

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
$mail->Subject = "Respuesta a Ticket: ".$_GET['id'];
if($_GET['idUser'] != $_SESSION['ticket_id']){
  $mail->Body = "

  	<div style=\"width: 800px;height: ".(250+(strlen($_POST['respuesta'])/6))."px;border: 1px solid #ddd;border-radius:6px;\">

    <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;\">

          <strong>Respuesta</strong>

           <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

    </div>

    <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

        Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br>
          <strong>".$resultado2['personaNombre']." ".$resultado2['apellido']."</strong> le dio respuesta a su ticket.

        <table style=\"border-collapse: collapse;width: 100%;margin-bottom: 20px;\">
          <tr>
            <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Numero de Ticket</th>
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$_GET['id']."</td>
          </tr>
          <tr>
            <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Fecha y Hora de Envio</th>
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">El ".$fecha[2]."/".$fecha[1]."/".$fecha[0]." a las ".$ticket->hora."</td>
          </tr>
        </table>

        <fieldset>
            <legend><strong>Respuesta</strong></legend>
            ".$_POST['respuesta']." ".$cierrep."
        </fieldset>

    </div>

  </div>";
}
else{

  $mail->Body = "

    <div style=\"width: 800px;height: ".(250+(strlen($_POST['respuesta'])/6))."px;border: 1px solid #ddd;border-radius:6px;\">

    <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;\">

          <strong>Respuesta</strong>

          <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

    </div>

    <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

        Hola <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong>,<br> Usted dio respuesta a su ticket.

        <table style=\"border-collapse: collapse;width: 100%;margin-bottom: 20px;\">
          <tr>
            <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Numero de Ticket</th>
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$_GET['id']."</td>
          </tr>
          <tr>
            <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Fecha y Hora de Envio</th>
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">El ".$fecha[2]."/".$fecha[1]."/".$fecha[0]." a las ".$ticket->hora."</td>
          </tr>
        </table>

        <fieldset>
            <legend><strong>Respuesta</strong></legend>
            ".$_POST['respuesta']." ".$cierrep."
        </fieldset>

    </div>

  </div>";
}
$mail->CharSet = 'UTF-8';
$mail->AddAddress($resultado['email']);
//$mail->AddAddress(""); si queremos copia
$mail->Send();

if($_POST['informar']){

  $ticket->informar($conexion, $_GET['id']);

  for ($i=0; $i <= $_POST['cantidad_persona']; $i++) {

    $consulta_usuario_informar    = $usuario->searchUser($conexion, $_POST['persona'.$i]);
    $resultado_usuario_informar[] = $consulta_usuario_informar->fetch_array(MYSQLI_ASSOC);
  }

  $consulta_ticket = $ticket->searchTicket($conexion, $_GET['id']);
  $resultado_ticket = $consulta_ticket->fetch_array(MYSQLI_ASSOC);

  if($resultado_ticket['tipo_solicitud']==1)
    $solicitud = "Soporte";
  elseif($resultado_ticket['tipo_solicitud']==2)
    $solicitud = "Reparacion";
  else
    $solicitud = "Asistencia";

  if($resultado_ticket['prioridad']==1)
    $prioridad = "<span class=\"label label-danger\">Alta</span>";
  elseif($resultado_ticket['prioridad']==2)
    $prioridad = "<span class=\"label label-warning\">Media</span>";
  else
    $prioridad = "<span class=\"label label-success\">Baja</span>";

  $fecha = array();

  $fecha = explode("-" ,$resultado_ticket['fecha_creacion']);

  $fecha[0] = $fecha[0]%1000;

  $respuestas = '';

  $consulta_respuestas = $ticket->listResponse($conexion, $_GET['id']);

  while($resultado_respuestas = $consulta_respuestas->fetch_array(MYSQLI_ASSOC)){

    $consulta_usuario_respuesta = $usuario->searchUser($conexion, $resultado_respuestas['id_usuario']);

    $resultado_usuario_respuesta = $consulta_usuario_respuesta->fetch_array(MYSQLI_ASSOC);

    $fecha  = array();
    $hora   = array();

    $fecha  = explode('-', $resultado_respuestas['fecha']);
    $hora   = explode(':', $resultado_respuestas['hora']);
    $fecha[0] = $fecha[0]%2000;

    $respuestas .= "<fieldset>
                    <legend><strong>Respuesta:</strong></legend>
                    <strong>".$resultado_usuario_respuesta['personaNombre']." ".$resultado_usuario_respuesta['apellido']." Escribio el ".$fecha[2]."/".$fecha[1]."/".$fecha[0]." a las ".$hora[0].":".$hora[1]."</strong><br>
                    ".$resultado_respuestas['respuesta']."
                  </fieldset>";
  }

  if($resultado['id_cede']==11)
      $cede = "CI - Carupano";
    if($resultado_usuario['id_cede']==12)
      $cede = "CI - Maturin";
    if($resultado_usuario['id_cede']==13)
      $cede = "CI - Cumana";
    if($resultado_usuario['id_cede']==21)
      $cede = "SF - Carupano";
    if($resultado_usuario['id_cede']==22)
      $cede = "SF - Cumana";

  $mail2 = new PHPMailer(); // create a new object
  $mail2->IsSMTP(); // enable SMTP
  $mail2->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
  $mail2->SMTPAuth = true; // authentication enabled
  $mail2->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail/ tls
  $mail2->Host = "";
  $mail2->Port = 465;// or 587
  $mail2->IsHTML(true);
  $mail2->Username = "";
  $mail2->Password = "";
  $mail2->SetFrom("","Sistemas");
  $mail2->Subject = $_POST['titulo-informe']." Ticket #".$resultado_ticket['id']."";
  $mail2->Body = "

    <div style=\"width: 800px;height: ".(350+(strlen($resultado_ticket['observacion'])/6)+(strlen($respuestas)/5))."px;border: 1px solid #ddd;border-radius:6px;\">

    <div style=\"width: 770px;height: 20px;margin-top: 0; margin-bottom: 0; font-size: 20px; color: inherit;color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;\">

          <strong>Ticket #".$resultado_ticket['id']."</strong>

           <img src=\"\" style=\"width: 40px;height: 25px;float: right;\">

    </div>

    <div style=\"border-top: 1px solid #ddd;padding: 15px;background:white;\">  

        Hola,<br> A continuacion se informa sobre el ticket generado por <strong>".$resultado['personaNombre']." ".$resultado['apellido']."</strong> de la sede ".$cede.":

        <table style=\"border-collapse: collapse;width: 100%;margin-bottom: 20px;\">
          <tr>
            <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Numero de Ticket</th>
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$resultado_ticket['id']."</td>
          </tr>
          <tr>
            <th style=\"background-color: #fff;text-align: left;padding-top:5px;\">Fecha y Hora de Envio</th>
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">El ".$fecha[2]."/".$fecha[1]."/".$fecha[0]." a las ".$resultado_ticket['hora_creacion']."</td>
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
            <td style=\"background-color: #fff;text-align: left;padding-top:5px;\">".$resultado_ticket['titulo']."</td>
          </tr>

        </table>

          <fieldset>
              <legend><strong>Observación</strong></legend>
              ".$resultado_ticket['observacion']."
          </fieldset><br>

          ".$respuestas."

    </div>

  </div>";
  $mail2->CharSet = 'UTF-8';
  $mail2->AddAddress($_SESSION['ticket_email']); //mail del usuario
  $mail2->AddAddress('');//si queremos copia
  for ($i=0; $i < count($resultado_usuario_informar); $i++) { 
    $mail2->AddAddress($resultado_usuario_informar[$i]['email']);
  }
  $mail2->Send();
}

$conexion->close();
header("location: ../checkTicket-1-".$_GET['id']." ");
?>