$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  
$("#txtplaza").keypress(function(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
          _getdatosplaza();
          return false;
        }
  });

function _getdatosplaza() {   
    var formData = new FormData($("form[name='frmintegra']")[0]);   
    $('.loading').show();   
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmintegra').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {                
                 allrowsplaza(data);                
           $('.loading').hide(); 
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

 var xy=0;
function allrowsplaza(data) { 
   
    var tableHtml="";       
    if(data.length!=0){ 
    $.each(data, function( key, value ) {         
    xy++;      
    tableHtml += '<tr>'+ 
                   '<td><input type="hidden" id="IN'+xy+'" name="IN'+xy+'" value="'+value.NroPlaza+'" >'+value.NroPlaza+'</td>'+
                   '<td>'+value.IdNivel+'</td>'+
                   '<td>'+value.cargo+'</td>'+
                   '<td>'+value.Estado+'</td>'+
                   '</tr>';
                   
    }); 
        $('#idshowPlazasIntegra').append(tableHtml);
        $('#txtplaza').val('');
       }else{      
   if( xy==0) $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(4000).fadeOut('slow');
  }
   
}

function saveintegracionplaza(){    
   var formData = new FormData($("form[name='frmintegrasave']")[0]);  
      $('.loading').show();
      var nrop      = $('#nroplazaintegrada').val();
      //var PzInte    = $('#IN2').val();
     
     
    if(nrop.trim()==""){
      $('#IdMensajeAlert').html('<div class="alert alert-danger" role="alert"></span>Ingrese el # de Plaza para Recategorizar</div>').fadeIn().delay(4000).fadeOut('slow');
    }else{
                if($('#IN2').length){                
                          $.ajax({  
                                  type: "post",
                                  headers: {'X-CSRF-TOKEN':$('#token').val()},
                                  url:  $('#frmintegrasave').attr('action'),
                                  dataType: 'json',
                                  data: formData,
                                  cache: false,
                                  contentType: false,
                                  processData: false,
                              success: function (data) {                                      
                                  if(data===1) {               
                                         $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');                   
                                         $("#frmintegrasave")[0].reset();                                       
                                         $('#idshowPlazasIntegra').html('');                        
                                      } else {
                                         $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
                                  }
                                 $('.loading').hide();          
                              },
                              error: function (xhr, status, error) {
                                  alert(xhr.responseText);
                              }
                          });
                  }else{
                    $('#IdMensajeAlert').html('<div class="alert alert-danger" role="alert"></span>Se requiere mas de una plaza para Recategorizar</div>').fadeIn().delay(4000).fadeOut('slow');
                  }

       }   
}