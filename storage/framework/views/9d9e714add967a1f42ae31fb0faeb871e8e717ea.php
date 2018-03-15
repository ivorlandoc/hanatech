<?php $__env->startSection('title'); ?>
Gestionar Plazas
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
<!-- ================== css de datepiker======= -->
    <!--<link href="<?php echo e(asset('assets/vendors/daterangepicker/css/daterangepicker.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/vendors/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/vendors/clockface/css/clockface.css')); ?>" rel="stylesheet" type="text/css"/>-->
    <link href="<?php echo e(asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>" rel="stylesheet" type="text/css" />
<!-- =================================================== -->
 <link rel="stylesheet" href="<?php echo e(asset('assets/css/pages/buttons.css')); ?>" />
    <!-- include the BotDetect layout stylesheet -->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Gestionar Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Gestionar Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Movimiento de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body">                
                    
                        <div class="form-group">                            
                            <div class="input-group select2-bootstrap-append">                          
                                 <?php echo Form::text('search_plaza',null, ['class'=>'form-control','placeholder'=>'# de Plaza','type'=>'search','id'=>'search_plaza']); ?>  
                                        <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">                   
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                <span class="glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>

                                         <span class="input-group-btn">
                                            <a data-href="#responsive-searchM" href="#responsive-searchM" data-toggle="modal" >
                                                <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                    ...
                                                </button>
                                            </a>
                                        </span>

                            </div>
                        </div>
                        
                            <div class="panel-body" id="IdShowHideGesPlazas" style="display: none">                                        
                                    <div class="form-group">
                                            <label>Apellidos y Nombres:</label>
                                            <div class="input-group">
                                              <span id="txtnombresG"></span></s>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                            <label># De Plaza / Nivel / Cargo:</label>
                                            <div class="input-group">
                                              <span id="txtIdPlazaG"></span></s>
                                            </div>
                                    </div>

                                     <div class="form-group">
                                            <label># Dependencia:</label>
                                            <div class="input-group">
                                              <span id="txtIdEstructuraG"></span></s>
                                            </div>
                                    </div>
                                          
                            </div>
                        <?php echo Form::close(); ?>                        
                 
                    </div>
                </div>
            </div>
      


        <div class="panel panel-info" id="DesingFormGestPlz" style="display:none;">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> LA PLAZA PERTENECE A:  <span id="txttitulonombres"></span></s>
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>

                <div class="panel-body">

                        <!--<form method="POST" action="/api/admin/gesplazas/insert" name="frmsaveMov" id="frmsaveMov" enctype="multipart/form-data">-->
                        <form method="POST" action="/gpessalud/public/api/admin/gesplazas/insert" name="frmsaveMov" id="frmsaveMov" enctype="multipart/form-data">
                             <input type="hidden" name="__token" value="<?php echo e(csrf_token()); ?>"> 
                                <!-- Datos Estáticos de cabecera-->
                                     <input type="hidden" name="idUserSession" value="<?php echo e($idUserSession); ?>"> <!-- idsesion para enviar por ajax al api -->

                                      <input type="hidden" class="form-control" id="IdPlazaG"     name="IdPlazaG"  value="">
                                      <input type="hidden" class="form-control"  id="IdPersonaG"   name="IdPersonaG"    value="">
                                      <input type="hidden" class="form-control"  id="IdEstructuraG" name="IdEstructuraG" value="">
                                      <input type="hidden" class="form-control"  id="IdCargoG"    name="IdCargoG"      value="">
                                      <input type="hidden" class="form-control"  id="NroPlazaG" name="NroPlazaG"     value="">
                                   <!-- <div id ="IdshowExample"> Aqui mostra el return</div>-->
                              
            

                                <!-- ============== fin head =============================== -->
                                <div class="form-group">
                                    <label for="formEmail">Acción [VARIACIÓN DE UBICACIÓN]</label>
                                     <select id="IdTipoMovimiento" class="form-control select2" name="IdTipoMovimiento" required="">
                                        <option value="">Elegir</option>        
                                        
                                    </select>
                                </div>
                                <!-- ========== Load dependencia ============ -->
                        
                                <div class="form-group">
                                     <label for="formEmail">A:</label>   
                                    <input type="hidden" name="_ttoken" value="<?php echo e(csrf_token()); ?>">                        
                                    <select id="select_10" class="form-control select2" name="select_2dig" required="">
                                        <option value="">Elegir</option>                                        
                                       <?php $__currentLoopData = $getDosDig; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $getAll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <option value="<?php echo e(substr($getAll->IdEstructura,0,2)); ?>"><?php echo e(substr($getAll->IdEstructura,0,2)); ?> - <?php echo e($getAll->Descripcion); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
                                    </select>                                    
                                </div>

                                 <div class="form-group">   
                                 <!-- <label for="formEmail"></label>                    -->                                                  
                                    <select id="select_11" class="form-control select2" name="select_4dig" required="">
                                        <option value="">Elegir</option>                                         
                                    </select>
                                    
                                </div>

                                <div class="form-group">  
                                     <!-- <label for="formEmail"></label>                    -->
                                    <select id="select_22" class="form-control select2" name="select_7dig" required=""><!-- select_4dig -->
                                        <option value="">Elegir</option>        
                                        
                                    </select>
                                    
                                </div>

                                <div class="form-group">
                                    <select id="select_33" class="form-control select2" name="select_33" required="">
                                        <option value="">Todos</option>                                
                                    </select>                            
                                </div>
                            
                                 <div class="form-group">                    
                                    <select id="select_44" class="form-control select2" name="select_44" required="">
                                        <option value="">Todos</option>                                
                                    </select>                            
                                </div>

                                <!-- fin load dependencia ================ -->

                                <div class="form-group">
                                        <label>Fecha de Movimiento[Inicio]:</label>
                                        <!--<div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>                                         
                                            <input type="text"  class="form-control" name="FechaMov" id="datetime3" required="">    

                                        </div>-->
                                        <input type="date"  class="form-control" name="FechaMov" id="datetime3" required=""  pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                </div>

                                <div class="form-group">
                                        <label>Fecha de Documento[Término]:</label>
                                        <!--<div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="livicon" data-name="laptop" data-size="16" data-c="#555555"
                                                   data-hc="#555555" data-loop="true"></i>
                                            </div>
                                            <input type="text"  class="form-control" name="FechaDocRef" id="datetime1" required=""> 
                                        </div>-->
                                            <input type="date"  class="form-control" name="FechaDocRef" id="datetime1" required=""  pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
                                </div>

                                
           
                                <div class="form-group">
                                    <label for="formPassword">Doc. de Referencia</label>
                                    <input type="text" class="form-control" id="DocRefmov" name="DocRefmov" value="" required="">
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
                                                        <input type="file" name="FileAdjuntomov" id="FileAdjuntomov" readonly="" accept="*.pdf" required=""></span>
                                            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Eliminar</a>
                                        </div>


                                </div>

                                 <div class="form-group">
                                    <label for="formPassword">Observación</label>                          
                                        <textarea id="Observacion" name="Observacion" rows="3" class="form-control resize_vertical" required=""></textarea>
                                </div>

                                    <div class="btn-group btn-group-lg">       
                                          <!--  <button type="submit" class="btn btn-info btn_sizes" style="margin-bottom:7px;" id="IdSaveMovimientosDePlazas" >Guardar los cambios</button>
                                           <a href="<?php echo e(URL::to('admin/gesplazas')); ?>" class="btn btn-success btn_sizes" style="margin-bottom:7px;" >Volver a buscar</a>
                                            -->
                                    </div>  

                                    <div class="btn-group btn-group-lg">
                                        <button type="submit" class="alert alert-success alert-dismissable margin5" id="IdSaveMovimientosDePlazas">Guardar Cambios</button>
                                   
                                        <a href="<?php echo e(URL::to('admin/gesplazas')); ?>" class="alert alert-info alert-dismissable margin5" >Retorna a buscar[Salir]</a>
                                    
                                    </div>
                     
                        </div>
                    </form>             
                <div id="Idmessage"></div>             
            <!--   =================    -->
              
        </div>
    </div>    <!-- row-->
</section>
<!--=====Para search persona -->
        <div class="modal fade expandOpen" id="responsive-searchM" tabindex="-1" role="dialog" aria-hidden="false">
                <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-info">
                               <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        <h5 class="modal-title">CONSULTA</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="table-responsive" >
                                        <!-- ================= inicio search ===================-->
                                        <div class="input-group select2-bootstrap-append">                          
                                             <?php echo Form::text('search_personam',null, ['class'=>'form-control','placeholder'=>'Apellidos y Nombres | Dni Plaza','type'=>'search','id'=>'search_personam']); ?> 
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                    </span>
                                        </div>
                                        <!-- ================= fin ===================-->

                                           <form method="get" name="frmResultSear" id='frmResultSear' enctype="multipart/form-data" action="#">   
                                                <div class="col-md-12">

                                                    <!-- ==========draw table========== -->
                                                    <div class="panel-body">
                                                        <div class="table-responsive" >
                                                            <table  class="table dataTable no-footer dtr-inline">
                                                                <thead>
                                                                    <tr class="filters">
                                                                        <th>#</th><th>#PLAZA</th><th>DNI</th><th>APELLIDOS Y NOMBRES</th>                       
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="IdShowResultSearchP">
                                                                

                                                                </tbody>
                                                                <div id="IdMsjeErrorResultSearchp"></div>
                                                            </table>
                                                        </div>
                                                    </div>                        
                                                    <!-- ================ -->                        
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" class="btn btn-default" id="CierrameModalResult">Ciérrame!</button>
                           
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <!-- =======================================  -->
<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/jquery.dataTables.js')); ?>" ></script>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/dataTables.bootstrap.js')); ?>" ></script>
<!-- ========== datepiker ================= -->
<!--<script src="<?php echo e(asset('assets/vendors/moment/js/moment.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/daterangepicker/js/daterangepicker.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/clockface/js/clockface.js')); ?>" type="text/javascript"></script>

<script src="<?php echo e(asset('assets/js/pages/datepicker.js')); ?>" type="text/javascript"></script>
-->
<script src="<?php echo e(asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>" type="text/javascript"></script>



<!-- ===================== -->

<!-- ======================  -->

<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>

<script type="text/javascript" src="<?php echo e(asset('assets/js/api-gesplazas.js')); ?>"> </script>
    

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
/*=================================*/
 

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>