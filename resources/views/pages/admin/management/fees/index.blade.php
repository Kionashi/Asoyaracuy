@extends('templates.admin.master.index') 
@section('title', 'Contacts')
@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Body -->
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
            </ul>
            {{ Form::open(array('class'=>'form-horizontal panel-body','id' => 'createFee')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Cuota actual', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::number('fee', $fee->amount, array('class'=>'form-control', 'id'=> 'user', 'disabled')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                    {{ Form::label(null, 'Nueva cuota', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                    <div class="col-lg-8">
                                        {{ Form::number('amount', $fee->amount, array('class'=>'form-control')) }}
                                    </div>
                                    <button class="btn btn-primary" type="submit">Modificar</button>
                                <a class="btn btn-default" href="{{route('dashboard')}}">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop 