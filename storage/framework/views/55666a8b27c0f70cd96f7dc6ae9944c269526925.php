<?php $__env->startSection('title'); ?>
Mantenedor
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
 
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<!-- <link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />-->
<link href="<?php echo e(asset('assets/vendors/modal/css/component.css')); ?>" rel="stylesheet"/>
<!--<link href="<?php echo e(asset('assets/css/pages/advmodals.css')); ?>" rel="stylesheet"/>-->
<link href="<?php echo e(asset('assets/css/loading.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Estructuras Funcionales</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Mantenimiento de Estructuraa</a></li>
        <li class="active">Estructuras</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Mantenimiento de Estructuras
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <form name="frmupdateStruct" id="frmupdateStruct" action="<?php echo e(route('admin.filespdf.index','01')); ?>"> 
                            <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">
                            <div class="form-group">          
                                <div class="input-group select2-bootstrap-append">     
                                    <select id="select_nivel0" class="form-control select2" name="select_2dig">
                                        <option value="%">Todos</option>                                        
                                       <?php $__currentLoopData = $getDosDig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getAll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <option value="<?php echo e(substr($getAll->IdEstructura,0,2)); ?>"><?php echo e(substr($getAll->IdEstructura,0,2)); ?> | <?php echo e($getAll->Descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </select>
                                        
                                             <span class="input-group-btn"><!-- onclick=viewEstructuraEnPdf() -->
                                                    <a href="<?php echo e(route('admin.filespdf.index','01')); ?>" data-toggle="modal">
                                                        <button class="btn btn-default" type="submit" data-select2-open="single-append-text">
                                                            &nbsp<span class="glyphicon glyphicon-print"></span>&nbsp
                                                        </button>
                                                    </a>
                                            </span>
                                       
                                </div>                            
                            </div>
                            <div class="form-group">                      
                                <select id="select_nivel1" class="form-control select2" name="select_4dig">
                                    <option value="%">Todos</option>
                                </select>
                            </div>

                            <div class="form-group">                      
                                <select id="select_nivel2" class="form-control select2" name="select_7dig">
                                    <option value="%">Todos</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <select id="select_nivel3" class="form-control select2" name="select_11dig" onclick="GetIdSelectFour()">
                                    <option value="%">Todos</option>                                
                                </select>                            
                            </div>                       
                            
                         <?php echo e(Form::close()); ?>    
                       <!-- </form>-->
                       <!-- <div class="form-group">                         
                            <select id="select_nivel4" class="form-control select2" name="select_10dig" onclick="GetIdSelectFour()">
                                <option value="%">Todos</option>                                
                            </select>                            
                        </div>
                        
                        <div class="form-group">
                            <label for="e1" class="control-label">Todos</label>
                           <input type="text" class="form-control" id="txtcuartoNivel" name="txtcuartoNivel" required="" value="" maxlength="60" placeholder="Descripcion del 4to Nivel">
                        </div>
                    
                        <div class="btn-group btn-group-lg">
                                <button type="submit" class="alert alert-success alert-dismissable margin5" id="IdSaveManteEstru">Guardar Cambios</button>
                                <button type="button" class="alert alert-info alert-dismissable margin5" id="IdSalir"><a href="<?php echo e(URL::to('admin/mantestruct')); ?>" class="alert-info">[ Salir ]</a></button>
                        </div>-->

                        <div id="IdMensajeAlert"></div>
                             <!-- ==========draw table========== -->
                            <?php echo e(Form::open(array('route' => 'save-update-mantestruct', 'method' => 'post', 'id' => 'frmupdateEstr','name' => 'frmupdateEstr'))); ?> 
                            <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table  class="table dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr class="filters">
                                                    <th>#</th><th>CODIGO</th><th>ÓRGANO</th><th>GERENCIA</th> <th>DEPENDENCIA</th><th>OFICINA</th>                       
                                                </tr>
                                            </thead>
                                            <tbody id="IdShowresume">                                            
                                                <div class="loading">                                                   
                                                    <span>Loading</span>
                                                </div>
                                            </tbody>
                                        </table>
                                    </div>
                                </div> 
                            <?php echo e(Form::close()); ?>                       
                            <!-- ================ -->                      
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

    <script type="text/javascript" src="<?php echo e(asset('assets/js/api-manteEstructura.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/modal/js/classie.js')); ?>"></script>


<script>    
    $(function () {
    	$('body').on('hidden.bs.modal', '.modal', function () {
    		$(this).removeData('bs.modal');
    	});
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>