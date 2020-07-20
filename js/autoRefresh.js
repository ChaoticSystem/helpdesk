function autoRefresh(){
                         
var consulta;
                                                 
consulta = $("#registros").val();
                      
//hace la búsqueda
$("#registros").delay(1000).queue(function(n) {      
                           
        $.ajax({
              type: "POST",
              url: "scripts/scriptAutoRefresh.php",
              data: "b="+consulta,
              dataType: "html",
              error: function(){
                    return;
              },
              success: function(data){                                                      
                    $("#registros").html(data);
                    n();
              }
  });
                           
});
                          
}