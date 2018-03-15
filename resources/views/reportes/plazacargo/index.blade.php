@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Reporte  - Plazas x Cargo
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
@stop

{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Plazas por Cargo</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#">Plazas por Cargo</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Plazas por Cargo
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>


                <div class="panel-body">                   
                        <!-- ================Tabs============= -->                                                         
                         <div class="form-group">                        
                           <!--<form class="form-inline" id="form-plzcar" name="form-plzcar" action="get-plaza-cargo">-->
                            {{ Form::open(array( 'route' => 'get-plaza-cargo', 'method' => 'post', 'id' => 'form-plzcar','name' => 'form-plzcar'))}}
                                <input type="hidden" name="token" value="{{ csrf_token()}}">
                                  <div class="form-group">                                   
                              <select id="idregimen" class="form-control select2" name="idregimen" onchange="ajaxLoad()">
                                            <option value="">Elige el Régimen</option>                                                                                         
                                             @foreach($dataR as $keys) 
                                                <option value="{{ $keys->IdRegimen }}">{{ $keys->IdRegimen }} | {{ $keys->Sigla }}</option>
                                            @endforeach                                   
                                            
                                      </select>
                                  </div>
                                    
                           {{ Form::close()}}
                        </div>
                        
                        <!--
                        <div class="pull-right">
                          <div class="input-group">
                              <input class="form-control" id="search"
                                     value="{{ request()->session()->get('search') }}"
                                     onkeydown="if (event.keyCode == 13) ajaxLoad('{{url('posts')}}?search='+this.value)"
                                     placeholder="Search Title" name="search"
                                     type="text" id="search"/>
                              <div class="input-group-btn">
                                  <button type="submit" class="btn btn-primary"
                                          onclick="ajaxLoad('{{url('posts')}}?search='+$('#search').val())">
                                          <i class="fa fa-search" aria-hidden="true"></i>
                                  </button>
                              </div>
                          </div>

                        </div>-->

                        <!-- ************************** -->
                              <div class="panel-body">
                                  <div class="table-responsive">                                
                                  <table class="table table-bordered width100" id="table">
                                      <thead>
                                           <tr>
                                              <th colspan="9" id="headmsje-PlazaCargo"> 

                                              </th>                                             
                                          </tr>
                                          <tr class="filters">
                                              <th>#</th>
                                              <th>NIVEL</th>                                             
                                              <th>CARGO</th>
                                              <th>ACTIVAS</th>
                                              <th>VACANTES</th>
                                              <th>INACTIVAS</th>
                                              <th>R.JUDICIAL</th>
                                              <th>R.O.ACC</th>
                                              <th>TOTAL</th>
                                          </tr>
                                      </thead>
                                      <tbody id="allplazasCargo">

                                         
                                        <div class="loading">
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


<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>


<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
<script type="text/javascript" src="{{ asset('assets/js/js-plazas-por-cargo.js') }}"> </script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>

@stop