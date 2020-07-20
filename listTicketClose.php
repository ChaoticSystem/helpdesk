<?php

require ("scripts/scriptValidaSession.php");
require ("clases/ticket.class.php");
require ("clases/baseDatos.class.php");
require ("clases/usuario.class.php");

date_default_timezone_set('America/Caracas');

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$ticket = new Ticket();

if($_SESSION['ticket_tipo'] == 3){

  $consulta = $ticket->listTicketCloseEmpleado($conexion, $_SESSION['ticket_id']);
}
elseif($_SESSION['ticket_tipo'] == 2){

  $consulta = $ticket->listTicketCloseSupervisor($conexion, $_SESSION['ticket_id_departamento']);
}
elseif($_SESSION['ticket_tipo'] == 4){

  $consulta = $ticket->listTicketCloseGerente($conexion, $_SESSION['ticket_id_cede']);
}
elseif($_SESSION['ticket_tipo'] == 1 || $_SESSION['ticket_tipo'] == 5){

  $consulta = $ticket->listTicketClose($conexion);
}


?>
<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Solicitudes cerradas</title>

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
    <div class="card-panel grey lighten-4" style="padding: 0px 20px 20px 20px !important;">
      <table class="highlight responsive-table centered">

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
          <th>Fecha Apertura</th>
          <th>Fecha Cierre</th>
          <th>Diferencia</th>
          <td></td>

        </tr>
      </thead>

      <tbody>
        <?php
          
          while ($resultado   = $consulta->fetch_array(MYSQLI_ASSOC)){

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
              $cede = "Mi primera Sede";
     

              $fecha = array();

              $fecha = explode("-" ,$resultado['fecha_cierre']);

              $fecha[0] = $fecha[0]%1000;

              $fecha2 = array();

              $fecha2 = explode("-" ,$resultado['fecha_creacion']);

              $fecha2[0] = $fecha2[0]%1000;

              $fecha_cierre = $resultado['fecha_cierre']." ".$resultado['hora_cierre'];

              $fecha_creacion = $resultado['t_fcreacion']." ".$resultado['t_hcreacion'];

              $segundos=strtotime($fecha_cierre) - strtotime($fecha_creacion);

              $diferencia=intval($segundos/60);

              $dif_dias = intval($diferencia/60/24);

              $dif_horas = intval(($diferencia/60)-($dif_dias*24));

              $dif_min = ($diferencia)-($dif_dias*24*60)-($dif_horas*60);

              if($resultado['id_usuario_cerrador'] == 777 && $resultado['informe'])
                $cerrado_sistema = "<i class=\"glyphicon glyphicon-saved\"> </i> <i class=\"glyphicon glyphicon-fire\"></i>";
              elseif($resultado['id_usuario_cerrador'] == 777)
                $cerrado_sistema = "<i class=\"glyphicon glyphicon-saved\"></i>";
              elseif($resultado['informe'])
                $cerrado_sistema = "<i class=\"glyphicon glyphicon-fire\"></i>";
              else
                $cerrado_sistema = '';

            if($_SESSION['ticket_tipo'] == 2 || $_SESSION['ticket_tipo'] == 4)
                  echo "<tr>
                    <td><a class=\"btn\" href=\"checkTicket-1-".$resultado['id_ticket']."\">".$resultado['id_ticket']."</a></td>
                    <td>".$resultado_usuario['personaNombre']." ".$resultado_usuario['apellido']."</td>
                    <td>".$resultado_usuario['nombreDepartamento']."</td>
                    <td>".$cede."</td>
                    <td>".$solicitud."</td>
                    <td>".$prioridad."</td>
                    <td>".substr($resultado['titulo'],0,14)."</td>
                    <td>".$archivo."</td>
                    <td>".$status."</td>
                    <td>".$fecha2[2]."/".$fecha2[1]."/".$fecha2[0]." - ".$resultado['hora_creacion']."</td>
                    <td>".$fecha[2]."/".$fecha[1]."/".$fecha[0]." - ".$resultado['hora_cierre']."</td>
                    <td>".str_pad($dif_dias, 2, '0', STR_PAD_LEFT)."d-".str_pad($dif_horas, 2, '0', STR_PAD_LEFT)."h-".str_pad($dif_min, 2, '0', STR_PAD_LEFT)."m</td>
                  </tr>";
              else
                  echo "<tr>
                    <td><a class=\"btn\" href=\"checkTicket-2-".$resultado['id']."\">".$resultado['id']."</a></td>
                    <td>".$resultado_usuario['personaNombre']." ".$resultado_usuario['apellido']."</td>
                    <td>".$resultado_usuario['nombreDepartamento']."</td>
                    <td>".$cede."</td>
                    <td>".$solicitud."</td>
                    <td>".$prioridad."</td>
                    <td>".substr($resultado['titulo'],0,14)."</td>
                    <td>".$archivo."</td>
                    <td>".$status."</td>
                    <td>".$fecha2[2]."/".$fecha2[1]."/".$fecha2[0]." - ".$resultado['hora_creacion']."</td>
                    <td>".$fecha[2]."/".$fecha[1]."/".$fecha[0]." - ".$resultado['hora_cierre']."</td>
                    <td>".str_pad($dif_dias, 2, '0', STR_PAD_LEFT)."d-".str_pad($dif_horas, 2, '0', STR_PAD_LEFT)."h-".str_pad($dif_min, 2, '0', STR_PAD_LEFT)."m</td>
                    <td>".$cerrado_sistema."</td>
                  </tr>";
          }
          
          ?>
      </tbody>

      </table>
    </div>
  </body>

</html>