function validaEmail(){
                         
var consulta;
                                                 
consulta = $("#email").val();
                      
//hace la búsqueda
$("#validaEmail").delay(1000).queue(function(n) {      
                           
  $("#validaEmail").html('<img src="img/loading.gif">');
                           
        $.ajax({
              type: "POST",
              url: "scripts/scriptValidaEmail.php",
              data: "b="+consulta,
              dataType: "html",
              error: function(){
                    alert("error petición ajax");
              },
              success: function(data){                                                      
                    $("#validaEmail").html(data);
                    n();
              }
  });
                           
});
                          
}