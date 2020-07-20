function validaArea(){
                         
var consulta;
                                                 
consulta = $("#codigo").val();
                      
//hace la búsqueda
$("#validaCodigo").delay(1000).queue(function(n) {      
                           
  $("#validaCodigo").html('<img src="img/loading.gif">');
                           
    $.ajax({
          type: "POST",
          url: "scripts/scriptValidaCodigoArea.php",
          data: "b="+consulta,
          dataType: "html",
          error: function(){
                alert("error petición ajax");
          },
          success: function(data){                                                      
                $("#validaCodigo").html(data);
                n();
          }
    });
                           
});
                          
}