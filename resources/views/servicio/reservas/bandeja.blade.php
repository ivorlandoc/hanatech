@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Bandeja de Solicitud
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link rel="stylesheet" href="{{ asset('assets/vendors/Buttons/css/buttons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/pages/advbuttons.css') }}" />

@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Bandeja de Servicios</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Bandeja de Solicitud</a></li>
        <li class="active">Bandeja</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Bandeja de Solicitud
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">           
                <form method="POST" action="#" name="frmbandeja" id="frmbandeja" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
                     <div id="IdMensajeAlert"></div>                     
                     <!-- ==========draw table========== -->
                     <div class="panel-body">
                            <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                            <th>ACCIÓN</th><th>SOLICITANTE</th><th>ASUNTO</th>  <th>FECHA</th>  <th>REFERENCIA</th><th>ESTADO</th>
                                        </tr>
                                         
                                    </thead>
                                    <tbody>
                                    <?php $i=0; $fla=""; $id=""; $idSolicitServ="";?>
                                     @foreach ($data as $key) <?php 
                                     $i++; 
                                     $fla = $key->IdEstadoSer; 
                                     $id=$key->Id; 
                                     $idSolicitServ=$key->IdSolicitud;
                                     ?>
                                        <tr>
                                            <td>
                                                 @if($fla==1)
                                                <a data-href="#responsive-AtSolicit" href="#responsive-AtSolicit" onclick="setFlatIdServ('{{$id}}','{{$idSolicitServ}}')" data-toggle="modal" class="btn btn-raised btn-info md-trigger" >{{$key->IdSolicitud}} <br>Atender</a>
                                                 @else
                                                <a data-href="#responsive-AtSolicitShow" href="#responsive-AtSolicitShow" data-toggle="modal" class="btn default" onclick=ShowObservacion('{{$id}}')>{{$key->IdSolicitud}}</a>
                                                @endif
                                            </td>
                                            <td>{{ $key->sede }} | {{ $key->dep }}</td>                                           
                                            <td>{{ $key->tipo }} <BR> {{ $key->Apenombres }}</td>
                                            <td>{{ $key->FechaDoc }}</td>
                                            <td>{{ $key->DocReferencia }}</td>
                                            <td>
                                                @if($fla==1)
                                                     <h5>Pendiente</h5>
                                                @elseif($fla==2)
                                                     <h5>Rechazado</h5>                                                   
                                                @else
                                                     <h5>Atendido</h5> 
                                                @endif

                                            </td>                                        
                                        </tr>
                                @endforeach  
                                    </tbody>
                                </table>                             
                            </div>
                        </div>
                      
                    </form>
                </div>

            </div>
            
           
            <!--   =================    -->

        </div>
    </div>    <!-- row-->
</section>
      <div class="modal fade" id="responsive-AtSolicit" role="dialog" aria-labelledby="modalLabelinfo">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="modalLabelinfo">ATENDIENDO SOLICITUD</h4>
                    </div>

                    <div class="modal-body">
                        
                        <form method="post" action="/gpessalud/public/api/servicio/reservas/insertAt" name="frmSaveAtServ" id="frmSaveAtServ">
                             <input type="hidden" name="_token" value="{{ csrf_token()}}"> 
                                 <div class="form-group">
                                    <h5 id="htmlNroSolicitud"></h5> 
                                    <input type="hidden" id="IdSolicitud" name="IdSolicitud" value="">
                                </div> 

                                <div class="form-group">
                                    <label for="formPassword">Respuesta y/o Observación</label>                          
                                        <textarea id="ObservacionAt" name="ObservacionAt" rows="3" class="form-control resize_vertical" required="">Solicitud Atendida:</textarea>
                                </div> 
                                <div class="form-group">
                                    <h4><!-- class="custom_icheck custom-checkbox pos-rel p-l-30"-->
                                        <input type="checkbox" id="idRechaz" name="idRechaz" >&nbsp;Rechazar Solicitud</h4>
                                        <input type="hidden" id="idSetValCheck" name="idSetValCheck" value="3">
                                        <div id="IdMensajeAlertSolicitud"></div>
                                </div>   
                                <div class="form-group">                                                        
                                        <button type="submit" class="alert alert-success alert-dismissable margin5" id="idSaveAtencionServicio">Guardar Solicitud</button>
                                </div>                            
                        
                                
                        </form> 
                         
                        <div class="modal-footer">
                                <button class="btn  btn-info" data-dismiss="modal">Ciérrame!</button>                                    
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- ===================================== -->

        <div class="modal fade" id="responsive-AtSolicitShow" role="dialog" aria-labelledby="modalLabelinfo">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h4 class="modal-title" id="modalLabelinfo">INFORMACIÓN DE SOLICITUD</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <h4> Observación</h4>
                            <div id="IdShowObservacion"></div>
                        </div> 
                        
                         <div class="form-group">
                            <h4> Doc. Referencia</h4>
                            <div id="DocRefDiv"></div>
                        </div> 
                        
                        <div class="form-group">
                            <h4> Otros</h4>
                            <div id="IdNivelDiv"></div>
                        </div>

                        <div class="modal-footer">
                                <button class="btn  btn-info" data-dismiss="modal">Ciérrame!</button>                                    
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
