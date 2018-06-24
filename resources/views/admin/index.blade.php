@extends('admin/layouts/default')

{{-- Page title --}}
@section('title')
    Home | Hanatech
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')


    <link rel="stylesheet" href="{{ asset('assets/vendors/animate/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/only_dashboard.css') }}"/>
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/morrisjs/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/dashboard2.css') }}"/>
 
    <!-- Añadido por icorlando -->
     <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <!-- fin  -->
@stop

{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>Bienvenido al Dashboard   <span class="hidden-xs header_info"></span></h1>

        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="livicon" data-name="home" data-size="16" data-color="#333" data-hovercolor="#333"></i>
                    Dashboard
                </a>
            </li>
        </ol>
    </section>

    <section class="content">
       <!--
        @if ($analytics_error != 0)
            <div class="alert alert-danger alert-dismissable margin5">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error:</strong> You Need to add Google Analytics file for full working of the page
            </div>
        @endif
        -->
        <div class="row ">
            <div class="col-md-8 col-sm-7 no_padding">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="panel panel-border main_chart">
                            <div class="panel-heading ">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="barchart" data-size="16" data-loop="true" data-c="#EF6F6C" data-hc="#EF6F6C"></i><!-- Estadísticas de usuarios--> Altas y bajas
                                </h3>
                            </div>
                             <?php $chart_data="";?>

                                    @foreach($data as $key )
                                        <?php { $chart_data .= "{ month:'".$key->FechaMov."', alta:".$key->alta.", baja:".$key->baja."}, "; } ?>                                    
                                    @endforeach
                                    <?php $chart_data = substr($chart_data, 0, -2); // echo $chart_data;   ?>
                            <div class="panel-body nopadmar users">                               
                              <!--  {!! $db_chart->html() !!} -->
                               <div id="chart"></div>
                                
                            </div>
                            <script>                               
                                function morrisArea(){                                   
                                    Morris.Area({
                                    element : 'chart',
                                     data:[<?php echo $chart_data; ?>],
                                     xkey:'month',
                                     ykeys:['alta', 'baja'],
                                     labels:['Altas', 'Bajas'],
                                     parseTime:true,
                                     hideHover:'auto',
                                     pointFillColors:['#a5e4d5','#5fcab3'], //lineColors: 
                                     lineColors:['#5fcab3','#a5e4d5','#dd7f7e'],  // fillOpacity:0.5,                                    
                                     stacked:true,   //lineWidth:'2px',
                                     resize: true,                                     
                                     xLabelFormat : function (month) { return (month.getMonth()+1);}
                                    });
                                }
                                morrisArea();

                                </script>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="panel panel-border roles_chart">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#F89A14"
                                       data-hc="#F89A14"></i>
                                    <!-- Roles del usuario-->Plazas Vacantes
                                </h4>

                            </div>
                            <div class="panel-body nopadmar">
                               {!! $user_roles->html() !!} 

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="panel panel-border roles_chart">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="livicon" data-name="barchart" data-size="16" data-loop="true" data-c="#67C5DF"
                                       data-hc="#67C5DF"></i>
                                    <!--Visitantes anuales--> Plazas | Presupuesto
                                </h4>

                            </div>
                            <div class="panel-body nopadmar">
                                <div id="bar_chart">
                                <!-- {!! $line_chart->html() !!} -->
                                  {!! $porc->html() !!}
                                </div>                              
                               
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="col-md-12 ">
                        <div class="panel panel-border map">

                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="map" data-size="16" data-loop="true" data-c="#515763"
                                       data-hc="#515763"></i>
                                    Users from countries
                                </h3>

                            </div>
                            <div class="panel-body nopadmar">
                                {!! $geo->html() !!}
                            </div>
                        </div>
                    </div>-->
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-5">
                <div class="panel panel-border">
                    <div class="panel-heading border-light">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="users" data-size="18" data-color="#00bc8c" data-hc="#00bc8c"
                               data-l="true"></i>
                            Plazas a Nivel Nacional
                        </h3>
                    </div>
                    <div class="panel-body nopadmar users" >
                        <div class="table-responsive">
                            <table  class="table dataTable no-footer dtr-inline small">                                  
                                @foreach($pobla as $user )  
                                    <tr>
                                        <td>{{ $user->red }}</td>
                                        <td class="text-right">{{ $user->Plaza }}</td>
                                   </tr>
                                @endforeach                        
                            </table>
                            {{$pobla->render()}}                            
                        </div>

                        <!-- @foreach($users as $user )
                            <div class="media">
                                <div class="media-left">
                                    @if($user->pic)
                                    <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" class="media-object img-circle" >
                                    @else
                                        <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" class="media-object img-circle" >
                                     @endif
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading">{{ $user->full_name }}</h5>
                                    <p>{{ $user->email }}  <span class="user_create_date pull-right">{{ $user->created_at->format('d M') }} </span></p>
                                </div>
                            </div> 
                        @endforeach-->

                    </div>
                </div>
                <div class="panel panel-border">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="livicon" data-name="eye-open" data-size="16" data-loop="true" data-c="#EF6F6C"
                               data-hc="#EF6F6C"></i>
                            Usuarios Conectados
                        </h4>

                    </div>
                    <div class="panel-body nopadmar">
                        <div id="visitors_chart">                            
                            @foreach($users as $user )
                                <div class="media">
                                    <div class="media-left">
                                        @if($user->pic)
                                        <img src="{!! url('/').'/uploads/users/'.$user->pic !!}" class="media-object img-circle" >
                                        @else
                                            <img src="{{ asset('assets/images/authors/no_avatar.jpg') }}" class="media-object img-circle" >
                                         @endif
                                    </div>
                                    <div class="media-body">
                                        <h5 class="media-heading">{{ $user->full_name }}</h5>
                                        <p>{{ $user->email }}  <span class="user_create_date pull-right">{{ $user->created_at->format('d M') }} </span></p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                         
                    </div>
                </div>
                <!-- ================ -->



               
            </div>
        </div>
    </section>
    <div class="modal fade" id="editConfirmModal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Alerta</h4>
                </div>
                <div class="modal-body">
                    <p>Ya está editando una fila, debe guardar o cancelar esa fila antes de editar / eliminar una nueva fila</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/vendors/moment/js/moment.min.js') }}"></script>
    <!--for calendar-->
    <script src="{{ asset('assets/vendors/moment/js/moment.min.js') }}" type="text/javascript"></script>
    <!-- Back to Top-->
    <script type="text/javascript" src="{{ asset('assets/vendors/countUp_js/js/countUp.js') }}"></script>
    <script src="http://demo.lorvent.com/rare/default/vendors/raphael/js/raphael.min.js"></script>

     <script src="{{ asset('assets/vendors/morrisjs/morris.min.js') }}"></script>


    <script>
        var useOnComplete = false,
            useEasing = false,
            useGrouping = false,
        options = {
            useEasing: useEasing, // toggle easing
            useGrouping: useGrouping, // 1,000,000 vs 1000000
            separator: ',', // character to use as a separator
            decimal: '.' // character to use as a decimal
        };
        var demo = new CountUp("myTargetElement1", 12.52, {{ $pageVisits }}, 0, 6, options);
        demo.start();
       
        var demo = new CountUp("myTargetElement3", 24.02, {{ $visitors }}, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement4", 125, {{ $user_count }}, 0, 6, options);
        demo.start();
       
        var week_data = {!! $month_visits !!};
        var year_data = {!! $year_visits !!};

        function lineChart() {
            Morris.Line({
                element: 'visitors_chart',
                data: week_data,
                lineColors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)', 'rgb(96, 125, 139)'],//['#418BCA', '#00bc8c', '#EF6F6C'],
                xkey: 'date',
                ykeys: ['pageViews', 'visitors'],
                labels: ['pageViews', 'visitors'],
                pointSize: 0,
                lineWidth: 2,
                resize: true,
                fillOpacity: 1,
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                hideHover: 'auto'

            });
        }
        function barChart() {
            Morris.Bar({
                element: 'bar_chart',
                data: year_data.length ? year_data :   [ { label:"No Data", value:100 } ],
                barColors: ['rgb(233, 30, 99)', 'rgb(0, 188, 212)', 'rgb(255, 152, 0)', 'rgb(0, 150, 136)', 'rgb(96, 125, 139)'], //['#418BCA', '#00bc8c'],
                xkey: 'date',
                ykeys: ['pageViews', 'visitors'],
                labels: ['pageViews', 'visitors'],
                pointSize: 0,
                lineWidth: 2,
                resize: true,
                fillOpacity: 0.4,
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                hideHover: 'auto'
            });
        }
        lineChart();
        barChart();       
        $(".sidebar-toggle").on("click",function () {
            setTimeout(function () {
                $('#visitors_chart').empty();
                $('#bar_chart').empty();
                lineChart();
                barChart();                     
            },10);
        });

    </script>
    {!! Charts::scripts() !!}
    {!! $db_chart->script() !!}
    {!! $geo->script() !!}
    {!! $user_roles->script() !!}
   

    {!! $porc->script() !!}

@stop