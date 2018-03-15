<?php $__env->startSection('title'); ?>
Nivel Ocupacional
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>´Niveles Ocupacionales</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Nivel Ocupacional</a></li>
        <li class="active">Lista Niveles </li>
    </ol>
</section>

<!-- Main content -->
<section class="content paddingleft_right15">
    <div class="row">
        <div class="panel panel-info">
            <div class="panel-heading">
                <h4 class="panel-title"> <i class="livicon" data-name="user" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                    Lista de Niveles Ocupacionales
                </h4>
            </div>
            <br />
            <div class="panel-body">
                <div class="table-responsive">
                <table class="table dataTable no-footer dtr-inline">
                    <thead>
                        <tr class="filters">
                            <th>#</th>
                            <th>DESCRIPCION</th>
                            <th>REMUN</th>
                            <th>BONIF</th>
                            <th>BONO-PROD</th>
                            <th>BONO-ALTA-RESP</th>
                            <th>BONO-EXTRAORD</th>
                            <th>BONO-ESP</th>
                            <th>TOTAL</th>                          
                        </tr>
                    </thead>
            <tbody><?php $total=0;?>
                  <?php $__currentLoopData = $getAllnivel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getAll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                        <?php $total=round($getAll->Remuneracion+$getAll->Bonif+$getAll->BonoProd+$getAll->BonoAltaResp+$getAll->BonoExtraord+$getAll->BonoEspecialidad,2) ?>          
                        <tr>
                            <td><?php echo e($getAll->IdNivel); ?></td>
                            <td><?php echo e($getAll->Descripcion); ?></td> 
                            <td><?php echo e($getAll->Remuneracion); ?></td>
                            <td><?php echo e($getAll->Bonif); ?></td>
                            <td><?php echo e($getAll->BonoProd); ?></td>
                            <td><?php echo e($getAll->BonoAltaResp); ?></td>
                            <td><?php echo e($getAll->BonoExtraord); ?></td>
                            <td><?php echo e($getAll->BonoEspecialidad); ?></td>
                            <td><?php echo e($total); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </tbody>
                   
                </table>
                 <?php echo e($getAllnivel->render()); ?>

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