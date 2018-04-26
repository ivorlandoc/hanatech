@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Suplencias
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
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
            <form method="POST" action="/gpessalud/public/api/admin/gesplazas/insert" name="frmsaveMov" id="frmsaveMov" enctype="multipart/form-data">
                    <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                    <div class="form-group"> 
                        <div class="input-group select2-bootstrap-append">  
                                {!! Form::text('searchpzSup',null, ['class'=>'form-control','placeholder'=>'#Plaza','type'=>'search','id'=>'searchpzSup']) !!}
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="_getdataShow()"  id="idsearchaltaform">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>                                                                 
                            {!!Form::close()!!} 
                        </div>
                    </div>   
                    <!-- ========== Load dependencia ============ --> 
                     <div class="form-group">   
                            <label for="formEmail">Titular:</label> 
                             -----
                        
                    </div>

                     <div class="form-group">   
                            <label for="formEmail">Cargo</label>  
                             -----                      
                    </div>
                    <hr>
                     <div class="form-group">                      
                            <div class="input-group select2-bootstrap-append">
                                <input type="search" class="form-control" id="txtdni" name="txtdni" placeholder="#dni" required="">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="idsearchaltaform">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                    </div>
                    <div class="form-group">   
                            <label for="formEmail">Datos de Suplencia:</label> 
                            -----
                    </div>
                     <div class="form-group">   
                        <label for="formEmail">Tipo de Suplencia</label>                                                  
                        <select id="tiposupl" class="form-control select2" name="tiposupl" required="">
                            <option value="">Elegir</option>                                         
                        </select>
                        
                    </div>

                    <div class="form-group">   
                        <label for="formEmail">F.Inicio</label>                                                  
                         <input type="date" class="form-control" id="datetime1" name="datefinicio" required="">
                        
                    </div>

                    <div class="form-group">   
                        <label for="formEmail">F.Término</label>                                                  
                         <input type="date" class="form-control" id="datetime2" name="dateftermino" required="">                        
                    </div>

                    <div class="form-group">   
                        <label for="formEmail">Procesos</label>                                                  
                         <input type="text" class="form-control" id="txtproceso" name="txtproceso" required="">                        
                    </div>

                    <div class="btn-group btn-group-lg">
                        <button type="submit" class="alert alert-success alert-dismissable margin5" id="IdSaveMovimientosDePlazas">Guardar Cambios</button>
                   
                        <a href="{{ URL::to('admin/suplencias') }}" class="alert alert-info alert-dismissable margin5" >Retorna a buscar[Salir]</a>
                    
                    </div>
            </form>

         


          

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
<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
