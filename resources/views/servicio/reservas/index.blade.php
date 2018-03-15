@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Reservas de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>

@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Reserva de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Reserva de Plazas</a></li>
        <li class="active">Reservas</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary "> 
            <!--=================-->

           <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Reservas de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">           
                <form method="POST" action="/gpessalud/public/api/servicio/reservas/insert" name="frmsolicitud" id="frmsolicitud" onsubmit="return Validation()" enctype="multipart/form-data">
                             <input type="hidden" name="token" value="{{ csrf_token()}}"> 

                    <div class="col-md-12">
                        <div class="form-group"> 
                            <label>Tipo[Acción] de Reserva:</label>                         
                            <select id="selectTipoR" class="form-control select2" name="selectTipoR">
                                <option value="">Elegir el Tipo de Reserva</option>                                        
                               @foreach ($getTipo as $key) 
                                    <option value="{{ $key->IdEstadoPlaza }}">{{ $key->IdEstadoPlaza }} | {{ $key->Descripcion }}</option>
                                @endforeach  
                            </select>                            
                        </div>

                        <div class="form-group">  
                             <label>Beneficiario(a) de Plaza</label>                        
                               <input type="text" class="form-control" id="txtdni" name="txtdni" placeholder="Ingrese el # DNI" maxlength="8" >
                                <br>                                 
                               <input type="text" class="form-control" id="txtnombres" name="txtnombres" placeholder="Ingrese Los Apellidos y Nombres" maxlength="128">                         
                        </div>

                        <div class="form-group">
                                <label>Fecha de Documento:</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                           data-hc="#555555" data-loop="true"></i>
                                    </div>
                                    <input type="date"  class="form-control" name="fechadoc" id="datetime3" required=""> 
                                </div>
                        </div>
                      
                        <div class="form-group"> 
                            <label>Documento de Referencia:</label>
                            <textarea id="txtreferencia" name="txtreferencia" rows="2" class="form-control resize_vertical" required=""></textarea>                         
                        </div>

                        <div class="form-group">   
                             <label>Nivel:</label>                 
                            <select id="idselectNivel" class="form-control select2" name="idselectNivel" >
                                <option value="">Elegir el Nivel</option>   
                                 @foreach ($getnivel as $key) 
                                    <option value="{{ $key->IdNivel }}">{{ $key->IdNivel }} | {{ $key->Descripcion }}</option>
                                @endforeach                               
                            </select>                            
                        </div>

                        <div class="btn-group btn-group-lg">
                            <button type="submit" class="alert alert-success alert-dismissable margin5" id="idSaveReservaPlaza">Guardar Cambios</button>                       
                            <a href="{{ URL::to('servicio/reservas') }}" class="alert alert-info alert-dismissable margin5" >[Salir]</a>                        
                        </div>

                         <div id="IdMensajeAlert"></div>
                     
                        <!-- ==========draw table========== -->
                     <div class="panel-body">
                            <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                            <th>#SOLIC</th><th>SOLICITANTE</th><th>ASUNTO</th> <th>FECHA</th>  <th>REFERENCIA</th>  <th>ESTADO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="IdShowReservaPlazas">
                                    

                                    </tbody>
                                </table>
                                <div id="IdMsjeErrorResultReservas"></div>
                            </div>
                        </div>
                        
                        <!-- ================ -->

                        
                    </div>                      
                      
                    </form>
                </div>

            </div>
            
           
            <!--   =================    -->

        </div>
    </div>    <!-- row-->
</section>

@stop

{{-- page level scripts --}}

@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>



<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/solicitudser/api-solicitudservicio.js') }}"> </script>
    

<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
