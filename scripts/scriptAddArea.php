<?php

require ("scriptValidaSession.php");
require ("../clases/area.class.php");
require ("../clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$zona = new Area();

$zona->setCodigo($_POST['codigo']);
$zona->setNombre($_POST['nombre']);
$zona->addArea($conexion);

$conexion->close();

header("location: ../listArea.php?active=6");
?>