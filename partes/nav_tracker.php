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

<nav style="margin-top:-10px">
  <div class="nav-wrapper blue darken-1">
    <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="fa fa-bars" aria-hidden="true"></i></a>
    <ul class="right hide-on-med-and-down">
      <li class=<?=$active[5]?>><a href="inicio_tracker-5"><i class="fa fa-home" aria-hidden="true"></i> Home</a></li>
      <li class=<?=$active[0]?>><a href='addLoad.php?active=0'><i class="fa fa-plus"></i> Nueva Carga</a></li>
      <li class=<?=$active[1]?>><a href='listLoadTransit.php?active=1'><i class="fa fa-exchange"></i> Cargas en Transito</a></li>
      <li class=<?=$active[2]?>><a href='listLoadClose.php?active=2'><i class="fa fa-unlock-alt"></i> Cargas Cerradas</a></li>
      <li class=<?=$active[3]?>><a href='listDriver.php?active=3'><i class="fa fa-user"></i> Choferes</a></li>
      <li class=<?=$active[4]?>><a href='listUnit.php?active=4'><i class="fa fa-truck"></i> Unidades</a></li>
      <li class=<?=$active[6]?>><a href='listArea.php?active=6'><i class="fa fa-globe"></i> Zonas</a></li>
      <li><a class="dropdown-button" href="#!" data-activates="sesion"><?=$_SESSION['ticket_usuario']?><i class="fa fa-chevron-down right" aria-hidden="true"></i></a></li>
    </ul>
    <ul class="side-nav" id="mobile-demo">
      <li><a href="#">Home</a></li>
      <li>><a href='addLoad.php?active=0'>Nueva Carga</a></li>
      <li>><a href='listLoadTransit.php?active=1'>Cargas en Transito</a></li>
      <li>><a href='listLoadClose.php?active=2'>Cargas Cerradas</a></li>
      <li>><a href='listDriver.php?active=3'>Choferes</a></li>
      <li>><a href='listUnit.php?active=4'>Unidades</a></li>
      <li>><a href='listArea.php?active=6'>Zonas</a></li>
      <li><a href='#'>Usuario: <?=$_SESSION['ticket_usuario']?></a></li>
      <li><a href='scripts/scriptCierraSesion.php'>Cerrar Sesion</a></li>
    </ul>
  </div>
</nav>