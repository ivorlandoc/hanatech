@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Alta de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>*/
<!-- =============== -->

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<!-- ================== css de datepiker======= -->
   <link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!-- =================================================== -->
 <link rel="stylesheet" href="{{ asset('assets/css/pages/buttons.css') }}" />
 <!-- ================ ´para select contry============= -->
 <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
 <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
<!-- ========================-->
 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/awesomeBootstrapCheckbox/awesome-bootstrap-checkbox.css') }}"/>
<style type="text/css"> input {text-transform:uppercase;></style>
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Alta de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Altas de Plazas</a></li>
        <li class="active">Plazas</li>
    </ol>
   
</section>

<!-- Main content -->
<section class="content paddingleft_right15">                  
    <div class="row">
        <div class="panel panel-primary "> 
            <!--=================-->             
           <div class="panel panel-info" id="idheadinformcion">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Alta de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
   


                <div class="panel-body">
                        <div class="form-group">                            
                            <div class="input-group select2-bootstrap-append">                                      
                                    <span class="input-group-btn"> 
                                         <button class="btn btn-default" type="button" data-select2-open="single-append-text" >
                                            <input type="checkbox"  id="checkboxalta" onclick="CheckboxAltaSup()" />Suplencia <!-- class="flat-red"-->
                                        </button>                                      
                                    </span>

                                 {!! Form::text('search_plaza',null, ['class'=>'form-control','placeholder'=>'# de Plaza','type'=>'search','id'=>'search_plaza','style'=>'height:36px']) !!}  
                                        <input type="hidden" name="token" value="{{ csrf_token()}}">   

                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="loaddatosform()"  id="idsearchaltaform" style="height:36px">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>

                                        <span class="input-group-btn">
                                           <a data-href="#responsive" href="#responsive" data-toggle="modal" onclick="getEstructuraAll('1');getflat('0')">
                                                <button class="btn btn-default" type="button" style="height:36px">
                                                    <span class="glyphicon glyphicon-book"></span>
                                                </button>
                                            </a>
                                        </span>
                                         
                                    {!!Form::close()!!} 
                            </div>
                            
                        </div>                           
                        

                        <!-- ========== Cuerpo de Formulario ============================ -->
                    <div  id="IdFormbodyalta">
                        <form method="POST" action="/gpessalud/public/api/admin/altaplaza/insert" name="frmSaveAlta" id="frmSaveAlta" enctype="multipart/form-data">
                             <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
                                <!-- Datos Estáticos de cabecera-->                          
                              <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                              <input type="hidden" class="form-control" id="IdPlazaA"     name="IdPlazaA"  value="">
                              <input type="hidden" class="form-control"  id="IdPersonaA"   name="IdPersonaA"    value="">
                              <input type="hidden" class="form-control"  id="IdEstructuraA" name="IdEstructuraA" value="">
                              <input type="hidden" class="form-control"  id="IdCargoA"    name="IdCargoA"      value="">
                              <input type="hidden" class="form-control" id="NroPlazaA" name="NroPlazaA" value=""> 
                              <input type="hidden" class="form-control" id="idflat" name="idflat" value="">   
                              <input type="hidden" name="flatcheckbox" id='flatcheckbox' value="0">                                   
                           <!-- <div id ="IdshowExample"> Aqui mostra el return</div>-->
                              <div id="IdMsjeErrorAltaPlaza"></div>
                        <!-- ========== Load dependencia ============ -->
                            <div id="ShowDataHead" style="display:none">                                   
                                    <div class="form-group">
                                            <input type="text" class="form-control" id="NroPlazaDescripcion" name="NroPlazaDescripcion" value="" disabled="">
                                            <input type="text" class="form-control" id="IdNivelNroPlaza" name="IdNivelNroPlaza" value="" readonly="">
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group select2-bootstrap-append"> 
                                                <input type="text" class="form-control" id="IdDepenorgano" name="IdDepenorgano" value="" readonly="">
                                                <!--<input type="text" class="form-control" id="IdDependenciaDes" name="IdDependenciaDes" value="" readonly="">-->
                                             <span class="input-group-btn">
                                                   <a data-href="#responsive" href="#responsive" data-toggle="modal" onclick="getEstructuraAll('1');getflat('1')">
                                                    <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                        <span class="glyphicon glyphicon-th-list"></span>
                                                    </button>
                                                    </a>
                                            </span>

                                    </div>
                                </div>

                            </div>
                            <div class="form-group" id="IdSpaceHead"></div>
                            <div id="FormAltaPlaza">

                                <div class="form-group">
                                   <!-- <label for="formEmail">Tipo de Documento</label>-->                                     
                                    <div class="input-group select2-bootstrap-append"> 
                                        <select id="IdTipoDocument" class="form-control select2" name="IdTipoDocument" >
                                            <option value="">Tipo de Documento</option>
                                        </select>
                                        <span class="input-group-btn">
                                               <a data-href="#responsive-search" href="#responsive-search" data-toggle="modal" >
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-user"></span>
                                                </button>
                                            </a>
                                        </span>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <!--<label for="formPassword"># de Documento</label>-->
                                  
                                        <input type="text" class="form-control" id="nrodocumento" name="nrodocumento" required="" maxlength="12" placeholder="# de Documento[DNI]">
                                </div>
                                <div class="form-group">
                                   <!-- <label for="formPassword">Apellido Paterno</label>-->
                                    <input type="text" class="form-control" id="ape_pat" name="ape_pat" required="" maxlength="40" placeholder="Apellido Paterno">
                                </div>
                                <div class="form-group">
                                    <!--<label for="formPassword">Apellido Materno</label>-->
                                    <input type="text" class="form-control" id="ape_mat" name="ape_mat" required="" maxlength="40" placeholder="Apellido Materno">
                                </div>
                                <div class="form-group">
                                   <!-- <label for="formPassword">Nombres</label> -->
                                    <input type="text" class="form-control" id="txtnombre" name="txtnombre" required="" maxlength="60" placeholder="Nombres">
                                </div>

                                <div class="form-group">
                                        <label>Fecha de Nacimiento:</label>
                                        <!--
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>
                                            <input type="text"  class="form-control" name="Fechanac" id="datetime1" required="" placeholder="Fecha de Nacimiento"> 
                                        </div>-->
                                        <div class="form-group">
                                            <input type="date" id="datetime1" name="Fechanac" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                        </div>
                                </div>

                                <div class="form-group">
                                    <!--<label for="formEmail">País</label>-->
                                     {!! Form::select('country', $countries, null,['class' => 'form-control select2', 'id' => 'countries']) !!}

                                     <span class="help-block">{{ $errors->first('country', ':message') }}</span>
                                </div>

                                <div class="form-group">                                   
                                   <input type="text" class="form-control" id="txtdireccion" name="txtdireccion" required="" placeholder="Dirección">
                                </div>
                                <div class="form-group">
                                    <!--<label for="formEmail">Género</label>-->
                                     <select id="idgenero" class="form-control select2" name="idgenero">
                                        <option value="">Seleccione Género</option>
                                        <option value="1">Hombre</option>
                                        <option value="2">Mujer</option>
                                    </select>
                                </div>

                                
                                <div class="form-group">
                                    <!--<label for="formEmail">Carrera[Profesiones]</label>-->
                                     <select id="idcarrera" class="form-control select2" name="idcarrera">
                                        <option value="">Carrera[Profesiones]</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <!--<label for="formPassword">Especialdiad</label>-->
                                    <input type="text" class="form-control" id="txtespecialidad" name="txtespecialidad" placeholder="Especialdiad">
                                </div>
                                    
                                <div class="form-group">
                                    <!--<label for="formEmail">Motivo de Alta</label>-->
                                     <select id="selectIdalta" class="form-control select2" name="selectIdalta">
                                        <option value="">Motivo de Alta</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <!--<label for="formEmail">Motivo de Alta</label>-->
                                     <select id="IdRegimen" class="form-control select2" name="IdRegimen">
                                        <option value="">Seleccione Régimen</option>
                                    </select>
                                </div>
                                 <div class="form-group">
                                        <label>Fecha de alta[Ingreso]:</label>
                                        <!--<div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>
                                            <input type="text"  class="form-control" name="IdFechaalta" id="datetime3" required="" placeholder="Fecha Inicio[Mov]"> 
                                        </div>-->

                                    <div class="form-group">
                                        <input type="date" id="datetime3" name="IdFechaalta" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="formPassword" id="idlabeladjunto">Adjuntar Documento.</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Selecione Archivo</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                        <input type="file" name="FileAdjuntoAlta" id="FileAdjuntoAlta" accept="*.pdf"></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                </div>

                                 <div class="form-group">
                                    <!--<label for="formPassword">Documento de Referencia</label>-->                                        
                                        <input type="text" class="form-control" id="ObserAlta" name="ObserAlta" value="--" required="" placeholder="Documento de Referencia">
                                </div>
                                <div class="form-group">
                                            
                                            <label>
                                                <input type="checkbox" class="minimal-blue" name="idResidentado" id="idResidentado" value="0" onclick="checkboxS()">
                                                <input type="hidden" class="form-control" id="idresid" name="idresid" value="0">
                                            </label>
                                         
                                        <label>Residentado Médico</label>
                                </div>
                                <div class="btn-group btn-group-lg">
                                    <button type="submit" class="alert alert-success alert-dismissable margin5" id="IdSaveAltaDePlazas">Guardar Alta</button>
                               
                                    <a href="{{ URL::to('admin/altaplaza') }}" class="alert alert-info alert-dismissable margin5" id="SalirAlta" >Nuevo [Salir]</a>
                                
                                </div> 
                                 <div id="IdMensajeAlert"></div>

                            </div>                    
                        </form>                
                    </div>
                <!--  ===================================================== -->
                </div>


            </div>
        </div>
      
    </div>
    <!-- row-->
</section>
    <div class="modal fade expandOpen" id="responsive" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title">CONSULTA DE PLAZAS</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                     <div id="msjcount"></div>
                                    <div class="table-responsive" >
                                           <form method="get" name="frmResult" id='form_validation' enctype="multipart/form-data" action="#">   
                                                <div class="col-md-12">

                                                    <div class="form-group">                          
                                                        <select id="select_nivel-0" class="form-control select2" name="select_nivel-0">
                                                            <option value="">Elegir</option>                                        
                                                           
                                                        </select>
                                                    </div>

                                                     <div class="form-group">                          
                                                        <select id="select_nivel-1" class="form-control select2" name="select_nivel-1" >
                                                            <option value="%">Todos</option>                                        
                                                           
                                                        </select>
                                                    </div>

                                                     <div class="form-group">                      
                                                            <select id="select_nivel-2" class="form-control select2" name="select_4dig" onchange="onChangeAll_2()" >
                                                                <option value="%">Todos</option>        
                                                                
                                                            </select>
                                                            
                                                        </div>

                                                        <div class="form-group">
                                                            <select id="select_nivel-3" class="form-control select2" name="select_7dig" onclick="onChangeAll_3()">
                                                                <option value="%">Todos</option>                                
                                                            </select>                            
                                                        </div>
                                                    
                                                        <div class="form-group">
                                                            <!--<label for="e1" class="control-label">Todos</label>-->
                                                            <select id="select_nivel-4" class="form-control select2" name="select_10dig" onchange="onChangeAll_4()" >
                                                                <option value="%">Todos</option>                                
                                                            </select>                            
                                                        </div>

                                                      


                                                    <!-- ==========draw table========== -->
                                                    <div class="panel-body">
                                                        <div class="table-responsive" >
                                                            <table  class="table dataTable no-footer dtr-inline">
                                                                <thead>
                                                                    <tr class="filters">
                                                                        <th>#</th><th>DEPENDENCIA</th><th>PLAZA</th> <th>NIVEL</th>  <th>CARGO</th>  <th>NOMBRES</th>                       
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="IdShowPlazasAlta">
                                                                

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                       
                                                    </div>                        
                                                    <!-- ================ -->                        
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModal">Ciérrame!</button>
                           
                            </div>
                        </div>
                </div>
            </div>
        </div> 
        <!--=====Para search persona -->
        <div class="modal fade expandOpen" id="responsive-search" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title">CONSULTA</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive" >
                                        <!-- ================= inicio search ===================-->
                                        <div class="input-group select2-bootstrap-append">                          
                                             {!! Form::text('search_persona',null, ['class'=>'form-control','placeholder'=>'Apellidos y Nombres | Dni Plaza','type'=>'search','id'=>'search_persona']) !!}  
                                                    <input type="hidden" name="token" value="{{ csrf_token()}}">                   
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                    </span>
                                        </div>
                                        <!-- ================= fin ===================-->

                                           <form method="get" name="frmResultSear" id='frmResultSear' enctype="multipart/form-data" action="#">   
                                                <div class="col-md-12">

                                                    <!-- ==========draw table========== -->
                                                    <div class="panel-body">
                                                        <div class="table-responsive" >
                                                            <table  class="table dataTable no-footer dtr-inline">
                                                                <thead>
                                                                    <tr class="filters">
                                                                        <th>#</th><th>DNI</th><th>APELLIDOS Y NOMBRES</th>                       
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="IdShowResultSearchP">
                                                                

                                                                </tbody>
                                                                <div id="IdMsjeErrorResultSearchp"></div>
                                                            </table>
                                                        </div>
                                                    </div>                        
                                                    <!-- ================ -->                        
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModalResult">Ciérrame!</button>
                           
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- =======================================  -->

@stop

{{-- page level scripts --}}

@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
<!-- ========== datepiker ================= -->
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>

<!--<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>-->

<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/datepicker.js') }}" type="text/javascript"></script>

<!-- ====contry================= -->
<script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<!-- ======================  -->

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
<script src="{{ asset('assets/js/pages/tabs_accordions.js') }}" type="text/javascript"></script>

<script type="text/javascript" src="{{ asset('assets/js/api-estructura.js') }}"> </script>
<script type="text/javascript" src="{{ asset('assets/js/api-altaplaza.js') }}"> </script>
  <script language="javascript" type="text/javascript" src="{{ asset('assets/js/pages/radio_checkbox.js') }}"></script>

  <script>
   function formatState (state) {
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="{{ asset('assets/img/countries_flags') }}/'+ state.element.value.toLowerCase() + '.png" class="img-flag" width="20px" height="20px" /> ' + state.text + '</span>'
            );
            return $state;

        }
        $("#countries").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "Selecione el País",
            theme:"bootstrap"
        });


$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>
@stop