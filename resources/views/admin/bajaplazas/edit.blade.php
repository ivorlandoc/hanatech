@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
Baja de Plazas
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
<!--
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/datatables/css/dataTables.bootstrap.css') }}" />
<link href="{{ asset('assets/css/pages/tables.css') }}" rel="stylesheet" type="text/css" />

 <link href="{{ asset('assets/vendors/modal/css/component.css') }}" rel="stylesheet"/>
 <link href="{{ asset('assets/css/pages/advmodals.css') }}" rel="stylesheet"/>
-->
    <link href="{{ asset('assets/vendors/daterangepicker/css/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/vendors/clockface/css/clockface.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}" rel="stylesheet" type="text/css" />

        <link rel="stylesheet" href="{{ asset('assets/vendors/Buttons/css/buttons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/pages/advbuttons.css') }}" />

@stop


{{-- Page content --}}
@section('content')
<section class="content-header">
    <h1>Baja de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Baja de Plazas</a></li>
        <li class="active">Plazas</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Baja de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">                 

                        <!--  ===============diseño del formulari0====================== -->
                
                    <!--  ===============Hasta aqui el diseño del formulario========= -->

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


<!--
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>
-->

<!-- begining of page level js -->

<script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/daterangepicker/js/daterangepicker.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/clockface/js/clockface.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" type="text/javascript"></script>


<script src="{{ asset('assets/js/pages/datepicker.js') }}" type="text/javascript"></script>
<!-- end of page level js -->

<script type="text/javascript" src="{{ asset('assets/vendors/Buttons/js/scrollto.js') }}" ></script>
<script type="text/javascript" src="{{ asset('assets/vendors/Buttons/js/buttons.js') }}" ></script>

<script type="text/javascript" src="{{ asset('assets/js/bajaPlaza.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/modal/js/classie.js')}}"></script>

 <!--social buttons-->
    <script type="text/javascript">
        $(function () {
            var all_classes = "";
            var timer = undefined;
            $.each($('li', '.social-class'), function (index, element) {
                all_classes += " btn-" + $(element).data("code");
            });
            $('li', '.social-class').mouseenter(function () {
                var icon_name = $(this).data("code");
                if ($(this).data("icon")) {
                    icon_name = $(this).data("icon");
                }
                var icon = "<i class='fa fa-" + icon_name + "'></i>";
                $('.btn-social', '.social-sizes').html(icon + "Sign in with " + $(this).data("name"));
                $('.btn-social-icon', '.social-sizes').html(icon);
                $('.btn', '.social-sizes').removeClass(all_classes);
                $('.btn', '.social-sizes').addClass("btn-" + $(this).data('code'));
            });
            $($('li', '.social-class')[Math.floor($('li', '.social-class').length * Math.random())]).mouseenter();
        });
    </script>
@stop