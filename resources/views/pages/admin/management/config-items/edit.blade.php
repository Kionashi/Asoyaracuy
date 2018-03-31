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
            {!! Form::model($configItem, array('id' => 'editConfigItemForm', 'class' => 'panel-body form-horizontal')) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Clave:', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('key', null, array('class'=>'form-control', 'id' => 'key', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('description', 'Descripción:', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::textarea('description', null, array('class'=>'form-control', 'id' => 'description', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label('value', 'Valor:', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('value', null, array('class'=>'form-control', 'id' => 'value')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                {!! Form::submit('Guardar', array('class' => 'btn btn-primary')) !!}
                                <a href="{{ route('management/config-items') }}" class="btn btn-default">Cancelar</a>
                            </div>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@stop
@section('custom_script')
    {!! $validator !!}
@stop