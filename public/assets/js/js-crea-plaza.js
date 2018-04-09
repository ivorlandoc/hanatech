$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

  


function GetSelEstructura(id) {   
    var formData = new FormData($("form[name='frmgetEstru']")[0]);
     if(id=="2") {       
        formData.append('id',$('#select_nivel1').val());
      }else if(id=="3"){
        formData.append('id',$('#select_nivel2').val());
     }else if(id=="4"){
        formData.append('id',$('#select_nivel3').val());
     }else if(id=="5"){
        formData.append('id',$('#select_nivel4').val());
     }else {
       formData.append('id',$('#select_nivel5').val());
     }

    $('.loading').show();
    $.ajax({  
            type: "post",
            headers: {'X-CSRF-TOKEN':$('#token').val()},
            url:  $('#frmgetEstru').attr('action'),
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        success: function (data) { 
                if(id=="2") {       
                   getSelect2(data);       
                 }else if(id=="3"){
                  getSelect3(data);
                 }else if(id=="4"){
                 getSelect4(data);
                 }else if(id=="5"){
                 getSelect5(data);
                 }else if(id=="6"){
                 getAllRowsEstru(data);
                 }
           $('.loading').hide(); 
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function getSelect2(data) { 
    var html_select2="";  
      $.each(data, function( key, value ) {      
       html_select2 += '<option value="'+value.IdEstructura+'">'+value.IdEstructura+' | '+value.Descripcion+'</option>';
      $('#select_nivel2').html(html_select2); 
           
      });   
}
function getSelect3(data) { 
    var html_select3="";  
      $.each(data, function( key, value ) {      
       html_select3 += '<option value="'+value.IdEstructura+'">'+value.IdEstructura+' | '+value.Descripcion+'</option>';
      $('#select_nivel3').html(html_select3); 
           
      });   
}

function getSelect4(data) { 
    var html_select4="";  
      $.each(data, function( key, value ) {      
       html_select4 += '<option value="'+value.IdEstructura+'">'+value.IdEstructura+' | '+value.Descripcion+'</option>';
      $('#select_nivel4').html(html_select4); 
           
      });   
}

function getSelect5(data) { 
    var html_select5="";  
      $.each(data, function( key, value ) {      
       html_select5 += '<option value="'+value.IdEstructura+'">'+value.IdEstructura+' | '+value.Descripcion+'</option>';
      $('#select_nivel5').html(html_select5); 
           
      });   
}
function getAllRowsEstru(data) { 
    var xy=0;
    var tableHtml="";  
    if(data.length!=0){  
     $.each(data, function( key, value ) {      
      xy++;      
      tableHtml += '<tr><td>'+xy+'</td>'+ 
                   '<td><a href="#" onclick=putEstructuraJs("'+value.IdEstructura+'")>'+value.IdEstructura+'</a></td>'+
                   '<td><input type="hidden" value="'+value.Descripcion+'" id="'+value.IdEstructura+'">'+value.Descripcion+'</td>'+
                   '</tr>';
        $('#IdShow4toNivelPlazas').html(tableHtml);            
      }); 
       }else{      
   if( xy==0) $("#IdShow4toNivelPlazas").html('<div class="alert alert-danger" role="alert"></span> No existe registros</div>').fadeIn().delay(4000).fadeOut('slow');
  }
   
}

function putEstructuraJs(id){
  $('#IdEstructura').val(id+" | "+$('#'+id).val()); 
  //console.log($('#select_nivel2 option:selected').html());
  $('#idcentro').html("<b>"+$('#select_nivel2 option:selected').html()+"</b>"); 
  $('#idsubcentro').html("<b>"+$('#select_nivel3 option:selected').html()+"</b>"); 
  $('#iddepen').html("<b>"+$('#select_nivel4 option:selected').html()+"</b>"); 
  $('#idoficina').html("<b>"+$('#select_nivel5 option:selected').html()+"</b>"); 
  $('#idservicio').html("<b>"+id+" | "+$('#'+id).val()+"</b>"); 
  $('#txthidenEstru').val(id);
/*======================================*/
  $('#CierrameModal').click()
}


function SaveContador(){    
   var formData = new FormData($("form[name='frmcreaplz']")[0]);  
      $('.loading').show();
      var estr=$('#txthidenEstru').val();
    if(estr.trim()==""){
      $('#IdMensajeAlert').html('<div class="alert alert-danger" role="alert"></span>Complete los registros en blanco</div>').fadeIn().delay(4000).fadeOut('slow');
    }else{
                $.ajax({  
                        type: "post",
                        headers: {'X-CSRF-TOKEN':$('#token').val()},
                        url:  $('#frmcreaplz').attr('action'),
                        dataType: 'json',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                    success: function (data) {                                      
                        if(data===true) {               
                               $("#IdMensajeAlert").html('<div class="alert alert-success" role="alert">La Operación se realizó con éxito</div>').fadeIn().delay(4000).fadeOut('slow');                   
                               $("#frmcreaplz")[0].reset();
                           
                            } else {
                               $("#IdMensajeAlert").html('<div class="alert alert-danger" role="alert"></span> </strong>La Operación no se realizó</div>').fadeIn().delay(4000).fadeOut('slow');
                        }
                       $('.loading').hide();          
                    },
                    error: function (xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
        }
     //   return false;
}

function SetNroPlaza(){
  var sel ="";
  sel=$("#selereg").val();
  if(sel=="1") { 
    $("#getnroplazas727").html("PLAZA N°:  "+$('#selNivel').val()+ $('#regtxt728').val());
    $("#getnroplazas727").show();
    $("#getnroplazascas").hide();
  } else{
  $("#getnroplazascas").html("PLAZA N°:  "+$('#regtxtcas').val()+"9")
   $("#getnroplazas727").hide();
   $("#getnroplazascas").show();
  }

  
}