<?php

require ("scripts/scriptValidaSession.php");
require ("clases/departamento.class.php");
require ("clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$departamento = new Departamento();

$consulta = $departamento->searchDepartament($conexion, $_GET['id']);

$resultado  = $consulta->fetch_array(MYSQLI_ASSOC);
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
    <script type="text/javascript" src="js/letrasYnumeros.js"></script>
    <script type="text/javascript" src="materialize/js/materialize.min.js"></script>
    <script type="text/javascript" src="materialize/js/init.js"></script>

    <script type="text/javascript">

      $(function(){

        $('#nombre').validCampoFranz(' abcdefghijklmnñopqrstuvwxyzáéíóú');
      });

    </script> 

  </head>

  <body>

    <?php

      if($_SESSION['ticket_tipo'] == 1 || ($_SESSION['ticket_tipo'] > 3 && $_SESSION['ticket_tipo'] < 6) ) include_once("partes/nav.php"); else include_once("partes/nav2.php");

    ?>

    <div class="container">

      <div class="card-panel grey lighten-4">
      
        <div class="row">
          <div class="col s12">
            <a class="btn teal lighten-2" href="agregarDepartamento-4">Registrar Departamento</a>
            <a class="btn teal lighten-2" href="departamentos-4">Listar Departamentos</a>
          </div>
        </div>
          
        <form class="col s12" name="formularioDepartamento" action="scripts/scriptEditDepartament.php?id=<?=$resultado['id']?>" method="POST">

            <div class="row">
              <div class="input-field col s12">
                <label>Nombre:</label>
                <input type="text" required class="form-control input-sm" id="nombre" name="nombre" value="<?=$resultado['nombre']?>">
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

  </body>

</html>