@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Mantenedor
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
 
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<!-- <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />-->
<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<!--<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>-->
<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />

@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Estructuras Funcionales</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Mantenimiento de Estructuraa</a></li>
        <li class="active">Estructuras</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Mantenimiento de Estructuras
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                     <div id="IdMensajeAlert"></div>
                    <div class="col-md-12">  
                      
                 {{ Form::open(array('route' => ['getload-det-estruct','1'], 'method' => 'post', 'id' => 'frmmantestru','name' => 'frmmantestru'))}}
                       
                      
                            <input type="hidden" name="token" value="{{ csrf_token()}}">
                            <div class="form-group">          
                                <div class="input-group select2-bootstrap-append">     
                                    <select id="select_nivel0" class="form-control select2" name="select_2dig">
                                        <option value="%">Todos</option>                                        
                                       @foreach ($getDosDig as $getAll) 
                                            <option value="{{ substr($getAll->IdEstructura,0,2) }}">{{ substr($getAll->IdEstructura,0,2) }} | {{ $getAll->Descripcion }}</option>
                                        @endforeach 
                                    </select>
                                        
                                             <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                                    <a href="{{ route('admin.filespdf.index','01') }}" data-toggle="modal">
                                                        <button class="btn btn-default" type="submit" data-select2-open="single-append-text">
                                                            &nbsp<span class="glyphicon glyphicon-print"></span>&nbsp
                                                        </button>
                                                    </a>
                                            </span>
                                       
                                </div>                            
                            </div>
                            <div class="form-group">  
                                    <div class="input-group select2-bootstrap-append">                      
                                        <select id="select_nivel1" class="form-control select2" name="select_4dig" onchange ="ajaxloadDetEstruct(2)">
                                            <option value="%">Todos</option>
                                        </select>

                                             <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                                    <a href="{{ route('admin.filespdf.index','01') }}" data-toggle="modal">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            &nbsp<span class="glyphicon glyphicon-add"></span>&nbsp<b>+</b>
                                                        </button>
                                                    </a>
                                            </span>
                                    </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group select2-bootstrap-append"> 
                                    <select id="select_nivel2" class="form-control select2" name="select_6dig" onchange="ajaxloadDetEstruct(3)">
                                        <option value="%">Todos</option>
                                    </select>

                                     <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                            <a href="{{ route('admin.filespdf.index','01') }}" data-toggle="modal">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    &nbsp<span class="glyphicon glyphicon-add"></span>&nbsp<b>+</b>
                                                </button>
                                            </a>
                                    </span>
                                </div>

                            </div>

                            <div class="form-group">
                                 <div class="input-group select2-bootstrap-append"> 
                                        <select id="select_nivel3" class="form-control select2" name="select_8dig" onclick="ajaxloadDetEstruct(4)">
                                            <option value="%">Todos</option>                                
                                        </select>  
                                        <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                            <a href="{{ route('admin.filespdf.index','01') }}" data-toggle="modal">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    &nbsp<span class="glyphicon glyphicon-add"></span>&nbsp<b>+</b>
                                                </button>
                                            </a>
                                        </span>
                                </div>
                            </div> 

                            <div class="form-group">
                                <div class="input-group select2-bootstrap-append">
                                        <select id="select_nivel4" class="form-control select2" name="select_10dig" onclick="ajaxloadDetEstruct(5)">
                                            <option value="%">Todos</option>                                
                                        </select>    
                                        <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                            <a href="{{ route('admin.filespdf.index','01') }}" data-toggle="modal">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    &nbsp<span class="glyphicon glyphicon-add"></span>&nbsp<b>+</b>
                                                </button>
                                            </a>
                                        </span>
                                </div>

                            </div>                       
                            
                         {{ Form::close()}}    
                       <!-- </form>-->
                       <!-- <div class="form-group">                         
                            <select id="select_nivel4" class="form-control select2" name="select_10dig" onclick="GetIdSelectFour()">
                                <option value="%">Todos</option>                                
                            </select>                            
                        </div>
                        
                        <div class="form-group">
                            <label for="e1" class="control-label">Todos</label>
                           <input type="text" class="form-control" id="txtcuartoNivel" name="txtcuartoNivel" required="" value="" maxlength="60" placeholder="Descripcion del 4to Nivel">
                        </div>
                    
                        <div class="btn-group btn-group-lg">
                                <button type="submit" class="alert alert-success alert-dismissable margin5" id="IdSaveManteEstru">Guardar Cambios</button>
                                <button type="button" class="alert alert-info alert-dismissable margin5" id="IdSalir"><a href="{{ URL::to('admin/mantestruct')}}" class="alert-info">[ Salir ]</a></button>
                        </div>-->

                       
                             <!-- ==========draw table========== -->
                            {{ Form::open(array('route' => 'save-update-mantestruct', 'method' => 'post', 'id' => 'frmupdateEstr','name' => 'frmupdateEstr'))}} 
                            <input type="hidden" name="token" value="{{ csrf_token()}}">
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table  class="table dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr class="filters">
                                                    <th>#</th><th>CODIGO</th><th>ÓRGANO</th><th>GERENCIA</th> <th>DEPENDENCIA</th><th>OFICINA</th> <th>SERVICIO</th>                      
                                                </tr>
                                            </thead>
                                            <tbody id="IdShowresume">                                            
                                                <div class="loading">                                                   
                                                    <span>Loading</span>
                                                </div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            {{ Form::close()}}                       
                            <!-- ================ -->                      
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

    <script type="text/javascript" src="{{ asset('assets/js/api-manteEstructura.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>


<script>    
    $(function () {
    	$('body').on('hidden.bs.modal', '.modal', function () {
    		$(this).removeData('bs.modal');
    	});
    });
</script>
@stop