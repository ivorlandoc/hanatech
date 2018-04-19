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


                <div class="panel-body">                   
 
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
                                <div class="tab-content" id="slim2" style="height:730px; border:0px solid red" >
                                    <div class="tab-pane active" id="tab_1">
                                        

                                            {!! Form::open(['route'=>'admin.rpteplazas.index','method'=>'GET','id'=>'movplazas']) !!}
                                                <input type="hidden" name="token" value="{{ csrf_token()}}">
                                                <div class="form-group">                            
                                                    <div class="input-group select2-bootstrap-append">                          
                                                                {!! Form::text('stri_search',null, ['class'=>'form-control','placeholder'=>'Buscar:: Dni | Apellidos |  Plaza','type'=>'search','id'=>'stri_search']) !!}                     
                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                                        <span class="glyphicon glyphicon-search"></span>
                                                                    </button>
                                                                </span>
                                                    </div>
                                                </div>
                                            {!!Form::close()!!}   
                                       

                                                <div class="table-responsive" >
                                                    <table  class="table dataTable no-footer dtr-inline">
                                                        <thead>
                                                            <tr class="filters">
                                                                    <th>#</th>
                                                                    <!--<th>CARGO</th> -->
                                                                    <th># PLAZA</th>
                                                                    <th>NIVEL</th> 
                                                                    <th># Dni</th> 
                                                                    <th>NOMBRES</th>
                                                                    <th>DEPENDENCIA</th>
                                                                    <th style="text-align: center;" colspan="2">ACCIONES</th> 
                                                                    <th style="text-align: center;">BAJA</th>                      
                                                            </tr>
                                                        </thead>
                                                        <tbody > 

                                                         <?php $i=0; $plaz=""; $_dni=""; $html='<p class="text-danger">.text-danger</p>';?>  

                                                            @foreach($DataM as $Data) 
                                                            <?php $i++;                                                               
                                                                $plaz=$Data->NroPlaza;
                                                                $_dni=$Data->dni;
                                                                ?>                                           
                                                            <tr>
                                                                <td>{{$i}}</td>                                                                
                                                                <!-- <td>{{$Data->cargo}}</td>  -->
                                                                <td><?php if($Data->NroPlaza =="") { ?> <p class="text-danger"><b>INACTIVO</b></p><?php } else { ?>  {{ $plaz }}<?php }?></td> 
                                                                <td>{{$Data->IdNivel}}</td>                                                              
                                                                 <td>{{$Data->dni}}</td>
                                                                <td>{{$Data->nom}} </td>
                                                                <td>{{$Data->sede}} - {{$Data->dependencia}}</td> 
                                                                
                                                                <td>
                                                                    <a data-href="#responsive" href="#responsive" onclick=GetDetalleGeneralPlaza("{{$plaz}}","{{$_dni}}") class="btn btn-info btn-sm btn-responsive" role="button" data-toggle="modal" >
                                                                            <span class="livicon" data-name="signal" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>
                                                                            <br/> Detalle
                                                                        </a>

                                                                </td>                                               
                                                                <td>  
                                                                    <a data-href="#responsive" href="#responsive" onclick=ShowHistoriaMov("{{$plaz}}","{{$_dni}}") class="btn btn-warning btn-sm btn-responsive" role="button" data-toggle="modal"><!-- -->
                                                                            <span class="livicon" data-name="notebook" data-size="14" data-loop="true" data-c="#fff" data-hc="white"></span>
                                                                            <br/> Movimientos
                                                                        </a>
                                                                </td>

                                                                <td>  
                                                                  
                                                                   <div class="ui-group-buttons">                                                                      
                                                                         <a href="{{ URL::to('admin/bajaplazas') }}?z={{$plaz}}" class="btn btn-danger btn-lg"> </i> Baja</a>
                                                                    </div>
                                                                </td>

                                                            </tr>
                                                            @endforeach   
                                                    </tbody>
                                                </table>                                
                                        </div> 


                                           
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2">                                     
                                

                                             <div class="form-group">                            
                                                <div class="input-group select2-bootstrap-append">                          
                                                     {!! Form::text('searchPlazaForRpte',null, ['class'=>'form-control','placeholder'=>'# de Plaza','type'=>'search','id'=>'searchPlazaForRpte']) !!} 
                                                            <input type="hidden" name="x_token" value="{{ csrf_token()}}">                   
                                                            <span class="input-group-btn">
                                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                                    <span class="glyphicon glyphicon-search"></span>
                                                                </button>
                                                            </span>
                                                      {!!Form::close()!!} 
                                                </div>
                                            </div>
                                            <!--  ====================== -->
                                                 <div class="table-responsive" >
                                                    <table  class="table dataTable no-footer dtr-inline">
                                                        <thead>   
                                                            <div id="IdGetShowEstadoPlaza" >                                                                
                                                               
                                                            </div>
                                                            <div id="IdGetShowEstadoPlazaDet" >                                                                
                                                                 <div class="loading">
                                                                   
                                                                    <br>
                                                                    <span>Loading</span>
                                                                </div>
                                                            </div>
                                                        </thead>
                                                    </table>
                                                </div>
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
                                <div class="row">
                                    <div class="table-responsive" >
                                            <table  class="table dataTable no-footer dtr-inline">
                                                <thead id="headTR">
                                                   
                                                </thead>
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