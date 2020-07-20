<?php

session_start();

if(isset($_SESSION['ticket_usuario'])){

	header("location:inicio-5");
}

if(isset($_GET['error'])){

	$_GET['error'] == 1 ? $error = "¡Usuario ó Clave Invalidos!" : $error = "¡Usuario Desactivado!";
}
elseif(isset($_GET['login'])){

	!$_GET['login'] ? $error = "¡Error no se encuentra Logueado en el Sistema!" : $error = " ";
}
elseif(isset($_GET['email'])){

	!$_GET['email'] ? $error = "¡El correo Electronico no existe en el Sistema!" : $error = "Su Usuario y Contraseña Fueron enviados a su Correo Electronico.";
}
else
	$error=" ";
?>

<!DOCTYPE html>

<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Login</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

  </head>

  <body>

  <main>
    <center>
      <img class="responsive-img" src="images/logo.png" width="15%" height="15%" />

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

          <form role="form" method="POST" action="scripts/login.php" class="col-12">

            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <label for="Usuario">Usuario:</label>
                <input type="text" class="form-control" name="usuario" id="usuario" required autofocus>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <label for="Clave">Clave:</label>
                <input type="password" class="form-control" name="clave" id="clave" required>
              </div>
              <label style='float: right;'><a class='black-text' href="forgotUserAndPassword.php"><b>¿Olvido su Contraseña?</b></a></label>
            </div>

            <br />
            <center>
              <div class='row'>
                <button type="reset" class='col s5 btn waves-effect teal lighten-2'>Borrar</button>
                <button type="submit" class='col s5 offset-s2 btn waves-effect blue darken-1'>Enviar</button>
              </div>
            </center>
          </form>
        </div>
      </div>
    </center>
    <?php if(isset($_GET['error']) || isset($_GET['login']) || isset($_GET['email'])): ?>
      <center>
        <div class="container">
          <div class="row" style="display: inline-block;">
            <div class="card-panel grey lighten-1"><?=$error?></div>
          </div>
        </div>
      </center>
    <?php endif; ?>
  </main>



  </body>

</html>