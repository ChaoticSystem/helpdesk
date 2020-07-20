<?php

require ("scripts/scriptValidaSession.php");
require ("clases/ticket.class.php");
require ("clases/baseDatos.class.php");
require ("clases/usuario.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario    = new Usuario();
$consulta   = $usuario->listUser($conexion);

if(isset($_POST['usuario'])){

  $ticket = new Ticket();
  $ticket->setIdUsuario($_POST['usuario']);
  $ticket->setTipoSolicitud($_POST['solicitud']);
  $ticket->setTitulo($_POST['titulo']);
  $ticket->setObservacion($_POST['observacion']);

  $consulta_ticket = $ticket->filtro($conexion);

}

?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Filtro</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

  </head>

  <body>


    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>
    
    <div class="card-panel grey lighten-4">

      <form class="col s12" action="?" method="POST" autocomplete="off">

        <?php if(!isset($_POST['usuario'])): ?>
          <div class="row">
            <div class="input-field col s2">
              <select name="usuario">
                <option value="0">Todos</option>
                <?php while($resultado  = $consulta->fetch_array(MYSQLI_ASSOC)): ?>
                  <option value="<?=$resultado['idUsuario']?>"><?php echo $resultado['personaNombre'] ?> <?php echo $resultado['apellido'] ?></option>
                <?php endwhile; ?>
              </select>
              <label>Usuario</label>
            </div>

            <div class="input-field col s2">
              <select name="solicitud">
                <option value="0">Todas</option>
                <option value="1">Soporte</option>
                <option value="2">Reparacion</option>
                <option value="3">Asistencia</option>
              </select>
              <label>Tipo de Solicitud</label>
            </div>
            <div class="input-field col s2">
              <label>Titulo</label>
              <input type="text" class="form-control input-sm" name="titulo">
            </div>

            <div class="input-field col s2">
              <label>Observación</label>
              <input type="text" class="form-control input-sm" name="observacion">
            </div>

            <div class="input-field col s2">
              <button type="submit" class="btn btn-default btn-sm">Filtrar</button>
            </div>
          </div>


        <?php else: ?>

          <div class="row">
            <div class="input-field col s2">
              <select name="usuario">
                <option value="0">Todos</option>
                <?php while($resultado  = $consulta->fetch_array(MYSQLI_ASSOC)): ?>
                  <option <?php if($_POST['usuario'] == $resultado['idUsuario']) echo 'selected'; ?> value="<?=$resultado['idUsuario']?>"><?php echo $resultado['personaNombre'] ?> <?php echo $resultado['apellido'] ?></option>
                <?php endwhile; ?>
              </select>
              <label>Usuario</label>
            </div>

            <div class="input-field col s2">
              <select name="solicitud" class="form-control input-sm" >
                  <option <?php if($_POST['solicitud'] == 0) echo 'selected'; ?> value="0">Todas</option>
                  <option <?php if($_POST['solicitud'] == 1) echo 'selected'; ?> value="1">Soporte</option>
                  <option <?php if($_POST['solicitud'] == 2) echo 'selected'; ?> value="2">Reparacion</option>
                  <option <?php if($_POST['solicitud'] == 3) echo 'selected'; ?> value="3">Asistencia</option>
              </select>
              <label>Tipo de Solicitud</label>
            </div>
            <div class="input-field col s2">
              <label>Titulo</label>
              <input type="text" class="form-control input-sm" name="titulo" value="<?=$_POST['titulo']?>">
            </div>

            <div class="input-field col s2">
              <label>Observación</label>
              <input type="text" class="form-control input-sm" name="observacion" value="<?=$_POST['observacion']?>">
            </div>

            <div class="input-field col s2">
              <button type="submit" class="btn btn-default btn-sm">Filtrar</button>
            </div>
            <div class="input-field col s2">
              <?php echo "Mostrando <strong>".$consulta_ticket->num_rows."</strong> Tickets"; ?>
            </div>
            
          </div>

        <?php endif; ?>

      </form>

      <!--tabla-->

      <?php if(isset($_POST['usuario'])): ?>

      <div class="col-md-12" id="list">

        <table class="table table-hover table-striped table-condensed centered">

          <thead>
            <tr>

              <th>Ticket</th>
              <th>Usuario</th>
              <th>Departamento</th>
              <th>Sede</th>
              <th>Solicitud</th>
              <th>Prioridad</th>
              <th><span class="white-text blue" style="padding:5px;border-radius:5px;">Titulo</span></th>
              <th>Adjunto</th>
              <th>Status</th>
              <th>Fecha</th>
              <th>Hora</th>

            </tr>
          </thead>

          <tbody>
            <?php
              
              while ($resultado   = $consulta_ticket->fetch_array(MYSQLI_ASSOC)){

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
                $prioridad = "<span class=\"white-text red\" style=\"padding:5px;border-radius:5px;\">Alta</span>";
              elseif($resultado['prioridad']==2)
                $prioridad = "<span class=\"white-text yellow darken-3\" style=\"padding:5px;border-radius:5px;\">Media</span>";
              else
                $prioridad = "<span class=\"white-text green\" style=\"padding:5px;border-radius:5px;\">Baja</span>";

              if($resultado['status']==1){

                $cierrep = "";
                $status = "<span class=\"white-text blue\" style=\"padding:5px;border-radius:5px;\">Por Revisar</span>";
              }
              elseif($resultado['status']==2){

                $cierrep = "";
                $status = "<span class=\"white-text yellow darken-3\" style=\"padding:5px;border-radius:5px;\">Revisado</span>";
              }
              elseif($resultado['status']==3){

                $cierrep = "";
                $status = "<span class=\"white-text grey\" style=\"padding:5px;border-radius:5px;\">Cerrado</span>";
              }
              elseif($resultado['status']==4){

                $cierrep = "";
                $status = "<span class=\"white-text brown\" style=\"padding:5px;border-radius:5px;\">Reabierto</span>";
              }
              elseif($resultado['status']==5){

                $status = "<span class=\"white-text green\" style=\"padding:5px;border-radius:5px;\">Revisado</span>";
                $cierrep = "class=\"danger\"";
              }
              elseif($resultado['status']==6){

                $status = "<span class=\"white-text green\" style=\"padding:5px;border-radius:5px;\">Autorizado</span>";
                $cierrep = "";
              }
              elseif($resultado['status']==7){

                $status = "<span class=\"white-text red\" style=\"padding:5px;border-radius:5px;\">No autorizado</span>";
                $cierrep = "";
              }

              if(strlen($resultado['archivo'])>0)
                $archivo = "Si";
              else
                $archivo = "No";

              if($resultado_usuario['id_cede']==11)
                  $cede = "Diarca - Barcelona";
                if($resultado_usuario['id_cede']==21)
                  $cede = "Diserial - Barcelona";
                if($resultado_usuario['id_cede']==31)
                  $cede = "Diarca - Monagas";
                if($resultado_usuario['id_cede']==41)
                  $cede = "Diarca - Guayana";
                if($resultado_usuario['id_cede']==51)
                  $cede = "Etse - Barcelona";
                if($resultado_usuario['id_cede']==61)
                  $cede = "Alidelta - Porlamar";
                if($resultado_usuario['id_cede']==71)
                  $cede = "Trainsland - Porlamar";
                if($resultado_usuario['id_cede']==72)
                  $cede = "Trainsland - Barcelona";

                $fecha = array();

                if($_SESSION['ticket_tipo'] == 2 || $_SESSION['ticket_tipo'] == 4){

                  $fecha = explode("-" ,$resultado['t_fcreacion']);

                  $hora = $resultado['t_hcreacion'];

                }
                else{

                  $fecha = explode("-" ,$resultado['fecha_creacion']);

                  $hora = $resultado['hora_creacion'];
                }
                $fecha[0] = $fecha[0]%1000;

                  echo "<tr ".$cierrep.">
                    <td><a class=\"btn\" href=\"checkTicket-1-".$resultado['id']."\">".$resultado['id']."</a></td>
                    <td>".$resultado_usuario['personaNombre']." ".$resultado_usuario['apellido']."</td>
                    <td>".$resultado_usuario['nombreDepartamento']."</td>
                    <td>".$cede."</td>
                    <td>".$solicitud."</td>
                    <td>".$prioridad."</td>
                    <td>".$resultado['titulo']."</td>
                    <td>".$archivo."</td>
                    <td>".$status."</td>
                    <td>".$fecha[2]."/".$fecha[1]."/".$fecha[0]."</td>
                    <td>".$hora."</td>
                  </tr>";
                
              }
              
              ?>
          </tbody>

        </table>
        
      </div>

      <?php endif; ?>

    </div>

  </body>

</html>