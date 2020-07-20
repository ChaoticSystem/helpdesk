function validaUsuario(){
                         
var consulta;
                                                 
consulta = $("#nombreUsuario").val();
                      
//hace la búsqueda
$("#validaUsuario").delay(1000).queue(function(n) {      
                           
  $("#validaUsuario").html('<img src="img/loading.gif">');
                           
        $.ajax({
              type: "POST",
              url: "scripts/scriptValidaNombreUsuario.php",
              data: "b="+consulta,
              dataType: "html",
              error: function(){
                    alert("error petición ajax");
              },
              success: function(data){                                                      
                    $("#validaUsuario").html(data);
                    n();
              }
  });
                           
});
                          
}