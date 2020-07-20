function validaCedula(){
                         
var consulta;
                                                 
consulta = $("#cedula").val();
                      
//hace la búsqueda
$("#validaCedula").delay(1000).queue(function(n) {      
                           
  $("#validaCedula").html('<img src="img/loading.gif">');
                           
    $.ajax({
          type: "POST",
          url: "scripts/scriptValidaCedula.php",
          data: "b="+consulta,
          dataType: "html",
          error: function(){
                alert("error petición ajax");
          },
          success: function(data){                                                      
                $("#validaCedula").html(data);
                n();
          }
    });
                           
});
                          
}