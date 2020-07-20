function listaDepartamentoUsuario(){
                         
var consulta = $("#empresa").val()+$("#cede"+$("#empresa").val()).val();
                      
//hace la búsqueda
$("#listaDepartamentos").delay(1000).queue(function(n) {      
                           
  $("#listaDepartamentos").html('<img src="img/loading.gif">');
                           
        $.ajax({
              type: "POST",
              url: "scripts/scriptListDepartamentUser.php",
              data: "b="+consulta,
              dataType: "html",
              error: function(){
                    alert("error petición ajax");
              },
              success: function(data){                                                      
                    $("#listaDepartamentos").html(data);
                    n();
              }
  });
                           
});
                          
}