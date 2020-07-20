<?php

      //database settings
      require ("../clases/baseDatos.class.php");

      $cede = $_POST['b'];
       
      if(!empty($cede)) {
            comprobar($cede);
      }
       
      function comprobar($b) {

            $conexion = new baseDatos();

                if ($conexion->connect_errno) {
                    
                    echo "Fallo la conexion: ".$conexion->connect_error;
                };
       
            $sql = mysqli_query($conexion, "SELECT * FROM departamento WHERE id_cede = '".$b."' ");

            echo "<table class=\"highlight responsive-table\">

                        <tr>

                              <th>Nombre</th>
                              <td></td>
                              <td></td>

                        </tr>";
             
            while($resultado = $sql->fetch_array(MYSQLI_ASSOC)){

                  echo "<tr>

                              <td>".$resultado['nombre']."</td>
                              <td><a class=\"btn\" href=\"usuariosPorDepartamento-4-".$resultado['id']."\">Ver Empleados</a></td>
                              <td><a title=\"Editar\" href=\"editarDepartamento-4-".$resultado['id']."\"><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></a></td>

                        </tr>";
            }

            echo "</table>";
      }
?>