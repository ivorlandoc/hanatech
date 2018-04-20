@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Consulta de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
<link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>

<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Consulta de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Consulta de Plazas</a></li>
        <li class="active">Plazas</li>
    </ol>
</section>
<script type="text/javascript">
    function vapr(){
    var xyz=$('#select_4').val()
    return xyz;
}
</script>
<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-primary "> 
            <!--=================-->

           <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Consulta de Plazas 
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                

                <form method="GET" name="frmexportex" id='frmexportex'  action="{{ route('plazas.excel','1') }}" > 
                            <div class="form-group">
                               
                                        <!--
                                        <label>
                                          <input type="checkbox" name="regimenId" id="regimenId" class="polaris"  /> 
                                          <input type="hidden" name="checkText" id="checkText">
                                        </label>
                                        <label>CAS</label>-->
                             </div>
                              <div class="form-group">     
                                     <label> Dependencia</label>
                                        <select id="select_4" class="form-control select2" name="select_10dig"  > <!-- onchange="GetIdSelectFour()"  -->
                                        <option value="%">Todos</option>                                        
                                           @foreach ($getDosDig as $getAll) 
                                               <option value="{{ $getAll->IdEstructura }}">{{ $getAll->IdEstructura }} - {{ $getAll->Descripcion }}</option>
                                            @endforeach 
                                        </select>  
                             </div>     
 
                              <div class="form-group">  
                              <label> Nivel</label>    
                                        <select id="select_e" class="form-control select2" name="select_e"  > <!-- onchange="GetIdSelectFour()"  -->
                                        <option value="%">Todos</option>                                       
                                            @foreach ($nivel as $key) 
                                               <option value="{{ $key->id }}">{{ $key->nom }}</option>
                                            @endforeach 
                                        </select> 
                                   
                                </div>
                                 <div class="form-group">
                                    
                                         <button  type="submit" class="btn btn-sm btn-primary">
                                            <span class="glyphicon glyphicon-hand-right"> Exportar Nominativo a Excel</span>
                                         </button>                               
                                   

                                </div>
                            </div>


                        <!-- ==========draw table========== -->
                        <div class="panel-body">
                            <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                       <!-- <tr class="filters">
                                            <th>#</th>                                           
                                            <th>CENTRO</th>
                                            <th>DEPENDENCIA</th>
                                            <th>AREA</th>
                                            <th>PLAZA</th>
                                            <th>#DNI</th>
                                            <th>NOMBRES</th>
                                            <th>CONDICIÓN</th>
                                            <th>F.INGRESO</th>                        
                                            <th>CARGO</th>                        
                                            <th>NIVEL</th>                        
                                            <th>ESTADO</th>                        
                                        </tr>-->
                                    </thead>
                                    <tbody id="IdShowPlazas">
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
                    <!--</form>-->
                {{ Form::close()}}    
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


<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>


<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="{{ asset('assets/js/showplaza.js') }}"> </script>
    

<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
