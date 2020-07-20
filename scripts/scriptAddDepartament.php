<?php

require ("scriptValidaSession.php");
require ("../clases/departamento.class.php");
require ("../clases/baseDatos.class.php");

$conexion = new baseDatos();

if ($conexion->connect_errno) {
    
    echo "Fallo la conexion: ".$conexion->connect_error;
}

$departamento = new Departamento();

$departamento->setCede($_POST['empresa'].$_POST['cede'.$_POST['empresa']]);
$departamento->setNombre($_POST['nombre']);
$departamento->setFecha();
$departamento->addDepartament($conexion, $_SESSION['ticket_id']);

$conexion->close();

header("location: ../departamentos-4");
?>