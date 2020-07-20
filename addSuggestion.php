<?php

require ("scripts/scriptValidaSession.php");
require ("clases/usuario.class.php");
require ("clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_SESSION['ticket_id']);

$resultado  = $consulta->fetch_array(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Nuevo Departamento</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

    $(document).ready(function(){

      $("#addTicket").submit(function() {

        if ($("#solicitud").val() == 0) {

          $( "#dialog-modal-solicitud" ).dialog({
            height: 140,
            modal: true
          });

          $("#error-solicitud").addClass("has-error");

          return false;
        }

        if ($("#solicitud").val() == 7 && $("#otro").val().length == 0) {

          $( "#dialog-modal-otro" ).dialog({
            height: 140,
            modal: true
          });

          $("#otro").addClass("has-error");

          return false;
        }

      });

        $("#solicitud").change(function(){

          if($("#solicitud").val() == 7){

            $("#otro").show();
          }else{

            $("#otro").hide();
          }

        });

        $("#dialog-modal-solicitud").hide();
        $("#dialog-modal-otro").hide();
        $("#otro").hide();
    });

  </script>

  </head>

  <body>

    <!-- Mensajes al Usuario -->

    <div id="dialog-modal-solicitud" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>Antes debe seleccionar a que aplica su Sugerencia.</p>
      </div>
    </div>

    <div id="dialog-modal-otro" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>El campo Otro no puede quedar en Blanco.</p>
      </div>
    </div>

    <!-- Fin -->


    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="container">

      <div class="card-panel grey lighten-4">

      <div class="row">

        <div class="col s12">
          <h4>Mejoras o Sugerencias</h4>
        </div>
        <hr/>

        <form class="col s12" name="formulario" id="addTicket" action="scripts/scriptAddSuggestion.php" method="POST" enctype="multipart/form-data">

          <div class="row">
            <div class="col s12">
              Nombre:
              <strong><?=$resultado['personaNombre']?> <?=$resultado['apellido']?></strong>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
            <input type="text" id="titulo" name="titulo" size="60" required>
            <label for="titulo">Titulo:</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <label for="solicitud">¿Aplica para?</label>
              <span class="form-group" id="error-solicitud">
                <select name="aplica" id="solicitud" required>
                  <option value="0">-</option>
                  <option value="Herramienta HelpDesk">La Herramienta de Soporte</option>
                  <option value="Sistema Administrativo">Sistema Administrativo</option>
                  <option value="Sucursal">Sucursal</option>
                  <option value="Infraestructura">Infraestructura</option>
                  <option value="Equipos Informaticos">Equipos Informaticos</option>
                  <option value="Jefe Inmediato">Jefe Inmediato</option>
                  <option value="7">Otro</option>
                </select>
              </span>
              <input style="margin-top: 4px;" type="text" class="form-control input-sm" id="otro" name="otro" size="60" placeholder="¿A que Aplica su Sugerencia?">
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <textarea id="observacion" required class="materialize-textarea" rows="5" name="observacion" placeholder="De una descripcion de su Solicitud"></textarea>
              <label for="observacion">Observación:</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s6">
              <button type="reset" class="btn" disabled>Borrar</button>
            </div>
            <div class="input-field col s6">
              <button type="submit" class="btn">Enviar</button>
            </div>
          </div>

        </form>

      </div>

      </div>

    </div>

  </body>

</html>