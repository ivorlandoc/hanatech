$(function(){
	$('#select_nivel0').on('change',OnSelectElPrimerNMant);
	$('#select_nivel1').on('change',OnSelectElSegundoNMant);
	$('#select_nivel2').on('change',OnSelectElTercerNMant);
	$('#select_nivel3').on('click',OnSelectElFourNMant);

	$("#searchPlazaForRpte").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
        // var strin=$("#searchPlazaForRpte").val();
          updatetxtoficinas('','');
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
	$.get('../api/admin/mantestruct/'+getNivel_2,function(data2){
	var html_select3="";
	if(data2.length=="1")	 {html_select3 += '<option value="">Elegir</option>'; $('#select_nivel2').html(html_select3);}
	for (var i=0; i < data2.length; i++)
		html_select3 += '<option value="'+data2[i].IdEstructura+'">'+data2[i].IdEstructura+' | '+data2[i].Descripcion+'</option>';
		$('#select_nivel2').html(html_select3);	
	
	});

	$('#select_nivel3').html('<option value="">Elegir</option>');
	$('#select_nivel4').html('<option value="">Elegir</option>');
	ajaxloadDetEstruct(3);
}

function OnSelectElTercerNMant(){
	var getNivel_3= $('#select_nivel2').val();	
	if(!getNivel_3){
		$('#select_nivel3').html('<option value="">Select</option>');
		return;
	}
	$.get('../api/admin/mantestruct/'+getNivel_3,function(data3){
	var html_select4="";	
	for (var i=0; i < data3.length; i++)
		html_select4 += '<option value="'+data3[i].IdEstructura+'">'+data3[i].IdEstructura+' | '+data3[i].Descripcion+'</option>';
		$('#select_nivel3').html(html_select4);	
	});
	$('#select_nivel4').html('<option value="">Elegir</option>');
	ajaxloadDetEstruct(4);
}

function OnSelectElFourNMant(){
	var getNivel_4= $('#select_nivel3').val();	
	if(!getNivel_4){
		$('#select_nivel4').html('<option value="">Select</option>');
		return;
	}

	$.get('../api/admin/mantestruct/'+getNivel_4,function(data){
	var html_select5="";	
	for (var i=0; i < data.length; i++)
		html_select5 += '<option value="'+data[i].IdEstructura+'">'+data[i].IdEstructura+' | '+data[i].Descripcion+'</option>';
		$('#select_nivel4').html(html_select5);	
	});
	ajaxloadDetEstruct(5);	
}


function ajaxloadDetEstruct(idx){
	var _string="";
	if(idx===3) _string =$("#select_nivel2").val();
	if(idx===4) _string =$("#select_nivel3").val();
	if(idx===5) _string =$("#select_nivel4").val();

	$.get('../api/admin/mantestruct/list3/'+_string,function(data){
		var tableHtml="";	
		if(data.length!=0){  
			//console.log("<----->"+data);
			for (var i=0; i < data.length; i++){
				console.log("<----->"+i+"--"+data[i].IdEstructura);
				if(data[i].IdEstructura.length!=12) check="disabled"; else check="";   
					tableHtml += '<tr><td>'+i+'</td>  <td>'+data[i].IdEstructura+'</td>  <td>'+data[i].organo+'</td> <td>'+data[i].gerencia+'</td><td>'+data[i].dependencia+'</td><td>'+data[i].oficina+'</td>'+
					'<td>'+												
						'<div class="form-group">'+	
							'<div>'+				
								'<p class="flatpickr input-group" data-wrap="true" data-clickOpens="false">'+
									'<input class="form-control" type="text" value="'+data[i].servicio+'"  '+check+' id="'+data[i].IdEstructura+'" data-input>'+
										'<span class="input-group-addon add-on" style="cursor: pointer;">'+
											'<a class="input-btn" onclick=updatetxtoficinas("'+data[i].IdEstructura+'",0) data-clear>'+
												'<i class="livicon" data-name="save" data-size="16" data-c="#555555" data-hc="#555555" data-loop="true">...</i>'+									
											'</a>'+
										'</span>'+
								'</p>'+	
							'</div>'+				
						'</div>'+
					'</td></tr>';
					$('#IdShowresume').html(tableHtml);
				}
		}else{
		    $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(2000).fadeOut('slow');
		}
	});
	 
	//ajaxloadDetEstruct(5);	
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
		                   ajaxloadDetEstruct(5);
		                  
		                } else {
		                   $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		            }
		        } 
		    });
		    
		} else { $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>'+messages+'</div>').fadeIn().delay(4000).fadeOut('slow'); }
})

/*
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
*/
function updatetxtoficinas(idestru,idx){
	var formData = new FormData($("form[name='frmupdateEstr']")[0]);
	 formData.append('idestru',idestru);
	 formData.append('Descrip',$('#'+idestru).val());	
	 formData.append('iddepenhiden',idx);
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
           if(data===1 || data===true) {               
                   $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');                   
                 	//$('#select_nivel4').click()
                } else {
                   $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert">La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
            }
           $('.loading').hide(); 
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

/*===========================================*/
function showdepen(){
	if($("#select_nivel0").val()!=""){
		$("#divdepen1").show();
		$('#msjetitle1').html($('#select_nivel0 option:selected').html());

		$("#divdepen2").hide();
		$("#divdepen3").hide();
		$("#divdepen4").hide();
		$("#divdepen5").hide();
	
		
	}else{
		 $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert">Seleccione la dependencia[Órgano] </strong></div>').fadeIn().delay(2000).fadeOut('slow');
		 $("#select_nivel0").focus();
		 $("#select_nivel0").click();
		
	}
}

function showdepen2(){	
	if($("#select_nivel1").val()!=""){
		$("#divdepen2").show();
		$('#msjetitle2').html($('#select_nivel1 option:selected').html());
		$("#divdepen1").hide();

		$("#divdepen3").hide();
		$("#divdepen4").hide();
		$("#divdepen5").hide();	
		
	}else{
		 $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert">Seleccione la dependencia[Órgano] </strong></div>').fadeIn().delay(2000).fadeOut('slow');
		 $("#select_nivel1").focus();
		 $("#select_nivel1").click();
		
	}	
}
function showdepen3(){	
	if($("#select_nivel2").val()!=""){
		$("#divdepen3").show();
		$('#msjetitle3').html($('#select_nivel2 option:selected').html());	
		$("#divdepen1").hide();
		$("#divdepen2").hide();

		$("#divdepen4").hide();
		$("#divdepen5").hide();	
	}else{
		 $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert">Seleccione la dependencia[Órgano] </strong></div>').fadeIn().delay(2000).fadeOut('slow');
		 $("#select_nivel2").focus();
		 $("#select_nivel2").click();
	}	
}


function showdepen4(){	
	if($("#select_nivel3").val()!=""){
		$("#divdepen4").show();
		$('#msjetitle4').html($('#select_nivel3 option:selected').html());	
		$("#divdepen1").hide();
		$("#divdepen2").hide();
		$("#divdepen3").hide();

		$("#divdepen5").hide();
	
	}else{
		 $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert">Seleccione la dependencia[Órgano] </strong></div>').fadeIn().delay(2000).fadeOut('slow');
		 $("#select_nivel3").focus();
		 $("#select_nivel3").click();
	}	
}


function showdepen5(){
	if($("#select_nivel4").val()!=""){
		$("#divdepen5").show();
		$('#msjetitle5').html($('#select_nivel4 option:selected').html());	
		$("#divdepen1").hide();
		$("#divdepen2").hide();
		$("#divdepen3").hide();
		$("#divdepen4").hide();
		
	}else{
		 $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert">Seleccione la dependencia[Órgano] </strong></div>').fadeIn().delay(2000).fadeOut('slow');
		 $("#select_nivel4").focus();
		 $("#select_nivel4").click();
	}	
}
/*=======================================*/

function hidendepen() {$("#divdepen1").hide();}
function hidendepen2(){$("#divdepen2").hide();}
function hidendepen3(){$("#divdepen3").hide();}
function hidendepen4(){$("#divdepen4").hide();}
function hidendepen5(){$("#divdepen5").hide();}
