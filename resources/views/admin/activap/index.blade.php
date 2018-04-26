@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Activación de Plazas
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

<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
<style type="text/css"> input {text-transform:uppercase;></style>
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Activación de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Activación de Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Activación de Plazas Sin Presupuesto
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body"> 
                        <!-- ========== Cuerpo de Formulario ============================ -->
                    <div  id="IdFormbodyalta">
                         {{ Form::open(array( 'route' => ['get-datos-activa'], 'method' => 'post', 'id' => 'frmactivap','name' => 'frmactivap'))}}                       
                             <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                                <!-- Datos Estáticos de cabecera-->                          
                                 <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                                <!-- ========== Load dependencia ============ -->
                                <div id="FormAltaPlaza">
                                  <div class="form-group">                               
                                     <div id="IdMensajeAlert"></div>

                                    <div class="input-group select2-bootstrap-append"> 
                                        <input type="text" class="form-control" id="txtplazaA" name="txtplazaA" maxlength="12" placeholder="#Plaza">
                                        <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" onclick="_getdatosplazaAct()" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                        </span>                                        
                                    

                                    </div>

                                </div>
                        {{ Form::close()}} 
                            
                        {{ Form::open(array( 'route' => ['save-datos-activa','0'], 'method' => 'post', 'id' => 'frmactivaplza','name' => 'frmactivaplza'))}} 
                                <!-- ==========draw table========== -->
                                 <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                                  <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> 
                                 
                                <!-- ================ --> 
                                 <div class="form-group">                                  
                                        <label for="formPassword">Datos de la Plza</label> 



                                         <div class="input-group select2-bootstrap-append">                                            
                                            <input type="text" id="datosPpto" name="datosPpto" class="form-control" readonly="">

                                            <span class="input-group-btn" id="getmsjeActiva">                                               
                                                    <button class="btn btn-success" type="button" data-select2-open="single-append-text"><span class="glyphicon glyphicon"></span></button>                                       
                                            </span>
                                        </div>



                                        <input type="hidden" id="nroplazaactivar" name="nroplazaactivar" class="form-control" >
                                       
                               
                                 <div class="form-group">                                  
                                        <label for="formPassword">Actualizar Fecha de Cese</label> 
                                        <input type="date" id="datetime1" name="fechaceseActivar" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                       
                                </div>

                                <div class="form-group">                                   
                                    <input type="text" class="form-control" id="docrefActivar" name="docrefActivar" maxlength="128" placeholder="Doc. de Referencia">
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
                                                        <input type="file" name="FileAdjuntoActivar" id="FileAdjuntoActivar" readonly="" accept="*.pdf"></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                </div>

                                 

                                <div class="form-group">                                

                                   <label for="formPassword">Observación</label>                          
                                    <textarea id="obserActivar" name="obserActivar" rows="3" class="form-control resize_vertical" required=""></textarea>
                                </div>

                               <div class="input-group select2-bootstrap-append"> 
                                    <div class="btn-group btn-group-lg">
                                        <button type="button" class="alert alert-success alert-dismissable margin5" id="saveintegrarplaza" onclick="saveActivaplaza()">Activar Plaza</button>
                                        <a href="{{ URL::to('admin/activap') }}" class="alert alert-info alert-dismissable margin5" id="SalirIntegra" >[Salir]</a>
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
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/js-activar-plaza.js') }}"> </script>



<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
<script src="{{ asset('assets/js/pages/tabs_accordions.js') }}" type="text/javascript"></script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>
@stop