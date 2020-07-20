<?php

	$active = array();

	for($i=0; $i<3; $i++){

		if($_GET['active']==$i){

			$active[$i] = 'active';
			break;
		}
	}

?>

<div id='cssmenu'>

	<ul>
		<li class=<?=$active[5]?>><a href='inicio.php?active=5'><span>Inicio</span></a></li>
		<li class=<?=$active[0]?>><a href='addTicket.php?active=0'><span>Nueva Solicitud</span></a></li>
		<li class=<?=$active[1]?>><a href='listTicketUnrevised.php?active=1'><span>Solicitudes Pendientes</span></a></li>
		<li class=<?=$active[2]?>><a href='listTicketClose.php?active=2'><span>Solicitudes Cerradas</span></a></li>
		<li><a href='scripts/scriptCierraSesion.php'><span>Cerrar Sesion</span></a></li>
		<div id="mostrarUsuario" style="float:right">Usuario: <?=$_SESSION['ticket_usuario']?></div>
	</ul>

</div>