<?php $__env->startSection('title'); ?>
Reserva de Plazas
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>

<!-- <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />

 <link href="<?php echo e(asset('assets/vendors/modal/css/component.css')); ?>" rel="stylesheet"/>
 <link href="<?php echo e(asset('assets/css/pages/advmodals.css')); ?>" rel="stylesheet"/>*/
<!-- =============== -->

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />

<!-- =================================================== -->
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/pages/buttons.css')); ?>" />

 <link href="<?php echo e(asset('assets/vendors/modal/css/component.css')); ?>" rel="stylesheet"/>
 <link href="<?php echo e(asset('assets/css/pages/advmodals.css')); ?>" rel="stylesheet"/>
 <link href="<?php echo e(asset('assets/css/loading.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Alta de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Reserva de Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Reserva de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body"> 
                         <div class="form-group">
                            <?php echo e(Form::open(array('route' => 'get-datos-parareserva', 'method' => 'post', 'id' => 'formreserva','name' => 'formreserva'))); ?>

                                <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">
                                  <div class="input-group select2-bootstrap-append">                                   
                                        <?php echo Form::text('reserva_plaza',null, ['class'=>'form-control','placeholder'=>'# de Plaza','type'=>'search','id'=>'reserva_plaza']); ?>  
                                                        
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="ajaxloadsearch()" data-select2-open="single-append-text">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>                                        
                                    <?php echo Form::close(); ?>

                                  </div>
                                    
                           <?php echo e(Form::close()); ?>

                        </div>

                    <div  id="IdFormbodyalta">
                        <?php echo e(Form::open(array('route' => ['get-datos-procesareserva','1'], 'method' => 'post', 'id' => 'formreservaPro','name' => 'formreservaPro'))); ?>

                       
                            <input type="hidden" name="idUserSession" value="<?php echo e($idUserSession); ?>">                        
                            <div id="ShowDataHead" style="display:none;"> 

                                <div class="form-group" id="IdSpaceHead">                                
                                    <div class="loading">
                                        <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                        <br>
                                        <span>Loading</span>
                                    </div>
                                    <input type="hidden" class="form-control" id="txtidplaza" name="txtidplaza" value="" > 
                                    <input type="hidden" class="form-control" id="txtestructura" name="txtestructura" value="">

                                    <div class="form-group">
                                         <label for="formEmail"># PLAZA</label> 
                                          <input type="text" class="form-control" id="nroplazar" name="nroplazar" readonly=""> 
                                    </div>  

                                    <div class="form-group">                                            
                                            <label for="formEmail">DEPENDENCIA</label>                                 
                                           <div id="IdDivDependencia"></div>
                                    </div>

                                    <div class="form-group">
                                            <label for="formEmail">NIVEL</label>                                 
                                           <div id="IdDivNivel"></div>
                                    </div>

                                    <div class="form-group">
                                            <label for="formEmail">CARGO</label>  
                                             <input type="hidden" class="form-control" id="txtidcargo" name="txtidcargo" value="">                               
                                           <div id="IdDivCargo"></div>
                                    </div>

                                </div>

                               
                                <div class="form-group">                                 
                                        <select id="IdTipoMotivoreser" class="form-control select2" name="IdTipoMotivoreser" >
                                            <option value="">Tipo de Reserva</option>                                                                                        
                                             <?php $__currentLoopData = $alltipo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                <option value="<?php echo e($keys->IdEstadoPlaza); ?>"><?php echo e($keys->IdEstadoPlaza); ?> | <?php echo e($keys->Descripcion); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                </div>
                                <div class="form-group">                                      
                                        <div class="form-group">
                                            <input type="date" id="datetime1" name="fechaRserv" class="form-control" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                        </div>
                                </div>

                                <div class="form-group">                                                                      
                                   <input type="text" class="form-control" id="DocRefRser" name="DocRefRser" value="" required="" placeholder="Doc .de Referencia">
                                </div>

                                 <div class="form-group" id ="idbotones">
                                    <textarea id="obserRser" name="obserRser" rows="3" class="form-control resize_vertical " placeholder="Observación"></textarea>                           
                                </div>

                                <div class="btn-group btn-group-lg">
                                    <button type="button" class="alert alert-success alert-dismissable margin5" onclick="SaveProcesaRserva()">Reservar Plaza </button>
                               
                                    <a href="<?php echo e(URL::to('admin/reserva')); ?>" class="alert alert-info alert-dismissable margin5" id="IdSalir" >[Salir]</a>
                                
                                </div> 
                                
                            </div>
                            <div id="IdMensajeAlert"></div>
                        <?php echo e(Form::close()); ?>                
                    </div>
                <!--  ===================================================== -->
                </div>


            </div>
        </div>
      
    </div>
    <!-- row-->
</section>
        <!-- =======================================  -->

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/jquery.dataTables.js')); ?>" ></script>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/dataTables.bootstrap.js')); ?>" ></script>

<script src="<?php echo e(asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/js-reserva-plaza.js')); ?>"> </script>




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