$(function(){
$("#search_plaza").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
        loaddatosform();
        }
      });
 	$('#FormAltaPlaza').hide();

	/* =============================*/
	$("#search_persona").keypress(function(e) {
		var code = (e.keyCode ? e.keyCode : e.which);
        if(code == 13) {
         var strin=$("#search_persona").val();       
        console.log("val-->"+strin);
        GetDataPerSeach(strin);
        }
      });
	/*================================*/

})

function loaddatosform(){
	 $("#frmSaveAlta")[0].reset();
         var strin=$("#search_plaza").val();
          GetDatosPlazaForAlta(strin);  
          getTipoDoc("1");   
          getProfesionForAlta("1");    
          getTipoAltaForAlta("1");
          getRegimenForAlta("1");
}
/*===================================================*/
function GetDataPerSeach(id){	
	//console.log("=1==>"+id);
	$.get('../api/admin/altaplaza/listper/'+id,function(dataSearch){			
		//console.log("=2==>"+dataSearch);
		var tableHtml='';
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	var xy=0;
       	var dni="";
       	if(dataSearch.length!=0){       		
			for (var i=0; i < dataSearch.length; i++) 	{
				xy++; 
				dni=dataSearch[i].Dni;
				tableHtml += '<tr><td>'+xy+'</td> <td><a href="#" onclick=setDatosFormPersona("'+dni+'")>'+dataSearch[i].Dni+'</a></td><td>'+dataSearch[i].Nombres+'</td></tr>';
				$('#IdShowResultSearchP').html(tableHtml);				
			}
		}else{
			$('#IdMsjeErrorResultSearchp').html(ErrorHtml);
		}	
	});	
}

/*===================================================*/
function setDatosFormPersona(xdni){
	//alert("======1==>"+xdni);
	$.get('../api/admin/altaplaza/listset/'+xdni,function(dataSearch){			
		console.log("=2==>"+dataSearch);		
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';  
       	var html_G="";
       	var resi="";
       	if(dataSearch.length!=0){       		
			for (var i=0; i < dataSearch.length; i++) 	{								
				$('#nrodocumento').val(dataSearch[i].Dni);				
				$('#ape_pat').val(dataSearch[i].ApellidoPat);
				$('#ape_mat').val(dataSearch[i].ApellidoMat);
				$('#txtnombre').val(dataSearch[i].Nombres);

				$('#datetime1').val(dataSearch[i].FechaNac);
				$('#datetime3').val(dataSearch[i].FechaIngreso);
				console.log("=1==>"+dataSearch[i].FechaNac);
			
				$('#txtdireccion').val(dataSearch[i].Direccion);			
				$('#idgenero option[value='+dataSearch[i].Genero+']').attr('selected','selected');
				$('#idcarrera option[value='+dataSearch[i].IdProfesion+']').attr('selected','selected');	
				$('#IdRegimen option[value='+dataSearch[i].IdRegimen+']').attr('selected','selected');			
       			$('#txtespecialidad').text(dataSearch[i].Especialidad);       			
				$('#countries option[value='+dataSearch[i].IdPais+']').attr('selected','selected');
				//console.log("=1=Pais=>"+dataSearch[i].IdPais);	
				$('#CierrameModalResult').click();
				resi=dataSearch[i].Residentado;
				//console.log("--resi-->"+resi);
				if(resi=="1"){$('#idResidentado').click();} 

			}
		}else{
			$('#IdMsjeErrorResultSearchp').html(ErrorHtml);
		}	
	});	

}
/*===================================================*/


$("#IdSaveAltaDePlazas").click(function (e) {
    e.preventDefault();  	
    var formData = new FormData($("form[name='frmSaveAlta']")[0]);
    
    var messages="";
	var _NroPlazaA			= $('#NroPlazaA').val();
	var _IdCargoA			= $('#IdCargoA').val();

	var _IdTipoDoc			= $('#IdTipoDocument').val();
	var	_nrodoc				= $('#nrodocumento').val();
	var _ape_pat			= $('#ape_pat').val();
	var _ape_mat			= $('#ape_mat').val();
	var	_txtnombre			= $('#txtnombre').val();
	var	_Fechanac			= $('#datetime1').val();
	var	_country			= $('#country').val();
	var	_txtdirecc			= $('#txtdireccion').val();
	var	_idgenero			= $('#idgenero').val();
	var	_idcarrera			= $('#idcarrera').val();
	var	_txtespecial		= $('#txtespecialidad').val();
	var	_IdRegimen			= $('#IdRegimen').val();
	var	_IdFechaalta		= $('#datetime3').val();
	var	_MotivoAlta			= $('#selectIdalta').val();
	
	
	if(_NroPlazaA.trim().length!=8){		messages="Error! No existe el N° de Plaza";} 
	else if(_IdCargoA.length!=5){			messages="Error! No existe el  Cargo";} 
	else if(_IdTipoDoc==""){				messages="Por favor, seleccione el Tipo de docuemento";} 
	else if(_nrodoc.trim().length<8){		messages="Ingrese el N° de documento, el N° debe esta compuesto por 8 caractéres";} 
	else if(_ape_pat.trim().length<3){		messages="Por favor, Ingrese el Apellido Paterno[No menor a tres caractéres]";} 
	else if(_ape_mat.trim().length<3){		messages="Por favor, Ingrese el Apellido Materno[No menor a tres caractéres]";} 
	else if(_txtnombre.trim().length<3){	messages="Por favor, Ingrese los Nombres[No menor a tres caractéres]";} 
	else if(_Fechanac.trim().length<10){	messages="Por favor, Seleccione la Fecha de Nacimiento";} 
	else if(_country==""){					messages="Por favor, Seleccione el Pais";} 
	//else if(_txtdirecc.trim().length<8){	messages="Por favor, Ingrese la Dirección[No menor a ocho caractéres]";} 
	else if(_idgenero==""){					messages="Por favor, Seleccione el Género";} 
	//else if(_idcarrera==""){				messages="Por favor, Seleccione la Carrera";} 	
	else if(_MotivoAlta==""){				messages="Por favor, Seleccione el Tipo de Alta";}	
	else if(_IdRegimen==""){				messages="Por favor, Seleccione el Régimen";}	
	else if(_IdFechaalta.trim().length<10){	messages="Por favor, Seleccione la Fecha de Alta";} else{messages="";}

		if(messages==""){
		    $.ajax({
		        type: "post",
		        headers: {'X-CSRF-TOKEN':$('#_token').val()},
		        url:  $('#frmSaveAlta').attr('action'),
		        dataType: 'json',
		        data: formData,
		        cache: false,
		        contentType: false,
		        processData: false,
		        success: function(data){ 
		        console.log("-2->"+data);		        	  
		           	if(data===true) {		           	
		                   $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');		             		
		                   $("#frmSaveAlta")[0].reset();		                   	
		                   $('#NroPlazaA').val("");		                  	              
		                } else {
		                   $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
		                }
		        } /*error:function(jqXHR, textStatus, errorThrown){
										console.log('error:: '+ errorThrown);
							}*/	
		    });
		} else { $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>'+messages+'</div>').fadeIn().delay(4000).fadeOut('slow'); }

})

function GetDatosPlazaForAlta(id){	
	console.log("===>"+id);
	$.get('../api/admin/altaplaza/'+id,function(dataAlta){			
		console.log("===>"+dataAlta);
		var tableHtml='';
		var htmlHead="";
		var htmlNombre="";
 
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';
       	var HtmlPlaza='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> La Plaza no esta disponible!</div>';
       	if(dataAlta.length!=0){
       		$('#ShowDataHead').show();
       		$('#IdMsjeErrorAltaPlaza').html("");	
			for (var i=0; i < dataAlta.length; i++) 	{
				_IdPlaza		=dataAlta[i].IdPlaza;
				_IdPersona		=dataAlta[i].IdPersona;
				_IdEstructura 	=dataAlta[i].IdEstructura;
				_IdCargo		=dataAlta[i].IdCargo;				
				_NroPlaza		=dataAlta[i].NroPlaza;
				$('#IdPlazaA').val(_IdPlaza);
				$('#IdPersonaA').val(_IdPersona);
				$('#IdEstructuraA').val(_IdEstructura);
				$('#IdCargoA').val(_IdCargo);
				$('#NroPlazaA').val(_NroPlaza);

   				_IdNivelCargo	='NIVEL|CARGO: '+dataAlta[i].IdNivel+' | '+dataAlta[i].cargo;							
   				_sede			=dataAlta[i].sede +' | '+dataAlta[i].organo+' | '+dataAlta[i].dep+' | '+dataAlta[i].dep2+ ' | '+dataAlta[i].descrip;   				
   				//_dep		  	=dataAlta[i].dep+' | '+dataAlta[i].descrip;  

   				if(_IdPersona==""){   					   					
   					$('#NroPlazaDescripcion').val(_NroPlaza+"[PLAZA VACANTE]");
   					$('#FormAltaPlaza').show();
   					$('#IdSpaceHead').html("");
   				}
   				else { 
   					$('#NroPlazaDescripcion').val(_NroPlaza+"[PLAZA NO DISPONIBLRE]");
   					$('#FormAltaPlaza').hide();
   					$('#IdSpaceHead').html(HtmlPlaza);
   					
   					
   				}
   				$('#IdNivelNroPlaza').val(_IdNivelCargo);
   				$('#IdDepenorgano').val(_sede);
   				//$('#IdDependenciaDes').val(_dep);				
			}

		}else{
			$('#IdMsjeErrorAltaPlaza').html(ErrorHtml);
		}
	
	});	
}

function getTipoDoc(idx){
	$.get('../api/admin/tipodoc/getforalta/'+idx,function(data){
	var html_select="";
	console.log(data);
	for (var i=0; i < data.length; i++)
		html_select += '<option value="'+data[i].IdTipoDocumento+'">'+data[i].Descripcion+'</option>';
		$('#IdTipoDocument').html(html_select);	
	});
}

function getProfesionForAlta(idx){
	$.get('../api/admin/profesion/getforalta/'+idx,function(data){
	var html_select="";
	//console.log(data+" <br>=========>"+idx);
	html_select = '<option value="">Seleccione la Carrera[Profesiones]</option>';
	for (var i=0; i < data.length; i++)
		html_select += '<option value="'+data[i].IdProfesion+'">'+data[i].Descripcion+'</option>';
		$('#idcarrera').html(html_select);	
	});
}

function getTipoAltaForAlta(idx){
	$.get('../api/admin/altaplaza/gettipomov/'+idx,function(data){
	var html_select="";	
	html_select = '<option value="">Seleccione el Tipo de Alta</option>';
	for (var i=0; i < data.length; i++)
		html_select += '<option value="'+data[i].IdTipoMov+'">'+data[i].Descripcion+'</option>';
		$('#selectIdalta').html(html_select);	
	});
}

function getRegimenForAlta(idx){
	$.get('../api/admin/altaplaza/getregimen/'+idx,function(data){
	var html_select="";	
	html_select = '<option value="">Seleccione el Tipo de Régimen</option>';
	for (var i=0; i < data.length; i++)
		html_select += '<option value="'+data[i].IdRegimen+'">'+data[i].Descripcion+'</option>';
		$('#IdRegimen').html(html_select);	
	});
}

function onChangeAll_2(){
	var getData=$('#select_nivel-2').val();
	GetAllPlazasForAlta(getData);
}

function onChangeAll_3(){
	var getData=$('#select_nivel-3').val();
	GetAllPlazasForAlta(getData);
}

function onChangeAll_4(){
	var getData=$('#select_nivel-4').val();
	GetAllPlazasForAlta(getData);
}

function onChangeAll_5(){
	var getData=$('#select_nivel-5').val();
	GetAllPlazasForAlta(getData);
}


function getEstructuraAll(id){
	$.get('../api/admin/altaplaza/getestru/'+id,function(data3){
	var html_select="";
	html_select = '<option value="">Elegir</option>'
	for (var i=0; i < data3.length; i++)
		html_select += '<option value="'+data3[i].IdEstructura.substr(0,2)+'">'+data3[i].IdEstructura.substr(0,2)+' | '+data3[i].Descripcion+'</option>';
		$('#select_nivel-0').html(html_select);	
	});
	
}

function getflat(ix){
	$("#idflat").val(ix);
}

function GetAllPlazasForAlta(idx){	
	console.log('ID==>'+idx);	
	$('#IdShowPlazasAlta').html("");
	$('#msjcount').html("");
	$.get('../api/admin/altaplaza/getshowest/'+idx,function(dataDa){
			var tableHtml='';		
       		var xy=0;   
       		var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Error:</strong> no existe registros!</div>';
       		
       		console.log('ID==3===>'+idx);
       		var NroPlaza;
       		if(dataDa.length!=0){ 
       		$('#IdShowPlazasAlta').html(""); 		
			for (var i=0; i < dataDa.length; i++) 	{		
				xy++; 
				NroPlaza=dataDa[i].NroPlaza;
				if($("#idflat").val()=="0"){
					tableHtml += '<tr><td>'+xy+'</td><td>'+dataDa[i].IdEstructura+'</td> <td><a href="#" onclick=setPrmFiltroDatos("'+NroPlaza+'")>'+dataDa[i].NroPlaza+'</a></td><td>'+dataDa[i].IdNivel+'</td><td>'+dataDa[i].cargo+'</td><td>'+dataDa[i].ApellidoPat+' '+dataDa[i].ApellidoMat+'  '+dataDa[i].Nombres+'</td></tr>';
				}
				if($("#idflat").val()=="1"){
					tableHtml += '<tr><td>'+xy+'</td><td><a href="#" onclick=setPrmFiltroDatosEstru("'+dataDa[i].IdEstructura+'")>'+dataDa[i].IdEstructura+'</a></td><td>'+dataDa[i].NroPlaza+'</td><td>'+dataDa[i].IdNivel+'</td><td>'+dataDa[i].cargo+'</td><td>--</td></tr>';
				}
				$('#IdShowPlazasAlta').html(tableHtml);	
			}
			if(xy>=500){
				$('#msjcount').html('<div class="alert alert-danger" role="alert"></span> </strong>La cantidad de registros sobre pasa a 500!</div>').fadeIn().delay(4000).fadeOut('slow');;
			}
		}else{
			$('#IdShowPlazasAlta').html(ErrorHtml);
		}
		
	});		
}

function setPrmFiltroDatos(id){
	$('#search_plaza').val(id);		
	$('#CierrameModal').click();
}

function setPrmFiltroDatosEstru(id){
	$('#IdEstructuraA').val(id);	

	$('#CierrameModal').click();
	$('#IdDepenorgano').val($('#select_nivel-0 option:selected').html()+' | '+$('#select_nivel-1 option:selected').html()+' | '+$('#select_nivel-2 option:selected').html()+' | '+$('#select_nivel-3 option:selected').html()+' | '+$('#select_nivel-4 option:selected').html());

	
}


function checkboxS(){
	var select= "0";
	if($("#idResidentado").is(':checked')) {select="1";} else {select="0";}
	$("#idresid").val(select);
}

var paramstr = window.location.search.substr(1);
var paramarr = paramstr.split ("&");
var params = {};

for ( var i = 0; i < paramarr.length; i++) {
    var tmparr = paramarr[i].split("=");
    params[tmparr[0]] = tmparr[1];
}
if (params['x']) {
  $("#search_plaza").val(params['x']);
  $("#idsearchaltaform").click();  
}