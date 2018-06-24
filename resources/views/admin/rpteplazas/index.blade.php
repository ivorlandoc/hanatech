@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Consulta - Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
<link rel="stylesheet" href="{{ asset('assets/css/pages/tab.css') }}" />

<link href="{{ asset('assets/css/loading.css') }}" rel="stylesheet" type="text/css" />
    <style>
        @media (min-width:320px) and (max-width:425px){
            .popover.left{
                width:100px !important;
            }
        }
    </style>
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
        <li class="active">Consultas</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Consulta de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>


                <div class="panel-body"  >                   
                          
                        <!-- ================Tabs============= -->
                            <div class="nav-tabs-custom">

                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1" data-toggle="tab">Titular</a>
                                    </li>
                                    <li>
                                        <a href="#tab_2" data-toggle="tab">Plaza[Vacante]</a>
                                    </li>
                                    <li class="pull-right">
                                        <a href="#" class="text-muted">
                                            <i class="fa fa-gear"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="slim2" >
                                    <div class="tab-pane active" id="tab_1">                                        
                                             {{ Form::open(array( 'route' => ['getResutListaIndex'], 'method' => 'post', 'id' => 'frmindex','name' => 'frmindex'))}} 
                                                <input type="hidden" name="token" value="{{ csrf_token()}}">
                                                <div class="form-group">                            
                                                    <div class="input-group select2-bootstrap-append">                          
                                                                {!! Form::text('stri_search',null, ['class'=>'form-control','placeholder'=>'Buscar:: Dni | Apellidos |  Plaza','type'=>'search','id'=>'stri_search']) !!}                     
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" type="button" onclick="GetListaIndex()" data-select2-open="single-append-text">
                                                                        <span class="glyphicon glyphicon-search"></span>
                                                                    </button>
                                                                </span>
                                                    </div>
                                                </div>
                                            {!!Form::close()!!}   

                                            {{ Form::open(array( 'route' => ['getfichajob','1'], 'method' => 'post', 'id' => 'frmfichajob','name' => 'frmfichajob'))}}    
                                                <input type="hidden" name="txtdnificha" id="txtdnificha" value="">
                                                <input type="hidden" name="txtplazaficha" id="txtplazaficha" value="">
                                            {{ Form::close()}} 

                                             {{ Form::open(array( 'route' => ['getmovWindEmer','1','1','1','1'], 'method' => 'post', 'id' => 'frmmovwindowEmerg','name' => 'frmmovwindowEmerg'))}}    
                                                <input type="hidden" name="txtdnifichamov" id="txtdnifichamov" value="">
                                               <!-- <input type="text" name="txtplazafichamov" id="txtplazafichamov" value="">-->
                                            {{ Form::close()}} 
                                             <div id="msjerror"></div>
                                                <div class="table-responsive" >
                                                    <table  class="table dataTable no-footer dtr-inline">
                                                        <thead>
                                                            <tr class="filters">
                                                                    <th>#</th>                                                                 
                                                                    <th># PLAZA</th>
                                                                    <th>NIVEL</th> 
                                                                    <th># Dni</th> 
                                                                    <th>NOMBRES</th>
                                                                    <th>DEPENDENCIA</th>
                                                                    <th style="text-align: center;" colspan="2">ACCIONES</th> 
                                                                    <th style="text-align: center;">BAJA</th>                      
                                                            </tr>
                                                        </thead>
                                                        <tbody id="Divgetlistaindex"> 
                                                             <div class="loading">                                                           
                                                                <br>
                                                                <span>Loading</span>
                                                            </div>
                                                    </tbody>
                                                </table>                                
                                        </div> 


                                           
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">                                     
                                             {{ Form::open(array( 'route' => ['getDetallaMovimientos','1','1'], 'method' => 'post', 'id' => 'frmdetallamov','name' => 'frmdetallamov'))}} 

                                             <div class="form-group">                            
                                                <div class="input-group select2-bootstrap-append"> 

                                                     {!! Form::text('searchPlazaForRpte',null, ['class'=>'form-control','placeholder'=>'# de Plaza','type'=>'search','id'=>'searchPlazaForRpte']) !!} 
                                                            <input type="hidden" name="x_token" value="{{ csrf_token()}}">                   
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text" onclick="GetEstadoPlazahead()">
                                                                    <span class="glyphicon glyphicon-search"></span>
                                                                </button>
                                                            </span>                                                      
                                                </div>
                                            </div>
                                            {!!Form::close()!!} 


                                            {{ Form::open(array( 'route' => ['getdatallemovdet','1','1','1'], 'method' => 'post', 'id' => 'frmplazamovdet','name' => 'frmplazamovdet'))}} 
                                                <input type="hidden" name="txtplazamovdet" id="txtplazamovdet" value="">
                                            {{ Form::close()}}
                                            <!--  ====================== -->
                                                <!-- <div style="border:1px solid black">-->
                                                    
                                                    <div id="msjerrormov" > </div>
                                                    <div id="IdGetShowEstadoPlaza" > </div>
                                                    <div id="msjerrormovdet" > </div>
                                                    <div id="IdGetShowEstadoPlazaDet" >                                                                
                                                         <div class="loading">                                                           
                                                            <br>
                                                            <span>Loading</span>
                                                        </div>
                                                    </div>
                                                  
                                               <!-- </div>-->
                                            <!-- ================== -->
                                        
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>



                        <!-- =================================  -->


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
                                        <h5 class="modal-title"><div id="IdHeadDetMov"></div></h5>
                            </div>
                            <div class="modal-body">
                                <div id="divmsjeerror"></div>
                                <div class="row">
                                    <div class="table-responsive" >
                                        <div id="headficha"></div>
                                            <table  class="table dataTable no-footer dtr-inline" style="border:0">
                                                <!--<thead id="headTR"></thead>-->
                                                <tbody id="IdShowDetailsMov">                                                
                                                        <div class="loading">
                                                            <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                                            <br>
                                                            <span>Loading</span>
                                                        </div>
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


<script type="text/javascript" src="{{ asset('assets/js/api-rpteplaza.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
<script src="{{ asset('assets/js/pages/tabs_accordions.js') }}" type="text/javascript"></script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>

@stop