@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Banco de Estructuras
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
 
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<!-- <link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />-->
<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<!--<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>-->
    <link href="{{ asset('assets/css/pages/timeline.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/pages/timeline2.css') }}" rel="stylesheet" />

<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
<style type="text/css"> input {text-transform:uppercase;></style>
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Banco de Estructuras Funcionales</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Banco de Estructuraa</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Banco de Estructuras
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                     <div id="IdMensajeAlert"></div>
                    <div class="col-md-12"> 
                        {{ Form::open(array('route' => ['addupdate-mantestruct'], 'method' => 'post', 'id' => 'frmupdateEstr','name' => 'frmupdateEstr'))}}
                       
                             <input type="hidden" name="idUserSession" value="{{ $idUserSession }}"> <!-- idsesion para enviar por ajax al api -->
                            <input type="hidden" name="token" value="{{ csrf_token()}}">
                            <div class="form-group">          
                                <div class="input-group select2-bootstrap-append">     
                                    <select id="select_nivel0" class="form-control select2" name="select_2dig">
                                        <option value="">Todos</option>                                        
                                       @foreach ($getDosDig as $getAll) 
                                            <option value="{{ $getAll->IdEstructura }}">{{ $getAll->IdEstructura }} | {{ $getAll->Descripcion }}</option>
                                        @endforeach 
                                    </select>
                                        <!--
                                             <span class="input-group-btn">
                                                    <a href="{{ route('admin.filespdf.index','01') }}" data-toggle="modal">
                                                        <button class="btn btn-default" type="submit" data-select2-open="single-append-text">
                                                            &nbsp<span class="glyphicon glyphicon-print"></span>&nbsp
                                                        </button>
                                                    </a>
                                            </span>
                                       -->
                                       <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                                <a href="javascript:void(0)" data-toggle="modal" onclick="showdepen()">
                                                    <button class="btn btn-default" type="button" data-select2-open="single-append-text" >
                                                        &nbsp<span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                </a>
                                        </span>
                                </div> 
                                <!-- =========== -->
                                <div class="row" id="divdepen1" style="display:none;">
                                   
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge">
                                                <i class="livicon" data-name="hammer" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                            </div>
                                            <div class="timeline-panel" style="display:inline-block;">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title" id="msjetitle1"> </h4>
                                                    <p>
                                                        <small class="text-muted">
                                                            <i class="livicon" data-name="bell" data-c="#F89A14" data-hc="#F89A14" data-size="18" data-loop="true"></i>
                                                            Dentro de éste nivel se creará la estructura.
                                                        </small>
                                                    </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p> 
                                                       <div class="input-group select2-bootstrap-append">     
                                                                                                                                                 
                                                            <input type="text" class="form-control" id="iddepen2" name="txtiddepen2" placeholder="Ingrese la Descripción">
                                                            <span class="input-group-btn">

                                                                <a data-href="#responsive-changeEs" href="#responsive-changeEs" >
                                                                        <button class="btn btn-info" type="button"  onclick="updatetxtoficinas('',1)" data-select2-open="single-append-text">Listo</button>
                                                                        <button class="btn btn-warning" type="button" onclick="hidendepen()" data-select2-open="single-append-text">Cancelar</button>
                                                                </a>

                                                            </span>
                                                      </div>                                                          
                                                    </p>
                                                   
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                     
                                 </div>
                                 <!-- =========== -->                                
                            </div>
                            <div class="form-group">  
                                    <div class="input-group select2-bootstrap-append">                      
                                        <select id="select_nivel1" class="form-control select2" name="select_4dig" >
                                            <option value="">Todos</option>
                                        </select>

                                             <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                                    <a href="javascript:void(0)" data-toggle="modal" onclick="showdepen2()">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text" >
                                                            &nbsp<span class="glyphicon glyphicon-plus"></span>
                                                        </button>
                                                    </a>
                                            </span>
                                    </div>
                                     <!-- =========== -->
                                <div class="row" id="divdepen2" style="display:none;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge">
                                                <i class="livicon" data-name="hammer" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                            </div>
                                            <div class="timeline-panel" style="display:inline-block;">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title" id="msjetitle2"></h4>
                                                    <p>
                                                        <small class="text-muted">
                                                            <i class="livicon" data-name="bell" data-c="#F89A14" data-hc="#F89A14" data-size="18" data-loop="true"></i>
                                                            Dentro de éste nivel se creará la estructura.
                                                        </small>
                                                    </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p> 
                                                       <div class="input-group select2-bootstrap-append">                                                                                                   
                                                            <input type="text" class="form-control" id="iddepen3" name="txtiddepen3" placeholder="Ingrese la Descripción">
                                                            <span class="input-group-btn">

                                                                <a data-href="#responsive-changeEs" href="#responsive-changeEs" >
                                                                        <button class="btn btn-info" type="button" onclick="updatetxtoficinas('',2)" data-select2-open="single-append-text">Listo</button>
                                                                        <button class="btn btn-warning" type="button" onclick="hidendepen2()" data-select2-open="single-append-text">Cancelar</button>
                                                                </a>

                                                            </span>
                                                      </div>                                                          
                                                    </p>
                                                   
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                 </div>
                                 <!-- =========== -->      


                            </div>

                            <div class="form-group">
                                <div class="input-group select2-bootstrap-append"> 
                                    <select id="select_nivel2" class="form-control select2" name="select_6dig" onchange="ajaxloadDetEstruct(3)">
                                        <option value="">Todos</option>
                                    </select>

                                     <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="showdepen3()">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    &nbsp<span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </a>
                                    </span>
                                </div>
                                 <!-- =========== -->
                                <div class="row" id="divdepen3" style="display:none;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge">
                                                <i class="livicon" data-name="hammer" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                            </div>
                                            <div class="timeline-panel" style="display:inline-block;">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title" id="msjetitle3"></h4>
                                                    <p>
                                                        <small class="text-muted">
                                                            <i class="livicon" data-name="bell" data-c="#F89A14" data-hc="#F89A14" data-size="18" data-loop="true"></i>
                                                            Dentro de éste nivel se creará la estructura.
                                                        </small>
                                                    </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p> 
                                                       <div class="input-group select2-bootstrap-append">                                                                                                   
                                                            <input type="text" class="form-control" id="iddepen4" name="txtiddepen4" placeholder="Ingrese la Descripción">
                                                            <span class="input-group-btn">

                                                                <a data-href="#responsive-changeEs" href="#responsive-changeEs" >
                                                                        <button class="btn btn-info" type="button" onclick="updatetxtoficinas('',3)" data-select2-open="single-append-text">Listo</button>
                                                                        <button class="btn btn-warning" type="button" onclick="hidendepen3()" data-select2-open="single-append-text">Cancelar</button>
                                                                </a>

                                                            </span>
                                                      </div>                                                          
                                                    </p>
                                                   
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                 </div>
                                 <!-- =========== -->      

                            </div>

                            <div class="form-group">
                                 <div class="input-group select2-bootstrap-append"> 
                                        <select id="select_nivel3" class="form-control select2" name="select_8dig" onclick="ajaxloadDetEstruct(4)">
                                            <option value="%">Todos</option>                                
                                        </select>  
                                        <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="showdepen4()">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    &nbsp<span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </a>
                                        </span>
                                </div>
                                <!-- =========== -->
                                <div class="row" id="divdepen4" style="display:none;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge">
                                                <i class="livicon" data-name="hammer" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                            </div>
                                            <div class="timeline-panel" style="display:inline-block;">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title" id="msjetitle4"></h4>
                                                    <p>
                                                        <small class="text-muted">
                                                            <i class="livicon" data-name="bell" data-c="#F89A14" data-hc="#F89A14" data-size="18" data-loop="true"></i>
                                                            Dentro de éste nivel se creará la estructura.
                                                        </small>
                                                    </p>
                                                </div> 
                                                <div class="timeline-body">
                                                    <p> 
                                                       <div class="input-group select2-bootstrap-append">                                                                                                   
                                                            <input type="text" class="form-control" id="iddepen5" name="txtiddepen5" placeholder="Ingrese la Descripción">
                                                            <span class="input-group-btn">

                                                                <a data-href="#responsive-changeEs" href="#responsive-changeEs" >
                                                                         <button class="btn btn-info" type="button" onclick="updatetxtoficinas('',4)" data-select2-open="single-append-text">Listo</button>
                                                                        <button class="btn btn-warning" type="button" onclick="hidendepen4()" data-select2-open="single-append-text">Cancelar</button>
                                                                </a>

                                                            </span>
                                                      </div>                                                          
                                                    </p>
                                                   
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                 </div>
                                 <!-- =========== -->      
                            </div> 

                            <div class="form-group">
                                <div class="input-group select2-bootstrap-append">
                                        <select id="select_nivel4" class="form-control select2" name="select_10dig" onclick="ajaxloadDetEstruct(5)">
                                            <option value="%">Todos</option>                                
                                        </select>   

                                        <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                            <a href="javascript:void(0)" data-toggle="modal" onclick="showdepen5()">
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    &nbsp<span class="glyphicon glyphicon-plus"></span>
                                                </button>
                                            </a>
                                        </span>
                                </div>
                                <!-- =========== -->
                                <div class="row" id="divdepen5" style="display:none;">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge">
                                                <i class="livicon" data-name="hammer" data-c="#fff" data-hc="#fff" data-size="18" data-loop="true"></i>
                                            </div>
                                            <div class="timeline-panel" style="display:inline-block;">
                                                <div class="timeline-heading">
                                                    <h4 class="timeline-title" id="msjetitle5"></h4>
                                                    <p>
                                                        <small class="text-muted">
                                                            <i class="livicon" data-name="bell" data-c="#F89A14" data-hc="#F89A14" data-size="18" data-loop="true"></i>
                                                             Dentro de éste nivel se creará la estructura.
                                                        </small>
                                                    </p>
                                                </div>
                                                <div class="timeline-body">
                                                    <p> 
                                                       <div class="input-group select2-bootstrap-append">                                                                                                   
                                                            <input type="text" class="form-control" id="iddepen6" name="txtiddepen6" placeholder="Ingrese la Descripción">
                                                            <span class="input-group-btn">

                                                                <a data-href="#responsive-changeEs" href="#responsive-changeEs" >
                                                                        <button class="btn btn-info" type="button" onclick="updatetxtoficinas('',5)" data-select2-open="single-append-text">Listo</button>
                                                                        <button class="btn btn-warning" type="button" onclick="hidendepen5()" data-select2-open="single-append-text">Cancelar</button>
                                                                </a>

                                                            </span>
                                                      </div>                                                          
                                                    </p>
                                                   
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                 </div>
                                 <!-- =========== -->   

                            </div>                       
                            {{ Form::close()}}    
                            
                             <!-- ==========draw table========== -->                          
                                <input type="hidden" name="token" value="{{ csrf_token()}}">
                                <div class="panel-body">
                                    <div class="table-responsive">
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