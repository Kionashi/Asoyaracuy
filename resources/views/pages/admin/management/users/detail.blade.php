@extends('templates.admin.master.index') 
@section('title', 'Users')
@section('content')
<!-- iCheck -->
{!! Html::style('admin/plugins/iCheck/minimal/red.css') !!}
<div class="row">
    <div class="col-md-12">
        <!-- Body -->
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
            </ul>
            {{ Form::model($user, array('class'=>'form-horizontal panel-body','id' => 'detail-user-form')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Casa', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('house', null, array('class'=>'form-control', 'id' => 'house', 'disabled')) }}
                                </div>
                            </div>                        
                            <div class="form-group">
                                {{ Form::label(null, 'Correo electrónico', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('email', null, array('class'=>'form-control', 'id' => 'email', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Teléfono', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('phone', $user->phone ? $user->phone : '-', array('class'=>'form-control', 'id' => 'phone', 'disabled')) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Balance', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('balance', $user->balance ? $user->balance : '-', array('class'=>'form-control', 'id' => 'balance', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Fecha de creación', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('registerDate', AdminDateHelper::formatDate($user->registerDate), array('class'=>'form-control', 'id'=> 'registerDate', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Dirección IP de creación', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('register_ip_address', $user->registerIpAddress, array('class'=>'form-control', 'id'=> 'registerIpAddress', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Habilitado', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    <div class="checkbox">
                                         {{ Form::checkbox('enabled', '', null, array('disabled' => true, 'class' => 'minimal-red')) }}
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                            @if(\AdminAuthHelper::hasPermission('management/users/edit'))
                                <a  href="{{route('management/users/edit', $user->id)}}" class="btn btn-primary">Editar</i></a>
                            @endif
                                <a class="btn btn-default" href="{{route('management/users')}}">Volver</a>                    
                            </div>
                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop 
@section('custom_script')
<!-- iCheck -->
{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}
<script type="text/javascript">
$(document).ready(function() {

    // Styles to checkbox
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    });
});

</script>
@stop