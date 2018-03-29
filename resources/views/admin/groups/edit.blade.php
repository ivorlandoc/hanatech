@extends('admin/layouts/default')

{{-- Web site Title --}}
@section('title')
Editar Rol
@parent
@stop

{{-- Content --}}
@section('content')
<section class="content-header">
    <h1>
       <!-- @lang('groups/title.edit')--> Editar Rol
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <i class="livicon" data-name="home" data-size="14" data-color="#000"></i>
                @lang('general.dashboard')
            </a>
        </li>
        <li><!--@lang('groups/title.groups')-->Roles</li>
        <li class="active"><!--@lang('groups/title.edit')--> Editar Rol</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary ">
                <div class="panel-heading">
                    <h4 class="panel-title"> <i class="livicon" data-name="wrench" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                       <!-- @lang('groups/title.edit')-->Editar Rol
                    </h4>
                </div>
                <div class="panel-body">
                       {!! Form::model($role, ['route' => ['admin.groups.update', $role->id],'method' => 'PUT']) !!}
                       
                        @include('admin.groups.partials.form')
                        
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- row-->
</section>

@stop
