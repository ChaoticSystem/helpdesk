<?php

  $active = array();

  for($i=0; $i<7; $i++){

    if($_GET['active']==$i){

      $active[$i] = 'active';
     }
    else{

      $active[$i] = "";
    }
  }

?>

<ul id="sesion" class="dropdown-content">
  <li><a href='scripts/scriptCierraSesion.php'><i class="fa fa-sign-out" aria-hidden="true"></i> Cerrar Sesion</a></li>
</ul>
<ul id="tickets" class="dropdown-content">
  <li><a href='nuevoTicket-0'><i class="fa fa-plus-square" aria-hidden="true"></i> Nueva Solicitud</a></li>
  <li><a href='tickets-sin-revisar-0'><i class="fa fa-pause" aria-hidden="true"></i> Solicitudes Pendientes</a></li>
  <li><a href='tickets-revisados-0'><i class="fa fa-check-square" aria-hidden="true"></i> Solicitudes Cerradas</a></li>

</ul>

<nav style="margin-top:-10px">
  <div class="nav-wrapper blue darken-1">
    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars" aria-hidden="true"></i></a>
    <ul class="right hide-on-med-and-down">
      <li class="<?=$active[5]?>"><a href="inicio-5"><i class="fa fa-home" aria-hidden="true"></i> Inicio</a></li>
      <li class="<?=$active[0]?>" style="width:200px;text-align:center;"><a class="dropdown-button" href="#!" data-activates="tickets">Tickets <i class="fa fa-ticket" aria-hidden="true"></i></a></li>
      <li class="<?=$active[3]?>"><a href='usuarios-3'><i class="fa fa-user" aria-hidden="true"></i> Mi perfil</a></li>
      <li class="<?=$active[6]?>"><a href='sugerencias-6'><i class="fa fa-lightbulb-o" aria-hidden="true"></i> Sugerencias</a></li>
      <li><a class="dropdown-button" href="#!" data-activates="sesion"><?=$_SESSION['ticket_usuario']?><i class="fa fa-chevron-down right" aria-hidden="true"></i></a></li>
    </ul>
    <ul class="side-nav" id="mobile-demo">
      <li><a href="#">Inicio</a></li>
      <li><a href='nuevoTicket-0'>Nueva Solicitud</a></li>
      <li><a href='tickets-sin-revisar-1'>Solicitudes Pendientes</a></li>
      <li><a href='tickets-revisados-2'>Solicitudes Cerradas</a></li>
      <li><a href='usuarios-3'>Mi perfil</a></li>
      <li><a href='sugerencias-6'>Sugerencias</a></li>
      <li><a href='sugerencias-6'>Usuario: <?=$_SESSION['ticket_usuario']?></a></li>
      <li><a href='scripts/scriptCierraSesion.php'>Cerrar Sesion</a></li>
    </ul>
  </div>
</nav>
