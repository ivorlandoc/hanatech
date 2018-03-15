@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Baja de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
-->
<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<!--<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>-->

<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('assets/vendors/Buttons/css/buttons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/pages/buttons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/pages/advbuttons.css') }}" />



@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Baja de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Gestionar Bajas</a></li>
        <li class="active">Plazas</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Baja de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                    <div id ="GetSearch">
                        {!! Form::open(['route'=>'admin.bajaplazas.index','method'=>'GET','id'=>'BajaPlazas']) !!}
                            <input type="hidden" name="token" value="{{ csrf_token()}}">
                            <div class="form-group">                            
                                <div class="input-group select2-bootstrap-append">                          
                                            {!! Form::text('string_search',null, ['class'=>'form-control','placeholder'=>'Apellidos | #Dni | #Plaza','type'=>'search']) !!}                     
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                            </span>
                                </div>
                            </div>
                        {!!Form::close()!!}   
                   

                        <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                                <th>#</th>
                                                <th># PLAZA</th>
                                                <th>NIVEL</th>  
                                                <th>CARGO</th> 
                                                <th>NOMBRES</th>                                                           
                                                <th style="text-align:center;">ACCIONES</th>                       
                                        </tr>
                                    </thead>
                                    <tbody id="IdShowSearch">
                                        <?php $i=0;$_plza="";?>  

                                            @foreach($GetSearch as $GetAllp) 
                                            <?php $i++;?>

                                            <?php 
                                                $_plza =$GetAllp->NroPlaza;
                                            ?>

                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>{{$GetAllp->NroPlaza}}</td>
                                                <td>{{$GetAllp->IdNivel}}</td>
                                                <td>{{$GetAllp->cargo}}</td>
                                                <td>{{$GetAllp->Nombres}}</td>                 
                                                <td style="text-align:center;">
                                                    <div class="ui-group-buttons">
                                                        <button type="button" class="btn btn-danger btn-lg" onclick="ShowFormBaja('{{$GetAllp->NroPlaza}}')">Dar Baja</button>
                                                        <!--<div class="or or-lg"></div>
                                                        <a  data-href="#responsive" href="#responsive" class="btn btn-danger btn-lg">Eliminar</a>-->
                                                    </div>
                                                </td>                                 
                                            </tr>
                                            @endforeach   

                                    </tbody>
                                </table>
                                <div style="text-align:right"> {{$GetSearch->render()}}</div>
                        </div>                       
                    </div> <!-- Termina el div search -->
                        <!--  ===============diseño del formulari0============================ admin.requisiciones.requisicion.store -->
                        <div id="DesingForm">                           
                           <form method="POST" action="/gpessalud/public/api/admin/bajaplazas/ProcesaBajaInsert" name="frmsaveBaja" id="frmsaveBaja" enctype="multipart/form-data">
                        <!--<form method="POST" action="/api/admin/bajaplazas/ProcesaBajaInsert" name="frmsaveBaja" id="frmsaveBaja" enctype="multipart/form-data">-->
                        <!--<form method="POST" action="/api/admin/gesplazas/insert"             name="frmsaveMov"  id="frmsaveMov"  enctype="multipart/form-data">-->
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                 <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                                <div class="form-group" >
                                    <label for="formEmail">Nombres</label>                                       
                                      <input type="text" class="form-control" id="txtnombres" readonly="" value="">                                          
                                    
                                      <input type="hidden" class="form-control" id="IdPersona"  name="IdPersona"   value="">
                                      <input type="hidden" class="form-control" id="IdPlaza"     name="IdPlaza" value="">

                                      <input type="hidden" class="form-control" id="IdEstructura"  name="IdEstructura" value="">
                                      <input type="hidden" class="form-control" id="IdCargo"       name="IdCargo"  value="">
                                      <input type="hidden" class="form-control" id="NroPlaza"     name="NroPlaza"  value="">
                                      
                                </div>

                                <div class="form-group" >
                                    <label for="formEmail"># Plaza / Nivel / Cargo</label>
                                      <input type="text" class="form-control" id="txtIdPlaza" readonly="" value="">
                                </div>
                                <div class="form-group">
                                    <label for="formEmail">Dependencia</label>
                                     <input type="text" class="form-control" id="txtIdEstructura" readonly="" value="">
                                </div>

                                <div class="form-group">
                                    <label for="formEmail">Motivo de Baja</label>
                                     <select id="IdTipoMovbaja" class="form-control select2" name="IdTipoMovbaja">
                                        <option value="">Elegir</option>        
                                        
                                    </select>
                                </div>

                                <div class="form-group">
                                        <label>Fecha[Movimiento] de baja:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>
                                            <input type="text"  class="form-control" name="FechaMovbaja" id="datetime3"/> 
                                        </div>
                                </div>

                                <div class="form-group">
                                        <label>Fecha de documento de baja:</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>
                                            <input type="text"  class="form-control" name="FechaDocRefbja" id="datetime1"/> 
                                        </div>
                                </div>

                                
                                <div class="form-group">
                                    <label for="formPassword">Documento de Referencia</label>
                                    <input type="text" class="form-control" name="DocRefBaja" id="DocRefBaja" value="">
                                </div>
                                    
                                <div class="form-group">
                                    <label for="formPassword">Adjuntar Documento</label>
                                     <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                        <div class="form-control" data-trigger="fileinput">
                                            <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                            <span class="fileinput-filename"></span>
                                        </div>
                                                <span class="input-group-addon btn btn-default btn-file">
                                                    <span class="fileinput-new">Selecione Archivo</span>
                                                    <span class="fileinput-exists">Cambiar</span>
                                                    <input type="file" name="FileAdjuntoBaja" id="FileAdjuntoBaja" readonly="" ></span>
                                        <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>

                                    </div>
                                                

                                </div>

                                 <div class="form-group" id ="idbotones">
                                    <label for="formPassword">Observación</label>                          
                                        <textarea id="Observacion" name="Observacion" rows="3" class="form-control resize_vertical "></textarea>                           
                                </div>

                               
                                <div class="btn-group btn-group-lg">   
                                    <button type="submit" class="alert alert-success alert-dismissable margin5" id="IdSavebajaPlaza">Guardar Baja</button> 
                                    <a href="{{ URL::to('admin/bajaplazas') }}" class="alert alert-info alert-dismissable margin5"> Retorna a buscar[Salir]</a>
                                </div>
                                 <div id="Idmessage"></div> 
                           </form>                                
                        
                    </div>
                    <!--  ===============Hasta aqui el diseño del formulario============================ -->
                </div>
            </div>
            <!--   =================    -->

        </div>
    </div>    <!-- row-->
</section>
      <div class="modal fade expandOpen" id="responsive" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title"><div id="IdHeadDetMov"></div></h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive" >
                                            <table  class="table dataTable no-footer dtr-inline">
                                                <thead id="headTR">
                                                   
                                                </thead>
                                                <tbody id="IdShowDetailsMov">                                                
                                                
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default">Ciérrame!</button>
                           
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


<script src="{{ asset('assets/js/pages/datepicker.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/api-bajaPlaza.js') }}"></script>
    

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>





 <!--social buttons-->
 <!--
    <script type="text/javascript">
        $(function () {
            var all_classes = "";
            var timer = undefined;
            $.each($('li', '.social-class'), function (index, element) {
                all_classes += " btn-" + $(element).data("code");
            });
            $('li', '.social-class').mouseenter(function () {
                var icon_name = $(this).data("code");
                if ($(this).data("icon")) {
                    icon_name = $(this).data("icon");
                }
                var icon = "<i class='fa fa-" + icon_name + "'></i>";
                $('.btn-social', '.social-sizes').html(icon + "Sign in with " + $(this).data("name"));
                $('.btn-social-icon', '.social-sizes').html(icon);
                $('.btn', '.social-sizes').removeClass(all_classes);
                $('.btn', '.social-sizes').addClass("btn-" + $(this).data('code'));
            });
            $($('li', '.social-class')[Math.floor($('li', '.social-class').length * Math.random())]).mouseenter();
        });-->
    </script>
@stop