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
    <title>HelpDesk - Nueva sugerencia</title>

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

       
				if ($("#titulo").val() < 5) {

				   $("#dialog-modal-titulo").openModal();
					
					 return false;
					
					}


			   if ($("#solicitud").val() == 0) {

			   $("#dialog-modal-solicitud").openModal();
				
				 return false;
				
				}

      
		
				 if ($("#observacion").val().length < 15) {

			   $("#dialog-modal-otro").openModal();
				
				 return false;
				
				}
		

      });

        $("#solicitud").change(function(){

          if($("#solicitud").val() == 7){

             $("#dialog-modal-otro").openModal();
		
				return false;
        
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

    <div id="dialog-modal-titulo" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>Antes debe indicar el titulo de su solicitud.</p>
      </div>
    </div>


<div id="dialog-modal-solicitud" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>Indique a que área va dirigida su solicitud.</p>
      </div>
    </div>

	
	
    <div id="dialog-modal-otro" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>Explique detalladamente su sugerencia en el area de abajo.</p>
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
            <input type="text" id="titulo" name="titulo" size="60" >
            <label for="titulo">Titulo:</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">
              <label for="solicitud">¿Aplica para?</label>
              <span class="form-group" id="error-solicitud">
                <select name="aplica" id="solicitud" >
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
              <textarea id="observacion"  class="materialize-textarea" rows="5" name="observacion" placeholder="De una descripcion de su Solicitud"></textarea>
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
