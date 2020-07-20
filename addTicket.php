<?php

require ("scripts/scriptValidaSession.php");
require ("clases/usuario.class.php");
require ("clases/ticket.class.php");
require ("clases/baseDatos.class.php");

if(isset($_GET['archivo'])){

  !$_GET['archivo'] ? $error = "¡El formato del archivo no esta Permitido!" : $error = "El archivo es muy grande!.";
}
else
  $error = "Solo se admiten imagenes hasta un maximo de 2mb.";

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_SESSION['ticket_id']);

$resultado  = $consulta->fetch_array(MYSQLI_ASSOC);

$ticket = new Ticket();

$consulta_pendientes = $ticket->numSlope($conexion, $_SESSION['ticket_id']);

$resultado_pendientes = $consulta_pendientes->num_rows;

?>
<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help-Desk Añadir Nuevo Ticket</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
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

    $(document).ready(function(){

      $("#addTicket").submit(function() {

          if ($("#solicitud").val() == 0) {

            statSend = false;

            $( "#dialog-modal-solicitud" ).openModal();

            return false;
          } else if ($("#prioridad").val() == 0) {

            statSend = false;

            $( "#dialog-modal-prioridad" ).openModal();

            return false;
          }

          var archivo = $("#archivo").val();

          var ext = ""+archivo[archivo.length-4]+archivo[archivo.length-3]+archivo[archivo.length-2]+archivo[archivo.length-1];

          if(ext == ".png"  || ext == ".jpg" || ext == "jpeg" || archivo.length == 0)
            return true
          else{
            $( "#dialog-modal-archivo" ).dialog({
              height: 140,
              modal: true
            });
            return false;
          }
        });

        $("#dialog-modal-solicitud").hide();
        $("#dialog-modal-prioridad").hide();
        $("#dialog-modal-archivo").hide();

        <?php

          if($resultado_pendientes>=1){

            echo "alert(\"Usted posee 1 solicitud cerrada parcialmente por el departamento de sistemas, valide y cierrela antes de crear otra nueva.\");
                  document.location=(\"./listTicketUnrevised.php?active=0\");";
          }

        ?>
    });

  </script>

  </head>

  <body>

    <!-- Mensajes al Usuario -->

    <div id="dialog-modal-solicitud" class="modal">
      <div class="modal-content">
        <h4>Atencion!</h4>
        <p>Antes debe seleccionar un tipo de Solicitud</p>
      </div>
    </div>

    <div id="dialog-modal-prioridad" class="modal">
      <div class="modal-content">
        <h4>Atencion!</h4>
        <p>Antes debe seleccionar la Prioridad</p>
      </div>
    </div>

    <div id="dialog-modal-archivo" class="modal">
      <div class="modal-content">
        <h4>Atencion!</h4>
        <p>El formato del Archivo no es Correcto</p>
      </div>
    </div>

    <!-- Fin -->


    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>
    <div class="container">
      <div class="card-panel grey lighten-4">
        <h4 class="header blue-text">Nuevo Ticket</h4>
        <form class="col s12" name="formulario" id="addTicket" action="scripts/scriptAddTicket.php" method="POST" enctype="multipart/form-data" onsubmit="return checkSubmit();">
          <div class="row">
            <div class="col s6">
              Nombre
            </div>
            <div class="col s6">
              <strong><?=$resultado['personaNombre']?> <?=$resultado['apellido']?></strong>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <select name="solicitud" id="solicitud">
                <option value="1">Soporte</option>
                <option value="2">Reparacion</option>
                <option value="3">Asistencia</option>
              </select>
              <label>Tipo de Solicitud</label>
            </div>
            <div class="input-field col s6">
              <select name="prioridad" id="prioridad">
                <option value="3">Baja</option>
                <option value="2">Media</option>
                <option value="1">Alta</option>
              </select>
              <label>Prioridad</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="text" id="titulo" name="titulo" size="60" required>
              <label for="titulo">Titulo</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="observacion" class="materialize-textarea" name="observacion" required></textarea>
              <label for="observacion">Observación</label>
            </div>
          </div>
          <div class="file-field input-field">
            <div class="btn">
              <span><i class="fa fa-file" aria-hidden="true"></i></span>
              <input type="hidden" name="MAX_FILE_SIZE" value="5000000" /><input type="file" name="archivo" id="archivo" accept="image/*">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">

            </div>
            <?php  echo  "<span class=\"help-block\">".$error."</span>"; ?></td>
          </div>
          <div class="row">
            <div class="input-field col s6">
              <button type="reset" class="btn" disabled>Borrar</button>
            </div>
            <div class="input-field col s6">
              <button id="btsubmit" type="submit" class="btn">Enviar</button>
            </div>
          </div>
        </form>
      </div>
    </div>

  </body>

</html>