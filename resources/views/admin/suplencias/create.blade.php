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
 <link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
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
                <div id="IdMensajeAlert"></div>
            <!-- =====================================  -->
                <h3>Titular</h3>
                 {{ Form::open(array('route' => ['getdatheadTitular','0','1'], 'method' => 'post', 'id' => 'frmsearchSupHead','name' => 'frmsearchSupHead'))}}
                    <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                    <div class="form-group" style="margin-left: 20px"> 
                        <div class="input-group select2-bootstrap-append">  
                                {!! Form::text('searchpzSup',null, ['class'=>'form-control','placeholder'=>'#Plaza del Titular','type'=>'search','id'=>'searchpzSup']) !!}
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="getDatoheadTitular()"  id="headdatotitular">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>                                                                 
                            {!!Form::close()!!} 
                        </div>
                    </div>   
             {!!Form::close()!!} 
                    <!-- ========== Load dependencia ============ -->
                    <div id="msjerror" style="margin-left: 20px"></div>
                     
                     <div class="form-group" style="margin-left: 20px" id="titularnom">   
                           <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div> 
                            
                        
                    </div>

                     <div class="form-group" style="margin-left:20px" id="titularcargo">   
                           <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div> 

                    </div>

                    <hr>
                    <h3>Suplente</h3> 
                     {{ Form::open(array('route' => ['getdatheadSuplen','0','1','0'], 'method' => 'post', 'id' => 'frmsearhSuplent','name' => 'frmsearhSuplent'))}}
                         <div class="form-group">                      
                                <div class="input-group select2-bootstrap-append" style="margin-left:20px">
                                    <input type="search" class="form-control" id="txtdnisup" name="txtdnisup" placeholder="#DNI" required="">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" id="idsearchgetsuplente" onclick="getDatoheadSuplente()">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>
                                </div>
                        </div>
                     {!!Form::close()!!} 

                    {{ Form::open(array('route' => ['savesuplencias','0','1','0','1'], 'method' => 'post', 'id' => 'frmsavesuplencia','name' => 'frmsavesuplencia'))}}
                      <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                    <div class="form-group" style="margin-left:20px" id="iddivsuplente">
                            <div class="loading">
                                <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                <br>
                                <span>Loading</span>
                            </div>
                    </div>
                    <input type="hidden" class="form-control" id="txtidpersona" name="txtidpersona">
                    <input type="hidden" class="form-control" id="txtidtitular" name="txtidtitular">
                    <input type="hidden" class="form-control" id="txtplaza" name="txtplaza">
                    <div id="msjerror2" style="margin-left: 20px"></div>
                     <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">Tipo de Suplencia</label>                                                  
                        <select id="tiposupl" class="form-control select2" name="tiposupl" required="">
                            <option value="">Elegir</option> 
                             @foreach($tiposuple as $key )  
                                    <option value="{{ $key->IdTipoSuplencia }}">{{ $key->IdTipoSuplencia }} | {{ $key->Descripcion }}</option>                                     
                              @endforeach                                      
                        </select>                        
                    </div>

                    <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">F.Inicio</label>                                                  
                         <input type="date" class="form-control" id="datetime1" name="datefinicio" required="">
                        
                    </div>

                    <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">F.Término</label>                                                  
                         <input type="date" class="form-control" id="datetime2" name="dateftermino" required="">                        
                    </div>

                    <div class="form-group" style="margin-left:20px">   
                        <label for="formEmail">Process</label>                                                  
                         <input type="text" class="form-control" id="txtproceso" name="txtproceso" required="">                        
                    </div>

                    <div class="btn-group btn-group-lg" style="margin-left:20px">
                        <button type="button" class="alert alert-success alert-dismissable margin5" onclick="SaveSuplenciaFrm()">Guardar Cambios</button>
                   
                        <a href="{{ URL::to('admin/suplencias') }}" class="alert alert-info alert-dismissable margin5" >Retorna | Salir</a>
                    
                    </div>
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

<script type="text/javascript" src="{{ asset('assets/js/js-suplencias-create.js') }}"></script>

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
