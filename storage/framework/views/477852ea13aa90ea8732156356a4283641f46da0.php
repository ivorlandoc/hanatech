<?php $__env->startSection('title'); ?>
Consulta de Plazas
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('assets/css/loading.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Consulta de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Consulta de Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Consulta de Plazas 
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                <?php echo e(Form::open(array( 'route' => 'get-plaza-ejec', 'method' => 'post', 'id' => 'frmejec','name' => 'frmejec'))); ?>

                 <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">              
                        <div class="form-group"> 
                                <select id="select4" class="form-control select2" name="select4" onchange="LoadNomejec()">
                                <option value="">Todos</option>                                        
                                   <?php $__currentLoopData = $getDosDig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getAll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                       <option value="<?php echo e($getAll->IdEstructura); ?>"><?php echo e($getAll->IdEstructura); ?> - <?php echo e($getAll->Descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                </select>              
                        </div>
                        <!-- ==========draw table========== -->
                        <div class="panel-body">
                            <div class="table-responsive" >
                                <table  class="table dataTable no-footer dtr-inline">
                                    <thead>
                                        <tr class="filters">
                                            <th>#</th>                                           
                                            <th>CENTRO</th>
                                            <th>DEPENDENCIA</th>
                                            <th>AREA</th>
                                            <th>PLAZA</th>
                                            <th>#DNI</th>
                                            <th>NOMBRES</th>
                                            <th>CONDICIÓN</th>
                                            <th>F.INGRESO</th>                        
                                            <th>CARGO</th>                        
                                            <th>NIVEL</th>                        
                                            <th>ESTADO</th>                        
                                        </tr>
                                    </thead>
                                    <tbody id="showplazaejec">
                                        <div class="loading">
                                            <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                            <br>
                                            <span>Loading</span>
                                        </div>

                                    </tbody>
                                </table>
                            </div>
                        </div>                        
                        <!-- ================ -->                      
                    <?php echo e(Form::close()); ?>

                </div>

            </div>
            
           
            <!--   =================    -->

        </div>
    </div>    <!-- row-->
</section>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/jquery.dataTables.js')); ?>" ></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/dataTables.bootstrap.js')); ?>" ></script>



<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="<?php echo e(asset('assets/js/js-rpte-ejec.js')); ?>"> </script>
    

<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>