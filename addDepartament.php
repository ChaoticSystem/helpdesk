<?php

require ("scripts/scriptValidaSession.php");
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
    <script type="text/javascript" src="js/letrasYnumeros.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

      $(document).ready(function(){

        $(".cede").hide();

        $("#empresa").change(function(){
          $(".cede").hide();
          $("#div_" + $(this).val()).show();
        });

        $('#nombre').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéíóú');

        $("#addDepartament").submit(function() {

          if ($("#empresa").val() == 0) {

            $( "#dialog-modal-empresa" ).openModal();

            return false;

          } else if ($("#cede1").val() == 0 && 
                     $("#cede2").val() == 0 &&
                     $("#cede3").val() == 0 &&
                     $("#cede4").val() == 0 &&
                     $("#cede5").val() == 0 &&
                     $("#cede6").val() == 0 &&
                     $("#cede7").val() == 0){

            $( "#dialog-modal-cede" ).openModal();

            return false;

          } else
            return true;      
        });

        $("#dialog-modal-empresa").hide();
        $("#dialog-modal-cede").hide();
      });

    </script>

  </head>

  <body>

    <!-- Mensajes al Usuario -->

    <div id="dialog-modal-empresa" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>Antes debe seleccionar una Empresa</p>
      </div>
      <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>

    <div id="dialog-modal-cede" class="modal">
      <div class="modal-content">
        <h4>Atención!</h4>
        <p>Antes debe seleccionar una Sede</p>
      </div>
      <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>

    <!-- Fin -->

    <img src="images/banner-top.png" alt="" width="100%" height="200px">
    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="container">

      <div class="card-panel grey lighten-4">

        <div class="row">
          <div class="col s12">
            <a class="btn" href="departamentos-4">Listar Departamentos</a>
          </div>
        </div>

        <form class="col s12" name="formulario" id="addDepartament" action="scripts/scriptAddDepartament.php" method="POST">

          <div class="row">
            <div class="input-field col s12">
              <select name="empresa" id="empresa">
                <option value="0">Seleccione Empresa</option>
                <option value="1">DIARCA, S.A</option>
                <option value="2">DISERIAL, C.A</option>
                <option value="3">DIARCA MONAGAS</option>
                <option value="4">DIARCA GUAYANA</option>
                <option value="5">ETSE</option>
                <option value="6">ALIDELTA, C.A</option>
                <option value="7">TRAISLAND</option>
              </select>
              <label>Compañia</label>
            </div>
          </div>
          
          <div class="row cede" id="div_1">
            <div class="input-field col s12">
              <select name="cede1" id="cede1">
                <option value="0">Seleccione Sede</option>
                <option value="1">Porlamar</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row cede" id="div_2">
            <div class="input-field col s12">
              <select name="cede2" id="cede2" class="form-control input-sm">
                <option value="0">Seleccione Sede</option>
                <option value="1">Barcelona</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row cede" id="div_3">
            <div class="input-field col s12">
              <select name="cede3" id="cede3" class="form-control input-sm">
                <option value="0">Seleccione Sede</option>
                <option value="1">Maturin</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row cede" id="div_4">
            <div class="input-field col s12">
              <select name="cede4" id="cede4" class="form-control input-sm">
                <option value="0">Seleccione Sede</option>
                <option value="1">Puerto Ordaz</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row cede" id="div_5">
            <div class="input-field col s12">
              <select name="cede5" id="cede5" class="form-control input-sm">
                <option value="0">Seleccione Sede</option>
                <option value="1">Barcelona</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row cede" id="div_6">
            <div class="input-field col s12">
              <select name="cede6" id="cede6" class="form-control input-sm">
                <option value="0">Seleccione Sede</option>
                <option value="1">Porlamar</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row cede" id="div_7">
            <div class="input-field col s12">
              <select name="cede7" id="cede7" class="form-control input-sm">
                <option value="0">Seleccione Sede</option>
                <option value="1">Porlamar</option>
                <option value="1">Barcelona</option>
              </select>
              <label>Sede</label>
            </div>
          </div>

          <div class="row">
            <div class="input-field col s12">

              <input type="text" class="form-control input-sm" id="nombre" name="nombre" id="nombre" autofocus required>
              <label for="nombre">Nombre:</label>

            </div>
          </div>


          <div class="row">
            <div class="input-field col s6">
              <button type="reset" class="btn btn-primary btn-sm" disabled>Borrar</button>
            </div>
            <div class="input-field col s6">
              <button type="submit" class="btn btn-primary btn-sm">Enviar</button>
            </div>
          </div>

        </form>

      </div>

    </div>

  </body>

</html>