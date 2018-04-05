@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Administrar Permisos
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1><!--@lang('groups/title.management')--> Administrar Permisos</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('general.dashboard')
            </a>
        </li>
        <li><a href="#"> <!--@lang('groups/title.groups')--> Permisos</a></li>
        <li class="active"><!--@lang('groups/title.groups_list')--> Lista de Permisos</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left"> <i class="livicon" data-name="users" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        @lang('Permisos')
                    </h4>
                    <div class="pull-right">
                    <a href="{{ URL::to('admin/permisos/create') }}" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span>Crear Nuevo</a>
                    </div>
                </div>
                <br />
                <div class="panel-body">                  
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Descripción</th>
                                        <th colspan="2">Acciones</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=0; ?>
                                    @foreach ($permissions as $key) <?php $i++ ;?>
                                    <tr>
                                        <td>{!! $i !!}</td>
                                        <td>{!! $key->name !!}</td>
                                        <td>{!! $key->slug !!}</td>                                
                                        <td>{!! $key->description !!}</td>
                                        <td>
                                        <!--<a class="btn btn-info" href="{{ url::to('admin/permisos/show',$key->id) }}">Show</a>-->
                                            <a class="btn btn-info" href="{{ url::to('admin/permisos/edit',$key->id) }}">Editar</a>
                                        </td>
                                         <td>
                                            {!! Form::open(['method' => 'DELETE','route' => ['admin.permisos.destroy', $key->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>  
                            {{$permissions->render()}}                      
                      </div>
                   
                </div>
            </div>
        </div>
    </div>    <!-- row-->
</section>




@stop

{{-- Body Bottom confirm modal --}}
@section('footer_scripts')
<div class="modal fade" id="delete_confirm" tabindex="-1" role="dialog" aria-labelledby="user_delete_confirm_title" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    </div>
  </div>
</div>
<div class="modal fade" id="users_exists" tabindex="-2" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                @lang('groups/message.users_exists')
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {$('body').on('hidden.bs.modal', '.modal', function () {$(this).removeData('bs.modal');});});
    $(document).on("click", ".users_exists", function () {

        var group_name = $(this).data('name');
        $(".modal-header h4").text( group_name+" Group" );
    });</script>
@stop
