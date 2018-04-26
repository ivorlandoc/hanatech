@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Estructuras
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
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
        <li><a href="#"> Gestionar Estructura</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Lista de Estructuras
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                <form method="get" name="frmOnline" id='form_validation' enctype="multipart/form-data" action="#">   
                    <div class="col-md-12">
                            <div class="form-group">                          
                                <select id="select_nivel-0" class="form-control select2" name="select_2dig">
                                <option value="%">Todos</option>                                        
                                   @foreach ($getDosDig as $getAll) 
                                        <option value="{{ $getAll->IdEstructura }}">{{ $getAll->IdEstructura }} | {{ $getAll->Descripcion }}</option>
                                    @endforeach 
                                </select>
                            </div>

                        <div class="form-group">                          
                            <select id="select_nivel-1" class="form-control select2" name="select_2dig" >
                                <option value="%">Todos</option>
                            </select>
                        </div>

                        <div class="form-group">                      
                            <select id="select_nivel-2" class="form-control select2" name="select_4dig"  onclick="GetIdSelectLevelThree()">
                                <option value="%">Todos</option>        
                                
                            </select>
                            
                        </div>

                        <div class="form-group">
                            <select id="select_nivel-3" class="form-control select2" name="select_7dig" onclick ="GetIdSelectLevelFour()">
                                <option value="%">Todos</option>                                
                            </select>                            
                        </div>
                    
                         <div class="form-group">
                            <!--<label for="e1" class="control-label">Todos</label>-->
                            <select id="select_nivel-4" class="form-control select2" name="select_10dig" onclick="GetIdSelectLevelFive()">
                                <option value="%">Todos</option>                                
                            </select>                            
                        </div>
                        
                         <!-- ==========draw table========== -->
                        <div class="panel-body">
                            <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                            <th>#</th><th>DEPENDENCIA</th><th>ADMIN</th> <th>ASIST</th> <th>VAC.</th> <th>TOTAL</th>                       
                                        </tr>
                                    </thead>
                                    <tbody id="IdShowresume">
                                        <div class="loading">
                                            <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                            <br>
                                            <span>Loading</span>
                                        </div>

                                    </tbody>
                                </table>
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




            <div class="modal fade expandOpen" id="responsive" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title"><div id="IdHeadDet"></div></h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive" >
                                            <table  class="table dataTable no-footer dtr-inline">
                                                <thead>
                                                    <tr class="filters"> 
                                                        <th>#</th><th>N° PLAZA</th> <th>NIVEL</th> <th>CARGO</th> <th>NOMBRES</th>                       
                                                    </tr>
                                                </thead>
                                                <tbody id="IdShowDetails">
                                                

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



<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/api-estructura.js') }}">
    
</script>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
<script>
    
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop