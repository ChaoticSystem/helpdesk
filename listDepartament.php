<?php

require ("scripts/scriptValidaSession.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Departamentos</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="js/listaDepartamentos.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

    $(document).ready(function(){

      $(".cede").hide();
      $("#empresa").change(function(){
        $(".cede").hide();
        $("#div_" + $(this).val()).show();
      });

      $("#empresa").change(listar)

      function listar(){

        $("#cede"+$("#empresa").val()).change(listaDepartamentos);

      }

    });

    </script>

  </head>

  <body>

    <img src="images/banner-top.png" alt="" width="100%" height="200px">
    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="card-panel grey lighten-4">

      <div class="row">
        <div class="col s12">
          <a class="btn" href="agregarDepartamento-4">Registrar Departamento</a>
        </div>
      </div>

      <table class="highlight responsive-table">

      <tr>
        <th>Compañia</th>
        <td>
          <select name="empresa" id="empresa" class="browser-default">
            <option value="0">Seleccione Empresa</option>
            <option value="1">Mi primera empresa</option>
          </select>
        </td>
      </tr>

      <tr id="div_1" class="cede">
        <th>Sede</th>
        <td>
          <select name="cede1" id="cede1" class="browser-default">
            <option value="0">Seleccione Sede</option>
            <option value="1">Mi primera sede</option>
          </select>
        </td>
      </tr>

      

    </table>

    <div id="listaDepartamentos"></div>

  </div>

  </body>

</html>