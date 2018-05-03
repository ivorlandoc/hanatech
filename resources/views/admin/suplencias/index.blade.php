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
        <li class="active">Lista de Suplencias </li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Lista de Suplencias
                </h4>
            </div>
            <br />
            <div class="panel-body">
            <!-- ========================== -->   
                    <div class="form-group">              
                        {{ Form::open(array('route' => ['get-datos-suplencia','0'], 'method' => 'post', 'id' => 'frmsearchSup','name' => 'frmsearchSup'))}}
                         <input type="hidden" name="token" value="{{ csrf_token()}}"> 
                        <div class="input-group select2-bootstrap-append">  
                                {!! Form::text('search_suplencia',null, ['class'=>'form-control','placeholder'=>'Titular | Suplente','type'=>'search','id'=>'search_suplencia']) !!}

                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="_getdataShow()"  id="idsearchaltaform">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>
                                </span>

                                <span class="input-group-btn">                                               
                                        <div class="pull-right">                       
                                           <a href="{{ URL::to('admin/suplencias/create') }}" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>Nueva Suplencia</a>
                                        </div>                                         
                                </span>                                     
                            {!!Form::close()!!} 
                        </div>
                        
                    </div>

                    
                  
            
       

                <div class="form-group">  
                    <table class="table dataTable no-footer dtr-inline small">
                        <thead>
                        <tr> 
                            <th colspan="3" class="text-primary" ><p class="text-center">TITULAR</p></th>
                            <th colspan="7"><p class="text-center">SUPLENTE</p></th>                    
                        </tr>
                        <tr>
                            <th>#</th>
                            <th class="text-primary">#PLAZA</th>
                            <!--<th class="text-primary">DNI</th>                    -->
                            <th class="text-primary">NOMBRES</th>
                                             
                            <th>NOMBRES</th>
                            <th>T.SUP</th>
                            <th>F.INICIO</th>
                            <th>F.TERMINO</th>
                            <th>PROCESO</th>
                            <th>ESTADO</th>                   
                            <th class="text-center">ACCIONES</th>
                        </tr>
                        </thead>
                            <tbody id="divshowSuplencias">  
                                <div class="loading">
                                    <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                    <br>
                                    <span>Loading</span>
                                </div>     
                             
                            </tbody>
                    </table>
                   
                </div>
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
<script type="text/javascript" src="{{ asset('assets/js/js-suplencias.js') }}"> </script>


<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
