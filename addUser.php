<?php

require ("scripts/scriptValidaSession.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Nuevo usuario</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="js/generaNombreUsuario.js"></script>
    <script type="text/javascript" src="js/validaNombreUsuario.js"></script>
    <script type="text/javascript" src="js/validaCedula.js"></script>
    <script type="text/javascript" src="js/validaEmail.js"></script>
    <script type="text/javascript" src="js/letrasYnumeros.js"></script>
    <script type="text/javascript" src="js/listaDepartamentoUsuario.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>


    <script type="text/javascript">

	$(document).ready(function(){

		var nombreUsuario 	= $("#nombreUsuario");
		var cedula 			= $("#cedula");
		var email 			= $("#email");

		nombreUsuario.focus(creaNombre);
		nombreUsuario.focus(validaUsuario);
		nombreUsuario.focusout(validaUsuario);
		email.focus(validaCedula);
		email.focusout(validaCedula);
		email.focus(validaEmail);
		email.focusout(validaEmail);

		$(".cede").hide();

		$("#empresa").change(function(){

			$(".cede").hide();
			$("#div_" + $(this).val()).show();
		});

		$("#empresa").change(listar)

		function listar(){

			$("#cede"+$("#empresa").val()).change(listaDepartamentoUsuario);

		}

		$('#nombre').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéíóú');
		$('#apellido').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéíóú');
		$('#nombreUsuario').validCampoFranz(' abcdefghijklmnñopqrstuvwxyz');
		$('#email').validCampoFranz(' abcdefghijklmnopqrstuvwxyz0123456789@-_.');
		$('#cedula').validCampoFranz('0123456789');

		$("#addUser").submit(function() {

			if ($("#empresa").val() == 0) {

				$( "#dialog-modal-empresa" ).openModal();

				return false;

			} else if ($("#cede1").val() == 0 && $("#cede2").val() == 0) {

				$( "#dialog-modal-cede" ).openModal();

				return false;

			} else
				return true;      
		});

	});

    </script>

  </head>

  <body>

  	<!-- Mensajes al Usuario -->

  	<div id="dialog-modal-empresa" class="modal">
  		<div class="modal-content">
	        <h4>Atencion!</h4>
	        <p>Antes debe seleccionar una Empresa</p>
      	</div>
    </div>

    <div id="dialog-modal-cede" class="modal">
  		<div class="modal-content">
	        <h4>Atencion!</h4>
	        <p>Antes debe seleccionar una Sede</p>
      	</div>
    </div>

    <!-- Fin -->

    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="container">
    	<div class="card-panel grey lighten-4">

      	<div class="col s12"><a class="btn" href="usuarios-3"><i class="fa fa-users" aria-hidden="true">	
      	</i> Listar Usuarios</a></div>


	    <div class="row">
		    <h4 class="header text-center">Nuevo Usuario</h4>
		    <hr>

	      	<form class="col s12" name="formulario" id="addUser" action="scripts/scriptAddUser.php" method="POST">
				
				<div class="row">

			        <div class="input-field col s6">

			          <label>Nombre:</label>
			          <input type="text" class="form-control input-sm" id="nombre" name="nombre" autofocus required>

			        </div>

			        <div class="input-field col s6">

			          <label>Apellido:</label>
			          <input type="text"  class="form-control input-sm" id="apellido" name="apellido" required>

			        </div>

		        </div>

		        <div class="row">

			        <div class="input-field col s6">

			          <label>Cedula:</label>
			          <input type="text" class="form-control input-sm" id="cedula" name="cedula" required><span id="validaCedula"></span>

			        </div>

			        <div class="input-field col s6">

			          <label>Correo Electronico:</label>
			          <input type="text" class="form-control input-sm" id="email" name="email" required><span id="validaEmail"></span>

			        </div>

		        </div>

		        <div class="row">

			        <div class="input-field col s6">

			          <label>Nombre de Usuario:</label>
			          <input type="text" class="form-control input-sm" id="nombreUsuario" name="nombreUsuario" required><span id="validaUsuario"></span>

			        </div>

			        <div class="col s6">
			            
			          	<label>Tipo de Usuario</label>
			            <select name="tipo" id="tipo">
			            	<option value="3">Empleado</option>
		                    <option value="2">Jefe de Departamento</option>
		                    <option value="4">Gerente</option>
		                    <option value="5">Gerente General</option>
		                    <option value="1">Administrador</option>
			            </select>
			              
			            
			        </div>

		        </div>

		        <div class="row">
				      <h4 class="header text-center">Departamento</h4>
				      <hr>
		        	<div class="col s12">
		            <label>Compañia</label>
              	<select name="empresa" id="empresa" class="browser-default">
                  <option value="0">Seleccione Empresa</option>
                  <option value="1">Mi primera Empresa</option>
                  
              	</select>
		          </div>
	            <div id="div_1" class="col s12 cede">
                <label>Sede</label>
                <select name="cede1" id="cede1" class="browser-default">
                  <option value="0">Seleccione Sede</option>
                  <option value="1">Mi primera Sede</option>
                </select>
	            </div>
	           
    					<div class="col s12">
    						<div>Seleccione un Departamento </div>
    						<div id="listaDepartamentos" style="padding-left: 2px"></div>
    					</div>
		        </div>

		        <div class="row">
		        	<div class="col s6">
		            <button type="reset" class="btn btn-primary btn-sm" disabled>Borrar</button>
              </div>
              <div class="col s6">
                <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
		        	</div>
		        </div>


		    </form>

	    </div>
	</div>
    </div>

  </body>

</html>
