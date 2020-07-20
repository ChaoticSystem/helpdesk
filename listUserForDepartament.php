<?php

require ("scripts/scriptValidaSession.php");
require ("clases/usuario.class.php");
require ("clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$usuario = new Usuario();

$consulta = $usuario->listUserForDepartament($conexion, $_GET['id_departamento']);

?>
<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HelpDesk - Listado de usuarios</title>

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
    <div class="card-panel grey lighten-4">
          
      <table class="highlight responsive-table">

        <tr>

          <th>Nombre</th>
          <th>Apellido</th>
          <th>Email</th>
          <th>Usuario</th>
          <th>Tipo</th>
          <th>Estado</th>
          <th>Sede</th>
          <th>Departamento</th>

        </tr>

        <?php
          
          while ($resultado   = $consulta->fetch_array(MYSQLI_ASSOC)){

            if($resultado['tipo'] == 1)
              $tipo = "Administrador";
            elseif($resultado['tipo'] == 2)
              $tipo = "Jefe de Departamento";
            else
              $tipo = "Empleado";

            if($resultado['activo'] == 1){
              
              $activo = "Activo";
              $actdesc = "<i class=\"fa fa-ban\" aria-hidden=\"true\"></i>";
            }
            else{

              $activo = "Desactivado";
              $actdesc = "<i class=\"fa fa-power-off\" aria-hidden=\"true\"></i>";
            }

            if($resultado['id_cede']==11)
              $cede = "Mi primera Sede";
 

            echo "<tr>
                  <td>".$resultado['personaNombre']."</td>
                  <td>".$resultado['apellido']."</td>
                  <td>".$resultado['email']."</td>
                  <td>".$resultado['nombreUsuario']."</td>
                  <td>".$tipo."</td>
                  <td>".$activo."</td>
                  <td>".$cede."</td>
                  <td>".$resultado['nombreDepartamento']."</td>
                </tr>";
          }
          
          ?>

      </table>

    </div>

  </body>

</html>