$(function(){

$("#searchPlazaForRpte").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
         var strin=$("#searchPlazaForRpte").val();
          GetAllPlazas(strin);
          GetAllPlazasMov(strin);
          return false;
        }
      });
 	
})

$(document).ready(function(){
    $('#searchPlazaForRpte').keyup(function(){$(this).val($(this).val().toUpperCase());});
    $('#stri_search').keyup(function(){$(this).val($(this).val().toUpperCase());});    
});

function GetAllPlazas(id){
	$.get('../api/admin/rpteplazas/getplaza/'+id,function(dataDet){
		console.log("===>"+dataDet);
		var tableHtml='';		
		var htmlHead="";
		var htmlNombre="";
		var Tinesino="";
		var url="";

       	var ErrorHtml='<tr><td colspan="2"><div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div></td></tr>';
       	if(dataDet.length!=0){        		
       		$('#IdGetShowEstadoPlaza').html(""); // "{{ URL::to('admin/bajaplazas') }}?x={{$plaz}}"
			for (var i=0; i < dataDet.length; i++) 	{	
				if(dataDet[i].fcese!=""){ Tinesino= '<p class="btn btn-info start">'+dataDet[i].sino+'</p>';} else{ Tinesino=" ";}				
				url= "altaplaza?x="+dataDet[i].NroPlaza;			
				if(dataDet[i].IdPersona=="") htmlNombre="<p class='btn btn-info start'>"+dataDet[i].estado+"</p><a href="+url+ ' class="btn btn-info start">DAR DE ALTA</a>'; else htmlNombre=dataDet[i].ApellidoPat+'  '+dataDet[i].ApellidoMat+' '+dataDet[i].Nombres;

				tableHtml += '<table><tr><th width="23%"># DE PLAZA:</th><td ><p style="margin: 0px 0px 0px 0px;">'+dataDet[i].NroPlaza+' </p></td></tr> '+
							 '<tr><th>PERSONA:</th><td><p style="margin: 0px 0px 0px 30px;">'+htmlNombre+'</p></td></tr> '+
							 '<tr><th colspan="2">DEPENDENCIA</th></tr>'+
							 '<tr><td colspan="2"><p style="margin: 0px 0px 0px 0px;">'+dataDet[i].sede+'  <b>|</b>  '+dataDet[i].organo+' </p></td></tr>'+												
							 '<tr><td colspan="2"><p style="margin: 0px 0px 0px 0px;">'+dataDet[i].dep+'  <b> | </b>  '+dataDet[i].dep2+'<b> | </b>  '+dataDet[i].descripcion+'</p></td></tr>'+							
							 '<tr><th>NIVEL:</th><td><p style="margin: 0px 0px 0px 0px;">'+dataDet[i].IdNivel+'  <b>|</b>  '+dataDet[i].Nivel+' </p></td></tr> '+					
							 '<tr><th>CARGO:</th><td><p style="margin: 0px 0px 0px 0px;">'+dataDet[i].cargo+' </p></td></tr> '+
							 '<tr><th>FECHA DE CESE:</th><td><p style="margin: 0px 0px 0px 0px;">'+dataDet[i].fcese+' </p></td></tr> '+	
							 '<tr><th>CUENTA CON PRESUPUESTO?</th><td>'+Tinesino+' </td></tr> '+						 							
							 '</tr></table>';
				$('#IdGetShowEstadoPlaza').html(tableHtml);	
			}
		}else{
			$('#IdGetShowEstadoPlaza').html(ErrorHtml);
		}
		
	});	
}

function GetAllPlazasMov(id){
	$.get('../api/admin/rpteplazas/detplaza/'+id,function(dataDet){
		var tableHtml='';
       	var persona="";
       	var xy=0;
       	if(dataDet.length!=0){  
       		$('.loading').show();
    
       	tableHtml  +='<table class="table dataTable no-footer dtr-inline"><tr> <th>#</th><th>PERSONA</th><th>TIPO.MOV.</th><th>DEPENDENCIA</th><th>CARGO</th> <th> DOC.REF.</th> <th>OBSERVACION</th> <th>F:&nbsp;MOV.&nbsp;&nbsp;|&nbsp;&nbsp;F:DOC.REF&nbsp;</th><th>ACCIÓN</th></tr>';    		
       		$('#IdGetShowEstadoPlazaDet').html("");
			for (var i=0; i < dataDet.length; i++) 	{ xy++;
				if(dataDet[i].Persona=="") persona="---"; else persona=dataDet[i].Persona;
				tableHtml += '<tr>	<th>'+xy+'</th>'+
									'<td>'+persona+'</td>'+
							 		'<td>'+dataDet[i].tipomov+'</td> '+							 		
							 		'<td>'+dataDet[i].organo+' | '+dataDet[i].dep+' | '+dataDet[i].dep2+'</td>'+	
							 		'<td>'+dataDet[i].cargo+'</td>'+											
							 		'<td><a href="../uploads/files/'+dataDet[i].FileAdjunto+'" target="_blank">'+dataDet[i].DocRef+'</a></td>'+							
							 		'<td>'+dataDet[i].Observacion+'</td>'+					
							 		'<td>'+dataDet[i].fm+' | '+dataDet[i].fd+'</td>'+							 							
							 '</tr>';

				//$('#IdGetShowEstadoPlazaDet').html(tableHtml);	
			}
			$('.loading').hide();
		}else{
			$('#IdGetShowEstadoPlazaDet').html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(4000).fadeOut('slow');
		}
		tableHtml += '</table>';
		$('#IdGetShowEstadoPlazaDet').html(tableHtml);
	});	
}


function ShowHistoriaMov(id,iddni){	
	console.log("Nro de Plaza=1==>"+id+"-->"+iddni);	
	$.get('../api/admin/rpteplazas/list/'+id+iddni,function(dataDa){
		$('#IdShowDetailsMov').html("");
		var tableHtml 	="";
		var htmlHead 	="";
		console.log("---->"+dataDa);
		
       	var xy=0;   
       	var ErrorHtml='<tr><td colspan="9"><div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div></td></tr>';
        var HtmlHeadTr='<tr class="filters"><th>#</th><th>DEPENDENCIA</th><th>NIVEL</th><th>CARGO</th><th>T.MOV</th><th>F.MOV</th> <th>F.DOC</th><th>DOC.DE&nbspREF.</th> <th>OBSERVACION</th><th>DOC.ADJ</th></tr>';
       		if(dataDa.length!=0){  
       		 $('.loading').show();	
       		$('#headTR').html(HtmlHeadTr);	       		
			for (var i=0; i < dataDa.length; i++) 	{
				xy++; 
				console.log("==sede=>"+dataDa[i].sede+' / '+dataDa[i].dependencia);
						if(i=="0"){
							 htmlHead ='<b>'+dataDa[0].dni +'  |  '+dataDa[0].nom+'  |  PLAZA N°['+dataDa[0].NroPlaza+']</b>';
							 $('#IdHeadDetMov').html(htmlHead);
						}						
				tableHtml += '<tr><td>'+xy+'</td>'+
				'<td>'+dataDa[i].centro+' | <br> '+dataDa[i].dep+' | '+dataDa[i].dep2+' | '+dataDa[i].dependencia+'</td>'+
				'<td>'+dataDa[i].IdNivel+'</td>'+
				'<td>'+dataDa[i].cargo+'</td>'+
				'<td>'+dataDa[i].TipoMov+'</td>'+
				'<td>'+dataDa[i].FechaMov+'</td>'+
				'<td>'+dataDa[i].fechaDoc+'</td>'+
				'<td>'+dataDa[i].DocRef+'</td>'+
				'<td>'+dataDa[i].Observacion+'</td>'+
				'<td><a href="../uploads/files/'+dataDa[i].FileAdjunto+'" target="_blank" class="btn btn-info btn-sm btn-responsive" role="button"><span class="livicon" data-name="notebook" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span><br/>Abrir</a></td>'+
				'</tr>';
				$('#IdShowDetailsMov').html(tableHtml);	
			}
			$('.loading').hide();
		}else{
			$('#IdShowDetailsMov').html(ErrorHtml);
		}
		
	});					
	
}

function GetDetalleGeneralPlaza(id,dni){		
	console.log("===>"+id);
	$.get('../api/admin/rpteplazas/det/'+id+dni,function(dataDet){
		//alert("Nro de Plaza=2==>"+id);///
		//console.log("===>"+dataDet);
		var tableHtml='';
		var htmlHead="";       
       	var ErrorHtml='<tr><td colspan="2"><div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div></td></tr>';
       	if(dataDet.length!=0){  	
       		 $('.loading').show();
       		$('#headTR').html("");	
			for (var i=0; i < dataDet.length; i++) 	{
				//xy++; 
				console.log("==sede=>"+dataDet[i].sede+' / '+dataDet[i].dependencia);
						if(i=="0"){
							 htmlHead ='<b> DETALLE DE LA  PLAZA N°['+dataDet[0].NroPlaza+']</b>';
							 $('#IdHeadDetMov').html(htmlHead);
						}						
				tableHtml += '<tr><th colspan="2" width="1">PERSONA:</th></tr>'+
							 '<tr ><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].dni+' | '+dataDet[i].nom+'</p></td></tr>'+
							 '<tr><th colspan="2">DEPENDENCIA</th></tr>'+
							 '<tr><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].sede+' | '+dataDet[i].organo+'</p></td></tr>'+					
							 '<tr><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].gerencia+' | '+dataDet[i].dep2+' | '+dataDet[i].dependencia+'</p></td></tr>'+						
							 '<tr><th style="width:1px">TIPO&nbspDE&nbspCARGO:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].tipo+' </p></td></tr> '+							
							 '<tr><th>NIVEL:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].IdNivel+' | '+dataDet[i].nivel+' </p></td></tr> '+					
							 '<tr><th>CARGO:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].cargo+' </p></td></tr> '+							 
							 '<tr><th>PLAZA N°:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].NroPlaza+' </p></td></tr> '+	
							 '<tr><th>RÉGIMEN:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].regimen+' </p></td></tr> '+						
							 '<tr><th>FECHA&nbspNACIMIENTO/INGRESO:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].FechaNac+' | '+dataDet[i].fingreso+'</p></td>'+
							 
							 '<tr><th>DOCUMENTO:</th><td><p style="margin: 0px 0px 0px 30px;">'+dataDet[i].documento+' </p></td></tr> '+
							 '</tr>';
				$('#IdShowDetailsMov').html(tableHtml);	
			}
			 $('.loading').hide();
		}else{
			$('#IdShowDetailsMov').html(ErrorHtml);
		}
		
	});	
	
}

function GetRpteGeneral(){
	//reg = $("#idregimen").val();
	est = $("#idestado").val();
	$("#idtxtEstado").val(est);

	console.log("===>"+est);
	$.get('../api/reportes/rplazas/'+est,function(dataDet){
		var tableHtml='';
		var xy=0;       		
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	tableHtml +='<table  class="table dataTable no-footer dtr-inline">'+
                                        '<thead>'+
                                            '<tr class="filters">'+
                                                '<th>#</th>'+
                                                '<th>ESTRUCTURA</th> '+
                                                '<th>DEPENDENCIA</th>'+
                                                '<th>#PLAZA</th>'+
                                                '<th>CARGO</th>'+  
                                                '<th>#DNI</th>'+
                                                '<th>NOMBRES</th>'+                                                
                                                '<th>ESTADO</th>'+
                                                '<th>RÉGIMEN</th>'+                     
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>';
       	if(dataDet.length!=0){    
       	if(est=="1")	 htmlHead ='<div class="alert alert-danger alert-dismissable margin5"><strong>Para consultar las plazas activas se recomienda exportar a excel; considerando que la cantidad de registros es extenso.</div>'; else htmlHead='';
       		$('#IdMsjeLimit').html(htmlHead).fadeIn().delay(4000).fadeOut('slow');;	

			for (var i=0; i < dataDet.length; i++) 	{
				xy++; 							
				tableHtml += '<tr>'+
							 '<td>'+xy+'</td>'+							
							 '<td>'+dataDet[i].IdEstructura+'</td>'+					
							 '<td>'+dataDet[i].Descripcion+' </td>'+						
							 '<td>'+dataDet[i].NroPlaza+' </td> '+							
							 '<td>'+dataDet[i].Cargo+' </td> '+					
							 '<td>'+dataDet[i].dni+'</td> '+							 
							 '<td>'+dataDet[i].nombres+'</td> '+	
							 '<td>'+dataDet[i].EstadoPlaza+'</td> '+						
							 '<td>'+dataDet[i].Regimen+'</td>'+
							 '</tr>';
				$('#IdShowRptePlazas').html(tableHtml);	
			}
		}else{
			$('#IdShowRptePlazas').html(ErrorHtml);
		}
			tableHtml +=' </tbody></table>';
			$('#IdShowRptePlazas').html(tableHtml);	
	});	
	
}