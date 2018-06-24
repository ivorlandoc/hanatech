@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Reporte  - 70 Años
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />

<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Proximos a cumplir 70 años</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Proximos a cumplir 70 años</a></li>
        <li class="active">Proximos</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Proximos a cumplir 70 años
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>


                <div class="panel-body">                   
                        <!-- ================Tabs============= --> 
                              <div class="panel-body">
                              <div class="table-responsive">                                
                                    <table class="table table-bordered width100" id="table">
                                        <thead>                                           
                                            <tr class="filters">
                                                <th>#</th>
                                                <th>RED</th>                                             
                                                <th>DNI</th>
                                                <th>NOMBRES</th>                                                
                                                <th>F.NAC</th>
                                                <th>AÑOS</th>
                                                <th>MESES</th> 
                                                <th>DIAS</th>                                            
                                            </tr>
                                        </thead>
                                        <tbody id="IdShowRptePlazas">  <?php $i=0;?>                                        
                                            @foreach($data as $keys)
                                            <?php 
                                                 $color="";
                                                $i++;
                                                if($keys->anios>=70){
                                                  $color="text-danger";
                                                } elseif ($keys->anios==69 && $keys->meses==12) {
                                                  $color="text-warning";                                                 
                                                }else{
                                                  $color=""; 
                                                }
                                            ?>
                                              <tr class="{{ $color }}" >
                                                <td> {{ $i }}</td>
                                                <td> {{ $keys->red }}</td>
                                                <td> {{ $keys->Dni }}</td>
                                                <td> {{ $keys->ApellidoPat}} {{ $keys->ApellidoMat}} {{ $keys->Nombres}}</td>
                                                <td> {{ $keys->FechaNac }}</td>
                                                <td> {{ $keys->anios }}</td>
                                                <td> {{ $keys->meses }}</td>
                                                <td> {{ $keys->dias }}</td>
                                              </tr>
                                            @endforeach                                           
                                        </tbody>                                         
                                    </table>
                                     <ul id="pagination" class="pagination-sm"> </ul>      
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