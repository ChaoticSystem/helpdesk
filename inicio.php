<?php

require ("scripts/scriptValidaSession.php");
?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Inicio</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">


    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>


  </head>

  <body>

  
    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

	  ?>
    <div class="slider">
      <ul class="slides">
        <li>
          <img src="images/slider_inicio/slider0.png">
        </li>
        <li>
          <img src="images/slider_inicio/slider1.png">
        </li>
        <li>
          <img src="images/slider_inicio/slider2.png">
        </li>
        <li>
          <img src="images/slider_inicio/slider3.png">
        </li>
        <li>
          <img src="images/slider_inicio/slider4.png">
        </li>
      </ul>
    </div>
  </body>

</html>