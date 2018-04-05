@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Editar Permisos
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
       <!-- @lang('groups/title.edit')--> Editar Permiso
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('general.dashboard')
            </a>
        </li>
        <li><!--@lang('groups/title.groups')-->Permisos</li>
        <li class="active"><!--@lang('groups/title.edit')--> Editar Permiso</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                       <!-- @lang('groups/title.edit')-->Editar Permisos
                    </h4>
                </div>
                <div class="panel-body">
                     {!! Form::model($permission, ['route' => ['admin.permisos.update', $permission->child['id']], 'method' => 'patch']) !!}
                     <!--<form method="post" action="{{action('PermisosController@update@update', $id)}}" >-->
                        <div class="form-group">
                            {{ Form::label('name', 'Nombre de la etiqueta') }}
                            {{ Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('slug', 'URL Amigable') }}
                            {{ Form::text('slug', null, ['class' => 'form-control', 'id' => 'slug']) }}
                        </div>

                        <div class="form-group">
                            {{ Form::label('description', 'Descripción') }}
                            {{ Form::textarea('description', null, ['class' => 'form-control','rows'=>'4']) }}
                        </div>

                        <!-- =================================== -->      
                         
                                              
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <a class="btn btn-danger" href="{{ route('admin/permisos') }}">
                                    @lang('button.cancel')
                                </a>
                                <button type="submit" class="btn btn-success">
                                    @lang('button.save')
                                </button>

                            </div>
                        </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>

@stop
