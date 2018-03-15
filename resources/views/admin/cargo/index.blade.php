@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Lista de Cargos
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
    <h1>Cargos</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#">Cargos</a></li>
        <li class="active">Lista de Cargos</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Lista de Cargos
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered width100" id="table">
                    <thead>
                        <tr class="filters">
                            <th>#</th>
                             <th>CLASIFICACION</th>
                            <th>#-NIVEL</th>
                            <th>N.OCUPACIONAL</th>
                            <th>C.CARGO</th>
                            <th>DESCRIPCION</th>
                            <th>C.ANT.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;?> 
                         @foreach ($getAll as $getA)   
                            <?php $i++;?>        
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $getA->TipoCargo }}</td>
                                    <td>{{ $getA->IdNivel }}</td>
                                    <td>{{ $getA->Nivel }}</td>
                                    <td>{{ $getA->IdCargo }}</td>
                                    <td>{{ $getA->Descripcion }}</td> 
                                    <td>{{ $getA->CodigoAnt }}</td>
                                </tr>
                            @endforeach 

                    </tbody>
                </table>
                {{$getAll->render()}}
                </div>
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
