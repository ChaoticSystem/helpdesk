<?php
if(!empty($_POST))
{
	//database settings
	require ("../clases/baseDatos.class.php");

	$conexion = new baseDatos();

    if ($conexion->connect_errno) {
        
        echo "Fallo la conexion: ".$conexion->connect_error;
    }

	foreach($_POST as $field_name => $val)
	{
		//clean post values
		$field_userid = strip_tags(trim($field_name));
		$val = strip_tags(trim(mysqli_real_escape_string ( $conexion , $val )));

		//from the fieldname:user_id we need to get user_id
		$split_data = explode(':', $field_userid);
		$user_id = $split_data[1];
		$field_name = $split_data[0];
		if(!empty($user_id) && !empty($field_name) && !empty($val))
		{
			//update the values
			mysqli_query($conexion, "UPDATE respuestas SET $field_name = '$val' WHERE id = $user_id") or mysqli_error();
			echo "Respuesta Actulizada";
		} else {
			echo "Invalid Requests";
		}
	}
} else {
	echo "Invalid Requests";
}
?>