function validaPlaca(){
                         
var consulta;
                                                 
consulta = $("#placa").val();
                      
//hace la búsqueda
$("#validaPlaca").delay(1000).queue(function(n) {      
                           
  $("#validaPlaca").html('<img src="img/loading.gif">');
                           
    $.ajax({
          type: "POST",
          url: "scripts/scriptValidaPlaca.php",
          data: "b="+consulta,
          dataType: "html",
          error: function(){
                alert("error petición ajax");
          },
          success: function(data){                                                      
                $("#validaPlaca").html(data);
                n();
          }
    });
                           
});
                          
}