@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Actualizando Movimientos de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')


<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />
<!-- =================================================== -->
 <link rel="stylesheet" href="{{ asset('assets/css/pages/buttons.css') }}" />
    <!-- include the BotDetect layout stylesheet -->
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Actualizar Mov. Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Actualizar Mov. Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Actualizar
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body">                
                     {{ Form::open(array( 'route' => ['search_mov'], 'method' => 'post', 'id' => 'frmsearchmov','name' => 'frmsearchmov'))}}  
                                <div class="form-group">                            
                                    <div class="input-group select2-bootstrap-append">   
                                                          
                                         {!! Form::text('search_plaza_mov',null, ['class'=>'form-control','placeholder'=>'#Plaza | #Dni | Apellidos ','type'=>'search','id'=>'search_plaza_mov']) !!}  
                                                <input type="hidden" name="token" value="{{ csrf_token()}}">                   
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-select2-open="single-append-text" onclick="getdataMovShow('0')">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                </span>                                       
                                   
                                    </div>
                                </div> 
                                <!-- ==========draw table========== -->
                                <div class="panel-body" id="headgetDatosmov">
                                    <div class="table-responsive" >
                                        <table  class="table dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr class="filters">
                                                    <th>#</th><th>#DNI</th><th>NOMBRES</th><th>#PLAZA</th><th>MOV.</th><th>DOC. REF</th> <th>ACCIONES</th>                   
                                                </tr>
                                            </thead>
                                            <tbody id="IdShowResultSearchM">
                                            

                                            </tbody>
                                            <div id="IdMsjeErrorResultSearchm"></div>
                                        </table>
                                    </div>
                                </div>                        
                                <!-- ================ -->  
                            
                                     
                 
                    </div>
                     {{ Form::close()}}    
                </div>
            </div>
      


        <div class="panel panel-info" id="DesingFrmMovtPlz" style="display:none;">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>:  <span id="txttitulonombres"></span></s>
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body">
                         <div id="Idmessage"></div>
                         {{ Form::open(array( 'route' => ['update-historia-mov','9'], 'method' => 'post', 'id' => 'frmupdatemov','name' => 'frmupdatemov'))}} 
                             <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
                                <!-- Datos Estáticos de cabecera-->
                                 <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                                 <input type="hidden" name="IdHistoria" id="IdHistoria">
                                 <input type="hidden" name="IdPlaza" id="IdPlaza">
                                 <input type="hidden" name="IdPersona" id="IdPersona"> 
                                 <input type="hidden" name="NroPlaza" id="NroPlaza"> 
                                <!-- ============== fin head =============================== -->
                               <!--<div class="form-group">
                                    <label for="formEmail">Acción [VARIACIÓN DE UBICACIÓN]</label>
                                     <select id="IdTipoMovimiento" class="form-control select2" name="IdTipoMovimiento" required="">
                                        <option value="">Elegir</option>        
                                        
                                    </select>
                                </div>-->
                                <!-- ========== Load dependencia ============ -->
                            <!--
                                <div class="form-group">
                                     <label for="formEmail">A:</label>   
                                    <input type="hidden" name="_ttoken" value="{{ csrf_token()}}">                        
                                    <select id="select_10" class="form-control select2" name="select_2dig" required="">
                                        <option value="">Elegir</option>                                        
                                       @foreach ($getDosDig as $getAll) 
                                            <option value="{{ substr($getAll->IdEstructura,0,2) }}">{{ substr($getAll->IdEstructura,0,2) }} - {{ $getAll->Descripcion }}</option>
                                        @endforeach  
                                    </select>                                    
                                </div>

                                 <div class="form-group">          
                                    <select id="select_11" class="form-control select2" name="select_4dig" required="">
                                        <option value="">Elegir</option>                                         
                                    </select>
                                    
                                </div>

                                <div class="form-group">
                                    <select id="select_22" class="form-control select2" name="select_7dig" required="">
                                        <option value="">Elegir</option> 
                                    </select>
                                    
                                </div>

                                <div class="form-group">
                                    <select id="select_33" class="form-control select2" name="select_33" required="">
                                        <option value="">Todos</option>                                
                                    </select>                            
                                </div>
                            
                                 <div class="form-group">                    
                                    <select id="select_44" class="form-control select2" name="select_44" required="">
                                        <option value="">Todos</option>                                
                                    </select>                            
                                </div>
                            -->
                            
                                <!-- fin load dependencia ================ -->
                                <div class="form-group">
                                        <label>Fecha de Movimiento[Inicio]:</label>                                      
                                        <input type="date"  class="form-control" name="FechaMov" id="datetime3" required=""  pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                </div>

                                <div class="form-group">
                                        <label>Fecha de Documento[Término]:</label>                                      
                                            <input type="date"  class="form-control" name="FechaDocRef" id="datetime1" required=""  pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                </div>

                                
           
                                <div class="form-group">
                                    <label for="formPassword">Doc. de Referencia</label>
                                    <input type="text" class="form-control" id="DocRefmov" name="DocRefmov" value="" required="">
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
                                                        <input type="file" name="FileAdjuntoUpdate" id="FileAdjuntoUpdate" readonly="" accept="*.pdf" required=""></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>


                                </div>

                                 <div class="form-group">
                                    <label for="formPassword">Observación</label>                          
                                        <textarea id="Observacion" name="Observacion" rows="3" class="form-control resize_vertical" required=""></textarea>
                                </div>                          

                                <div class="btn-group btn-group-lg">
                                    <button type="submit" class="alert alert-success alert-dismissable margin5" id="saveupdatemov">Guardar Cambios</button>
                               
                                    <a href="{{ URL::to('admin/upmov') }}" class="alert alert-info alert-dismissable margin5" >Nuevo | Salir</a>
                                
                                </div>
                     
                        </div>
                   {{ Form::close()}}  
            <!--   =================    -->
              
        </div>
    </div>    <!-- row-->
</section>

       
        <!-- =======================================  -->
@stop

{{-- page level scripts --}}

@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>
<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/js-update-mov.js') }}"> </script>
@stop