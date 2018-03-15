function GetDataTempo(xplaza){
	console.log("-->"+xplaza);
	$.get('../api/admin/rptetempo/list/'+xplaza,function(dataSearch){			
		console.log("=2==>"+dataSearch);		
       	var ErrorHtml='<div class="alert alert-danger alert-dismissable margin5"><strong>Ups</strong> no existe registros!</div>';  
       	var html_G="";
       	var resi="";
       	if(dataSearch.length!=0){       		
			for (var i=0; i < dataSearch.length; i++) 	{	
			console.log(dataSearch[i].nro_plaza);						
				/*$('#dniApe').html(dataSearch[i].lib_elect1 +" | "+dataSearch[i].nombres);	

				$('#htmlorgano').html(dataSearch[i].organo +"  |  "+dataSearch[i].centro);	
				//$('#htmlcentro').html(dataSearch[i].centro );	
				$('#htmldependencia').html(dataSearch[i].denominaci );

				$('#htmlnivel').html(dataSearch[i].nivel +"  |  "+dataSearch[i].descri_car);
				//$('#htmlcargo').html(dataSearch[i].descri_car );
				$('#htmlregimen').html(dataSearch[i].regimen);		
				$('#htmlplaza').html(dataSearch[i].nro_plaza);

				$('#htmlresu').html(dataSearch[i].resolucion);
				$('#htmlobs').html(dataSearch[i].observacion);
				$('#htmldetalle').html(dataSearch[i].detalle);*/


				$('#txtdni').val(dataSearch[i].lib_elect1);
				$('#txtape').val(dataSearch[i].nombres);
				$('#txtorg').val(dataSearch[i].organo);
				$('#txtcentro').val(dataSearch[i].centro);	
				$('#txtdep').val(dataSearch[i].denominaci);
				$('#txtnivel').val(dataSearch[i].nivel +"  |  "+dataSearch[i].descri_car);	
				$('#txtplaza').val(dataSearch[i].nro_plaza);
				$('#txtreg').val(dataSearch[i].regimen);
				$('#txtreso').val(dataSearch[i].resolucion);
				$('#txtobs').val(dataSearch[i].observacion);
				$('#txtotros').val(dataSearch[i].detalle);
				
				

			}
		}else{
			$('#IdMsjeErrorResultSearchp').html(ErrorHtml);
		}	
	});	

}