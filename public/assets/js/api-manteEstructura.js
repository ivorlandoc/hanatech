$(function(){
	$('#select_nivel0').on('change',OnSelectElPrimerNMant);
	$('#select_nivel1').on('click',OnSelectElSegundoNMant);
	$('#select_nivel2').on('click',OnSelectElTercerNMant);
	$('#select_nivel3').on('click',OnSelectElFourNMant);


	$("#searchPlazaForRpte").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
        // var strin=$("#searchPlazaForRpte").val();
          updatetxtoficinas();
          return false;
        }
      });

})


function viewEstructuraEnPdf(){
	var prm = $("#select_nivel1").val();
	if(prm!="%"){
		$.get('../api/admin/mantestruct/pdf/'+prm,function(datap){	});
	}else{
		 $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>Aún no ha seleccionado el criterio</div>').fadeIn().delay(4000).fadeOut('slow'); 		
		}
	}

function OnSelectElPrimerNMant(){
		var getNivel_1= $('#select_nivel0').val();		
		if(!getNivel_1){
			$('#select_nivel1').html('<option value="">Select</option>');
			return;
		}		
		$.get('../api/admin/mantestruct/'+getNivel_1,function(data){		
			var html_select2="";	
			if(data.length=="1")	 {html_select2 += '<option value="">Elegir</option>'; $('#select_nivel2').html(html_select2);}
		for (var i=0; i < data.length; i++)
			html_select2 += '<option value="'+data[i].IdEstructura.substr(0,4)+'">'+data[i].IdEstructura.substr(0,4)+' | '+data[i].Descripcion+'</option>';
			$('#select_nivel1').html(html_select2);			
		});
		$('#select_nivel2').html('<option value="">Elegir</option>');
		$('#select_nivel3').html('<option value="">Elegir</option>');
		$('#select_nivel4').html('<option value="">Elegir</option>');
}

function OnSelectElSegundoNMant(){
	var getNivel_2= $('#select_nivel1').val();	
	if(!getNivel_2){
		$('#select_nivel2').html('<option value="">Select</option>');
		return;
	}
	$.get('../api/admin/mantestruct/'+getNivel_2,function(data3){
	var html_select3="";
	if(data3.length=="1")	 {html_select3 += '<option value="">Elegir</option>'; $('#select_nivel2').html(html_select3);}
	for (var i=0; i < data3.length; i++)
		html_select3 += '<option value="'+data3[i].IdEstructura.substr(0,7)+'">'+data3[i].IdEstructura.substr(0,7)+' | '+data3[i].Descripcion+'</option>';
		$('#select_nivel2').html(html_select3);	
	});
	$('#select_nivel3').html('<option value="">Elegir</option>');
	$('#select_nivel4').html('<option value="">Elegir</option>');
}

function OnSelectElTercerNMant(){
	var getNivel_3= $('#select_nivel2').val();	
	if(!getNivel_3){
		$('#select_nivel3').html('<option value="">Select</option>');
		return;
	}
	$.get('../api/admin/mantestruct/'+getNivel_3,function(data4){
	var html_select4="";	
	for (var i=0; i < data4.length; i++)
		html_select4 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
		$('#select_nivel3').html(html_select4);	
	});
	$('#select_nivel4').html('<option value="">Elegir</option>');
}

function OnSelectElFourNMant(){
	var getNivel_4= $('#select_nivel3').val();	
	if(!getNivel_4){
		$('#select_nivel4').html('<option value="">Select</option>');
		return;
	}
	$.get('../api/admin/mantestruct/'+getNivel_4,function(data4){
	var html_select5="";	
	for (var i=0; i < data4.length; i++)
		html_select5 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
		$('#select_nivel4').html(html_select5);	
	});
	
}

function GetIdSelectFour(){
	var getSelectId= $('#select_nivel3').val();
	ShowDetaisMante(getSelectId);
}

$("#IdSaveManteEstru").click(function (e) {
    e.preventDefault();  	
    var formData = new FormData($("form[name='fmrSaveManteEstru']")[0]);    
    var messages="";
	var _Nivel2			= $('#select_nivel2').val();
	var _Nivel3			= $('#select_nivel3').val();
	var _Nivel4			= $('#select_nivel4').val();
	var _IdEstructura			= $('#select_nivel4').val();
	var _Descripcion			= $('#txtcuartoNivel').val();	

	if(_Nivel2.trim().length===0){	messages="Error! Selecione el primer nivel";} 
	else if(_Nivel3.trim().length===0){	messages="Error! Selecione el Segundo nivel";} 
	else if(_Nivel4.trim().length===0){	messages="Error! Selecione el Tercer nivel";} 
	else if(_IdEstructura.trim().length!=10){	messages="Error! Verifique que haya seleccionado correctamente la dependencia";} 
	else if(_Descripcion.trim().length<5){	messages="Error! asegúrese haber ingresado correctamente la descripcion";} else{messages="";}
		if(messages==""){
		    $.ajax({
		        type: "POST",
		        headers: {'X-CSRF-TOKEN':$('#_l_token').val()},
		        url:  $('#fmrSaveManteEstru').attr('action'),
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){ 
		        console.log("-2->"+data);		        		        	  
		           	if(data===true) {		           	
		                   $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');		             				                 
		                   GetIdSelectFour(_IdEstructura);
		                  
		                } else {
		                   $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		            }
		        } 
		    });
		    
		} else { $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>'+messages+'</div>').fadeIn().delay(4000).fadeOut('slow'); }
})

function ShowDetaisMante(id){
	$.get('../api/admin/mantestruct/'+id,function(datap){		
		var tableHtml='';
       		var xy=0;       		
			for (var i=0; i < datap.length; i++) 	{			
				xy++;				
			tableHtml += '<tr><td>'+xy+'</td>  <td>'+datap[i].IdEstructura+'</td>  <td>'+datap[i].organo+'</td> <td>'+datap[i].gerencia+'</td><td>'+datap[i].dependencia+'</td>'+
			'<td>'+
				'<div class="form-group">'+	
					'<div>'+				
						'<p class="flatpickr input-group" data-wrap="true" data-clickOpens="false">'+
							'<input class="form-control" type="text" value="'+datap[i].dep2+'"  id="'+datap[i].IdEstructura+'" data-input>'+
								'<span class="input-group-addon add-on" style="cursor: pointer;">'+
									'<a class="input-btn" onclick=updatetxtoficinas("'+datap[i].IdEstructura+'") data-clear>'+
										'<i class="livicon" data-name="save" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true">...</i>'+									
									'</a>'+
								'</span>'+
						'</p>'+	
					'</div>'+				
				'</div>'+
			'</td></tr>';
			$('#IdShowresume').html(tableHtml);	

		}		
		$('#IdShowresume').html(tableHtml);			
		});						
}

function updatetxtoficinas(idestru){
	var formData = new FormData($("form[name='frmupdateEstr']")[0]);
	 formData.append('idestru',idestru);
	 formData.append('Descrip',$('#'+idestru).val());
		var id= $('#select_nivel3').val();
      $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmupdateEstr').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {
           if(data===1) {               
                   //$("#IdShowresume").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');                   
                  ShowDetaisMante(id);
                } else {
                   $("#IdShowresume").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
            }
           $('.loading').hide(); 
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}
