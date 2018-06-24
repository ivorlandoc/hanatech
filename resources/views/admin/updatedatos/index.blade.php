@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Actualizar
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />

@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Actualizar Datos</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Actualizar datos</a></li>
        <li class="active">Personales </li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row" style="border:0px solid red;padding:0px">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Actualizando Datos Personales
                </h4>

            </div>
            <br />
            <div class="panel-body" style="padding-top:0px;">
            <!-- ========================== --> 
            <div id="msjerror"></div>
                {{ Form::open(array('route' => ['updatedatospersona'], 'method' => 'post', 'id' => 'frmprocesaUpdate','name' => 'frmprocesaUpdate'))}}     
                
                            <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div>

                    <table class="table dataTable no-footer dtr-inline small" >
                        <thead>                      
                        <tr>
                            <th>#</th>
                            <th>#DNI</th>                  
                            <th>NOMBRES</th>
                            <th>PLAZA</th> 
                            <!-- <th>OFICINA</th> 
                            <th>SERVICIO</th> -->
                            <th>CARGO</th>                           
                            <th>ESPECIALIDAD</th> 
                            <th class="text-center" >ACCIONES</th>   
                        </tr>
                        </thead>
                            <tbody>
                                <?php $i=0;?> 
                                 @foreach ($data as $key)   
                                    <?php $i++;?>        
                                        <tr>
                                            <td>{{ $i }} <input type="hidden" name="P{{ $i }}" id="{{ $i }}" value="{{ $key->IdPersona }}"> </td>
                                            <td>{{ $key->Dni }}</td>
                                            <td>{{ $key->ApellidoPat }} {{ $key->ApellidoMat }} {{ $key->Nombres }}</td>                                          
                                            <td>{{ $key->NroPlaza }}</td>
                                            <!-- <td>{ $key->dep }</td>
                                            <td>{ $key->servicio }</td>-->
                                            <td>{{ $key->cargo }}</td>
                                            <td>{{ $key->Especialidad }}</td>
                                            <td>                                                   
                                                <select id="E{{ $i }}" class="form-control select2 small" name="E{{ $i }}" style="height:33px"> 
                                                         <option value="">Elegir</option>                                                                                     
                                                        @foreach ($dataEsp as $keys) 
                                                         <option value="{{ $keys->IdEspecialidad }}" <?php if($key->codEsp == $keys->IdEspecialidad) { ?> selected <?php }else {}?> > {{ $keys->IdEspecialidad }} | {{ $keys->Descripcion }}</option>
                                                        @endforeach 
                                                </select>   
                                                  
                                            </td>
                                        </tr>
                                    @endforeach 
                            </tbody>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-success btn-responsive" id="saveintegrarplaza" onclick="updateespecialidad()">Actualizar</button>
                                </td>
                                <td colspan="2" class="text-rigth">{{$data->render()}}</td></tr>
                        </table> 
               
                 {!!Form::close()!!} 
             <!-- ========================== -->   
            </div>
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
<script type="text/javascript" src="{{ asset('assets/js/js-updatedatos.js') }}"> </script>

 <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/sweetalert/js/sweetalert-dev.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/pages/custom_sweetalert.js') }}" type="text/javascript"></script>
    
<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
