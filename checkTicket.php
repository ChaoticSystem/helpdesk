<?php

require ("scripts/scriptValidaSession.php");
require ("clases/usuario.class.php");
require ("clases/baseDatos.class.php");
require ("clases/ticket.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$ticket = new Ticket();

$consulta = $ticket->searchTicket($conexion, $_GET['id']);

$resultado = $consulta->fetch_array(MYSQLI_ASSOC);

$fecha = array();

$fecha = explode("-" ,$resultado['fecha_creacion']);

$fecha[0] = $fecha[0]%1000;

$consulta_respuestas = $ticket->listResponse($conexion, $_GET['id']);

$numero_respuestas = $consulta_respuestas->num_rows;

$usuario = new Usuario();

$consulta_usuario = $usuario->searchUser($conexion, $resultado['id_usuario']);

$resultado_usuario  = $consulta_usuario->fetch_array(MYSQLI_ASSOC);

$consulta_usuario_autoriza = $usuario->searchUser($conexion, $resultado['id_usuario_autoriza']);

$resultado_usuario_autoriza  = $consulta_usuario_autoriza->fetch_array(MYSQLI_ASSOC);

if($resultado['tipo_solicitud']==1)
    $solicitud = "Soporte";
  elseif($resultado['tipo_solicitud']==2)
    $solicitud = "Reparacion";
  else
    $solicitud = "Asistencia";

  if($resultado['prioridad']==1)
    $prioridad = "<span class=\"label label-danger\">Alta</span>";
  elseif($resultado['prioridad']==2)
    $prioridad = "<span class=\"label label-warning\">Media</span>";
  else
    $prioridad = "<span class=\"label label-success\">Baja</span>";

if($resultado_usuario['id_cede']==11)
  $cede = "Mi primera Sede";


  if($resultado['status'] == 2  || $resultado['status'] == 4 || $resultado['status'] == 5)
    $abrirCerrar = "<a class=\"btn\" title=\"Cerrar Ticket\" href=\"scripts/cerrarTicket-".$resultado['id']."-".$resultado['id_usuario']."\"><i class=\"fa fa-folder\"></i></a>";
  elseif($resultado['status'] == 3)
    $abrirCerrar = "<a class=\"btn\" title=\"Reabrir Ticket\" href=\"scripts/abrirTicket-".$resultado['id']."-".$resultado['id_usuario']."\"><i class=\"fa fa-folder-open\"></i></a>";
  else
    $abrirCerrar = "";

  if(($_SESSION['ticket_tipo'] == 1 || $_SESSION['ticket_tipo'] == 4 || $_SESSION['ticket_tipo'] == 5)){

    $autorizar    = "<a href=\"scripts/autorizaTicket-".$resultado['id']."-".$_SESSION['ticket_id']."\"><button title=\"Autorizar\" type=\"button\" class=\"btn\"><i class=\"fa fa-check\" aria-hidden=\"true\"></i></button></a>";
    $desAutorizar = "<a href=\"scripts/desautorizaTicket-".$resultado['id']."-".$_SESSION['ticket_id']."\"><button title=\"No Autorizar\" type=\"button\" class=\"btn\"><i class=\"fa fa-times\" aria-hidden=\"true\"></i></button></a>";
  }
  else{

    $autorizar    = "";
    $desAutorizar = "";
  }

?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Ticket <?=$resultado['id']?></title>
    
    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="yoxview/yoxview-init.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

        var statSend = false;
        function checkSubmit() {
            if (!statSend) {
                statSend = true;
                return true;
            } else {
                alert("El formulario ya se esta enviando...");
                return false;
            }
        }

       $(function(){
        //acknowledgement message
          var message_status = $("#status");
          message_status.hide();
          $("td[contenteditable=true]").blur(function(){
              var field_userid = $(this).attr("id") ;
              var value = $(this).text() ;
              $.post('scripts/scriptEditarResponse.php' , field_userid + "=" + value, function(data){
                  if(data != '')
                  {
                    message_status.show();
                    message_status.text(data);
                    //hide the message
                    setTimeout(function(){message_status.hide()},3000);
                  }
              });
          });
      });

       var c= 0;

      $(document).ready(function(){

        $( "#suma_persona" ).on('click',function() {

            $("#error-persona").append($("#persona0").clone().attr('id', 'persona'+(++c) ));
            $("#persona"+c).attr('name', 'persona'+c);
            $("#persona"+c).val(0);
            $("#cantidad_persona").val(c);
        });

        $( "#borra_persona" ).on('click',function() {

          if(c>0){

            $( "#persona"+c ).remove();
            c--;
          }
        });

        $("#campo-asunto").hide(); 
        $("#campo-select").hide();

        $( "#informar" ).click(function() {

          if($("#informar").is(':checked')){

            $("#campo-asunto").show(); 
            $("#campo-select").show();
          }
          else{

            $("#campo-asunto").hide(); 
            $("#campo-select").hide();
          }
        });

      });

    </script>

  </head>

  <body>

    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="container">
      <div class="card-panel grey lighten-4">
        <form name="formulario" action="scripts/scriptAddResponse.php?id=<?=$resultado['id']?>&idUser=<?=$resultado_usuario['idUsuario']?>" method="POST" enctype="multipart/form-data" onsubmit="return checkSubmit();">
        
        <table class="responsive-table">

          <tr>

            <th>
              ID:
            </th>
            <td>
                <?=$resultado['id']?>
            </td>
            <td>
              <?=$abrirCerrar?>
            </td>

            <td><?=$autorizar?></td>
            
            <td><?=$desAutorizar?></td>

          </tr>

          <tr>

            <th>
              Nombre:
            </th>
            <td>
                <?=$resultado_usuario['personaNombre']?> <?=$resultado_usuario['apellido']?> /
                <?=$resultado_usuario['nombreDepartamento']?> /
                <?=$cede?>
            </td>

          </tr>

          <tr>
              
            <th>Tipo de Solicitud:</th>
            <td><?=$solicitud?></td>
                
              
          </tr>

          <tr>
              
            <th>Prioridad:</th>
            <td><?=$prioridad?></td>
                
              
          </tr>

          <tr>

            <th>Titulo:</th>
            <td><?=$resultado['titulo']?></td>

          </tr>

          <tr>

            <th>Observación:</th>
            <td><?=$resultado['observacion']?></td>

          </tr>

          <tr>

            <th>Fecha y hora de creación:</th>
            <td>El <?=$fecha[2]?>/<?=$fecha[1]?>/<?=$fecha[0]?> a las <?=$resultado['hora_creacion']?></td>

          </tr>
          <?php if($resultado['id_usuario_autoriza']): ?>
            <tr>
              
              <?php if($resultado['autorizado']): ?>
                <th>Autorizado Por:</th>
                <td><?=$resultado_usuario_autoriza['personaNombre']?> <?=$resultado_usuario_autoriza['apellido']?></td>
              <?php elseif(!$resultado['autorizado']): ?>
                <th>No Autorizado Por:</th>
                <td><?=$resultado_usuario_autoriza['personaNombre']?> <?=$resultado_usuario_autoriza['apellido']?></td>
              <?php endif; ?>

            </tr>
          <?php else: ?>
            <tr>

              <th>Autorizado Por:</th>
              <td>Sin Autorizar</td>

            </tr>
          <?php endif; ?>

            <?php
            
              if(strlen($resultado['archivo'])>0)
                echo "<tr><th>Archivo:</th><td>
                        <div style=\"z-index: 2000;\" class=\"yoxview\"><a href=\"img/imagenesTickets/".$resultado['archivo']."\"><img  alt=\"Ver Imagen\" title=\"First image\" /></a>
                      </td></tr>";


            if($numero_respuestas > 0){

              echo "<tr>

                    <td colspan=\"6\" class=\"center-align\">
                      <h5>Respuestas</h5>
                    </td>

                  </tr>";

              while($resultado_respuestas = $consulta_respuestas->fetch_array(MYSQLI_ASSOC)){

                $usuario = new Usuario();

                $consulta_usuario = $usuario->searchUser($conexion, $resultado_respuestas['id_usuario']);

                $resultado_usuario  = $consulta_usuario->fetch_array(MYSQLI_ASSOC);

                $fecha  = array();
                $hora   = array();

                $fecha  = explode('-', $resultado_respuestas['fecha']);
                $hora   = explode(':', $resultado_respuestas['hora']);
                $fecha[0] = $fecha[0]%2000;

                if($resultado_usuario['tipo']==1 && $_SESSION['ticket_id'] == $resultado_usuario['idUsuario'])
                  $editar = "contenteditable='true'";
                else
                  $editar = "";

                echo  "<tr class=\"blue-grey lighten-4\">

                      <td colspan=\"6\"><div class=\"chip\"><i class=\"fa fa-user\"></i> ".$resultado_usuario['personaNombre']." ".$resultado_usuario['apellido']."</div> comentó el ".$fecha[2]."/".$fecha[1]."/".$fecha[0]." a las ".$hora[0].":".$hora[1]."</td>

                    </tr>

                    <tr class=\"blue-grey lighten-5\">
                      <td id='respuesta:".$resultado_respuestas['id']."' ".$editar." colspan=\"6\">".$resultado_respuestas['respuesta']."<input type='hidden' id='respuesta' value=".$resultado_respuestas['respuesta']."></td>
                    </tr>";
              }
            }

            if($resultado['status'] != 3)
              include_once("partes/respuestaTicket.php");

          ?>

        </table>

      </form>

      </div>
    </div>

  </body>

</html>