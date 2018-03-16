$(function(){
$('#DesingFormGestPlz').hide();

$.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });
$('#select_10').on('change',OnSelectOneGest);
$('#select_11').on('click',OnSelectTwoGest);
$('#select_22').on('click',OnSelectThreeGest);
$('#select_33').on('click',OnSelectFourGest);
 
$("#search_plaza").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
         var strin=$("#search_plaza").val();
          ShowFormChange(strin);
           return false;
        }
      });

	/* =============================*/
	$("#search_personam").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
         var strin=$("#search_personam").val();       
        console.log("val-->"+strin);       
        GetDataPerSeachMov(strin);
         return false;
        }
      });
	/*================================*/
 	$('#IdTipoMovimiento').on('change',showhideEstru);
})

function showhideEstru(){
var xy=$('#IdTipoMovimiento').val();

if(xy=="21"){	
	$('#select_10').attr('disabled',true);
	$('#select_11').attr('disabled',true);
	$('#select_22').attr('disabled',true);
	$('#select_33').attr('disabled',true);
	$('#select_44').attr('disabled',true);
}else{
	$('#select_10').attr('disabled',false);
	$('#select_11').attr('disabled',false);
	$('#select_22').attr('disabled',false);
	$('#select_33').attr('disabled',false);
	$('#select_44').attr('disabled',false);
}

}






function OnSelectOneGest(){
		var getSelectOne= $('#select_10').val();		
		if(!getSelectOne){
			$('#select_11').html('<option value="">Elegir</option>');
			return;
		}
		//alert(getSelectOne);
		$.get('../api/admin/plazas/'+getSelectOne,function(data){
		var html_select2="";
		console.log(data);	
		for (var i=0; i < data.length; i++)
			html_select2 += '<option value="'+data[i].IdEstructura.substr(0,4)+'">'+data[i].IdEstructura.substr(0,4)+' | '+data[i].Descripcion+'</option>';
			$('#select_11').html(html_select2);
		});
		$('#select_22').html('<option value="">Elegir</option>');
		$('#select_33').html('<option value="">Elegir</option>');
		$('#select_44').html('<option value="">Elegir</option>');
}

function OnSelectTwoGest(){
		var getSelectTwo= $('#select_11').val();	
		if(!getSelectTwo){
			$('#select_22').html('<option value="">Elegir</option>');
			return;
		}
		$.get('../api/admin/plazas/'+getSelectTwo,function(data3){
		var html_select3="";
		//if(data3.length=="1") {html_select3 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select3);}
		for (var i=0; i < data3.length; i++)
			html_select3 += '<option value="'+data3[i].IdEstructura.substr(0,7)+'">'+data3[i].IdEstructura.substr(0,7)+' | '+data3[i].Descripcion+'</option>';
			$('#select_22').html(html_select3);	
		});
		$('#select_33').html('<option value="">Elegir</option>');
		$('#select_44').html('<option value="">Elegir</option>');

}

function OnSelectThreeGest(){
		var getSelectThree= $('#select_22').val();	
		if(!getSelectThree){
			$('#select_33').html('<option value="">Select</option>');
			return;
		}
		$.get('../api/admin/plazas/'+getSelectThree,function(data4){
		var html_select4="";
		//if(data4.length==1)	 {html_select4 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select4);}
		for (var i=0; i < data4.length; i++)
			html_select4 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
			$('#select_33').html(html_select4);	
		});
		$('#select_44').html('<option value="">Elegir</option>');
}

function OnSelectFourGest(){
		var getSelectThree= $('#select_33').val();	
		if(!getSelectThree){
			$('#select_44').html('<option value="">Select</option>');
			return;
		}
		$.get('../api/admin/plazas/'+getSelectThree,function(data4){
		var html_select4="";
		//if(data4.length==1)	 {html_select4 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select4);}
		for (var i=0; i < data4.length; i++)
			html_select4 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
			$('#select_44').html(html_select4);	
		});
		
}

function ShowFormChange(idx){	
	$.get('../api/admin/gesplazas/'+idx,function(dataPlzM){	
		$('#DesingFormGestPlz').show();
       		var xy=0;         	     	
       		//console.log("==============>"+idx); 
       		var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Error:</strong> no existe registros!</div>';

       		var plaza 		="";
       		var Dep 		="";       
     
       		var html_name_	="";
       		var _IdPlazaG	="";
       		var _IdPersona	='';
       		var _IdEstructura='';
       		var _IdCargo	='';
       		var _NroPlaza	='';       		
       		if(dataPlzM.length!=0){  		
			for (var i=0; i < dataPlzM.length; i++) 	{
				$('#IdShowHideGesPlazas').show();	
				xy++; 
				plaza 			=	dataPlzM[i].NroPlaza+' / '+dataPlzM[i].IdNivel+' / '+dataPlzM[i].cargo;
				Dep 			=	dataPlzM[i].desc0+' | '+dataPlzM[i].desc1 +' | '+dataPlzM[i].desc2+' | '+dataPlzM[i].dep2+' | '+dataPlzM[i].Descripcion;			
				html_name_ 		+= dataPlzM[i].nombres;

				_IdPlazaG		=dataPlzM[i].IdPlaza;
				_IdPersona		=dataPlzM[i].IdPersona;
       		 	_IdEstructura	=dataPlzM[i].IdEstructura;
       		 	_IdCargo		=dataPlzM[i].IdCargo;
       			_NroPlaza		=dataPlzM[i].NroPlaza;

				$('#txtnombresG').html(html_name_);					
				$('#txtIdPlazaG').html(plaza);
				$('#txtIdEstructuraG').html(Dep);	
				$('#txttitulonombres').html(_NroPlaza+' / '+html_name_);
				
				
				$('#IdPlazaG').val(_IdPlazaG);
				$('#IdPersonaG').val(_IdPersona);
				$('#IdEstructuraG').val(_IdEstructura);
				$('#IdCargoG').val(_IdCargo);
				$('#NroPlazaG').val(_NroPlaza);		
				$('#IdShowHideGesPlazas');//.fadeOut(7000);							
			}

		}else{
			$('#DesingFormGestPlz').html(ErrorHtml);
		}
		GetTipoMov(idx);
	});						
	
}

/*=====================================*/
$("#IdSaveMovimientosDePlazas").click(function (e) {
    e.preventDefault();
  	
    var formData = new FormData($("form[name='frmsaveMov']")[0]);
    
    var messages="";
	var _IdTipoMov		= $('#IdTipoMovimiento').val();
	var	_select_44		= $('#select_44').val();
	var _FechaDocRef	= $('#datetime1').val();
	var _FechaMov		= $('#datetime3').val();
	var	_DocRefmov		= $('#DocRefmov').val();
	var	_FileAdjuntomov	= $('#FileAdjuntomov').val();
	
		 if(_IdTipoMov==""){		messages="Por favor, seleccione el Tipo de Moviemiento";} 
			else if(_select_44=="" && _IdTipoMov!="21"){		messages="Por favor, seleccione la dependencia";} 
			else if(_FechaMov==""){			messages="Por favor, Seleccione la fecha de Moviemiento";} 
			else if(_FechaDocRef==""){		messages="Por favor, Seleccione la fecha de documento";} 
			else if(_DocRefmov==""){		messages="Por favor, Ingrese el docuemento de referencia(Resolución /Carta, etc)";} 
			else if(_FileAdjuntomov==""){	messages="Por favor, seleccione el archivo .pdf";} else{messages="";}
			
		if(messages==""){
		    $.ajax({
		        type: "post",
		        headers: {'X-CSRF-TOKEN':$('#__token').val()},
		        url:  $('#frmsaveMov').attr('action'),
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){ 		        	  
		           	if(data===true) {		           	
		                   $("#Idmessage").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');;
		             		//alert("-2->"+data);
		                   $("#frmsaveMov")[0].reset();  
		                          
		                } else {
		                   $("#Idmessage").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		                }
		        } /*error:function(jqXHR, textStatus, errorThrown){
										console.log('error:: '+ errorThrown);
							}*/	
		    });
		} else { $("#Idmessage").html('<div class="alert alert-danger" role="alert"></span> </strong>'+messages+'</div>').fadeIn().delay(4000).fadeOut('slow'); }

})

function GetDataPerSeachMov(id){
	$.get('../api/admin/altaplaza/listper/'+id,function(dataSearch){			
		//console.log("=2==>"+dataSearch);
		var tableHtml='';
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	var xy=0;
       	var dni="";
       	var NroPlz="";
       	if(dataSearch.length!=0){       		
			for (var i=0; i < dataSearch.length; i++) 	{
				xy++; 
				NroPlz=dataSearch[i].NroPlaza;
				tableHtml += '<tr><td>'+xy+'</td> <td><a href="#" onclick=setNroPlazaToSearch("'+NroPlz+'");>'+dataSearch[i].NroPlaza+'</a></td><td>'+dataSearch[i].Dni+'</td><td>'+dataSearch[i].Nombres+'</td></tr>';
				$('#IdShowResultSearchP').html(tableHtml);				
			}
		}else{
			$('#IdMsjeErrorResultSearchp').html(ErrorHtml);
		}	
	});	
}

/*======================================*/
function setNroPlazaToSearch(Plz){
console.log("--Nro de plaza---->"+Plz);
$("#search_plaza").val(Plz)
$('#CierrameModalResult').click();
}
/*=====================================*/

function GetTipoMov(idx){	
	$.get('../api/admin/gesplazas/list/'+idx,function(dataTipM){	
       		var xy=0;   
       		
       		var html_="<option value=''>Elija el Motivo</option> ";
       		var getPer=$('#IdPersonaG').val();	
       		if($('#IdPersonaG').val()!=""){					
			       		if(dataTipM.length!=0){  		
						for (var i=0; i < dataTipM.length; i++) 	{
								xy++; 	
							if($('#IdPersonaG').val()!="" && xy===7){								
									//html_ = '<option value="">----</option>';								
							}else{
								html_ += '<option value="'+dataTipM[i].IdTipoMov+'">'+dataTipM[i].IdTipoMov+' | '+dataTipM[i].Descripcion+'</option>';
								$('#IdTipoMovimiento').html(html_);	
							}										
						}

					}else{
						$('#IdTipoMovimiento').html("No existe registros");
					}
		}else{
			html_ += '<option value="6">TRANFERENCIAS</option>';
			$('#IdTipoMovimiento').html(html_);
		}
	});	
}
