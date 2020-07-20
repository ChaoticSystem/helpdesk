<?php
      //database settings
      require ("../clases/baseDatos.class.php");

      $user = $_POST['b'];
       
      if(!empty($user)) {
            comprobar($user);
      }
       
      function comprobar($b) {

            $conexion = new baseDatos();

                if ($conexion->connect_errno) {
                    
                    echo "Fallo la conexion: ".$conexion->connect_error;
                };
       
            $sql = mysqli_query($conexion, "SELECT * FROM persona WHERE email = '".$b."'");
             
            $contar = $sql->num_rows;
             
            if($contar == 0){
                  echo "<img src=\"img/valid.png\">";
            }else{
                  echo "<img src=\"img/mal.png\">";
            }
      }     
?>