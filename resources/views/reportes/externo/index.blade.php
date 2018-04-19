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

 <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/css/all.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/iCheck/css/line/line.css') }}"/>
<!--<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/bootstrap-switch/css/bootstrap-switch.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/switchery/css/switchery.css') }}"/>-->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/awesomeBootstrapCheckbox/awesome-bootstrap-checkbox.css') }}"/>



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
                     {{ Form::open(array( 'route' => ['getdata-result'], 'method' => 'post', 'id' => 'frmexter','name' => 'frmexter'))}}  
                        <input type="hidden" name="token" value="{{ csrf_token()}}">
                        <div class="form-group">                            
                            <div class="input-group select2-bootstrap-append">  
                                    <span class="input-group-btn"> 
                                         <button class="btn btn-default" type="button" data-select2-open="single-append-text" >
                                       <input type="checkbox"  id="idcheckbox1" />  Plaza <!-- class="flat-red"-->
                                        </button>
                                      
                                    </span>                                                          
                                    {!! Form::text('stri_search_ext',null, ['class'=>'form-control','placeholder'=>'Buscar:: Dni | Apellidos','type'=>'search','id'=>'stri_search_ext','style'=>'height:36px']) !!}                     
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="_getdataParaShow()" data-select2-open="single-append-text" style="height:36px">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </span>  

                                     <span class="input-group-btn">
                                        <button class="btn btn-default" type="button" onclick="imprimir()" data-select2-open="single-append-text" style="height:36px">
                                            <span class="glyphicon glyphicon-print"></span>
                                        </button>
                                    </span>

                            </div>
                             <input type="hidden" name="idhidden" id="idhidden" value="1">
                        </div>
                         
                    {!!Form::close()!!}   
                                       
                    <div id="msjerror"></div>
                        <div id="idalldatos"></div> 
                        <!-- ========================= --> 
                        <div id="divgetdataexter"></div>
                         <div id="IdGetShowEstadoPlazaDet"></div>
                        
                        <div id="divreturn" style="display:none;">                            
                        </div>
                 
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

 <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
   <!-- <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/bootstrap-switch/js/bootstrap-switch.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/switchery/js/switchery.js') }}" ></script>
    <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/bootstrap-maxlength/js/bootstrap-maxlength.js') }}"></script>-->
    <script language="javascript" type="text/javascript" src="{{ asset('assets/vendors/card/lib/js/jquery.card.js') }}"></script>
    <script language="javascript" type="text/javascript" src="{{ asset('assets/js/pages/radio_checkbox.js') }}"></script>



<script type="text/javascript" src="{{ asset('assets/js/js-consultexterna.js') }}"></script>
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