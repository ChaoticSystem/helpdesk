<?php

require ("scriptValidaSession.php");
require ("../clases/departamento.class.php");
require ("../clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$departamento = new Departamento();

$departamento->setNombre($_POST['nombre']);
$departamento->setFecha();
$departamento->editDepartament($conexion, $_GET['id'], $_SESSION['ticket_id']);

$conexion->close();

header("location: ../departamentos-4");
?>