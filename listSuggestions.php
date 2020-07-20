<?php

require ("scripts/scriptValidaSession.php");
require ("clases/sugerencia.class.php");
require ("clases/baseDatos.class.php");
require ("clases/usuario.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$sugerencia       = new Sugerencia();

if($_SESSION['ticket_tipo'] == 1){

  $consulta         = $sugerencia->listSuggestionAdmin($conexion);

  $consulta_jquery  = $sugerencia->listSuggestionAdmin($conexion);

}
else{

  $consulta         = $sugerencia->listSuggestion($conexion, $_SESSION['ticket_id']);

  $consulta_jquery  = $sugerencia->listSuggestion($conexion, $_SESSION['ticket_id']);
}

?>

<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Listado de Sugerencias</title>

    <link rel="shortcut icon" href="images/favicon.png" />
    <link href="materialize/css/materialize.min.css" rel="stylesheet" media="screen">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">
    <link href="materialize/css/style.css" rel="stylesheet" media="screen">

    <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

  </head>

  <body>
    <?php while($resultado_jquery   = $consulta_jquery->fetch_array(MYSQLI_ASSOC)): ?>
    <!-- Modal Structure -->
    <div id="<?=$resultado_jquery['id_sugerencia'];?>" class="modal">
      <div class="modal-content">
        <h4>Sugerencia</h4>
        <p><?=htmlentities(strip_tags($resultado_jquery['observacion'])); ?></p>
      </div>
      <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Cerrar</a>
      </div>
    </div>
    <?php endwhile; ?>

    <div id="dialog" title="Observación">
      
    </div>


    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>
    <div class="card-panel grey lighten-4">

      <div class="row">
        <div class="col s12">
          <a class="btn" href="agregarSugerencia-6">Nueva Sugerencia</a>
        </div>
      </div>

      <table class="highlight responsive-table centered">

        <thead>
          
          <tr>

            <th>Usuario</th>
            <th>Titulo</th>
            <th>Aplica para</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Estado</th>
            <td></td>
            <td></td>

          </tr>
          
        </thead>

        <tbody>
          
          <?php
            
            while ($resultado   = $consulta->fetch_array(MYSQLI_ASSOC)){

              

                $fecha = array();

                $fecha = explode("-" ,$resultado['fecha']);

                $fecha[0] = $fecha[0]%1000;

                $resultado['estado'] == '0' ? $estado = 'Abierta': $estado = 'Cerrada';
                $resultado['estado'] == '0' ? $icono = 'fa fa-folder': $icono = 'fa fa-check';
                $resultado['estado'] == '0' ? $title = 'Cerrar': $title = 'Abrir';
                $resultado['estado'] == '0' ? $enlace = "<a title=\"".$title."\" href=\"scripts/scriptCloseSuggestion.php?id=".$resultado['id_sugerencia']."\"><i class=\"".$icono."\"></a>": $enlace = "<i class=\"".$icono."\">";

                echo "<tr>
                  <td>".$resultado['nombre']." ".$resultado['apellido']."</td>
                  <td>".$resultado['titulo']."</td>
                  <td>".$resultado['aplica']."</td>
                  <td>".$fecha[2]."/".$fecha[1]."/".$fecha[0]."</td>
                  <td>".$resultado['hora']."</td>
                  <td>".$estado."</td>
                  <td><button class=\"waves-effect waves-light btn modal-trigger\" href=\"#".$resultado['id_sugerencia']."\">Ver</button></td>
                  <td>".$enlace."</td>
                </tr>";
              
            }
            
            ?>

        </tbody>

      </table>

  

    </div>

  </body>

</html>