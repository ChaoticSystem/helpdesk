<?php

require ("scriptValidaSession.php");
require ("../clases/sugerencia.class.php");
require ("../clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$sugerencia = new Sugerencia();

$sugerencia->closeSuggestion($conexion, $_GET['id']);

$conexion->close();

header("location: ../sugerencias-6");
?>