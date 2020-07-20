<?php

      require ("../clases/baseDatos.class.php");

      $codigo = $_POST['b'];
       
      if(!empty($codigo)) {
            comprobar($codigo);
      }
       
      function comprobar($b) {
            $conexion = new baseDatos();

            if ($conexion->connect_errno) {
                
                echo "Fallo la conexion: ".$conexion->connect_error;
            }
       
            $sql = mysqli_query($conexion, "SELECT * FROM zona WHERE codigo = '".$b."'");
             
            $contar = $sql->num_rows;
             
            if($contar == 0){
                  echo "<img src=\"img/valid.png\">";
                  echo "<script type=\"text/javascript\">
                              
                              $(\"#inputCodigo\").val(0);

                        </script>";
            }else{
                  echo "<img src=\"img/mal.png\">";
                  echo "<script type=\"text/javascript\">
                              
                              $(\"#inputCodigo\").val(1);

                        </script>";
            }
      }     
?>