@extends('templates.admin.master.index') 
@section('title', 'Config items')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Body -->
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
            </ul>
            {{ Form::model($configItem, array('class'=>'form-horizontal panel-body','id' => 'detail-config-item-form')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Clave', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('key', null, array('class'=>'form-control', 'id' => 'key', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Descripción', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::textarea('description', null, array('class'=>'form-control', 'id' => 'description', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Valor', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('value', null, array('class'=>'form-control', 'id' => 'value', 'disabled')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                @if(\AdminAuthHelper::hasPermission('management/config-items/edit'))
                                    <a href="{{route('management/config-items/edit', $configItem->id)}}" class="btn btn-primary" style="display:{{\AdminAuthHelper::hasPermission('management/config-items/edit')?'':'none'}}">Editar</a>
                                @endif
                                <a class="btn btn-default" href="{{route('management/config-items')}}">Volver</a>                    
                            </div>
                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop 

