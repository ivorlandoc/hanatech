@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Periodos
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
    <h1>Periodos de PPTO</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Periodos</a></li>
        <li class="active">Lista de Periodos </li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Lista de Periodos
                </h4>
            </div>
            <br />
            <div class="panel-body">
            <!-- ========================== -->               
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">                        
                    </div>
                    <div class="pull-right">                       
                       <a href="{{ URL::to('admin/periodop/create') }}" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>Crear Nuevo</a>
                    </div>
                </div>
            </div>


       


            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Descripcion</th>
                    <th>Estado</th>
                    <th width="280px;" class="text-center">Acción</th>
                </tr><?php $esta="";?>
            @foreach ($periodo as $key) 
            <?php if($key->Estado=="1") $esta="<p class='text-success'>Activo</p>"; else $esta="<p class='text-danger'>Inactivo</p>";?>
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $key->Fecha}}</td>
                <td>{{ $key->Descripcion}}</td>                
                <td>
                    <?php if($key->Estado=="1"){?> <p class='text-success'><b>Activo</b></p>
                    <?php } else{ ?> <p class='text-danger'><b>Inactivo</b></p> <?php }?>
                </td>
                <td class="text-center">
                   <!-- <a class="btn btn-info" href="{{ route('periodop.show',$key->id) }}">Show</a>-->
                    <a class="btn btn-info" href="{{ route('periodop.edit',$key->id) }}">Actualizar</a>
                    {!! Form::open(['method' => 'DELETE','route' => ['periodop.destroy', $key->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
            </table>


            {!! $periodo->links() !!}




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
<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
@stop
