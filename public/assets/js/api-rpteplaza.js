$(function(){

$("#searchPlazaForRpte").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
        // var strin=$("#searchPlazaForRpte").val();
          GetEstadoPlazahead();
          //GetAllPlazasMov(strin);
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

// =====================================================================================
function GetEstadoPlazahead(){
	var formData = new FormData($("form[name='frmdetallamov']")[0]); 
	$("#txtplazamovdet").val($('#searchPlazaForRpte').val());
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmdetallamov').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {                      
                GetEstadoPlazahead_rows(data);
                GetDetalleMovientos();          
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });

}

function GetEstadoPlazahead_rows(data) { 
    	var xy=0;
   		var tableHtml='';		
		var htmlHead="";
		var htmlNombre="";
		var Tinesino="";
		var url="";
		var ofi="";
    	var desc="";
    	var Tinesino="";
    	var htmlAlta="";
		var htmlEsta="";
 		var link ="";
    	var linkdni="";   
    	var suplen="";
    	var suplenPrint="";    	

   //var tableHtmlhead="<table class='table dataTable no-footer dtr-inline'><tr><th>#</th> <th>#DNI</th> <th>APELLIDOS Y NOMBRES</th> <th>NIVEL</th> <th>CARGO</th><th>RÉGIMEN</th><th>#PLAZA</th></tr>";
   
    if(data.length!=0){
    	 $('.loading').show();
        $.each(data, function( key, value ) { xy++;
        		$('#IdGetShowEstadoPlaza').html(""); 

         if(value.fcese!=""){ Tinesino= '<p class="btn btn-info start">'+value.sino+'</p>';} else{ 
              if(value.estado=="ACTIVA"){Tinesino="<p class='btn btn-info start'> SI </p>";} else{Tinesino=" ";}
          }  
          url= "altaplaza?x="+value.NroPlaza;	
		  if(value.IdPersona=="") htmlAlta="<a href="+url+ ' class="btn btn-info">DAR DE ALTA</a>'; else htmlAlta="";

            htmlEsta="<p class='btn btn-info start'> "+value.NroPlaza+" | "+value.estado+"</p>" 
            htmlNombre=value.ApellidoPat+'  '+value.ApellidoMat+' '+value.Nombres;

            if(value.ofi=="SN"){ofi='';} else {ofi="<br>"+value.ofi;}

            if(value.descripcion=="SN"){desc='';} else {desc="<br>"+value.descripcion;}

             if(value.idsuplente!="") {suplenPrint=value.nombresuplente;}else{suplenPrint="";}
             var msjcompr="";
             if(value.SubIdEstadoPlaza!="") {msjcompr="<p class='btn btn-warning'>ESTA COMPROMETIDA PARA: "+value.desSubEstado+"</p>";}else{msjcompr="";}
            tableHtml +='<div class="rounded"><table class="table dataTable small">'+
                  '<tr><th width="23%"> PLAZA:</th>    <td>'+htmlEsta+' '+msjcompr+'<br><p class="text-danger"><b>'+value.Observ+'</p></td><td><p class="text-right">'+htmlAlta+'</p></td></tr> '+             
                   '<tr><th>TITULAR:</th>              <td colspan="2">'+htmlNombre+'</td></tr> '+
                   '<tr><th>SUPLENTE:</th>              <td colspan="2">'+suplenPrint+'</td></tr> '+
                   '<tr><th>DEPENDENCIA</th>           <td colspan="2"><b>'+value.organo+'</b> <br> '+value.gerencia+' <br>'+value.dep2+' '+ofi+'  '+desc+'</td></tr>'+                            
                   '<tr><th>NIVEL:</th>                <td colspan="2">'+value.IdNivel+'  <b>|</b>  '+value.Nivel+' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>REGIMEN:&nbsp;&nbsp;</b>'+value.regimen+'</td></tr> '+         
                   '<tr><th>CARGO:</th>                <td colspan="2">'+value.cargo+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ESPECIALIDAD:&nbsp;&nbsp;</b>'+value.Especialidad+'</td></tr> '+
                   '<tr><th>F. DE CESE:</th>           <td colspan="2">'+value.fcese+' </td></tr> '+ 
                   '<tr><th>CTA CON PRESUPUESTO?</th><td colspan="2">'+Tinesino+'</td></tr> '+ 
                 
                   '</table></div>';
                   /*
				tableHtml += '<table class="table dataTable no-footer dtr-inline">'+
							 '<tr><th width="23%">PLAZA:</th>		<td>'+htmlEsta+'</td><td><p class="text-right">'+htmlAlta+'</p></td></tr> '+
							 '<tr><th>TITULAR:</th>					<td colspan="2">'+htmlNombre+'</td></tr> '+						
							 '<tr><th>DEPENDENCIA</th>           	<td colspan="2"><b>'+value.organo+'</b> <br> '+value.gerencia+' <br>'+value.dep2+' '+ofi+'  '+desc+'</td></tr>'+
							 '<tr><th>NIVEL:</th>					<td colspan="2">'+value.IdNivel+'  <b>|</b>  '+value.Nivel+' </p></td></tr> '+					
							 '<tr><th>CARGO:</th>					<td colspan="2">'+value.cargo+'</td></tr> '+
							 '<tr><th>FECHA DE CESE:</th>			<td colspan="2">'+value.fcese+'</td></tr> '+	
							 '<tr><th>CUENTA CON PRESUPUESTO?</th>	<td colspan="2">'+Tinesino+' </td></tr> '+						 							
							 '</tr></table>';*/
				$('#IdGetShowEstadoPlaza').html(tableHtml);	

        });         
        $('.loading').hide();
       }else{       	
        $("#msjerrormov").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(3000).fadeOut('slow');
        $('#IdGetShowEstadoPlaza').html("");
    }
   
}
// ========================================================================================

function GetDetalleMovientos(){
	var formData = new FormData($("form[name='frmplazamovdet']")[0]); 
	$("#txtplazamovdet").val($('#searchPlazaForRpte').val());
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmplazamovdet').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {
        	GetDetalleMovientos_rows(data);
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });

}

function GetDetalleMovientos_rows(data){
var xy=0;
    var tableHtml="";
    var urlFicha="";
    var urlMov="";
    var plaza="";
    var sdelete="";
    	tableHtml  +='<table class="table dataTable no-footer dtr-inline"><tr> <th>#</th><th>PERSONA</th><th>TIPO.MOV.</th><th>DEPENDENCIA</th><th>CARGO</th> <th> DOC.REF.</th> <th>OBSERVACION</th> <th>F:&nbsp;MOV.&nbsp;&nbsp;|&nbsp;&nbsp;F:DOC.REF&nbsp;</th></tr>';    		   
	    if(data.length!=0){
	    	$('.loading').show();
	        $.each(data, function( key, value ) {
	        		xy++;
					if(value.Persona=="") persona="---"; else persona=value.Persona;
					if(value.FileAdjunto=="") url=value.DocRef; else url='<a href="../uploads/files/'+value.FileAdjunto+'" target="_blank">'+value.DocRef+'</a>';

					tableHtml += '<tr>	<th>'+xy+'</th>'+
										'<td>'+persona+'</td>'+
								 		'<td>'+value.tipomov+'</td> '+							 		
								 		'<td>'+value.organo+' | '+value.gerencia+' | '+value.dep2+' | '+value.ofi+'</td>'+	
								 		'<td>'+value.cargo+'</td>'+											
								 		'<td>'+url+'</td>'+							
								 		'<td>'+value.Observacion+'</td>'+					
								 		'<td>'+value.fm+' | '+value.fd+'</td>'+							 							
								 '</tr>';
				
							$('#IdGetShowEstadoPlazaDet').html(tableHtml);
					
	                     
	        }); 			       	
			$('.loading').hide(); 
	       }else{
	        $("#msjerrormovdet").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(3000).fadeOut('slow');
	        $('#IdGetShowEstadoPlazaDet').html("");
	    }
}
// ========================================================================================
function GetDetalleMovientosEmerg(xdni,xplaza){
	var formData = new FormData($("form[name='frmmovwindowEmerg']")[0]); 
	$("#txtdnifichamov").val(xdni);
	formData.append('txtplazamovdet',xplaza); 
	var xy=0;
    var tableHtml="";
    var urlFicha="";
    var urlMov="";
    var plaza="";
    var sdelete="";
    
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmmovwindowEmerg').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {
        		$('#headficha').html("");
        		tableHtml  +='<table class="table dataTable no-footer dtr-inline"><tr> <th>#</th><th>PERSONA</th><th>TIPO.MOV.</th><th>DEPENDENCIA</th><th>CARGO</th> <th> DOC.REF.</th> <th>OBSERVACION</th> <th>F:&nbsp;MOV.&nbsp;&nbsp;|&nbsp;&nbsp;F:DOC.REF&nbsp;</th></tr>';    		   
			    if(data.length!=0){
			    	$('.loading').show();
			        $.each(data, function( key, value ) {
			        		xy++;
							if(value.Persona=="") persona="---"; else persona=value.Persona;
							if(value.FileAdjunto=="") url=value.DocRef; else url='<a href="../uploads/files/'+value.FileAdjunto+'" target="_blank">'+value.DocRef+'</a>';

							tableHtml += '<tr>	<th>'+xy+'</th>'+
												'<td>'+persona+'</td>'+
										 		'<td>'+value.tipomov+'</td> '+							 		
										 		'<td>'+value.organo+' | '+value.gerencia+' | '+value.dep2+' | '+value.ofi+'</td>'+	
										 		'<td>'+value.cargo+'</td>'+											
										 		'<td>'+url+'</td>'+							
										 		'<td>'+value.Observacion+'</td>'+					
										 		'<td>'+value.fm+' | '+value.fd+'</td>'+							 							
										 '</tr>';
						
									$('#IdShowDetailsMov').html(tableHtml);
							
			                     
			        }); 			       	
					$('.loading').hide(); 
			       }else{
			        $("#divmsjeerror").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(3000).fadeOut('slow');
			        $('#IdShowDetailsMov').html("");
			    }

        	
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });

}
// ========================================================================================

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
                GetListaIndex_rows(data);
           
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function GetListaIndex_rows(data) { 
    var xy=0;
    var tableHtml="";
    var urlFicha="";
    var urlMov="";
    var plaza="";
    var sdelete="";
    var url="";
    var htmlbaja="";
    if(data.length!=0){
    	 $('.loading').show();
        $.each(data, function( key, value ) { xy++;

        	url= "bajaplazas?z="+value.NroPlaza;	
		  if(value.IdPersona!="") htmlbaja="<a href="+url+ ' class="btn btn-danger">Baja</a>'; else htmlbaja="";


		if(value.NroPlaza=="") plaza="<p class='text-danger'><b>INACTIVO</b></p>"; else plaza=value.NroPlaza;
           urlFicha='<a data-href="#responsive" href="#responsive" onclick=FichaTrabajador("'+value.dni+'","'+value.NroPlaza+'") class="btn btn-info btn-responsive" role="button" data-toggle="modal" ><span class="livicon" data-name="signal" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>Ficha  </a>';
           urlMov='<a data-href="#responsive" href="#responsive" onclick=GetDetalleMovientosEmerg("'+value.persona+'","'+value.NroPlaza+'") class="btn btn-warning btn-responsive" role="button" data-toggle="modal"><span class="livicon" data-name="notebook" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>Movimientos</a>';
           sdelete='<div class="ui-group-buttons">'+htmlbaja+'</div>';            

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
        $('#Divgetlistaindex').html("");
    }
   
}
// =====================================================================================
function FichaTrabajador(dni,plaza){		
	console.log("===>"+dni);
	$("#txtdnificha").val(dni)
	$("#txtplazaficha").val(plaza)

	var formData = new FormData($("form[name='frmfichajob']")[0]);   	
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
                FichaTrabajador_rows(data);
           $('.loading').hide(); 
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function FichaTrabajador_rows(data) { 
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
//=====================================================================================
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
// =========================================================================================

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