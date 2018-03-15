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
    <h1>Reporte de Plazas</h1>
    <ol class="breadcrumb">
        <li>
            <a href="<?php echo e(route('admin.dashboard')); ?>">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                Dashboard
            </a>
        </li>
        <li><a href="#"> Reporte de Plazas</a></li>
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
                        <i class="livicon" data-name="search" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i> Reporte de Plazas
                    </h3>
                    <span class="pull-right clickable">
                            <i class="glyphicon glyphicon-chevron-up"></i>
                    </span>
                </div>


                <div class="panel-body">                   
                        <!-- ================Tabs============= -->                                                         
                           
                          <?php echo e(Form::open(array( 'route' => 'get-rpte-plaza', 'method' => 'post', 'id' => 'formplazacar','name' => 'formplazacar','class'=>'form-inline'))); ?>

                              <input type="hidden" name="token" value="<?php echo e(csrf_token()); ?>">

                             
                            <div class="form-group">
                              <label>
                                  <input type="radio" name="regim" value="0" class="polaris" checked/> 
                              </label>
                              <label>D.L.728</label>
                              <label>
                                  <input type="radio" name="regim" value="9" class="polaris"/> 
                              </label>
                              <label>D.L.1057</label> 
                          </div>

                         <div class="form-group">                                   
                                <select id="idestado" class="form-control select2" name="idestado" onchange="ajaxloadplazas()">
                                    <option value="">Elige el  Critério</option>
                                    <?php $__currentLoopData = $dataE; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                        <option value="<?php echo e($key->IdEstadoPlaza); ?>"><?php echo e($key->IdEstadoPlaza); ?> | <?php echo e($key->Descripcion); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                
                          </div>
                                   
                          <div class="form-group">
                              <a href="<?php echo e(route('reportes.rplazas.index',1)); ?>" class="btn btn-sm btn-primary">Exportar a Excel[En Desarrollo]</a>   
                          </div> 

                           <?php echo e(Form::close()); ?>


                              <div class="panel-body">
                              <div class="table-responsive">                                
                                    <table class="table table-bordered width100" id="table">
                                        <thead>                                           
                                            <tr class="filters">
                                                <th>#</th>
                                                <th>CODIGO</th>                                             
                                                <th>DEPENDENCIA</th>
                                                <th>#PLAZA</th>
                                                <th>CARGO</th>
                                                <th>#DNI</th>
                                                <th>NOMBRES</th>
                                                <th>ESTADO</th>
                                                <th>RÉGIMEN</th>
                                            </tr>
                                        </thead>
                                        <tbody id="IdShowRptePlazas">                                          
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

<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>-->

<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/jquery.dataTables.js')); ?>" ></script>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/datatables/js/dataTables.bootstrap.js')); ?>" ></script>


<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"></div>
  </div>
</div>
<!--
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
-->
 <script type="text/javascript">
      var url = "http://localhost/gpessalud/public/reportes/rplazas";
    //  var url = "http://localhost:8000/";
    </script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/js-rpte-plazas.js')); ?>"> </script>

<script>
$(function () {
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
});


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>