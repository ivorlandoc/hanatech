$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

   
function ajaxLoad() {   
     var formData = new FormData($("form[name='form-plzcar']")[0]);
      $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#form-plzcar').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) {
            manageRow(data);       
            $('.loading').hide();
            //getPageData();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function manageRow(data) {
    var rows = '';
    var xy=0;
    var total=0;
    var act=0;
    var vacant=0;
    var inac=0;
    var judicial=0;
    var otros=0;
    var headHtml="";
        if($("#idregimen").val()=="9") { headHtml='<h4>RÉGIMEN CAS D.L.1057</h4>';} 
        else if($("#idregimen").val()=="4") { headHtml="<h4>RÉGIMEN D. L. 728</h4>";} else {headHtml="";}

    $("#headmsje-PlazaCargo").html(headHtml);
   
$.each( data, function( key, value ) {
     xy++;   
    rows = rows + '<tr>';
    rows = rows + '<td>'+xy+'</td>';
    rows = rows + '<td>'+value.IdNivel+'</td>';
    rows = rows + '<td>'+value.Descripcion+'</td>';
    rows = rows + '<td>'+value.act+'</td>';
    rows = rows + '<td>'+Number(value.vac)+'</td>';
    rows = rows + '<td>'+Number(value.inac)+'</td>';
    rows = rows + '<td>'+Number(value.jud)+'</td>';
    rows = rows + '<td>'+Number(value.otros)+'</td>';
    rows = rows + '<td>'+value.total+'</td>';
    rows = rows + '</tr>';   

    act             =act    + Number(value.act);
    vacant          =vacant + Number(value.vac);
    inac            =inac   + Number(value.inac);
    judicial        =judicial + Number(value.jud);
    otros           =otros  + Number(value.otros);
    total           =total  + Number(value.total);
    });
    rows = rows + '<tr><th colspan="3" style="text-align=right">TOTAL</th><th>'+act+'</th><th>'+vacant+'</th> <th>'+inac+'</th> <th>'+judicial+'</th> <th>'+otros+'</th> <th>'+total+'</th></tr>'; 
$('#allplazasCargo').html(rows);
    
}

