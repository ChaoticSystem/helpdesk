<?php

class baseDatos extends mysqli{
	
	function __construct(){
		
		parent::__construct("localhost", "root", "", "helpdesk");
	}
}

?>
