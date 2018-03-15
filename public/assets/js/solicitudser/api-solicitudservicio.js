
$(function(){
GetDataDetResevas();

})

$("#idSaveReservaPlaza").click(function (e) {
    e.preventDefault();  	
    var formData = new FormData($("form[name='frmsolicitud']")[0]);
    
    var messages="";
	var _selectTipoR			= $('#selectTipoR').val();
	var _txtdni					= $('#txtdni').val();
	var _txtnombres				= $('#txtnombres').val();
	var	_fechadoc				= $('#datetime3').val();
	var _txtreferencia			= $('#txtreferencia').val();
	var _idselectNivel			= $('#idselectNivel').val();

	if(_selectTipoR==""){					messages="Error! Seleccione el Tipo de Reserva";} 
	else if(_txtdni.length!=8){				messages="Error! Ingrese correctamente el # de DNI";} 
	else if(_txtnombres==""){				messages="Por favor, Ingrese los Apellidos y Nombres";} 
	else if(_fechadoc.length!=10){			messages="Ingrese la Fecha correctamente";} 
	else if(_txtreferencia==""){			messages="Por favor, Ingrese la Referencia";}		
	else if(_idselectNivel==""){			messages="Por favor, El seleccione el Nivel";} else{messages="";}

		if(messages==""){
		    $.ajax({
		        type: "post",
		        headers: {'X-CSRF-TOKEN':$('#token').val()},
		        url:  $('#frmsolicitud').attr('action'),
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){ 
		        console.log("-2->"+data);		        	  
		           	if(data===true) {		           	
		                   $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');		             		
		                   $("#frmsolicitud")[0].reset();		                   	
		                   GetDataDetResevas();             	              
		                } else {
		                   $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		                }
		        } 
		    });
		} else { $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>'+messages+'</div>').fadeIn().delay(4000).fadeOut('slow'); }

})

function GetDataDetResevas(id){
	$.get('../api/servicio/reservas/'+id,function(dataSearch){
		var tableHtml='';
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	var xy=0;
       	var msje="";
       	if(dataSearch.length!=0){       		
			for (var i=0; i < dataSearch.length; i++) 	{
				xy++; 
				if(dataSearch[i].IdEstadoSer==1) msje="Pendiente";	else if(dataSearch[i].IdEstadoSer==2)	 msje="Rechazado";	 else msje="Atendido";
				tableHtml += '<tr>'+								
								'<td>'+dataSearch[i].IdSolicitud+'</td>'+
								'<td>'+dataSearch[i].sede+' | '+dataSearch[i].dep+'</td>'+
								'<td>'+dataSearch[i].tipo+' <br>'+dataSearch[i].Apenombres+'</td>'+
								'<td>'+dataSearch[i].FechaDoc+'</td>'+
								'<td>'+dataSearch[i].DocReferencia+'</td>'+
								'<td>'+msje+'</td>'+


 											

				'</tr>';
				$('#IdShowReservaPlazas').html(tableHtml);				
			}
		}else{
			$('#IdMsjeErrorResultReservas').html(ErrorHtml);
		}	
	});	
}

function setFlatIdServ(id,IdSolicitudSer){
	$("#IdSolicitud").val(id);	
	$("#htmlNroSolicitud").html("Solicitud N°:   "+IdSolicitudSer)
}


$( "#idRechaz" ).on( "click", function() {
	if($("#idRechaz:checked" ).val()){ $( "#idSetValCheck" ).val("2");		
		$("#IdMensajeAlertSolicitud").html('<div class="alert alert-danger" role="alert"><strong>De rechazar la solicitud, ésta regresará a su origen</strong></div>').fadeIn().delay(4000).fadeOut('slow');
		$("#ObservacionAt").val("Solicitud Rechazada:");		
	}
	 else {
	 	$( "#idSetValCheck" ).val("3");
	 	$("#IdMensajeAlertSolicitud").html("");
	 	$("#ObservacionAt").val("Solicitud Atendida:");	
	}
});


$("#idSaveAtencionServicio").click(function (e) {
    e.preventDefault();  	
    var formData = new FormData($("form[name='frmSaveAtServ']")[0]);
    
    var messages="";
	var _selectTipoR			= $('#selectTipoR').val();
	var _txtdni					= $('#txtdni').val();

	if (confirm("Esta seguro de atender la solicitud") == true) {	
		    $.ajax({
		        type: "post",
		        headers: {'X-CSRF-TOKEN':$('#token').val()},
		        url:  $('#frmSaveAtServ').attr('action'),
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){ 
		        console.log("-2->"+data);		        	  
		           	if(data===1) {		           	
		                   $("#IdMensajeAlertSolicitud").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');		             		
		               		$("#idreservasbandeja").click;
		                } else {
		                   $("#IdMensajeAlertSolicitud").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		                }
		        } 
		    });
		} else { $("#IdMensajeAlertSolicitud").html("");}

})

function ShowObservacion(id){	
	$.get('../../api/servicio/reservas/list/'+id,function(data){
		var tableHtml='';
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	var xy=0;       
       	if(data.length!=0){       		
			for (var i=0; i < data.length; i++) 	{
				xy++; 			
				tableHtml += data[i].Observacion;				
				$('#IdShowObservacion').html(data[i].Observacion);	
				$('#IdNivelDiv').html("Nivel: "+data[i].IdNivel);
				$('#DocRefDiv').html(data[i].DocReferencia);

			}
		}else{
			$('#IdShowObservacion').html(ErrorHtml);
		}	
	});	
}