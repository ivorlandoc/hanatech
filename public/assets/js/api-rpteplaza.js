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

$("#stri_search").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {       
          GetListaIndex();         
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
		var ofi="";
    	var desc="";
    	var Tinesino="";
    	var htmlAlta="";
       	var ErrorHtml='<tr><td colspan="2"><div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div></td></tr>';
       	if(dataDet.length!=0){        		
       		$('#IdGetShowEstadoPlaza').html(""); // "{{ URL::to('admin/bajaplazas') }}?x={{$plaz}}"
			for (var i=0; i < dataDet.length; i++) 	{	
				if(dataDet[i].fcese!=""){ Tinesino= '<p class="btn btn-info start">'+dataDet[i].sino+'</p>';} else{ Tinesino=" ";}	

				url= "altaplaza?x="+dataDet[i].NroPlaza;	


				if(dataDet[i].IdPersona=="") htmlAlta="<a href="+url+ ' class="btn btn-info">DAR DE ALTA</a>'; else htmlAlta="";
				
				if(dataDet[i].fcese!=""){ Tinesino= '<p class="btn btn-info start">'+dataDet[i].sino+'</p>';} else{ 
	              if(dataDet[i].estado=="ACTIVA"){Tinesino="<p class='btn btn-info start'> SI </p>";} else{Tinesino=" ";}
	          	} 

				htmlEsta="<p class='btn btn-info start'> "+dataDet[i].NroPlaza+" | "+dataDet[i].estado+"</p>" 
				htmlNombre=dataDet[i].ApellidoPat+'  '+dataDet[i].ApellidoMat+' '+dataDet[i].Nombres;
				
				if(dataDet[i].ofi=="SN"){ofi='';} else {ofi="<br>"+dataDet[i].ofi;}
	            if(dataDet[i].descripcion=="SN"){desc='';} else {desc="<br>"+dataDet[i].descripcion;}

				tableHtml += '<table class="table dataTable no-footer dtr-inline">'+
							 '<tr><th width="23%">PLAZA:</th>		<td>'+htmlEsta+'</td><td><p class="text-right">'+htmlAlta+'</p></td></tr> '+
							 '<tr><th>TITULAR:</th>					<td colspan="2">'+htmlNombre+'</td></tr> '+						
							 '<tr><th>DEPENDENCIA</th>           	<td colspan="2"><b>'+dataDet[i].organo+'</b> <br> '+dataDet[i].gerencia+' <br>'+dataDet[i].dep2+' '+ofi+'  '+desc+'</td></tr>'+
							 '<tr><th>NIVEL:</th>					<td colspan="2">'+dataDet[i].IdNivel+'  <b>|</b>  '+dataDet[i].Nivel+' </p></td></tr> '+					
							 '<tr><th>CARGO:</th>					<td colspan="2">'+dataDet[i].cargo+'</td></tr> '+
							 '<tr><th>FECHA DE CESE:</th>			<td colspan="2">'+dataDet[i].fcese+'</td></tr> '+	
							 '<tr><th>CUENTA CON PRESUPUESTO?</th>	<td colspan="2">'+Tinesino+' </td></tr> '+						 							
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
       	var url="";
       	var xy=0;
       	if(dataDet.length!=0){  
       		$('.loading').show();
    
       	tableHtml  +='<table class="table dataTable no-footer dtr-inline"><tr> <th>#</th><th>PERSONA</th><th>TIPO.MOV.</th><th>DEPENDENCIA</th><th>CARGO</th> <th> DOC.REF.</th> <th>OBSERVACION</th> <th>F:&nbsp;MOV.&nbsp;&nbsp;|&nbsp;&nbsp;F:DOC.REF&nbsp;</th><th>ACCIÓN</th></tr>';    		
       		$('#IdGetShowEstadoPlazaDet').html("");
			for (var i=0; i < dataDet.length; i++) 	{ xy++;
				if(dataDet[i].Persona=="") persona="---"; else persona=dataDet[i].Persona;
				if(dataDet[i].FileAdjunto=="") url=dataDet[i].DocRef; else url='<a href="../uploads/files/'+dataDet[i].FileAdjunto+'" target="_blank">'+dataDet[i].DocRef+'</a>';

				tableHtml += '<tr>	<th>'+xy+'</th>'+
									'<td>'+persona+'</td>'+
							 		'<td>'+dataDet[i].tipomov+'</td> '+							 		
							 		'<td>'+dataDet[i].organo+' | '+dataDet[i].gerencia+' | '+dataDet[i].dep2+' | '+dataDet[i].ofi+'</td>'+	
							 		'<td>'+dataDet[i].cargo+'</td>'+											
							 		'<td>'+url+'</td>'+							
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
		// $('#IdShowDetailsMov').html(tableHtml);

	});	
}


function ShowHistoriaMov(id,iddni){	 // xxx 
	console.log("Nro de Plaza=1==>"+id+"-->"+iddni);	
	$.get('../api/admin/rpteplazas/list/'+id+iddni,function(dataDa){
		$('#IdShowDetailsMov').html("");
		var tableHtml 	="";
		var htmlHead 	="";
		//console.log("---->"+dataDa);
		var url="";
		
       	var xy=0;   
       	var ErrorHtml='<tr><td colspan="9"><div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div></td></tr>';
        var HtmlHeadTr='<tr class="filters"><th>#</th><th>DEPENDENCIA</th><th>NIVEL</th><th>CARGO</th><th>T.MOV</th><th>F.MOV</th> <th>F.DOC</th><th>DOC.DE&nbspREF.</th> <th>OBSERVACION</th><th>DOC.ADJ.</th></tr>';
       		if(dataDa.length!=0){  
       		 $('.loading').show();	
       		$('#headTR').html(HtmlHeadTr);	       		
			for (var i=0; i < dataDa.length; i++) 	{
				xy++; 
				//console.log("==sede=>"+dataDa[i].sede+' / '+dataDa[i].dependencia);
						if(i=="0"){
							 htmlHead ='<b>'+dataDa[0].dni +'  |  '+dataDa[0].nom+'  |  PLAZA N°['+dataDa[0].NroPlaza+']</b>';
							 $('#IdHeadDetMov').html(htmlHead);
						}
				if(dataDa[i].FileAdjunto=="") url='---'; else url='<a href="../uploads/files/'+dataDa[i].FileAdjunto+'" target="_blank" class="btn btn-info btn-sm btn-responsive" role="button"><span class="livicon" data-name="notebook" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span><br/>Abrir</a>';
						
				tableHtml += '<tr><td>'+xy+'</td>'+
				'<td>'+dataDa[i].centro+' | <br> '+dataDa[i].dep+' | '+dataDa[i].dep2+' | '+' | '+dataDa[i].ofi+' | '+ dataDa[i].dependencia+'</td>'+
				'<td>'+dataDa[i].IdNivel+'</td>'+
				'<td>'+dataDa[i].cargo+'</td>'+
				'<td>'+dataDa[i].TipoMov+'</td>'+
				'<td>'+dataDa[i].FechaMov+'</td>'+
				'<td>'+dataDa[i].fechaDoc+'</td>'+
				'<td>'+dataDa[i].DocRef+'</td>'+
				'<td>'+dataDa[i].Observacion+'</td>'+
				'<td>'+url+'</td>'+
				'</tr>';
				$('#IdShowDetailsMov').html(tableHtml);	
			}
			$('.loading').hide();
		}else{
			$('#IdShowDetailsMov').html(ErrorHtml);
		}
		
	});					
	
}
/*===================================================================*/
function GetListaIndex(){
	var formData = new FormData($("form[name='frmindex']")[0]);    
   
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmindex').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {                      
                getRowsListaIndex(data);
           
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function getRowsListaIndex(data) { 
    var xy=0;
    var tableHtml="";
    var urlFicha="";
    var urlMov="";
    var plaza="";
    var sdelete="";
    if(data.length!=0){
    	 $('.loading').show();
        $.each(data, function( key, value ) { xy++;

		if(value.NroPlaza=="") plaza="<p class='text-danger'><b>INACTIVO</b></p>"; else plaza=value.NroPlaza;
           urlFicha='<a data-href="#responsive" href="#responsive" onclick=FichaTrabajador("'+value.dni+'","'+value.NroPlaza+'") class="btn btn-info btn-responsive" role="button" data-toggle="modal" ><span class="livicon" data-name="signal" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>Ficha  </a>';
           urlMov='<a data-href="#responsive" href="#responsive" onclick=ShowHistoriaMov('+value.dni+'","'+value.NroPlaza+'") class="btn btn-warning btn-responsive" role="button" data-toggle="modal"><span class="livicon" data-name="notebook" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>Movimientos</a>';
           sdelete='<div class="ui-group-buttons"><a href="{{ URL::to(admin/bajaplazas) }}?z={{$plaz}}" class="btn btn-danger"> </i> Baja</a></div>';            

              tableHtml +=
                  '<tr>'+
                     '<td>'+xy+'</td>'+             
                     '<td>'+plaza+'</td>'+
                     '<td>'+value.IdNivel+'</td>'+                            
                     '<td>'+value.dni+'</td> '+         
                     '<td>'+value.nom+'</td>'+
                     '<td>'+value.sede+' | '+value.dependencia+' </td>'+
                     '<td>'+urlFicha+'</td>'+ 
                     '<td>'+urlMov+'</td>'+
                     '<td>'+sdelete+'</td>'+
                    
                  '</tr>';
                     
        }); 
        $('#Divgetlistaindex').html(tableHtml);
        $("#txtdnificha").val("");
		$("#txtplazaficha").val("");
		$('#IdShowDetailsMov').html("");	
		$('.loading').hide(); 
       }else{
        $("#msjerror").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(3000).fadeOut('slow');
    }
   
}

function FichaTrabajador(dni,plaza){		
	console.log("===>"+dni);
	$("#txtdnificha").val(dni)
	$("#txtplazaficha").val(plaza)

	var formData = new FormData($("form[name='frmfichajob']")[0]);   
	// formData.append('iddni',$("#txtdnificha").val()); 
    $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmfichajob').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {    

                dibujafichajob(data);

           $('.loading').hide(); 
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function doesFileExist(urlimg){
    var xhr = new XMLHttpRequest();
    var url=location.href+urlimg;
    xhr.open('HEAD', url, false);
    xhr.send();
    if (xhr.status == "404") {
        urlimg=location.href+"/../../uploads/img/no_avatar.jpg";        
        return urlimg;
    } else {
        return url;
    }
}

function dibujafichajob(data) { 
    var xy=0;
    var tableHtml="";
    var htmltitle="";
    var htmlHeadImg="";
    var urlimg="";
    var org="";
    if(data.length!=0){
        $.each(data, function( key, value ) { xy++;
		
					 htmltitle ='<b> FICHA DE  PLAZA N°['+value.NroPlaza+']</b>';
					 $('#IdHeadDetMov').html(htmltitle);					
						
					 urlimg=doesFileExist("/../../uploads/img/"+value.dni+".jpg");

					 htmlHeadImg = '<div class="text-center"><img src='+urlimg+' alt="img" class="img-circle" height="100px" width="100px"/>'+ 
									 '<p class="text-center"><h4>TITULAR</h4></p>'+
									 '<p class="text-center"><h5>'+value.dni+' | '+value.nom+'</h5></p>'+
									 '<p class="text-center"><h5>F.DE NACIMIENTO | '+value.FechaNac+'</h5></p>'+
								 '</div>';
					 $('#headficha').html(htmlHeadImg);
								
					 if(value.organo=="null "){org="-*-";} else {org=value.organo;}
					
					tableHtml += '<tr><th colspan="3">DEPENDENCIA</th></tr>'+
					 '<tr><td colspan="3"><p style="margin: 0px 0px 0px 30px;">'+org+' | '+value.gerencia+'</p></td></tr>'+					
					 '<tr><td colspan="3"><p style="margin: 0px 0px 0px 30px;">'+value.dep2+' | '+value.ofi+' | '+value.dependencia+'</p></td></tr>'+	

					 '<tr><th style="width:30%">NIVEL:</th><td colspan="2" style="width:45%"><p style="margin: 0px 0px 0px 30px;">'+value.idNivel+' | '+value.nivel+' </p></td></tr> '+					
					 '<tr><th>CARGO:</th><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+value.cargo+' </p></td></tr> '+							 
					 '<tr><th>PLAZA N°:</th><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+value.NroPlaza+' </p></td></tr> '+	
					 '<tr><th>RÉGIMEN:</th><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+value.regimen+' </p></td></tr> '+						
					 '<tr><th>FECHA&nbspINGRESO:</th><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+value.fingreso+'</p></td>'+
					 '<tr><th>FECHA&nbsp;INICIO&nbsp;FUNCIONES:</th><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+value.FechaInicio+'</p></td>'+					 
					 '<tr><th>DOCUMENTO:</th><td colspan="2"><p style="margin: 0px 0px 0px 30px;">'+value.documento+' </p></td></tr> '+
					 '</tr>';
					$('#IdShowDetailsMov').html(tableHtml);	
                     
        });    
       }else{
        $("#divmsjeerror").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(3000).fadeOut('slow');
    }
   
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

// =================================================
var paramstr = window.location.search.substr(1);
var paramarr = paramstr.split ("&");
var params = {};

for ( var i = 0; i < paramarr.length; i++) {
    var tmparr = paramarr[i].split("=");
    params[tmparr[0]] = tmparr[1];
}

if (params['z']) {
  $("#string_search").val(params['z']);
  $("#getsubmnit").click(); 
} 