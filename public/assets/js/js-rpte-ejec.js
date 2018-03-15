$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
   
function LoadNomejec() {   
     var formData = new FormData($("form[name='frmejec']")[0]);
      $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmejec').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {
            Rows(data);       
            $('.loading').hide();           
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function Rows(data) {
    var rows = '';
    var xy=0;
        $.each( data, function( key, value ) {
             xy++;   
            rows = rows + '<tr>';
            rows = rows + '<td>'+xy+'</td>';
            rows = rows + '<td>'+value.organo+'</td>';
            rows = rows + '<td>'+value.dep+'</td>';
            rows = rows + '<td>'+value.descripcion+'</td>';
            rows = rows + '<td>'+value.NroPlaza+'</td>';
            rows = rows + '<td>'+value.dni+'</td>';
            rows = rows + '<td>'+value.ApellidoPat+' '+value.ApellidoMat+' '+value.Nombres+'</td>';
            rows = rows + '<td>'+value.condicion+'</td>';
            rows = rows + '<td>'+value.fi+'</td>';
            rows = rows + '<td>'+value.cargo+'</td>';
            rows = rows + '<td>'+value.IdNivel+'</td>';           
            rows = rows + '<td><a href="../uploads/files/'+value.FileAdjunto+'.pdf" target="_blank" class="btn btn-info btn-sm btn-responsive" role="button"><span class="livicon" data-name="notebook" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>'+value.Estado+'</a></td>';                     
            rows = rows + '</tr>';   
             });
         
        $('#showplazaejec').html(rows);            
        
}