$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

   
function ajaxloadrpte() {   
     var formData = new FormData($("form[name='frmaltabaja']")[0]);
      $('.loading').show();
      
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmaltabaja').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {           
           manageRows(data);       
           $('.loading').hide();
           //getPageData();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function manageRows(data) {   
    var xy=0;  
    var tableHtml="";   
    $.each(data, function( key, value ) {
     xy++;   
        tableHtml += '<tr>'+
         '<td>'+xy+'</td>'+                         
         '<td>'+value.organo+'</td>'+ 
         '<td>'+value.dni+'</td>'+                   
         '<td>'+value.apellidoPat+' '+value.ApellidoMat+' '+value.Nombres+' </td>'+                        
         '<td>'+value.NroPlaza+' </td> '+                          
         '<td>'+value.al+' </td> '+                 
         '<td>'+value.tipobaja+'</td> '+                             
         '<td>'+value.fechaMov+' </td> '+    
         '<td>'+value.DocRef+'</td> '+                        
         '<td>'+value.regimen+'</td>'+
         '</tr>';
    });   
    $('#IdShowRpteAltabajas').html(tableHtml);
   
}

function hideshow(){
 var tipo = $("#idbajaalta").val();
    if(tipo=="1") {       
        $("#getTipoalta").show();
        $("#getTipobaja").hide();       
    }else{        
        $("#getTipoalta").hide();
        $("#getTipobaja").show();

    }
}