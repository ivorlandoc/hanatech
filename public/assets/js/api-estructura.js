$(function(){

$('#select_nivel-0').on('change',OnSelectElPrimerNivel);
$('#select_nivel-1').on('click',OnSelectElSegundoNivel);
$('#select_nivel-2').on('click',OnSelectElTercerNivel);
$('#select_nivel-3').on('click',OnSelectElCuartoNivel);
})

function OnSelectElPrimerNivel(){
		var getNivel_1= $(this).val();		
		if(!getNivel_1){
			$('#select_nivel-1').html('<option value="">Select</option>');
			return;
		}
		
		$.get('../api/admin/estructura/'+getNivel_1,function(data){
		var html_select2="";	
		for (var i=0; i < data.length; i++)
			html_select2 += '<option value="'+data[i].IdEstructura+'">'+data[i].IdEstructura+' | '+data[i].Descripcion+'</option>';
			$('#select_nivel-1').html(html_select2);			
		});
		$('#select_nivel-2').html('<option value="">Elegir</option>');
		$('#select_nivel-3').html('<option value="">Elegir</option>');
		$('#select_nivel-4').html('<option value="">Elegir</option>');
}



function OnSelectElSegundoNivel(){
	var getNivel_2= $('#select_nivel-1').val();	
	if(!getNivel_2){
		$('#select_nivel-2').html('<option value="">Select</option>');
		return;
	}
	$.get('../api/admin/estructura/'+getNivel_2,function(data3){
	var html_select3="";
	//alert("data3.length-->"+data3.length);
	if(data3.length=="1")	 {html_select3 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select3);}
	for (var i=0; i < data3.length; i++)
		html_select3 += '<option value="'+data3[i].IdEstructura+'">'+data3[i].IdEstructura+' | '+data3[i].Descripcion+'</option>';
		$('#select_nivel-2').html(html_select3);	
	});
	$('#select_nivel-3').html('<option value="">Elegir</option>');
	$('#select_nivel-4').html('<option value="">Elegir</option>');
}


function OnSelectElTercerNivel(){
	var getNivel_3= $('#select_nivel-2').val();	
	if(!getNivel_3){
		$('#select_nivel-3').html('<option value="">Select</option>');
		return;
	}
	$.get('../api/admin/estructura/'+getNivel_3,function(data4){
	var html_select4="";
	if(data4.length=="1")	 {html_select4 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select4);}

		for (var i=0; i < data4.length; i++)
			html_select4 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
			$('#select_nivel-3').html(html_select4);	
		});
	$('#select_nivel-4').html('<option value="">Elegir</option>');
}




function OnSelectElCuartoNivel(){
	var getNivel_4= $('#select_nivel-3').val();	
	if(!getNivel_4){
		$('#select_nivel-4').html('<option value="">Select</option>');
		return;
	}

	$.get('../api/admin/estructura/'+getNivel_4,function(data5){
	var html_select5="";
	if(data5.length=="1")	 {html_select5 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select5);}
		for (var i=0; i < data5.length; i++)
			html_select5 += '<option value="'+data5[i].IdEstructura+'">'+data5[i].IdEstructura+' | '+data5[i].Descripcion+'</option>';
			$('#select_nivel-4').html(html_select5);	
		});	
}


function GetIdSelectLevelOne(){
	var getSelectId= $('#select_nivel-0').val();
	ShowResumen(getSelectId);
}

function GetIdSelectLeveltwo(){
	var getSelectId= $('#select_nivel-1').val();
	ShowResumen(getSelectId);
}

function GetIdSelectLevelThree(){
	var getSelectId= $('#select_nivel-2').val();
	ShowResumen(getSelectId);
}

function GetIdSelectLevelFour(){
	var getSelectId= $('#select_nivel-3').val();
	ShowResumen(getSelectId);
}

function GetIdSelectLevelFive(){
	var getSelectId= $('#select_nivel-4').val();
	ShowResumen(getSelectId);
}

function ShowResumen(id){	
	console.log('ID==>'+id);	
	$.get('../api/admin/estructura/list/'+id,function(datap){
		var tableHtml='';
       		var xy=0;
       		var TotalSum=0;
       		var IdEstructura="";
       		
			for (var i=0; i < datap.length; i++) 	{
			TotalSum=TotalSum+datap[i].total;	
				xy++;
				IdEstructura=datap[i].IdEstructura;
			tableHtml += '<tr><td>'+xy+'</td> <td>'+datap[i].descripcion+'</td> <td style="text-align:center"> <a class="btn btn-raised btn-info" data-toggle="modal" data-href="#responsive" href="#responsive" onclick =ShowDetails("'+IdEstructura+'","1")>'+datap[i].admin+'</a></td><td style="text-align:center"> <a class="btn btn-raised btn-info" data-toggle="modal" data-href="#responsive" href="#responsive" onclick =ShowDetails("'+IdEstructura+'","2")>'+datap[i].Asist+'</a></td><td style="text-align:center"><a class="btn btn-raised btn-info" data-toggle="modal" data-href="#responsive" href="#responsive" onclick =ShowDetails("'+IdEstructura+'","0")>'+datap[i].vac+'</a></td><td style="text-align:center"><b>'+datap[i].total+'</b></td></tr>';
			$('#IdShowresume').html(tableHtml);	
		}
		tableHtml += '<tr><th colspan="5" style="text-align:right">TOTAL</th><th style="text-align:center">'+TotalSum+'</th></tr>';
		$('#IdShowresume').html(tableHtml);	
		});						
}

function ShowDetails(idx,flag){	
	$.get('../api/admin/estructura/detpobla/'+idx+flag,function(dataDa){
			var tableHtml='';
			var htmlHead="";
       		var xy=0;   
       		var ErrorHtml='<tr><td colspan="5"><div class="alert alert-danger alert-dismissable margin5"><strong>Error:</strong> no existe registros!</div></td></tr>';

       		if(dataDa.length!=0){  		
			for (var i=0; i < dataDa.length; i++) 	{		
				xy++; 
						if(i=="0"){
							 htmlHead ='<b>'+dataDa[0].IdEstructura +'  |  '+dataDa[0].descripcion+'</b>';
							 $('#IdHeadDet').html(htmlHead);
						}
				tableHtml += '<tr><td>'+xy+'</td><td>'+dataDa[i].NroPlaza+'</td> <td>'+dataDa[i].IdNivel+'</td><td>'+dataDa[i].cargo+'</td><td>'+dataDa[i].ApellidoPat+' '+dataDa[i].ApellidoMat+'  '+dataDa[i].Nombres+'</td></tr>';
				$('#IdShowDetails').html(tableHtml);	
			}
		}else{
			$('#IdShowDetails').html(ErrorHtml);
		}
		
	});		
	
}