<?php

require ("scripts/scriptValidaSession.php");

?>
<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Help-Desk Añadir Nueva Zona</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>
    <script type="text/javascript" src="js/letrasYnumeros.js"></script>
    <script type="text/javascript" src="js/validaArea.js"></script>

   <script type="text/javascript">

    $(document).ready(function(){

        var codigo   = $("#codigo");

        codigo.focus(validaArea);
        codigo.focusout(validaArea);

        $("#addArea").submit(function() {

          if ($("#inputCodigo").val() == 1) {

            $( "#dialog-modal-codigo" ).dialog({
              height: 140,
              modal: true
            });

            return false;
          }

        });

        $("#dialog-modal-codigo").hide();
        $('#codigo').validCampoFranz('abcdefghijklmnopqrstuvwxyz0123456789');
    });

  </script>

  </head>

  <body>

    <div id="dialog-modal-codigo" class="modal">
      <h4>Atencion!</h4>
      <p>Ya existe un area con ese codigo! <br> Rectifique.</p>
    </div>

    <img src="images/banner-top.png" alt="" width="100%" height="200px">
    <?php

      include_once("partes/nav_tracker.php");

    ?>

    <div class="container">

      <div class="card-panel grey lighten-4">

        <h4 class="header blue-text">Nueva Zona</h4>

        <form class="col s12" name="formulario" id="addArea" action="scripts/scriptAddArea.php" method="POST" enctype="multipart/form-data">

          <div class="row">
            <div class="input-field col s6">
              <input type="text" id="codigo" name="codigo" maxlength="2" required>
              <label for="codigo">Codigo</label>
              <span id="validaCodigo"></span><input type="hidden" id="inputCodigo">
            </div>

            <div class="input-field col s6">
              <input type="text" id="nombre" name="nombre" required></td>
              <label for="nombre">Nombre</label>
            </div>
          </div>

          <div class="row">
            <div class="col s6">
              <button type="reset" class="btn" disabled>Borrar</button>
            </div>
            <div class="col s6">
              <button type="submit" class="btn">Enviar</button>
            </div>
          </div>

        </form>

      </div>

    </div>

  </body>

</html>