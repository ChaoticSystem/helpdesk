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
       
            $sql = mysqli_query($conexion, "SELECT * FROM departamento WHERE id_cede = '".$b."' ") or die("Error listanto: ".mysql_error($con));

            if($sql->num_rows){
             
                  while($resultado = $sql->fetch_array(MYSQLI_ASSOC)){

                        echo "<input type=\"radio\" name=\"departamento\" id=\"departamento".$resultado['id']."\" value=\"".$resultado['id']."\" required>
                              <label for=\"departamento".$resultado['id']."\">".$resultado['nombre']."</label>";
                  }
            }
            else
                  echo "No hay departamentos registrados en la cede.";
      }
