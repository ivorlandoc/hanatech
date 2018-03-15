$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
/*$(document).on('click', 'a.page-link', function (event) {
    event.preventDefault();
    ajaxLoad($(this).attr('href'));
});

$(document).on('submit', 'form#frm', function (event) {
    event.preventDefault();
    var form = $(this);
    var data = new FormData($(this)[0]);
    var url = form.attr("action");
    $.ajax({
        type: form.attr('method'),
        url: url,
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            $('.is-invalid').removeClass('is-invalid');
            if (data.fail) {
                for (control in data.errors) {
                    $('#' + control).addClass('is-invalid');
                    $('#error-' + control).html(data.errors[control]);
                }
            } else {
                ajaxLoad(data.redirect_url);
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            alert("Error: " + errorThrown);
        }
    });
    return false;
});
*/
/*
var page = 1;
var current_page = 1;
var total_page = 0;
var is_ajax_fire = 0;

manageData();

function manageData() {
    $.ajax({
        dataType: 'json',
        url: url,
        data: {page:page}
    }).done(function(data) {
        total_page = data.last_page;
        current_page = data.current_page;
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
*/

   
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
    /*if(data.length!=0){         
        for (var i=0; i < data.length; i++)     {
                xy++;   
                rows = rows + '<tr>';
                rows = rows + '<td>'+xy+'</td>';
                rows = rows + '<td>'+data[i].IdNivel+'</td>';
                rows = rows + '<td>'+data[i].Descripcion+'</td>';
                rows = rows + '<td>'+data[i].act+'</td>';
                rows = rows + '<td>'+data[i].vac+'</td>';
                rows = rows + '<td>'+data[i].total+'</td>';
                rows = rows + '</tr>';                                 
        }
        $('#allplazasCargo').html(rows);
    }else{
        $('#IdTipoMovimiento').html("No existe registros");
    }
*/
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


/*
function getPageData() {
    $.ajax({
        dataType: 'json',
        url: url,
        data: {page:page}
    }).done(function(data) {
        manageRow(data.data);
    });
}
*/
/* Add new Post table row */


/*
function ajaxDelete(filename, token, content) {
    content = typeof content !== 'undefined' ? content : 'content';
    $('.loading').show();
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $("#" + content).html(data);
            $('.loading').hide();
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
*/