@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Reporte  - Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
<!--

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
-->



<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Reporte de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Reporte de Plazas</a></li>
        <li class="active">Reportes</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Reporte de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>


                <div class="panel-body">                   
                        <!-- ================Tabs============= -->                                                         
                           
                          {{ Form::open(array( 'route' => 'get-rpte-plaza', 'method' => 'post', 'id' => 'formplazacar','name' => 'formplazacar','class'=>'form-inline'))}}
                              <input type="hidden" name="token" value="{{ csrf_token()}}">

                             
                            <div class="form-group">
                              <label>
                                  <input type="radio" name="regim" value="0" class="polaris" checked/> 
                              </label>
                              <label>D.L.728</label>
                              <label>
                                  <input type="radio" name="regim" value="9" class="polaris"/> 
                              </label>
                              <label>D.L.1057</label> 
                          </div>

                         <div class="form-group">                                   
                                <select id="idestado" class="form-control select2" name="idestado">
                                    <option value="">Elige el  Critério</option>
                                    @foreach($dataE as $key) 
                                        <option value="{{ $key->IdEstadoPlaza }}">{{ $key->IdEstadoPlaza }} | {{ $key->Descripcion }}</option>
                                    @endforeach
                                </select>
                                
                          </div>
                           <div class="form-group">                                   
                                <select id="Subidestado" class="form-control select2" name="Subidestado" onchange="ajaxloadplazas()">
                                    <option value="">Elige el  Critério</option>
                                    @foreach($dataSub as $keys) 
                                        <option value="{{ $keys->IdEstadoPlaza }}">{{ $keys->IdEstadoPlaza }} | {{ $keys->Descripcion }}</option>
                                    @endforeach
                                </select>
                                
                          </div>
                                   
                          <div class="form-group">
                              <a href="{{route('reportes.rplazas.index',1)}}" class="btn btn-sm btn-primary">Exportar a Excel[Cuadro Plazas Vacantes]</a>   
                          </div> 

                           {{ Form::close()}}

                              <div class="panel-body">
                              <div class="table-responsive">                                
                                    <table class="table table-bordered width100" id="table">
                                        <thead>                                           
                                            <tr class="filters">
                                                <th>#</th>
                                                <th>CODIGO</th>                                             
                                                <th>ÓRGANO</th>
                                                <th>DEPENDENCIA</th>                                                
                                                <th>#PLAZA</th>
                                                <th>CARGO</th>
                                                <th>#DNI</th> 
                                                <th>NOMBRES</th>
                                                <th>ESTADO</th>
                                                <th>RÉGIMEN</th>
                                                <th>DOC.REF</th>
                                                <th>F.CESE</th>
                                            </tr>
                                        </thead>
                                        <tbody id="IdShowRptePlazas">                                          
                                                  <div class="loading" >
                                                        <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                                        <br>
                                                        <span>Loading</span>
                                                  </div> 

                                           
                                        </tbody>
                                         
                                    </table>
                                     <ul id="pagination" class="pagination-sm"></ul>      
                              </div> 
                            </div>                  
                        <!-- =================================  -->                
                </div>
            </div>
            <!--   =================    -->
        </div>
    </div>    <!-- row-->
</section>
     
@stop

{{-- page level scripts --}}

@section('footer_scripts')

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>-->

<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>


<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
<!--
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
-->
 <script type="text/javascript">
      var url = "http://localhost/gpessalud/public/reportes/rplazas";
    //  var url = "http://localhost:8000/";
    </script>
<script type="text/javascript" src="{{ asset('assets/js/js-rpte-plazas.js') }}"> </script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>

@stop