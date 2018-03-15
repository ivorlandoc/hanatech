@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Consulta - Persona
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--
    <link href="{{ asset('assets/css/pages/timeline.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/pages/timeline2.css') }}" rel="stylesheet" />
-->

    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/iCheck/css/all.css') }}"  rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

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
    <h1>Consulta de Persona</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#">Consulta de Persona</a></li>
        <li class="active">Consulta</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">      
            <!--   =================    -->

             <div class="col-md-6">
                    <!--md-6 starts-->
                    <!--validation states starts-->
                    <div class="panel panel-info" id="hidepanel4">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="rocket" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                Buscar
                            </h3>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up clickable"></i>
                                        <!--<i class="glyphicon glyphicon-remove removepanel clickable"></i>-->
                                    </span>
                        </div>
                        <div class="panel-body">


                              {!! Form::open(['route'=>'admin.rptetempo.index','method'=>'GET','id'=>'rptesTemp']) !!}
                                    <input type="hidden" name="token" value="{{ csrf_token()}}">
                                        <div class="form-group">                            
                                            <div class="input-group select2-bootstrap-append">                          
                                                    {!! Form::text('search_tempo',null, ['class'=>'form-control','placeholder'=>'Buscar:: Dni | Apellidos |  # Plaza','type'=>'search','type'=>'search']) !!}                     
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
                                                <th>#PLAZA</th> 
                                                <th>NOMBRES</th>                           
                                            </tr>
                                        </thead>
                                        <tbody >                                              
                                         <?php $i=0; 
                                                $xplaza="0";
                                         ?>                                          
                                            @foreach($DataM as $Data) 
                                            <?php $i++; 
                                                    $xplaza=$Data->nro_plaza;
                                            ?>   

                                            <tr>
                                                <td>{{$i}}</td>
                                                <td>
                                                    <a href="#" onclick =GetDataTempo("{{$xplaza}}") class="btn btn-info btn-sm btn-responsive" role="button" data-toggle="modal" > {{$Data->nro_plaza}}</a>
                                                </td>
                                                 
                                                <td>{{$Data->nombres}} </td>
                                                </tr>
                                                @endforeach   
                                        </tbody>
                                    </table>                             
                                    <!-- /.tab-pane -->
                                    {{$DataM->render()}}
                                </div>




                        </div>
                    </div>
                </div>
                <!--md-6 ends-->            

            <div class="col-md-6">
                <div class="panel panel-info" id="hidepanel3">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="leaf" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                Datos Informativos
                            </h3>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up clickable"></i>
                                        <!--<i class="glyphicon glyphicon-remove removepanel clickable"></i>-->
                                    </span>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" action="#">
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtdni">DNI </label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtdni" name="txtdni" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtape">NOMBRES </label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtape" name="txtape" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtorg">ORGANO</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtorg" name="txtorg" class="form-control" readonly >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtcentro">CENTRO</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtcentro" name="txtcentro" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtdep">DEPENDENCIA</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtdep" name="txtdep" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtnivel">NIVEL | CARGO</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtnivel" name="txtnivel" class="form-control" readonly>
                                    </div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtcargo">CARGO</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtcargo" name="txtcargo" class="form-control" readonly>
                                    </div>
                                </div>
                                -->
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtplaza">#PLAZA</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtplaza" name="txtplaza" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtreg">RÉGIMEN</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtreg" name="txtreg" class="form-control" readonly>
                                    </div>
                                </div>

                                  <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtreso">RESOLUCIÓN</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtreso" name="txtreso" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtobs">OBSERVACIÓN</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtobs" name="txtobs" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="txtotros">OTROS</label>
                                    <div class="col-md-9">
                                        <input type="text" id="txtotros" name="txtotros" class="form-control" readonly>
                                    </div>
                                </div>

                                    <!--
                                        <ul class="nav nav-list">                                             
                                                <label for="formPassword" class="sm-info">DNI | APELLIDOS Y NOMBRES</label>
                                                    <li><a tabindex="-1" href="#" id="dniApe"></a></li>
                                           
                                                <li class="divider"></li>  
                                                <label for="formPassword">ORGANO | CENTRO | DEPENDENCIA</label>                                                
                                                     <li><a tabindex="-1" href="#" id="htmlorgano"></a></li>
                                                    
                                                     <li><a tabindex="-1" href="#" id="htmldependencia"></a></li>

                                                <li class="divider"></li>
                                                <label for="formPassword">RÉGIMEN | #PLAZA </label>
                                                    <li><a tabindex="-1" href="#" id="htmlregimen"></a></li>
                                                    <li><a tabindex="-1" href="#" id="htmlplaza"></a></li> 

                                                <label for="formPassword">NIVEL | CARGO </label>                                                  
                                                    <li><a tabindex="-1" href="#" id="htmlnivel"></a></li>
                                                    

                                                 <li class="divider"></li>                                                
                                                 <label for="formPassword">RESOLUCIÓN | OBSERVACIÓN</label>
                                                    <li><a tabindex="-1" href="#" id="htmlresu"></a></li>
                                                    <li><a tabindex="-1" href="#" id="htmlobs"></a></li>
                                                 <li class="divider"></li>                                                
                                                 <label for="formPassword">OTROS</label>
                                                    <li><a tabindex="-1" href="#" id="htmldetalle"></a></li> 
                                        </ul>
                                    -->
                                </form>

                        </div>
                </div>
            </div>



            <!-- ===============================  -->
        </div>
    </div>    <!-- row-->
</section>
        <!-- =======================================  -->
@stop

{{-- page level scripts --}}
@section('footer_scripts')
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

<!-- 
 <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
    <script src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form_examples.js') }}"></script>
-->

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>


<script type="text/javascript" src="{{ asset('assets/js/api-tempo.js') }}"></script>
<!--<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>
<script src="{{ asset('assets/js/pages/tabs_accordions.js') }}" type="text/javascript"></script>
-->
<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>


@stop