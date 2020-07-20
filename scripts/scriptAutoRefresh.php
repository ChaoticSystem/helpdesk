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
       
            $sql = mysqli_query($conexion, "SELECT * FROM ticket WHERE status = '1'");
             
            $contar = $sql->num_rows;
             
            if($contar > $b)
                  echo "<script type=\"text/javascript\"> $(document).attr(\"title\", \"(".(int)($contar-$b).") HelpDesk - Solicitudes pendientes\") </script>";
            
      }     
?>