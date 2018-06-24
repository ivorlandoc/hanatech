@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Población
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/css/pages/icon.css') }}" rel="stylesheet" type="text/css" />
@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Población Por Dependencia </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Población Por Dependencia</a></li>
        <li class="active">Población</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">

        <div class="row">
                <div class="col-md-6">
                    <!--md-6 starts-->
                    <!--validation states starts-->
                    <div class="panel panel-info" id="hidepanel4">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="livicon" data-name="rocket" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                Origen
                            </h3>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up clickable"></i>
                                        <!--<i class="glyphicon glyphicon-remove removepanel clickable"></i>-->
                                    </span>
                        </div>
                        <div class="panel-body">
                            <form name="frmChangeStruct" id="frmChangeStruct" id="frmChangeStruct" action="#">                           
                                <input type="hidden" name="token" value="{{ csrf_token()}}">
                                <div class="form-group">                            
                                    <div class="input-group select2-bootstrap-append">  
                                         <input type="search" class="form-control" id="string_search_ChangeStru" name="string_search_ChangeStru" placeholder="Apellidos | #Dni">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" data-select2-open="single-append-text" onclick="serach_ ()">
                                                        <span class="glyphicon glyphicon-search"></span>
                                                    </button>
                                                </span>
                                    </div>
                                </div>
                            </form>
                  
                            <div class="table-responsive"  id="DivContentSearchStruct">
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                                <th>#</th>
                                                <th>DEPENDENCIA</th>
                                                <th>CARGO</th> 
                                                <th>NOMBRES</th>                                                           
                                                <th style="text-align:center;">ACCIÓN</th>                       
                                        </tr>
                                    </thead>
                                    <tbody id="IdSearchChangeEstru">                                    
                                           
                                    </tbody>
                                </table>
                                <div style="text-align:right"></div>
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
                                Destino
                            </h3>
                                    <span class="pull-right">
                                        <i class="glyphicon glyphicon-chevron-up clickable"></i>
                                        <!--<i class="glyphicon glyphicon-remove removepanel clickable"></i>-->
                                    </span>
                        </div>
                        <div class="panel-body">
                             <div id="IdMensajeAlert"></div>
                           {{ Form::open(array('route' =>['save-change-estr-per','0','1'], 'method' => 'post', 'id' => 'frmChangeEstr','name' => 'frmChangeEstr'))}} 
                      
                           <input type="hidden" name="idUserSession" value="{{ $idUserSession }}">                            
                                     <input type="hidden" name="token" value="{{ csrf_token()}}">
                                   <!-- <div class="form-group">                                
                                        <select id="sel1" name="sel1" class="form-control">
                                            <option value="">Elegir ---</option>
                                           
                                        </select>
                                    </div>-->

                                    <div class="form-group">                                    
                                        <select id="sel2" name="sel2" class="form-control">
                                            <option value="">Elegir</option>
                                             @foreach ($getDosDig as $getAll) 
                                            <option value="{{ $getAll->IdEstructura }}">{{ $getAll->IdEstructura }} | {{ $getAll->Descripcion }}</option>
                                            @endforeach 

                                        </select>
                                    </div>

                                    <div class="form-group">                                  
                                        <select id="sel3" name="sel3" class="form-control" >
                                            <option value="">Elegir</option>
                                        </select>
                                    </div>

                                    <div class="form-group">                                    
                                        <select id="sel4" name="sel4" class="form-control">
                                            <option value="">Elegir</option>
                                        </select>
                                    </div>

                                    <div class="form-group">                                       
                                        <select id="sel5" name="sel5" class="form-control">
                                            <option value="">Elegir</option>
                                        </select>                                     
                                    </div>

                                     <div class="form-group">                                       
                                        <select id="sel6" name="sel6" class="form-control" onclick="setFlagFive()">
                                            <option value="">Elegir</option>
                                        </select>
                                        <input type="hidden" name="txtidplaza" id="txtidplaza">
                                    </div>


                                    <div id="groupChanger" style="display:block;">
                                        <div class="form-group"> 
                                            <input type="text" name="txtreferencia" id="txtreferencia" class="form-control" placeholder="Ingrese el doc. de referencia">
                                        </div>

                                        <div class="form-group">  
                                            <input type="date" name="txtfechadoc" id="txtfechadoc" class="form-control" placeholder="Ingrese la fecha de Doc.">
                                        </div>

                                        <div class="form-group">
                                        <!--<label for="formPassword">Adjuntar Documento.</label>-->
                                        <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                                <div class="form-control" data-trigger="fileinput">
                                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                    <span class="fileinput-filename"></span>
                                                </div>
                                                        <span class="input-group-addon btn btn-default btn-file">
                                                            <span class="fileinput-new">Selecione Archivo</span>
                                                            <span class="fileinput-exists">Cambiar</span>
                                                            <input type="file" name="FileAdjuntoChange" id="FileAdjuntoChange" readonly="" accept="*.pdf"></span>
                                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>

                              {{ Form::close()}} 
                           
                            <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                                <th>#</th>                                                
                                                <th>CARGO</th> 
                                                <th>NOMBRES</th>                                                          
                                                                      
                                        </tr>
                                    </thead>
                                    <tbody id="IdSearchChangeEstruDest">                                    
                                          
                                    </tbody>
                                </table>
                                <div style="text-align:right"></div>
                            </div>


                        </div>
                </div>
            </div>

            <!--   =================    -->
        <!--</div>-->
    </div>    <!-- row-->
</section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/jquery.dataTables.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/datatables/js/dataTables.bootstrap.js') }}" ></script>

    <script type="text/javascript" src="{{ asset('assets/js/api-changeStruct.js') }}"> </script>


    <div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    	<div class="modal-dialog">
        	<div class="modal-content"></div>
        </div>
    </div>
<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>

<script>    
    $(function () {
    	$('body').on('hidden.bs.modal', '.modal', function () {
    		$(this).removeData('bs.modal');
    	});
    });
</script>
@stop