<?php $__env->startSection('title'); ?>
Lista de Cargos
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Cargos</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#">Cargos</a></li>
        <li class="active">Lista de Cargos</li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Lista de Cargos
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table table-bordered width100" id="table">
                    <thead>
                        <tr class="filters">
                            <th>#</th>
                             <th>CLASIFICACION</th>
                            <th>#-NIVEL</th>
                            <th>N.OCUPACIONAL</th>
                            <th>C.CARGO</th>
                            <th>DESCRIPCION</th>
                            <th>C.ANT.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0;?> 
                         <?php $__currentLoopData = $getAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getA): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                            <?php $i++;?>        
                                <tr>
                                    <td><?php echo e($i); ?></td>
                                    <td><?php echo e($getA->TipoCargo); ?></td>
                                    <td><?php echo e($getA->IdNivel); ?></td>
                                    <td><?php echo e($getA->Nivel); ?></td>
                                    <td><?php echo e($getA->IdCargo); ?></td>
                                    <td><?php echo e($getA->Descripcion); ?></td> 
                                    <td><?php echo e($getA->CodigoAnt); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                    </tbody>
                </table>
                <?php echo e($getAll->render()); ?>

                </div>
            </div>
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
<script>
$(function () {
	$('body').on('hidden.bs.modal', '.modal', function () {
		$(this).removeData('bs.modal');
	});
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>