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
    <title>Nueva Sugerencia</title>

    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>

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

    <div id="dialog-modal-solicitud" title="Atencion!">
      <p>Antes debe seleccionar a que aplica su Sugerencia.</p>
    </div>

    <div id="dialog-modal-otro" title="Atencion!">
      <p>El campo Otro no puede quedar en Blanco.</p>
    </div>

    <!-- Fin -->

    <div class="container-fluid">

      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

        <img src="img/banner2.jpg" alt="Banner" class="img-responsive">

        <?php

        $_SESSION['ticket_tipo'] == 1 ? include_once("partes/nav.php") : include_once("partes/nav2.php");

        ?>

      </nav>

      <div class="col-md-5">

      <div class="panel panel-primary">

        <div class="panel-heading">
          <h3 class="panel-title text-center">Mejoras ó Sugerencias</h3>
        </div>

        <div class="panel-body">

          <form name="formulario" id="addTicket" action="scripts/scriptAddSuggestion.php" method="POST" enctype="multipart/form-data">

            <table class="table table-condensed">

              <tr>

                <td>Nombre:</td><td><strong><?=$resultado['personaNombre']?> <?=$resultado['apellido']?></strong></td>

              </tr>

              <tr>

                <td>Titulo:</td><td><input type="text" class="form-control input-sm" id="titulo" name="titulo" size="60" placeholder="Titulo de su Sugerencia" required></td>

              </tr>

              <tr>
                  
                <td>¿Aplica para?</td>
                <td>
                  <span class="form-group" id="error-solicitud">
                    <select name="aplica" class="form-control input-sm" id="solicitud" required>
                      <option value="0">-</option>
                      <option value="La Aplicacion de Tickets">La Aplicacion de Tickets</option>
                      <option value="Ventor">Ventor</option>
                      <option value="Sucursal">Sucursal</option>
                      <option value="Infraestructura">Infraestructura</option>
                      <option value="Equipos Informaticos">Equipos Informaticos</option>
                      <option value="Jefe Inmediato">Jefe Inmediato</option>
                      <option value="7">Otro</option>
                    </select>
                  </span>
                  <input style="margin-top: 4px;" type="text" class="form-control input-sm" id="otro" name="otro" size="60" placeholder="¿A que Aplica su Sugerencia?">
                </td>
                    
                  
              </tr>

              <tr>

                <td>Observación:</td><td><textarea id="observacion" class="form-control input-sm" rows="5" name="observacion" placeholder="De una descripcion de su Solicitud"></textarea></td>

              </tr>

              <tr>

                <td><button type="submit" class="btn btn-primary btn-sm">Enviar</button></td><td> <button type="reset" class="btn btn-primary btn-sm">Borrar</button></td>

              </tr>

            </table>

          </form>

        </div>

      </div>

      </div>

    </div>

  </body>

</html>