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
<style type="text/css"> input {text-transform:uppercase;></style>
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
                    Agregando Nuevo Periodo
                </h4>
            </div>
            <br />
            <div class="panel-body">
            <!-- ========================== -->               
                <div class="col-lg-12 margin-tb">               
                    <div class="pull-right">
                        <a class="btn btn-primary" href="{{ URL::to('admin/periodop') }}"> Regresar</a>
                    
                    </div>
                </div>
      

            @if (count($errors) < 0)
                <div class="alert alert-danger">
                    <strong>¡Ups!</strong> Hubo algunos problemas con su entrada<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {!! Form::open(array('route' => 'admin.periodop.store','method'=>'POST')) !!}            
                 @include('admin.periodop.form')
            {!! Form::close() !!}

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
