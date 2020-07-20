<?php

require ("scripts/scriptValidaSession.php");
require ("clases/usuario.class.php");
require ("clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->searchUser($conexion, $_GET['id']);

$resultado 	= $consulta->fetch_array(MYSQLI_ASSOC);

$checked1="";
$checked2="";
$checked3="";
$checked4="";
$checked5="";

if($resultado['tipo']==1)
	$checked1 = "selected";
elseif ($resultado['tipo']==2)
	$checked2 = "selected";
elseif ($resultado['tipo']==3)
	$checked3 = "selected";
elseif ($resultado['tipo']==4)
	$checked4 = "selected";
else
	$checked5 = "selected";

$resultado['plataforma'] ? $checkedp = "checked" : $checkedp = " ";
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Editar usuario</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/letrasYnumeros.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

		$(function(){

	        $('#nombre').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéíóú');
	        $('#apellido').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéíóú');
	        $('#nombreUsuario').validCampoFranz(' abcdefghijklmnñopqrstuvwxyz');
	        $('#email').validCampoFranz(' abcdefghijklmnopqrstuvwxyz0123456789@-_.');
	        $('#cedula').validCampoFranz('0123456789');
        });

    </script>

  </head>

  <body>

    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="container">

	    <div class="card-panel grey lighten-4">

			<?php

				if($_SESSION['ticket_tipo'] == 1) echo "<div class=\"col-md-12\"><a class=\"btn\" href=\"agregarUsuario-3\">Registrar Usuario</a> <a class=\"btn\" href=\"usuarios-3\">Listar Usuarios</a></div>"

			?>

	      	<div class="row">
				    <h4 class="header text-center">Perfil</h4>
				    <hr>

	          	<form class="col s12" name="formularioUsuario" action="scripts/scriptEditUser.php?id=<?=$resultado['idPersona']?>" method="POST">

					<div class="row">

						<div class="input-field col s6">

							<label>Nombre:</label>
							<input type="text" required class="form-control input-sm" id="nombre" name="nombre" value="<?=$resultado['personaNombre']?>">

						</div>

						<div class="input-field col s6">

							<label>Apellido:</label>
							<input type="text" required class="form-control input-sm" id="apellido" name="apellido" value="<?=$resultado['apellido']?>">

						</div>

					</div>

					<div class="row">

						<div class="input-field col s6">

							<label>Cedula:</label>
							<input type="text" required class="form-control input-sm" id="cedula" name="cedula" value="<?=$resultado['cedula']?>">

						</div>

						<div class="input-field col s6">

							<label>Email:</label>
							<input type="text" required class="form-control input-sm" id="email" name="email" size="30" value="<?=$resultado['email']?>">

						</div>

					</div>

					<?php

					if($_SESSION['ticket_tipo'] == 1) 

						echo "<div class=\"row\">

						<div class=\"col s12\">
							
							<label>Tipo de Usuario</label>
							<select name=\"tipo\" id=\"tipo\" class=\"form-control input-sm\">
				            	<option value=\"3\" ".$checked3.">Empleado</option>
			                    <option value=\"2\" ".$checked2.">Jefe de Departamento</option>
			                    <option value=\"4\" ".$checked4.">Gerente</option>
			                    <option value=\"5\" ".$checked5.">Gerente General</option>
			                    <option value=\"1\" ".$checked1.">Adminstrador</option>
			            	</select>

						</div>

								
							
					</div>";

					?>

					<div class="row">

						<div class="col s6">
						  <button type="reset" class="btn btn-primary btn-sm" disabled>Deshacer</button>
            </div>
            <div class="col s6">
              <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
						</div>


					</div>

				</form>

	      	</div>

	    </div>
	    
    </div>

  </body>

</html>
