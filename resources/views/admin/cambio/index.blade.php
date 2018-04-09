@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Cambio de Denominación
@parent
@stop

{{-- page level styles --}}
@section('header_styles')



<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<!-- ================== css de datepiker======= -->
<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>

<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!--
<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
-->
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Cambio de Denominación</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Cambio de Denominación</a></li>
        <li class="active">Cambio</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Cambio de Denominación
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body"> 
                        <!-- ========== Cuerpo de Formulario ============================ -->
                    <div  id="IdFormbodyalta">
                         {{ Form::open(array( 'route' => ['get-datos-search'], 'method' => 'post', 'id' => 'frmserachChange','name' => 'frmserachChange'))}}                       
                             <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                                <!-- Datos Estáticos de cabecera-->                          
                                 <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                                <!-- ========== Load dependencia ============ -->
                                <div id="FormAltaPlaza">
                                  <div class="form-group">                               
                                     <div id="IdMensajeAlert"></div>
                                    <div class="input-group select2-bootstrap-append"> 
                                        <input type="text" class="form-control" id="txtSearchPlz" name="txtSearchPlz" maxlength="12" placeholder="#Plaza">
                                        <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" onclick="_getdatosplazaChang()" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                        </span>

                                    

                                    </div>

                                </div>
                        {{ Form::close()}} 
                            
                        {{ Form::open(array( 'route' => ['get-datos-saveChange','0'], 'method' => 'post', 'id' => 'frmsavechange','name' => 'frmsavechange'))}} 
                                <!-- ==========draw table========== -->
                                 <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                                  <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> 

                               
                                    <div class="form-group">
                                         <label for="formEmail"># PLAZA:</label>                                            
                                            <div class="input-group select2-bootstrap-append">                                           
                                                    <input type="text" class="form-control" id="nroplazaSearch" name="nroplazaSearch" readonly="">
                                                    <span class="input-group-btn">

                                                        <a data-href="#responsive-changeEs" href="#responsive-changeEs" data-toggle="modal" >
                                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                                    <span class="glyphicon glyphicon" id="idXargoSearch"></span>
                                                                </button>
                                                        </a>

                                                    </span>
                                              </div>

                                    </div>
                                <!--    <div class="form-group">                                   
                                        <select id="_idenivelChange" class="form-control select2" name="_idenivelChange">
                                            <option value="">Elegir el Nivel</option>
                                            @foreach($datan as $key) 
                                                <option value="{{ $key->IdNivel }}">{{ $key->IdNivel }} | {{ $key->Descripcion }}</option>
                                            @endforeach
                                        </select>  
                                    </div>
                                -->
                                    <div class="form-group">                                   
                                        <select id="_selectCargo" class="form-control select2" name="_selectCargo">
                                            <option value="">Elegir el Cargo</option>
                                            @foreach($data as $key) 
                                                <option value="{{ $key->IdCargo }}">{{ $key->IdCargo }} | {{ $key->Descripcion }}</option>
                                            @endforeach
                                        </select>  
                                    </div>

                                <div class="form-group">
                                    <!--<label for="formPassword">Documento de Referencia</label>-->
                                    <input type="text" class="form-control" name="docrefchange" id="docrefchange"  placeholder="Documento de Referencia">
                                </div>
                                 <div class="form-group">
                                        <label>Fecha de documento:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>
                                            <input type="text"  class="form-control" name="FechaDocChang" id="datetime1"/> 
                                        </div>
                                </div>
                                <div class="form-group">
                                    <label for="formPassword">Adjuntar Documento.</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Selecione Archivo</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                        <input type="file" name="FileAdjuntoChange" id="FileAdjuntoChange" readonly="" accept="*.pdf" ></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                </div>

                                <div class="form-group" id ="idbotones">
                                   <!-- <label for="formPassword">Observación</label>                          -->
                                    <textarea id="idObservacion" name="idObservacion" rows="3" class="form-control resize_vertical " placeholder="Observación"></textarea>                           
                                </div>

                                <div class="input-group select2-bootstrap-append"> 
                                    <div class="btn-group btn-group-lg">
                                        <button type="button" class="alert alert-success alert-dismissable margin5" id="saveintegrarplaza" onclick="SaveChangeDonominacion()">Guardar los Cambios</button>
                                        <a href="{{ URL::to('admin/cambio') }}" class="alert alert-info alert-dismissable margin5" id="SalirChange" >[Salir]</a>
                                    </div> 
                                </div>

                            </div> 
                         
                        {{ Form::close()}} 

                    </div>
                          
                <!--  ===================================================== -->
                </div>


            </div>
        </div>
      
    </div>
    <!-- row-->
</section>

@stop

{{-- page level scripts --}}

@section('footer_scripts')

<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
<!-- ========== datepiker ================= -->
<!-- begining of page level js -->
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/pages/datepicker.js') }}" type="text/javascript"></script>
<!-- end of page level js -->


<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/js-cambio-denomina.js') }}"> </script>



<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>


<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>
@stop