<?php $__env->startSection('title'); ?>
    Home
    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>


    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/animate/animate.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/pages/only_dashboard.css')); ?>"/>
    <meta name="_token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/vendors/morrisjs/morris.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/pages/dashboard2.css')); ?>"/>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

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
        <?php if($analytics_error != 0): ?>
            <div class="alert alert-danger alert-dismissable margin5">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <strong>Error:</strong> You Need to add Google Analytics file for full working of the page
            </div>
        <?php endif; ?>
        -->
        <div class="row ">
            <div class="col-md-8 col-sm-7 no_padding">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="panel panel-border main_chart">
                            <div class="panel-heading ">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="barchart" data-size="16" data-loop="true" data-c="#EF6F6C" data-hc="#EF6F6C"></i> Estadísticas de usuarios
                                </h3>
                            </div>
                            <div class="panel-body">
                                <?php echo $db_chart->html(); ?>


                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="panel panel-border roles_chart">

                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#F89A14"
                                       data-hc="#F89A14"></i>
                                    Roles del usuario
                                </h4>

                            </div>
                            <div class="panel-body nopadmar">
                                <?php echo $user_roles->html(); ?>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="panel panel-border">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <i class="livicon" data-name="barchart" data-size="16" data-loop="true" data-c="#67C5DF"
                                       data-hc="#67C5DF"></i>
                                    Visitantes anuales
                                </h4>

                            </div>
                            <div class="panel-body nopadmar">
                                <div id="bar_chart"></div>
                            </div>
                        </div>
                    </div>

                   <!-- <div class="col-md-12 ">
                        <div class="panel panel-border map">

                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    <i class="livicon" data-name="map" data-size="16" data-loop="true" data-c="#515763"
                                       data-hc="#515763"></i>
                                    Users from countries
                                </h3>

                            </div>
                            <div class="panel-body nopadmar">
                                <?php echo $geo->html(); ?>

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
                            Usuarios recientes
                        </h3>
                    </div>
                    <div class="panel-body nopadmar users">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="media">
                                <div class="media-left">
                                    <?php if($user->pic): ?>
                                    <img src="<?php echo url('/').'/uploads/users/'.$user->pic; ?>" class="media-object img-circle" >
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('assets/images/authors/no_avatar.jpg')); ?>" class="media-object img-circle" >
                                     <?php endif; ?>
                                </div>
                                <div class="media-body">
                                    <h5 class="media-heading"><?php echo e($user->full_name); ?></h5>
                                    <p><?php echo e($user->email); ?>  <span class="user_create_date pull-right"><?php echo e($user->created_at->format('d M')); ?> </span></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </div>
                </div>
                <div class="panel panel-border">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <i class="livicon" data-name="eye-open" data-size="16" data-loop="true" data-c="#EF6F6C"
                               data-hc="#EF6F6C"></i>
                            Esta semana los visitantes
                        </h4>

                    </div>
                    <div class="panel-body nopadmar">
                        <div id="visitors_chart"></div>
                    </div>
                </div>
               
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
<?php $__env->stopSection(); ?>


<?php $__env->startSection('footer_scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/moment/js/moment.min.js')); ?>"></script>
    <!--for calendar-->
    <script src="<?php echo e(asset('assets/vendors/moment/js/moment.min.js')); ?>" type="text/javascript"></script>
    <!-- Back to Top-->
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/countUp_js/js/countUp.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/vendors/morrisjs/morris.min.js')); ?>"></script>

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
        var demo = new CountUp("myTargetElement1", 12.52, <?php echo e($pageVisits); ?>, 0, 6, options);
        demo.start();
       
        var demo = new CountUp("myTargetElement3", 24.02, <?php echo e($visitors); ?>, 0, 6, options);
        demo.start();
        var demo = new CountUp("myTargetElement4", 125, <?php echo e($user_count); ?>, 0, 6, options);
        demo.start();
       
        var week_data = <?php echo $month_visits; ?>;
        var year_data = <?php echo $year_visits; ?>;

        function lineChart() {
            Morris.Line({
                element: 'visitors_chart',
                data: week_data,
                lineColors: ['#418BCA', '#00bc8c', '#EF6F6C'],
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
                barColors: ['#418BCA', '#00bc8c'],
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
    <?php echo Charts::scripts(); ?>

    <?php echo $db_chart->script(); ?>

    <?php echo $geo->script(); ?>

    <?php echo $user_roles->script(); ?>

    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>