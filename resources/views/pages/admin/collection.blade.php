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
                                {{ Form::label(null, 'Fecha de última cobranza', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::date('date', $collection->date, array('class'=>'form-control', 'id'=> 'date', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Cuota de última cobranza', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::number('amount', $collection->fee->amount, array('class'=>'form-control', 'id'=> 'amount', 'disabled')) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                    <a href="{{route('collection/add')}}"><button class="btn btn-primary" type="button">Realizar cobranza</button></a>
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