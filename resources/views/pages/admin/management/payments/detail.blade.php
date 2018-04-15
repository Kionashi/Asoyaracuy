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
            {{ Form::model($payment, array('class'=>'form-horizontal panel-body','id' => 'detail-contact-form')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Usuario', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('user', $payment->user->house, array('class'=>'form-control', 'id'=> 'user', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Tipo de pago', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('paymentType', PaymentType::getFriendlyName($payment->type), array('class'=>'form-control', 'id' => 'paymentType', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Banco', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('bank', null, array('class'=>'form-control', 'id' => 'bank', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'C&oacute;digo de confirmaci&oacute;n', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('confirmationCode', null, array('class'=>'form-control', 'id' => 'confirmationCode', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Estado', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('status', PaymentStatus::getFriendlyName($payment->status), array('class'=>'form-control', 'id' => 'status', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Fecha de pago', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('date', \AdminDateHelper::formatDate($payment->date), array('class'=>'form-control', 'id'=> 'date', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Monto', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('amount', null, array('class'=>'form-control', 'id'=> 'amount', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Observación', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::textarea('note', null, array('class'=>'form-control', 'id' => 'note', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Archivo', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    <a href="{{asset($payment->file)}}" target="_blank">
                                        <img src="{{asset($payment->file)}}" style="max-width: 100%;" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                @if(\AdminAuthHelper::hasPermission('management/payments/approve') && $payment->status != PaymentStatus::APPROVED)
                                    <a href="{{route('management/payments/approve', $payment->id)}}" class="btn btn-success">Aprobar</i></a>
                                @endif
                                @if(\AdminAuthHelper::hasPermission('management/payments/reject') && $payment->status != PaymentStatus::REJECTED)
                                    <a href="{{route('management/payments/reject', $payment->id)}}" class="btn btn-danger">Rechazar</i></a>
                                @endif
                                <a class="btn btn-default" href="{{route('management/payments')}}">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop 