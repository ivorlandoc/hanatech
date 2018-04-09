$(function(){

$('#select_0').on('change',OnSelectOne);
$('#select_1').on('click',OnSelectTwo);
$('#select_2').on('click',OnSelectThree);
$('#select_3').on('click',OnSelectFour); 

})



function ExportExcel(){    
   var formData = new FormData($("form[name='frmexportex']")[0]);  
      $('.loading').show();

                $.ajax({  
                        type: "post",
                        headers: {'X-CSRF-TOKEN':$('#token').val()},
                        url:  $('#frmexportex').attr('action'),
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    success: function (data) {                                      
                       
                       $('.loading').hide();          
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
       
     //   return false;
}



function OnSelectOne(){
		var getSelectOne= $('#select_0').val();		
		if(!getSelectOne){
			$('#select_1').html('<option value="">Elegir</option>');
			return;
		}
		//alert(getSelectOne);
		$.get('../api/admin/plazas/'+getSelectOne,function(data){
		var html_select2="";
		console.log(data);	
		for (var i=0; i < data.length; i++)
			html_select2 += '<option value="'+data[i].IdEstructura.substr(0,4)+'">'+data[i].IdEstructura.substr(0,4)+' | '+data[i].Descripcion+'</option>';
			$('#select_1').html(html_select2);
		});
		$('#select_2').html('<option value="">Elegir</option>');
		$('#select_3').html('<option value="">Elegir</option>');
		$('#select_4').html('<option value="">Elegir</option>');
		$('#IdShowPlazas').html('');
}

function OnSelectTwo(){
		var getSelectTwo= $('#select_1').val();	
		if(!getSelectTwo){
			$('#select_2').html('<option value="">Elegir</option>');
			return;
		}
		$.get('../api/admin/plazas/'+getSelectTwo,function(data3){
		var html_select3="";
		//if(data3.length=="1")	 {html_select3 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select3);}
		for (var i=0; i < data3.length; i++)
			html_select3 += '<option value="'+data3[i].IdEstructura.substr(0,7)+'">'+data3[i].IdEstructura.substr(0,7)+' | '+data3[i].Descripcion+'</option>';
			$('#select_2').html(html_select3);	
		});
		$('#select_3').html('<option value="">Elegir</option>');
		$('#select_4').html('<option value="">Elegir</option>');
		$('#IdShowPlazas').html('');
}

function OnSelectThree(){
		var getSelectThree= $('#select_2').val();	
		if(!getSelectThree){
			$('#select_3').html('<option value="">Select</option>');
			return;
		}
		$.get('../api/admin/plazas/'+getSelectThree,function(data4){
		var html_select4="";
		//if(data4.length==1)	 {html_select4 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select4);}
		for (var i=0; i < data4.length; i++)
			html_select4 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
			$('#select_3').html(html_select4);	
		});
		$('#select_4').html('<option value="">Elegir</option>');
		$('#IdShowPlazas').html('');
}

function OnSelectFour(){
		var getSelectThree= $('#select_3').val();	
		if(!getSelectThree){
			$('#select_4').html('<option value="">Select</option>');
			return;
		}
		$.get('../api/admin/plazas/'+getSelectThree,function(data4){
		var html_select5="";
		//if(data4.length==1)	 {html_select4 += '<option value="">Elegir</option>'; $('#select_nivel-4').html(html_select4);}
		for (var i=0; i < data4.length; i++)
			html_select5 += '<option value="'+data4[i].IdEstructura+'">'+data4[i].IdEstructura+' | '+data4[i].Descripcion+'</option>';
			$('#select_4').html(html_select5);	
		});
}

/*
function GetIdSelectTwo(){
	var getSelectId= $('#select_2').val();
	ShowPlaza(getSelectId);
}
*/
function GetIdSelectThree(){
	var getSelectId= $('#select_3').val();
	ShowPlaza(getSelectId);
}

function GetIdSelectFour(){
	var getSelectId= $('#select_4').val();
	ShowPlaza(getSelectId);
}

function ShowPlaza(id){		
	var getF=getFecha();
	var flat="";
	flat = $('#checkText').val();
	$('.loading').show();
	$.get('../api/admin/plazas/list/'+id+flat,function(datap){
		var tableHtml='';
       	var j=0;  

       	      	
			for (var i=0; i < datap.length; i++){ j++;	
				//if(datap[i].IdPersona==""){
					tableHtml += '<tr><td>'+j+'</td>'+					
					'<td>'+datap[i].organo+'</td>'+
					'<td>'+datap[i].dep+' | '+datap[i].centro+' | '+datap[i].ofi+'</td>'+
					'<td>'+datap[i].descripcion+'</td>'+
					'<td>'+datap[i].NroPlaza+'</td>'+
					'<td>'+datap[i].dni+'</td>'+
					'<td>'+datap[i].ApellidoPat+' '+datap[i].ApellidoMat+' '+datap[i].Nombres+'</td>'+
					'<td>'+datap[i].condicion+'</td>'+
					'<td>'+datap[i].fi+'</td>'+
					'<td>'+datap[i].cargo+'</td>'+
					'<td>'+datap[i].IdNivel+'</td>'+
					'<td>'+datap[i].Estado+'</td>'+
					'</tr>';
				/*}
				else{
					tableHtml += '<tr><td>'+j+'</td> <td>'+datap[i].descripcion+'</td> <td>'+datap[i].NroPlaza+'</td><td>'+datap[i].IdNivel+'</td><td>'+datap[i].cargo+'</td><td>'+datap[i].ApellidoPat+' '+datap[i].ApellidoMat+' '+datap[i].Nombres+' </td><td>'+datap[i].Estado+'</td></tr>';
				}*/
				$('#IdShowPlazas').html(tableHtml);	
			}
			 $('.loading').hide();
		});						
}


$('#regimenId').change(function() {
    if(this.checked) {
        $('#checkText').val('C')
        
    }else{
    	 $('#checkText').val('')
    }
});


function getFecha(){

var date = new Date();


var month = new Array();
month[0] = "01";
month[1] = "02";
month[2] = "03";
month[3] = "04";
month[4] = "05";
month[5] = "06";
month[6] = "07";
month[7] = "08";
month[8] = "09";
month[9] = "10";
month[10] = "11";
month[11] = "12";


var dia = date.getDate();
var mes = month[date.getMonth()];
var yyy = date.getFullYear();
var getfFormat = 'AL '+dia + '/' + mes + '/ ' + yyy;

return getfFormat;
}