<?php
require('clases/pdf.class.php');
require('clases/baseDatos.class.php');
require('clases/ticket.class.php');
require('clases/usuario.class.php');

$conexion = new baseDatos();
$ticket = new Ticket();

$consulta = $ticket->listTicketUnrevised($conexion);

$ticket->setFecha();

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L', 'Letter');
$pdf->SetFont('Times','',12);
$header = array('Ticket Id','Usuario','Departamento','Sede','Tipo de Solicitud','Titulo','Status','Fecha','Hora');
$ancho	= array(18,35,30,30,35,40,30,25,25);

foreach ($header as $key => $value){

	$pdf->Cell($ancho[$key],7,$value,1, 0, 'C');
}
$pdf->Ln();

while($resultado = $consulta->fetch_array(MYSQLI_ASSOC)){

	$usuario = new Usuario();

	$consulta_usuario = $usuario->searchUser($conexion, $resultado['id_usuario']);

	$resultado_usuario  = $consulta_usuario->fetch_array(MYSQLI_ASSOC);

	if($resultado['tipo_solicitud']==1)
		$solicitud = "Soporte";
	elseif($resultado['tipo_solicitud']==2)
		$solicitud = "Reparacion";
	else
		$solicitud = "Asistencia";

	if($resultado['prioridad']==1)
		$prioridad = "Alta";
	elseif($resultado['prioridad']==2)
		$prioridad = "Media";
	else
		$prioridad = "Baja";

	if($resultado['status']==1){

		$cierrep = "";
		$status = "Por Revisar";
	}
	elseif($resultado['status']==2){

		$cierrep = "";
		$status = "Revisado";
	}
	elseif($resultado['status']==3){

		$cierrep = "";
		$status = "Cerrado";
	}
	elseif($resultado['status']==4){

		$cierrep = "";
		$status = "Reabierto";
	}
	elseif($resultado['status']==5){

		$status = "Revisado";
	}
	elseif($resultado['status']==6){

		$status = "Autorizado";
	}
	elseif($resultado['status']==7){

		$status = "No autorizado";
	}

	if(strlen($resultado['archivo'])>0)
		$archivo = "Si";
	else
		$archivo = "No";

	if($resultado_usuario['id_cede']==11)
	  $cede = "Mi primera Sede";


	$fecha = array();

	$fecha = explode("-" ,$resultado['fecha_creacion']);

	$hora = $resultado['hora_creacion'];

	$fecha[0] = $fecha[0]%1000;

	$pdf->Cell($ancho[0],7,utf8_decode($resultado['id']),1, 0, 'C');
	$pdf->Cell($ancho[1],7,utf8_decode($resultado_usuario['personaNombre']." ".$resultado_usuario['apellido']),1, 0, 'C');
	$pdf->Cell($ancho[2],7,utf8_decode($resultado_usuario['nombreDepartamento']),1, 0, 'C');
	$pdf->Cell($ancho[3],7,utf8_decode($cede),1, 0, 'C');
	$pdf->Cell($ancho[4],7,utf8_decode($solicitud),1, 0, 'C');
	$pdf->Cell($ancho[5],7,utf8_decode(substr($resultado['titulo'],0,14)),1, 0, 'C');
	$pdf->Cell($ancho[6],7,utf8_decode($status),1, 0, 'C');
	$pdf->Cell($ancho[7],7,utf8_decode($fecha[2]."/".$fecha[1]."/".$fecha[0]),1, 0, 'C');
	$pdf->Cell($ancho[8],7,utf8_decode($hora),1, 0, 'C');
	$pdf->Ln();
}



$pdf->Output('tickets pendientes','I',1);


?>