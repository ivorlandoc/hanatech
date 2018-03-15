$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


$(function(){
$("#reserva_plaza").keypress(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {        
        ajaxloadsearch();
        return false;
        }
      }); 
})


   
function ajaxloadsearch() {   
     var formData = new FormData($("form[name='formreserva']")[0]);
      $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#formreserva').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {           
           getAllRows(data);       
           $('.loading').hide();          
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function getAllRows(data) { 
//  alert(data.length);
  if(data.length!=0){    
    $('#ShowDataHead').show();
      $.each(data, function( key, value ) {      
      $('#IdDivDependencia').html(value.sede+' <b>|</b> '+ value.organo+' | ' +value.gerencia+' | '+value.dep +' | '+value.dependencia);
      $('#IdDivNivel').html(value.IdNivel);
      $('#IdDivCargo').html(value.cargo);  
      $('#nroplazar').val(value.NroPlaza); 
      $('#txtidcargo').val(value.IdCargo);  
      $('#txtidplaza').val(value.IdPlaza); 
      $('#txtestructura').val(value.IdEstructura);
           
      });       
  }else{
    $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(4000).fadeOut('slow');
  }
   
}


function SaveProcesaRserva(){    
   var formData = new FormData($("form[name='formreservaPro']")[0]);  
      $('.loading').show();
      var plaz=$('#nroplazar').val();
    if(plaz.trim()==""){
      $('#IdMensajeAlert').html('<div class="alert alert-danger" role="alert"></span>Vuelve a buscar con el # de Plaza</div>').fadeIn().delay(4000).fadeOut('slow');
    }else{
                $.ajax({  
                        type: "post",
                        headers: {'X-CSRF-TOKEN':$('#token').val()},
                        url:  $('#formreservaPro').attr('action'),
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    success: function (data) {            
                        if(data===true) {               
                               $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');                   
                               $("#formreservaPro")[0].reset();
                               //$('#IdSalir').click();
                            } else {
                               $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
                        }
                       $('.loading').hide();          
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
        }

}