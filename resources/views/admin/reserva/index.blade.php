@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Reserva de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<!-- =================================================== -->
 <link rel="stylesheet" href="{{ asset('assets/css/pages/buttons.css') }}" />
     <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/css/pages/timeline.css') }}" rel="stylesheet" />

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
        <li><a href="#"> Reserva de Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Reserva de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body"> 
                         <div class="form-group">
                            {{ Form::open(array('route' => 'get-datos-parareserva', 'method' => 'post', 'id' => 'formreserva','name' => 'formreserva'))}}
                                <input type="hidden" name="token" value="{{ csrf_token()}}">
                                  <div class="input-group select2-bootstrap-append">                                   
                                        {!! Form::text('reserva_plaza',null, ['class'=>'form-control','placeholder'=>'# de Plaza','type'=>'search','id'=>'reserva_plaza']) !!}  
                                                        
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="ajaxloadsearch()" data-select2-open="single-append-text">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>                                        
                                    {!!Form::close()!!}
                                  </div>
                                    
                           {{ Form::close()}}
                        </div>

                    <div  id="IdFormbodyalta">
                        {{ Form::open(array('route' => ['get-datos-procesareserva','1'], 'method' => 'post', 'id' => 'formreservaPro','name' => 'formreservaPro'))}}
                       
                            <input type="hidden" name="idUserSession" value="{{ $idUserSession }}">                        
                            <div id="ShowDataHead" style="display:none;"> 

                                <div class="form-group" id="IdSpaceHead">                                
                                    <div class="loading">
                                        <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                        <br>
                                        <span>Loading</span>
                                    </div>
                                    <input type="hidden" class="form-control" id="txtidplaza" name="txtidplaza" value="" > 
                                    <input type="hidden" class="form-control" id="txtestructura" name="txtestructura" value="">

                                    <div class="form-group">
                                         <label for="formEmail"># PLAZA:</label>                                            
                                            <div class="input-group select2-bootstrap-append">                                           
                                                    <input type="text" class="form-control" id="nroplazar" name="nroplazar" readonly="">
                                                    <span class="input-group-btn">

                                                        <a data-href="#responsive-changeEs" href="#responsive-changeEs" data-toggle="modal" >
                                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                                    <span class="glyphicon glyphicon" id="idestadop"></span>
                                                                </button>
                                                        </a>

                                                    </span>
                                              </div>

                                    </div>  

                                    <div class="form-group">                                            
                                            <label for="formEmail">DEPENDENCIA</label>                                 
                                           <div id="IdDivDependencia"></div>
                                    </div>

                                    <div class="form-group">
                                            <label for="formEmail">NIVEL</label>                                 
                                           <div id="IdDivNivel"></div>
                                    </div>

                                    <div class="form-group">
                                            <label for="formEmail">CARGO</label>  
                                             <input type="hidden" class="form-control" id="txtidcargo" name="txtidcargo" value="">                               
                                           <div id="IdDivCargo"></div>
                                    </div>

                                </div>

                               
                                <div class="form-group">                                 
                                        <select id="IdTipoMotivoreser" class="form-control select2" name="IdTipoMotivoreser" >
                                            <option value="">Tipo de Reserva</option>                                                                                        
                                             @foreach($alltipo as $keys) 
                                                <option value="{{ $keys->IdEstadoPlaza }}">{{ $keys->IdEstadoPlaza }} | {{ $keys->Descripcion }}</option>
                                                @endforeach
                                        </select>

                                </div>
                                <div class="form-group">                                      
                                        <div class="form-group">
                                            <input type="date" id="datetime1" name="fechaRserv" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                        </div>
                                </div>

                                <div class="form-group">                                                                      
                                   <input type="text" class="form-control" id="DocRefRser" name="DocRefRser" value="" required="" placeholder="Doc .de Referencia">
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
                                                        <input type="file" name="FileAdjuntoReserva" id="FileAdjuntoReserva" readonly="" accept="*.pdf"></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                </div> 

                                 <div class="form-group" id ="idbotones">
                                    <textarea id="obserRser" name="obserRser" rows="3" class="form-control resize_vertical " placeholder="Observación"></textarea>                           
                                </div>

                                <div class="btn-group btn-group-lg">
                                    <button type="button" class="alert alert-success alert-dismissable margin5" onclick="SaveProcesaRserva()">Reservar Plaza </button>
                               
                                    <a href="{{ URL::to('admin/reserva') }}" class="alert alert-info alert-dismissable margin5" id="IdSalir" >[Salir]</a>
                                
                                </div> 
                                
                            </div>
                            <div id="IdMensajeAlert"></div>
                        {{ Form::close()}}                
                    </div>
                <!--  ===================================================== -->
                </div>


            </div>
        </div>
      
    </div>
    <!-- row-->
</section>
        <!-- =======================================  -->
                <div class="modal fade expandOpen" id="responsive-changeEs" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title" id="Idhead"></h5>
                            </div> 
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive" > 
                                        <div id="IdMensajeAlertChange"></div>
                                            {{ Form::open(array('route' => ['procesa-ChangeEstado','1','0'], 'method' => 'post', 'id' => 'frmChangeEstado','name' => 'frmChangeEstado'))}}
                                                <div class="col-md-12">
                                                    <!-- ==========draw table========== -->
                                                    <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> 
                                                    <div class="form-group">       
                                                        <input type="hidden" class="form-control" id="nroplazarEst" name="nroplazarEst">
                                                    </div>

                                                     
                                                   <!-- -->

                                                   <ul class="timeline">
                                                        <li>
                                                            <div class="timeline-badge">
                                                                <i class="livicon" data-name="hammer" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>

                                                            </div>
                                                            <div class="timeline-panel" >
                                                                <div class="timeline-heading">
                                                                    <h4 class="timeline-title">Cuidado! Tenga en cuenta los Siguiente.</h4>
                                                                    <p>
                                                                        <small class="text-muted">
                                                                            <i class="livicon" data-name="bell" data-c="#F89A14" data-hc="#F89A14" data-size="18" data-loop="true"></i>
                                                                            Advertencia!
                                                                        </small>
                                                                    </p>
                                                                </div>
                                                                <div class="timeline-body">
                                                                    <p>
                                                                        Al realizar el cambio de estado a una plaza, significa que se esta cambiando en el nominativo de plazas. Por ej. Si una plaza esta reservada para un Mandato Judicial, y lo cambia para otra acción, es responsabilidad propiamente del usuario. Esta acción guarda una bitácora de la acción para su posterior seguimiento en caso se requiera.
                                                                    </p>
                                                                </div>

                                                                 <div class="form-group">                                                                                                 
                                                                            <div class="input-group select2-bootstrap-append">
                                                                                    <select id="IdEstadoPlazaChange" class="form-control select2" name="IdEstadoPlazaChange" >
                                                                                        <option value="">Elegir Estado</option>                                             
                                                                                         @foreach($allEsta as $key) 
                                                                                            <option value="{{ $key->IdEstadoPlaza }}">{{ $key->IdEstadoPlaza }} | {{ $key->Descripcion }}</option>
                                                                                            @endforeach
                                                                                    </select>

                                                                                    <span class="input-group-btn">                                                                       
                                                                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text" onclick="SaveProcesaChangeEst()">
                                                                                                    <span class="glyphicon glyphicon"> Guardar Cambios</span>
                                                                                                </button>                                                                        
                                                                                    </span>
                                                                              </div>
                                                                    </div>

                                                            </div>
                                                        </li>
                                                         

                                                    </ul>
                                                   <!-- ->
                                                    <!-- ================ -->                        
                                                </div>
                                             {{ Form::close()}}
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModalResult">Ciérrame!</button>
                           
                            </div>
                        </div>
                </div>
            </div>
        </div>

@stop

{{-- page level scripts --}}

@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/js-reserva-plaza.js') }}"> </script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
  <script>

$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>
@stop

