//$( document ).ready(function() {
var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;

manageData();

/* manage data list */
function manageData() {
    $.ajax({
        dataType: 'json',
        url: url,
        data: {page:page}
    }).done(function(data){

       total_page = Math.ceil(data.total/10);
        current_page = page;

        $('#pagination').twbsPagination({
            totalPages: total_page,
            visiblePages: current_page,
            onPageClick: function (event, pageL) {
                page = pageL;
                if(is_ajax_fire != 0){
                  getPageData();
                }
            }
        });

        manageRow(data.data);
        is_ajax_fire = 1;
    });
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

   
function ajaxloadplazas() {   
     var formData = new FormData($("form[name='formplazacar']")[0]);
      $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#formplazacar').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {           
           manageRows(data);       
           $('.loading').hide();
           getPageData();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function manageRows(data) {   
    var xy=0;  
    var tableHtml="";
    /*
       for (var i=0; i < data.length; i++)     {            
                xy++;   
                tableHtml = tableHtml + '<tr>';
                tableHtml = tableHtml + '<td>'+xy+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].codestru+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].Descripcion+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].NroPlaza+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].dni+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].nombres+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].EstadoPlaza+'</td>';
                tableHtml = tableHtml + '<td>'+data[i].Regimen+'</td>';
                tableHtml = tableHtml + '</tr>';   
                                           
        }
        $('#IdShowRptePlazas').html(tableHtml);   
    */    
    $.each(data, function( key, value ) {
     xy++;   
      //console.log(key + ':' + value.Descripcion);
   
                tableHtml += '<tr>'+
                 '<td>'+xy+'</td>'+                         
                 '<td>'+value.codestru+'</td>'+                    
                 '<td>'+value.Descripcion+' </td>'+                        
                 '<td>'+value.NroPlaza+' </td> '+                          
                 '<td>'+value.Cargo+' </td> '+                 
                 '<td>'+value.dni+'</td> '+                             
                 '<td>'+value.ApellidoPat+' '+value.ApellidoMat+' '+value.Nombres+'</td> '+    
                 '<td>'+value.EstadoPlaza+'</td> '+                        
                 '<td>'+value.Regimen+'</td>'+
                 '</tr>';
    });   
    $('#IdShowRptePlazas').html(tableHtml);
   
}


    function getPageData() {
        $.ajax({
            dataType: 'json',
            url: url,
            data: {page:page}
        }).done(function(data){
            manageRow(data.data);
        });
    }
//});

/*=====================================*/