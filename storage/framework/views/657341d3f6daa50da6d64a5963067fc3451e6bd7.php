<?php $__env->startSection('title'); ?>
Recategorización de Plazas
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>



<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<!-- ================== css de datepiker======= -->
<link href="<?php echo e(asset('assets/vendors/daterangepicker/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('assets/vendors/clockface/css/clockface.css')); ?>" rel="stylesheet" type="text/css"/>
<link href="<?php echo e(asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo e(asset('assets/vendors/modal/css/component.css')); ?>" rel="stylesheet"/>
<link href="<?php echo e(asset('assets/css/pages/advmodals.css')); ?>" rel="stylesheet"/>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Recategorización de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Recategorización de Plazas</a></li>
        <li class="active">Plazas</li>
    </ol>
   
</section>

<!-- Main content -->
<section class="content paddingleft_right15">                  
    <div class="row">
        <div class="panel panel-primary "> 
            <!--=================-->             
           <div class="panel panel-info" id="idheadinformcion">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Recategorización de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body"> 
                        <!-- ========== Cuerpo de Formulario ============================ -->
                    <div  id="IdFormbodyalta">
                         <?php echo e(Form::open(array( 'route' => ['get-datos-paraintegra'], 'method' => 'post', 'id' => 'frmintegra','name' => 'frmintegra'))); ?>                       
                             <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>"> 
                                <!-- Datos Estáticos de cabecera-->                          
                                 <input type="hidden" name="idUserSession" value="<?php echo e($idUserSession); ?>"> <!-- idsesion para enviar por ajax al api -->
                                <!-- ========== Load dependencia ============ -->
                                <div id="FormAltaPlaza">
                                  <div class="form-group">                               
                                     <div id="IdMensajeAlert"></div>
                                    <div class="input-group select2-bootstrap-append"> 
                                        <input type="text" class="form-control" id="txtplaza" name="txtplaza" maxlength="12" placeholder="#Plaza">
                                        <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" onclick="_getdatosplaza()" data-select2-open="single-append-text">
                                                    <span class="glyphicon glyphicon-search"></span>
                                                </button>
                                        </span>

                                    

                                    </div>

                                </div>
                        <?php echo e(Form::close()); ?> 
                            
                        <?php echo e(Form::open(array( 'route' => ['save-paraintegra-plazas','0'], 'method' => 'post', 'id' => 'frmintegrasave','name' => 'frmintegrasave'))); ?> 
                                <!-- ==========draw table========== -->
                                 <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>"> 
                                  <input type="hidden" name="idUserSession" value="<?php echo e($idUserSession); ?>"> 
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table  class="table dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr class="filters">
                                                    <th>#PLAZA</th><th>NIVEL</th><th>CARGO</th><th>ESTADO</th>                       
                                                </tr>
                                            </thead>
                                            <tbody id="idshowPlazasIntegra">
                                            

                                            </tbody>
                                        </table>
                                    </div>
                                </div>                        
                                <!-- ================ --> 

                                <div class="form-group">                                   
                                    <input type="text" class="form-control" id="docrefintegra" name="docrefintegra" maxlength="128" placeholder="Doc. de Referencia">
                                </div>
                              

                                <div class="form-group">                                   
                                        <div class="form-group">
                                            <input type="date" id="datetime1" name="fechadocintegra" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                        </div>
                                </div>

                                <div class="form-group">
                                    <label for="formPassword">Adjuntar Documento.</label>
                                    <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                            <div class="form-control" data-trigger="fileinput">
                                                <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                                <span class="fileinput-filename"></span>
                                            </div>
                                                    <span class="input-group-addon btn btn-default btn-file">
                                                        <span class="fileinput-new">Selecione Archivo</span>
                                                        <span class="fileinput-exists">Cambiar</span>
                                                        <input type="file" name="FileAdjuntoIntegra" id="FileAdjuntoIntegra" readonly="" accept="*.pdf"></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>
                                </div>

                                 <div class="form-group">                                   
                                        <select id="_selectMotivo" class="form-control select2" name="_selectMotivo">
                                            <option value="">Elegir Motivo</option>
                                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                <option value="<?php echo e($keys->IdTipoMov); ?>"><?php echo e($keys->IdTipoMov); ?> | <?php echo e($keys->Descripcion); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>  
                                </div>

                                <div class="form-group">
                                    <!--<label for="formPassword">Documento de Referencia</label>-->                                        
                                        <input type="text" class="form-control" id="nroplazaintegrada" name="nroplazaintegrada" value="" required="" placeholder="#Plaza Integrada">
                                </div>

                               <div class="input-group select2-bootstrap-append"> 
                                    <div class="btn-group btn-group-lg">
                                        <button type="button" class="alert alert-success alert-dismissable margin5" id="saveintegrarplaza" onclick="saveintegracionplaza()">Recategorizar Plaza</button>
                                        <a href="<?php echo e(URL::to('admin/integra')); ?>" class="alert alert-info alert-dismissable margin5" id="SalirIntegra" >[Salir]</a>
                                    </div> 
                                </div>

                            </div> 
                         
                        <?php echo e(Form::close()); ?> 

                    </div>
                          
                <!--  ===================================================== -->
                </div>


            </div>
        </div>
      
    </div>
    <!-- row-->
</section>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/jquery.dataTables.js')); ?>" ></script>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/dataTables.bootstrap.js')); ?>" ></script>
<!-- ========== datepiker ================= -->
<script src="<?php echo e(asset('assets/vendors/moment/js/moment.min.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('assets/vendors/daterangepicker/js/daterangepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/clockface/js/clockface.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/js-integra-plaza.js')); ?>"> </script>



<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/modal/js/classie.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/pages/tabs_accordions.js')); ?>" type="text/javascript"></script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>