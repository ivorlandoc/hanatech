@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Suplencias
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
 <!-- ================ ´para select contry============= -->
 <link href="{{ asset('assets/vendors/select2/css/select2.min.css') }}" type="text/css" rel="stylesheet">
 <link href="{{ asset('assets/vendors/select2/css/select2-bootstrap.css') }}" rel="stylesheet">
<!-- ========================-->
<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Suplencias</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Suplencias</a></li>
        <li class="active">Alta de Suplencias </li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Agregando Nueva Suplencia
                </h4>
            </div>
            <br />
            <div class="panel-body">
            <!-- ========================== -->               
                <div class="col-lg-12 margin-tb">               
                    <div class="pull-right">
                        <a class="btn btn-info" href="{{ URL::to('admin/suplencias') }}"> Regresar</a>
                    
                    </div>
                </div>
               
            <!-- =====================================  -->
                <h3>Titular</h3>
                 <div id="IdMensajeAlert"></div>
                 {{ Form::open(array('route' => ['getdatheadTitular','0','1'], 'method' => 'post', 'id' => 'frmsearchSupHead','name' => 'frmsearchSupHead'))}}
                    <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                    <div class="form-group" style="margin-left: 20px"> 
                        <div class="input-group select2-bootstrap-append">  
                                {!! Form::text('searchpzSup',null, ['class'=>'form-control','placeholder'=>'#Plaza del Titular','type'=>'search','id'=>'searchpzSup']) !!}
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="getDatoheadTitular()"  id="headdatotitular">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>                                                                 
                            {!!Form::close()!!} 
                        </div>
                    </div>   
             {!!Form::close()!!} 
                    <!-- ========== Load dependencia ============ -->
                    <div id="msjerror" style="margin-left: 20px"></div>                     
                     <div class="form-group" style="margin-left: 20px" id="titularnom">   
                           <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div> 
                    </div>

                     <div class="form-group" style="margin-left:20px" id="titularcargo">   
                           <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div> 

                    </div>

                    <hr>
                    <h3>Suplente</h3> 
                     {{ Form::open(array('route' => ['getdatheadSuplen','0','1','0'], 'method' => 'post', 'id' => 'frmsearhSuplent','name' => 'frmsearhSuplent'))}}
                         <div class="form-group">                      
                                <div class="input-group select2-bootstrap-append" style="margin-left:20px">
                                    <input type="search" class="form-control" id="txtdnisup" name="txtdnisup" placeholder="#DNI" required="">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="idsearchgetsuplente" onclick="getDatoheadSuplente()">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>

                                    <span class="input-group-btn">
                                           <a data-href="#responsive" href="#responsive" data-toggle="modal">
                                                <button class="btn btn-default" type="button" >
                                                    <span class="glyphicon glyphicon-user"></span>
                                                </button>
                                            </a>
                                        </span>


                                </div>
                        </div>
                     {!!Form::close()!!} 

                    {{ Form::open(array('route' => ['savesuplencias','0','1','0','1'], 'method' => 'post', 'id' => 'frmsavesuplencia','name' => 'frmsavesuplencia'))}}
                      <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                    <div class="form-group" style="margin-left:20px" id="iddivsuplente">
                            <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div>
                    </div>
                    <input type="hidden" class="form-control" id="txtidpersona" name="txtidpersona">
                    <input type="hidden" class="form-control" id="txtidtitular" name="txtidtitular">
                    <input type="hidden" class="form-control" id="txtplaza" name="txtplaza">
                    <div id="msjerror2" style="margin-left: 20px"></div>
                     <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">Tipo de Suplencia</label>                                                  
                        <select id="tiposupl" class="form-control select2" name="tiposupl" required="">
                            <option value="">Elegir</option> 
                             @foreach($tiposuple as $key )  
                                    <option value="{{ $key->IdTipoSuplencia }}">{{ $key->IdTipoSuplencia }} | {{ $key->Descripcion }}</option>                                     
                              @endforeach                                      
                        </select>                        
                    </div>
                    <!--
                    <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">F.Inicio</label>                                                  
                         <input type="date" class="form-control" id="datetime1" name="datefinicio" required="">                        
                    </div>-->

                     <div class="input-group" style="margin-left:20px">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                   data-hc="#555555" data-loop="true"></i>
                            </div>
                            <input type="text"  class="form-control" name="datefinicio" id="datetime1" placeholder="Fecha de Inicio" required /> 

                    </div>
                    <!--
                    <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">F.Término</label>                                                  
                         <input type="date" class="form-control" id="datetime2" name="dateftermino" required="">                        
                    </div>-->
                    <br>
                     <div class="input-group" style="margin-left:20px">
                            <div class="input-group-addon">
                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                   data-hc="#555555" data-loop="true"></i>
                            </div>
                            <input type="text"  class="form-control" name="dateftermino" id="datetime3" placeholder="Fecha de Término" required /> 

                    </div>

                    <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">Proceso </label>                                                  
                         <input type="text" class="form-control" id="txtproceso" name="txtproceso" required="">                        
                    </div>

                    <div class="btn-group btn-group-lg" style="margin-left:20px">
                        <button type="button" class="alert alert-success alert-dismissable margin5" onclick="SaveSuplenciaFrm()">Guardar Cambios</button>
                   
                        <a href="{{ URL::to('admin/suplencias') }}" class="alert alert-info alert-dismissable margin5" >Retornar | Salir</a>
                    
                    </div>
            {!!Form::close()!!} 

         


          

             <!-- ========================== -->   
            </div>
        </div>
    </div>    <!-- row-->
</section>

<div class="modal fade expandOpen" id="responsive" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title">ALTA DE PERSONA</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                     <div id="idmsjealert"></div>
                                    <div class="table-responsive" >
                                         
                                             {{ Form::open(array('route' => ['processAltaSup','0','1','0','1','1','1'], 'method' => 'post', 'id' => 'frmprocessAltaSupl','name' => 'frmprocessAltaSupl'))}}
                                                <div class="col-md-12">
                                                    <!-- =====================  -->                                                        

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
                                                           <!-- <label for="formEmail">Tipo de Documento</label>--> 
                                                                <select id="IdTipoDocument" class="form-control select2 small" name="IdTipoDocument" >                                                                   
                                                                    @foreach ($tipodoc as $keyt) 
                                                                     <option value="{{ $keyt->IdTipoDocumento }}" > {{ $keyt->IdTipoDocumento }} | {{ $keyt->Descripcion }}</option>
                                                                    @endforeach 
                                                                </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <!--<label for="formPassword"># de Documento</label>-->                                  
                                                                <input type="text" class="form-control" id="nrodocumento" name="nrodocumento" required="" maxlength="8" placeholder="# de Documento[DNI]">
                                                        </div>

                                                        <div class="form-group">
                                                                <!--<label>Fecha de Nacimiento:</label>-->
                                                                
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                                           data-hc="#555555" data-loop="true"></i>
                                                                    </div>
                                                                    <input type="date"  class="form-control" name="idfechanac" id="datetime1" placeholder="Fecha de Nacimiento" required /> 

                                                                </div>                                                               
                                                        </div>

                                                         <div class="form-group">
                                                            <label>Género</label>                                                               
                                                                
                                                                    <label class="radio-inline" for="radios-0">
                                                                      <input name="radios" id="radio1" value="1" type="radio" onclick="checkGenero()">
                                                                      M
                                                                    </label> 
                                                                    <label class="radio-inline" for="radios-1" >
                                                                      <input name="radios" id="radio2" value="2" type="radio" onclick="checkGenero()">
                                                                      F
                                                                    </label>
                                                                     <input type="hidden"  class="form-control" name="idgenero" id="idgenero"/> 
                                                                
                                                                
                                                        </div>

                                                        <div class="form-group">                                                     
                                                             {!! Form::select('country', $countries, null,['style' => 'width:100%', 'id' => 'countries']) !!}
                                                             <span class="help-block">{{ $errors->first('country', ':message') }}</span>
                                                        </div>

                                                        <div class="form-group">                                   
                                                           <input type="text" class="form-control" id="txtdireccion" name="txtdireccion" required="" placeholder="Dirección">
                                                        </div>

                                                       
                                
                                                        <div class="form-group">
                                                            <!--<label for="formEmail">Carrera[Profesiones]</label>-->
                                                             <select id="idcarrera" class="form-control select2" name="idcarrera">
                                                                <option value="">Carrera Profesional</option>
                                                                @foreach ($profes as $keyp) 
                                                                    <option value="{{ $keyp->IdProfesion }}" > {{ $keyp->IdProfesion }} | {{ $keyp->Descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                
                                                        <div class="form-group">
                                                            <!--<label for="formPassword">Especialdiad</label>-->
                                                            <!--<input type="text" class="form-control" id="txtespecialidad" name="txtespecialidad" placeholder="Especialdiad">-->
                                                            <select id="txtespecialidad" class="form-control select2 small" name="txtespecialidad" style="height:33px"> 
                                                                     <option value="">Seleccione la Especialidad</option>                                                                                     
                                                                    @foreach ($dataEsp as $keys) 
                                                                     <option value="{{ $keys->IdEspecialidad }}" > {{ $keys->IdEspecialidad }} | {{ $keys->Descripcion }}</option>
                                                                    @endforeach 
                                                            </select>  

                                                        </div>                                    
                                
                                                        <div class="form-group">
                                                            <!--<label for="formEmail">Motivo de Alta</label>-->
                                                             <select id="IdRegimen" class="form-control select2" name="IdRegimen">
                                                                <option value="">Seleccione Régimen</option>
                                                                 @foreach ($regime as $keyR) 
                                                                    <option value="{{ $keyR->IdRegimen }}" > {{ $keyR->IdRegimen }} | {{ $keyR->Descripcion }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                         <div class="form-group">
                                                                <!--<label>Fecha [Ingreso]:</label>-->
                                                                
                                                                <div class="input-group">
                                                                    <div class="input-group-addon">
                                                                        <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                                           data-hc="#555555" data-loop="true"></i>
                                                                    </div>
                                                                    <input type="date"  class="form-control" name="idfechaingreso" id="datetime3" placeholder="Fecha de Ingreso" required /> 
                                                                </div>

                                                            <!--<div class="form-group">
                                                                <input type="date" id="datetime3" name="IdFechaalta" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" >
                                                            </div>-->
                                                        </div>
                            
                                                        <div class="modal-footer">
                                                            <a href="#" class="btn btn-success" onclick="SavealtaSuplente()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</a>                            
                                                            <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModal">Ciérrame!</button>
                                                        </div> 
                                                        

                                                    <!-- ================ -->                        
                                                </div>
                                             {!!Form::close()!!} 
                                    </div>
                                </div>
                            <!--<div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModal">Ciérrame!</button>
                           
                            </div>-->
                        </div>
                </div>
            </div>
        </div> 
@stop

{{-- page level scripts --}}
@section('footer_scripts')

<!-- ====country================= -->
<script src="{{ asset('assets/vendors/select2/js/select2.js') }}" type="text/javascript"></script>
<!-- ======================  -->
<script type="text/javascript" src="{{ asset('assets/js/js-suplencias-create.js') }}"></script>


<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>

<!-- ========== datepiker ================= -->
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/js/pages/datepicker.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>

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