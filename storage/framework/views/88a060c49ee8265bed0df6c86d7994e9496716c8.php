<?php $__env->startSection('title'); ?>
Reporte  - Plazas
##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>

<link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/datatables/css/dataTables.bootstrap.css')); ?>" />
<link href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('assets/css/loading.css')); ?>" rel="stylesheet" type="text/css" />
<!--

<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
-->



<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<section class="content-header">
    <h1>Rpte de Altas - Bajas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Altas - Bajas </a></li>
        <li class="active">Reportes</li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Altas - Bajas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>


                <div class="panel-body">                   
                        <!-- ================Tabs============= -->                                                         
                           
                          <?php echo e(Form::open(array( 'route' => 'get-rpte-altabaja', 'method' => 'post', 'id' => 'frmaltabaja','name' => 'frmaltabaja','class'=>'form-inline'))); ?>

                              <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">
                      
                          <div class="form-group">
                                <select id="idbajaalta" class="form-control select2" name="idbajaalta" onclick="hideshow()">                                    
                                    <option value="1">Altas</option>
                                    <option value="0">Bajas</option>
                                </select>  
                          </div> 

                         <div class="form-group">                                   
                                <select id="idperiodo" class="form-control select2" name="idperiodo" onchange="ajaxloadrpte()">
                                    <option value="">Elige el  Periodo</option>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <option value="<?php echo e($key->periodo); ?>"><?php echo e($key->Mes); ?> | <?php echo e($key->Mes); ?> | <?php echo e($key->Descripcion); ?>  <?php echo e($key->Anio); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                          </div>
                                   
                         
                           <div class="form-group">
                                  <div id="getTipoalta">
                                      <select id="IdConceptoa" class="form-control select2" name="IdConceptoa" onchange="ajaxloadrpte()">                                    
                                         <option value="">Elige el  Concepto</option>
                                            <?php $__currentLoopData = $data2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                              <option value="<?php echo e($key->IdTipoMov); ?>"><?php echo e($key->IdTipoMov); ?> | <?php echo e($key->f); ?> | <?php echo e($key->Descripcion); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select> 
                                  </div>

                                  <div id="getTipobaja" style="display:none">
                                     <select id="IdConceptob" class="form-control select2" name="IdConceptob" onchange="ajaxloadrpte()">                                    
                                       <option value="">Elige el  Concepto</option>
                                          <?php $__currentLoopData = $data3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <option value="<?php echo e($key->IdTipoMov); ?>"><?php echo e($key->IdTipoMov); ?> | <?php echo e($key->f); ?> | <?php echo e($key->Descripcion); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>   
                                  </div>

                          </div>
                       

                           <?php echo e(Form::close()); ?>


                              <div class="panel-body">
                              <div class="table-responsive">                                
                                    <table class="table table-bordered width100" id="table">
                                        <thead>                                           
                                            <tr class="filters">
                                                <th>#</th>
                                                 <th>DEPENDENCIA</th>
                                                <th>#DNI</th>                                             
                                                <th>NOMBRES</th>
                                                <th>#PLAZA</th>
                                                <th>TIPO</th>
                                                <th>TIPO MOV.</th>
                                                <th>F.MOV.</th>
                                                <th>DOC.REF.</th>
                                                <th>RÉGIMEN</th>
                                            </tr>
                                        </thead>
                                        <tbody id="IdShowRpteAltabajas">                                          
                                                  <div class="loading" >
                                                        <i class="fa fa-refresh fa-spin fa-2x fa-tw"></i>
                                                        <br>
                                                        <span>Loading</span>
                                                  </div> 

                                           
                                        </tbody>
                                         
                                    </table>
                                     <ul id="pagination" class="pagination-sm"></ul>      
                              </div> 
                            </div>                  
                        <!-- =================================  -->                
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
<script type="text/javascript" src="<?php echo e(asset('assets/js/js-rpte-altabajas.js')); ?>"> </script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>