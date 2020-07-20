<?php

require ("scripts/scriptValidaSession.php");
require ("clases/ticket.class.php");
require ("clases/baseDatos.class.php");
require ("clases/usuario.class.php");

?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Solicitudes pendientes</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/autoRefresh.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

     <script type="text/javascript">

    <?php

      if($_SESSION['ticket_tipo'] == 1)
      echo "var myVar = setInterval(function(){autoRefresh()}, 3000);";

    ?>

      window.addEventListener('focus', function() {
          document.title = 'HelpDesk - Solicitudes pendientes';
          $("#list").load(location.href+" #list>*","");
      });

    </script>

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
            <th>Fecha</th>
            <th>Hora</th>
                        <?php if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6)): ?><td><a href="reporte.php" target="_blank"><i title="Descargar PDF" class=" glyphicon glyphicon-floppy-save"></i></a></td><?php endif; ?>
            <td></td>

          </tr>
        </thead>
        <tbody>
          <?php

            $conexion = new baseDatos();

            if ($conexion->connect_errno) {
                
                echo "Fallo la conexion: ".$conexion->connect_error;
            }

            $ticket = new Ticket();

            if($_SESSION['ticket_tipo'] == 3){

              $consulta = $ticket->listTicketUnrevisedEmpleado($conexion, $_SESSION['ticket_id']);
            }
            elseif($_SESSION['ticket_tipo'] == 2){

              $consulta = $ticket->listTicketUnrevisedSupervisor($conexion, $_SESSION['ticket_id_departamento']);
            }
            elseif($_SESSION['ticket_tipo'] == 4){

              $consulta = $ticket->listTicketUnrevisedGerente($conexion, $_SESSION['ticket_id_cede']);
            }
            elseif($_SESSION['ticket_tipo'] == 1 || $_SESSION['ticket_tipo'] == 5){

              $consulta = $ticket->listTicketUnrevised($conexion);
            }

            $consultaRefresh = $ticket->listTicketRefresh($conexion);

            $registros = $consultaRefresh->num_rows;
            
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
                $status = "Cerrado";
              }
              elseif($resultado['status']==4){

                $cierrep = "";
                $status = "<span class=\"white-text brown\" style=\"padding:5px;border-radius:5px;\">Reabierto</span>";
              }
              elseif($resultado['status']==5){

                $status = "<span class=\"white-text brown\" style=\"padding:5px;border-radius:5px;\">Revisado</span>";
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

                if($_SESSION['ticket_tipo'] == 2 || $_SESSION['ticket_tipo'] == 4){

                  $fecha = explode("-" ,$resultado['t_fcreacion']);

                  $hora = $resultado['t_hcreacion'];

                }
                else{

                  $fecha = explode("-" ,$resultado['fecha_creacion']);

                  $hora = $resultado['hora_creacion'];
                }
                $fecha[0] = $fecha[0]%1000;

                if($resultado['informe'])
                  $cerrado_sistema = "<i class=\"fa fa-bullhorn\"></i>";
                else
                  $cerrado_sistema = '';

              if($_SESSION['ticket_tipo'] == 2 || $_SESSION['ticket_tipo'] == 4)
                    echo "<tr ".$cierrep.">
                      <td><a class=\"btn\" href=\"checkTicket-1-".$resultado['id_ticket']."\">".$resultado['id_ticket']."</a></td>
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
                else
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
                      <td>".$cerrado_sistema."</td>
                    </tr>";

                    echo "<input type=\"hidden\" name=\"registros\" id=\"registros\" value=\"".$registros."?>\">";
              
            }
            
            ?>
        </tbody>


      </table>
    </div>

  </body>

</html>