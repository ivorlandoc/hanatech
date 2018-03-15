@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Nivel Ocupacional
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
    <h1>´Niveles Ocupacionales</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Nivel Ocupacional</a></li>
        <li class="active">Lista Niveles </li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Lista de Niveles Ocupacionales
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table dataTable no-footer dtr-inline">
                    <thead>
                        <tr class="filters">
                            <th>#</th>
                            <th>DESCRIPCION</th>
                            <th>REMUN</th>
                            <th>BONIF</th>
                            <th>BONO-PROD</th>
                            <th>BONO-ALTA-RESP</th>
                            <th>BONO-EXTRAORD</th>
                            <th>BONO-ESP</th>
                            <th>TOTAL</th>                          
                        </tr>
                    </thead>
            <tbody><?php $total=0;?>
                  @foreach ($getAllnivel as $getAll)  
                        <?php $total=round($getAll->Remuneracion+$getAll->Bonif+$getAll->BonoProd+$getAll->BonoAltaResp+$getAll->BonoExtraord+$getAll->BonoEspecialidad,2) ?>          
                        <tr>
                            <td>{{ $getAll->IdNivel }}</td>
                            <td>{{ $getAll->Descripcion }}</td> 
                            <td>{{ $getAll->Remuneracion }}</td>
                            <td>{{ $getAll->Bonif }}</td>
                            <td>{{ $getAll->BonoProd }}</td>
                            <td>{{ $getAll->BonoAltaResp }}</td>
                            <td>{{ $getAll->BonoExtraord }}</td>
                            <td>{{ $getAll->BonoEspecialidad }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @endforeach 
            </tbody>
                   
                </table>
                 {{$getAllnivel->render()}}
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
