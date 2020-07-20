<?php

require ("scripts/scriptValidaSession.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Cambio de clave</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

    $(document).ready(function(){
      $("#cambioClave").submit(function() {

          if ($("#clave").val() != $("#clave2").val()) {
            alert("Las Claves no son iguales\n\nIntente Nuevamente");   
            return false;
          } else 
              return true;      
        });
    });

  </script>

  </head>

  <body>

    <main>
    <center>
      <img class="responsive-img" src="images/logo.png" width="15%" height="15%" />

      <div class="container">
        <div class="z-depth-1 grey lighten-4 row" style="display: inline-block; padding: 32px 48px 0px 48px; border: 1px solid #EEE;">

          <form role="form" method="POST" action="scripts/scriptChanguePass.php" id="cambioClave" class="col-12">

            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <label for="Usuario">Clave:</label>
                <input type="password" class="form-control" name="clave" id="clave" required autofocus>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <label for="Clave">Repita la Clave:</label>
                <input type="password" class="form-control" name="clave2" id="clave2" required>
              </div>
            </div>

            <br />
            <center>
              <div class='row'>
                <button type="submit" class='col s5 btn waves-effect blue darken-1'>Enviar</button>
                <button type="reset" class='col s5 offset-s2 btn waves-effect teal accent-3'>Borrar</button>
              </div>
            </center>
          </form>
        </div>
      </div>
    </center>
  </main>

  </body>

</html>