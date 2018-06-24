$(function(){
$('#DesingForm').hide();
  $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });

})

$(document).ready(function(){
    $('#string_search').keyup(function(){$(this).val($(this).val().toUpperCase());});
  
});

$("#IdSavebajaPlaza").click(function (e) {
  e.preventDefault();
    
     console.log("--0-->");
  var formData = new FormData($("form[name='frmsaveBaja']")[0]);
  
  var messages="";
 
  var _IdPersona        = $('#IdPersona').val();
  var _IdPlaza          = $('#IdPlaza').val();
  var _IdEstructura     = $('#IdEstructura').val();
  var _IdCargo          = $('#IdCargo').val();
  var _NroPlaza         = $('#NroPlaza').val();
  var _IdTMovbaja    = $('#IdTipoMovbaja').val();
  var _FechaBaja        = $('#datetime3').val();
  var _FechaDocBja      = $('#datetime1').val();
  var _DocRefBaja       = $('#DocRefBaja').val();
  var _FileAdjunto      = $('#FileAdjuntoBaja').val();
 
 
       if(_IdPersona==""){    messages="No Existe el codigo de la Persona, vuelva a cargar la pagina";} 
  else if(_IdPlaza==""){    messages="No Existe el codigo de la plaza, vuelva a cargar la pagina";} 
  else if(_IdEstructura==""){     messages="No Existe el codigo de la Dependencia, vuelva a cargar la pagina";} 
  else if(_IdCargo==""){    messages="No Existe el codigo del Cargo, vuelva a cargar la pagina";} 
  else if(_NroPlaza==""){    messages="No Existe el N° de la Plaza, vuelva a cargar la pagina";} 
  else if(_IdTMovbaja==""){    messages="Por favor seleccione el tipo de baja";} 
  else if(_FechaBaja==""){    messages="Por favor, seleccione la fecha de baja";} 
  else if(_FechaDocBja==""){    messages="Por favor, seleccione la fecha del documento de baja";} 
  else if(_DocRefBaja==""){    messages="Por favor, ingrese el N° de documento de referencia";} 
  else if(_FileAdjunto==""){    messages="Por favor, adjunte el documento en formato .pdf";} else{messages="";}

 
  
  if(messages==""){    
        $.ajax({
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#_token').val()},
            url:  $('#frmsaveBaja').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){                
                if(data===true) {     
                //alert("-2->"+data);     
                       $("#Idmessage").html('<div class="alert alert-success alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Éxito:</strong>La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');                    
                       $("#frmsaveBaja")[0].reset();   
                       //alert(_NroPlaza);     
                       /*===============================================*/
                      //  swal("Advertencia !", "La Plaza dado de baja\n "+_NroPlaza, "error");
                        /*===============================================*/
                        $("#txtIdPlaza").val(_NroPlaza);
                    } else {
                       $("#Idmessage").html('<div class="alert alert-danger alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Error: </strong>La Operación no se realizó!</div>').fadeIn().delay(4000).fadeOut('slow');
                    }
            }  
        });
    } else { $("#Idmessage").html('<div class="alert alert-danger alert-dismissable margin5"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Error: </strong>'+messages+' !</div>').fadeIn().delay(4000).fadeOut('slow'); }
    
    


  });



function ShowFormBaja(idx){	

	$.get('../api/admin/bajaplazas/'+idx,function(dataPlz){	
       		var xy=0;   
       	
       		console.log("-----2----->"+idx); 
       		var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Error:</strong> no existe registros!</div>';

       		var plaza="";
       		var Dep="";
       		$('#GetSearch').hide();
       		$('#DesingForm').show();
       		var html_name_="";

       		var _IdPersona='';
          var _IdPlaza ="";
       		var _IdEstructura='';
       		var _IdCargo='';
       		var _NroPlaza='';
       		if(dataPlz.length!=0){  		
			for (var i=0; i < dataPlz.length; i++) 	{		
				xy++; 
				plaza 	=	dataPlz[i].NroPlaza+' / '+dataPlz[i].IdNivel+' / '+dataPlz[i].cargo;

				Dep 	=	dataPlz[i].desc1 +' | '+dataPlz[i].desc2+' | '+dataPlz[i].desc3+' | '+dataPlz[i].ofi+' | '+dataPlz[i].Descripcion; 

				html_name_ += dataPlz[i].nombres;
        console.log("============IdPlaza====>"+dataPlz[i].IdPlaza);
				_IdPersona		=dataPlz[i].IdPersona;
        _IdPlaza      =dataPlz[i].IdPlaza;
   		 	_IdEstructura	=dataPlz[i].IdEstructura;
   		 	_IdCargo		  =dataPlz[i].IdCargo;
   			_NroPlaza		  =dataPlz[i].NroPlaza;

				$('#txtnombres').val(html_name_);					
				$('#txtIdPlaza').val(plaza);
				$('#txtIdEstructura').val(Dep);
				
				$('#IdPersona').val(_IdPersona);
        $('#IdPlaza').val(_IdPlaza);
				$('#IdEstructura').val(_IdEstructura);
				$('#IdCargo').val(_IdCargo);
				$('#NroPlaza').val(_NroPlaza);

									
			}

		}else{
			$('#DesingForm').html(ErrorHtml);
		}
		GetTipoBaja(idx);
	});						
	
}


function GetTipoBaja(idx){	
	$.get('../api/admin/bajaplazas/list/'+idx,function(dataTipb){	
       		var xy=0;          	
       		var html_="<option value=''>Elija el Motivo de baja</option> ";
       		if(dataTipb.length!=0){  		
			for (var i=0; i < dataTipb.length; i++) 	{
				xy++; 
				html_ += '<option value="'+dataTipb[i].IdTipobaja+'">'+dataTipb[i].IdTipobaja + '  |  '+dataTipb[i].Descripcion+'</option>';
				$('#IdTipoMovbaja').html(html_);	
										
			}

		}else{
			$('#IdTipoMovbaja').html("No existe registros");
		}
		
	});	
}
