$(function(){
$('#sel1').on('change',OnLoadSelectSegundoNivel);
$('#sel2').on('click',OnLoadSelectTercerNivel);
$('#sel3').on('click',OnLoadSelectCuartoNivel);
$('#sel4').on('click',OnLoadSelectQuintoNivel);

/*=========================================================*/
	$.get('../../api/admin/mantestruct/getlist/1',function(data){
		var tableHtml='';
		tableHtml += '<option value="">Elegir</option>';		
		for(var i=0; i < data.length; i++){
			tableHtml += '<option value="'+data[i].IdEstructura.substr(0,2)+'">'+data[i].IdEstructura+' | '+data[i].Descripcion+'</option>';			
			$('#sel1').html(tableHtml);	
		}				
	});		
/*=========================================================*/
		$("#string_search_ChangeStru").keypress(function(e) {
			var code = (e.keyCode ? e.keyCode : e.which);
	        if(code ==13) {  
	       	serach_ ();
	        return false;	                   
	        }
	      }); 	
	/* =============================*/	
})

function serach_ (){
	 var _string=$("#string_search_ChangeStru").val();	   
	        ShowDetaSearchChangeStruct(_string);  
}
function ShowDetaSearchChangeStruct(id){	
	//console.log('ID==>'+id);
	$.get('../../api/admin/mantestruct/list/'+id,function(datap){
		var tableHtml='';
		var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	var xy=0;    
		if(datap.length!=0){   		
				for (var i=0; i < datap.length; i++){			
					xy++;						
					tableHtml += '<tr>'+
					'<td>'+xy+'</td>'+
					'<td>'+datap[i].organo+' | '+datap[i].dep+' | '+datap[i].descrip+'</td>'+
					'<td>'+datap[i].IdNivel+' | '+datap[i].cargo+'</td>'+
					'<td>'+datap[i].nombres+'</td>'+				
					'<td><a href="#" onclick=pasarpersona("'+datap[i].IdPlaza+'") class="btn btn-info btn-lg">Pasar</a></td>'+
					'</tr>';
					$('#IdSearchChangeEstru').html(tableHtml);	
				}	
		}else{
			$('#DivContentSearchStruct').html(ErrorHtml);
		}					
		});						
}

function pasarpersona(id){
	$("#groupChanger").show();
	$("#txtidplaza").val(id);
	var formData = new FormData($("form[name='frmChangeStructDest']")[0]);    
    var messages="";
	var _sel4			= $('#sel4').val();
	var _sel5			= $('#sel5').val();
	var _DocRef			= $('#txtreferencia').val();
	var _FDoc			= $('#txtfechadoc').val();
	var _Crit			= "";
	if(_sel5=="") _Crit =_sel4; else _Crit=_sel5;
	if(_sel4==""){ 		messages="Debe seleccionar la debependencia.";}
	else if(_DocRef==""){ 	messages="Ingrese el documento de referencia.";}
	else if(_FDoc==""){ 		messages="Ingrese la fecha del documento.";}
	else if(_sel5=="" && _sel4!=""){ messages="La persona seleccionada se asignará al 4to Nivel seleccionado"; messages="";}	else {messages="";}

		if(messages==""){
		    $.ajax({
		        type: "POST",
		        headers: {'X-CSRF-TOKEN':$('#_token').val()},
		        url:  $('#frmChangeStructDest').attr('action'),
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){ 		    	        	  
		           	if(data===true) {		           	
		                   $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');		             		
		                   $('#txtreferencia').val("");
		                   $('#txtfechadoc').val("");
		                   $("#groupChanger").hide();
		                   getResultChangeDatos(_Crit);
		                } else {
		                   $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		                }
		        } 
		    });
		} else { $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>'+messages+'</div>').fadeIn().delay(4000).fadeOut('slow'); }
}



function OnLoadSelectSegundoNivel(){
	var getNivel_1= $('#sel1').val();	
	if(!getNivel_1){
		$('#sel2').html('<option value="">Elegir</option>');
		return;
	}	
	//console.log("---1--->"+getNivel_1);
	$.get('../../api/admin/mantestruct/'+getNivel_1,function(data){
	var html_select2="<option value=''>Elegir</option>";
	//console.log("---2--->"+getNivel_1+"---data-->>");	
	for (var i=0; i < data.length; i++)
		html_select2 += '<option value="'+data[i].IdEstructura.substr(0,4)+'">'+data[i].IdEstructura.substr(0,4)+' | '+data[i].Descripcion+'</option>';
		$('#sel2').html(html_select2);	
	});
	$('#sel3').html('<option value="">Elegir</option>');
	$('#sel4').html('<option value="">Elegir</option>');
}

function OnLoadSelectTercerNivel(){
	var getNivel_2= $('#sel2').val();	
	if(!getNivel_2){
		$('#sel3').html('<option value="">Elegir</option>');
		return;
	}	
	$.get('../../api/admin/mantestruct/'+getNivel_2,function(data){
	var html_select3="<option value=''>Elegir</option>";	
	for (var i=0; i < data.length; i++)
		html_select3 += '<option value="'+data[i].IdEstructura.substr(0,7)+'">'+data[i].IdEstructura.substr(0,7)+' | '+data[i].Descripcion+'</option>';
		$('#sel3').html(html_select3);	
	});
	$('#sel4').html('<option value="">Elegir</option>');
	$('#sel5').html('<option value="">Elegir</option>');
}

function OnLoadSelectCuartoNivel(){
	var getNivel_3= $('#sel3').val();	
	if(!getNivel_3){
		$('#sel4').html('<option value="">Elegir</option>');
		return;
	}	
	$.get('../../api/admin/mantestruct/'+getNivel_3,function(data){
	var html_select4="<option value=''>Elegir</option>";	
	for (var i=0; i < data.length; i++)
		html_select4 += '<option value="'+data[i].IdEstructura.substr(0,11)+'">'+data[i].IdEstructura.substr(0,11)+' | '+data[i].Descripcion+'</option>';
		$('#sel4').html(html_select4);	
	});	
	$('#sel5').html('<option value="">Elegir</option>');
}

function OnLoadSelectQuintoNivel(){
	var getNivel_4= $('#sel4').val();	
	if(!getNivel_4){
		$('#sel5').html('<option value="">Elegir[No existe registros]</option>');
		return;
	}	
	$.get('../../api/admin/mantestruct/'+getNivel_4,function(data){
	var html_select5="<option value=''>Elegir</option>";	
	for (var i=0; i < data.length; i++)
		html_select5 += '<option value="'+data[i].IdEstructura+'">'+data[i].IdEstructura+' | '+data[i].dep2+'</option>';
		$('#sel5').html(html_select5);	
	});	
}
/*
function setFlagThree(){
	var _string=	$('#sel3').val();	
	getResultChangeDatos(_string)
}
function setFlagFour(){
	var _string=	$('#sel4').val();	
	getResultChangeDatos(_string)
}*/
function setFlagFive(){
	var _string=	$('#sel5').val();	
	getResultChangeDatos(_string)
}

function getResultChangeDatos(id){	
	$.get('../../api/admin/mantestruct/list2/'+id,function(datap){
		console.log("===>"+datap);
		var tableHtml='';
		var htmlHead="";    
       	var ErrorHtml='<tr><td colspan="4"><div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div></td></tr>';
       	if(datap.length!=0){  
       		var xy=0;	
       		$('#IdSearchChangeEstruDest').html("");	
			for (var i=0; i < datap.length; i++){
				xy++;				
				tableHtml += '<tr>'+
					'<td>'+xy+'</td>'+
					/*'<td>'+datap[i].organo+' | '+datap[i].dep+' | '+datap[i].descrip+'</td>'+*/
					'<td>'+datap[i].IdNivel+' | '+datap[i].cargo+'</td>'+
					'<td>'+datap[i].nombres+'</td>'+
					'</tr>';
				$('#IdSearchChangeEstruDest').html(tableHtml);	
			}
		}else{
			$('#IdSearchChangeEstruDest').html(ErrorHtml);
		}
		
	});	
}