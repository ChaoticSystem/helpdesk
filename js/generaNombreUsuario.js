function creaNombre(){

	if($("#nombre").val().length>0 && $("#apellido").val().length>0 && $("#nombreUsuario").val().length==0){

		var comp 			= $("#nombre").val();
		var comp2			= $("#apellido").val();
			
		$("#nombreUsuario").val(comp[0]+comp2);
	}
}