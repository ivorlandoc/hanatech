@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Alta de Plazas
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
        <li><a href="#"> Creación de Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Creación de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body"> 
                        <!-- ========== Cuerpo de Formulario ============================ -->
                    <div  id="IdFormbodyalta">
                         {{ Form::open(array( 'route' => ['set-save-contador_plaza','0','1'], 'method' => 'post', 'id' => 'frmcreaplz','name' => 'frmcreaplz'))}}                       
                             <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                                <!-- Datos Estáticos de cabecera-->                          
                                 <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                                 
                        <!-- ========== Load dependencia ============ -->
                            <div id="ShowDataHead" style="display:none">
                                <input type="text" class="form-control" id="NroPlazaDescripcion" name="NroPlazaDescripcion" value="" disabled="">
                                <input type="text" class="form-control" id="IdNivelNroPlaza" name="IdNivelNroPlaza" value="" readonly="">
                                <input type="text" class="form-control" id="IdDepenorgano" name="IdDepenorgano" value="" readonly="">
                                <!--<input type="text" class="form-control" id="IdDependenciaDes" name="IdDependenciaDes" value="" readonly="">-->
                            </div>
                         
                            <div id="FormAltaPlaza">
                                  <div class="form-group">                               
                                     <div id="IdMensajeAlert"></div>
                                    <div class="input-group select2-bootstrap-append"> 
                                        <input type="text" class="form-control" id="IdEstructura" name="IdEstructura" maxlength="12" placeholder="# de Estructura">
                                        <span class="input-group-btn">
                                               <a data-href="#responsive" href="#responsive" data-toggle="modal" >
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </a>
                                        </span>

                                        <div class="form-group"> 
                                         @foreach($conta as $key)                                    
                                            <select id="selereg" class="form-control select2" name="selereg" onclick="SetNroPlaza()" >                                                
                                                <option value="1" style="width:80px;border: 0px;font-weight:bold;font-size:15px;">REG. 728: {{ $key->r728 }} </option>
                                                <option value="0" style="width:80px;border: 0px;font-weight:bold;font-size:15px;">REG. CAS:{{ $key->rcas }}9</option>
                                            </select>  
                                         @endforeach
                                           <input type="hidden" class="form-control" id="regtxt728" value="{{ $key->r728 }}">
                                            <input type="hidden" class="form-control" id="regtxtcas" value="{{ $key->rcas }}">
                                        </div>

                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="form-group" id="idcentro"></div>
                                    <div class="form-group" id="idsubcentro"></div>
                                    <div class="form-group" id="iddepen"></div>
                                    <div class="form-group" id="idoficina"></div>
                                    <input type="hidden" id="txthidenEstru" name="txthidenEstru" readonly="">
                                </div>


                                <div class="form-group">                                   
                                        <select id="selNivel" class="form-control select2" name="selNivel" onchange="SetNroPlaza()" >
                                            <option value="">Elegir Nivel</option>
                                            @foreach($allNivel as $keys) 
                                                <option value="{{ $keys->IdNivel }}">{{ $keys->IdNivel }} | {{ $keys->Descripcion }}</option>
                                                @endforeach
                                        </select>  
                                </div>

                                <div class="form-group">                                                                       
                                    <select id="selecargo" class="form-control select2" name="selecargo" >
                                        <option value="">Elegir Cargo</option>
                                        @foreach($allCargo as $keys) 
                                                <option value="{{ $keys->IdCargo }}">{{ $keys->IdCargo }} | {{ $keys->Descripcion }}</option>
                                                @endforeach
                                    </select>
                                </div>

                                <div class="form-group">                                   
                                    <input type="text" class="form-control" id="docrefcrea" name="docrefcrea" maxlength="128" placeholder="Doc. de Referencia">
                                </div>
                              

                                <div class="form-group">                                   
                                        <div class="form-group">
                                            <input type="date" id="datetime1" name="fechadoccrea" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
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
                                                        <input type="file" name="FileAdjuntoCrea" id="FileAdjuntoCrea" readonly="" accept="*.pdf"></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                </div>
                                
                                 <div class="form-group">
                                    <!--<label for="formPassword">Documento de Referencia</label>-->                                        
                                        <input type="text" class="form-control" id="obserCrea" name="obserCrea" value="" required="" placeholder="Observación">
                                </div>
                               <div class="input-group select2-bootstrap-append"> 
                                    <div class="btn-group btn-group-lg">
                                        <button type="button" class="alert alert-success alert-dismissable margin5" id="savecreaContador" onclick="SaveContador()">Crear Plaza</button>
                                        <a href="{{ URL::to('admin/creaplaza') }}" class="alert alert-info alert-dismissable margin5" id="SalirCrea" >Nuevo [Salir]</a>
                                        
                                            <span id="getnroplazas727" style="display::none; font-weight:bold;font-size:20px;text-align:right;"></span>
                                            <span id="getnroplazascas" style="display::none; font-weight:bold;font-size:20px;text-align:right;"></span>
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
    <div class="modal fade expandOpen" id="responsive" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title">SELECCIONE LA DEPENDENCIA</h5>
                            </div>
                             
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive" >
                                           {{ Form::open(array('route' => ['get-all-estruct','0'], 'method' => 'post', 'id' => 'frmgetEstru','name' => 'frmgetEstru'))}}  
                                                <div class="col-md-12">

                                                    <div class="form-group">                          
                                                        <select id="select_nivel1" class="form-control select2" name="select_nivel1" onchange="GetSelEstructura(2)">
                                                            <option value="">Elegir</option>                                        
                                                            @foreach($data as $keys) 
                                                            <option value="{{ $keys->IdEstructura }}">{{ $keys->IdEstructura }} | {{ $keys->Descripcion }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                     <div class="form-group">                      
                                                            <select id="select_nivel2" class="form-control select2" name="select_nivel2" onclick="GetSelEstructura(3)">
                                                                <option value="%">Todos</option>        
                                                                
                                                            </select>
                                                            
                                                        </div>

                                                        <div class="form-group">
                                                            <select id="select_nivel3" class="form-control select2" name="select_nivel3" onclick="GetSelEstructura(4)">
                                                                <option value="%">Todos</option>                                
                                                            </select>                            
                                                        </div>
                                                    
                                                         <div class="form-group">                                                         
                                                            <select id="select_nivel4" class="form-control select2" name="select_nivel4" onclick="GetSelEstructura(5)">
                                                                <option value="%">Todos</option>                                
                                                            </select>                            
                                                        </div>
                                                    

                                                    <!-- ==========draw table========== -->
                                                                    <div class="panel-body">
                                                                        <div class="table-responsive" >
                                                                            <table  class="table dataTable no-footer dtr-inline">
                                                                                <thead>
                                                                                    <tr class="filters">
                                                                                        <th>#</th><th>#DEPENDENCIA</th><th>DEPENDENCIA</th>                       
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody id="IdShow4toNivelPlazas">
                                                                                

                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>                        
                                                    <!-- ================ -->                        
                                                </div>
                                             {{ Form::close()}}
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModal">Ciérrame!</button>
                           
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
<!-- ========== datepiker ================= -->
<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>

<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/js/js-crea-plaza.js') }}"> </script>



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