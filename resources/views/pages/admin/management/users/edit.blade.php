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
            <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                    {!! Form::model($user, array('files' => true, 'id' => 'editUserForm', 'class' => 'panel-body form-horizontal')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('house', 'Casa', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                {!! Form::text('house', $user->house, array('class' => 'form-control')) !!}
                                <span class="help-block help-block-error right-light">{{ $errors->first('house') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('email', 'Correo electrónico', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                {!! Form::text('email', $user->email, array('class' => 'form-control')) !!}
                                <span class="help-block help-block-error right-light">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('phone', 'Teléfono', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                {!! Form::text('phone', $user->phone, array('class' => 'form-control')) !!}
                                <span class="help-block help-block-error right-light">{{ $errors->first('phone') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('balance', 'Balance', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                {!! Form::text('balance', $user->telegramUser, array('class' => 'form-control')) !!}
                                <span class="help-block help-block-error right-light">{{ $errors->first('balance') }}</span>
                            </div>
                        </div>
                        <?php dump($user); ?>
                        @if($user->specialFee)
                            <div class="form-group">
                                {!! Form::label('specialFee', 'Cuota Especial', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    {!! Form::text('specialFee', $user->specialFee->amount, array('class' => 'form-control')) !!}
                                    <span class="help-block help-block-error right-light">{{ $errors->first('amount') }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('enabled', 'Habilitado' , array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                <div class="checkbox">
                                    {!! Form::checkbox('enabled', null, $user->enabled, array('class' => 'minimal-red')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                            {!! Form::submit('Guardar', array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                            @if(AdminAuthHelper::hasPermission('management/users/change-password'))
                                <a href="{{ route('management/users/change-password', $user->id) }}" class="btn btn-primary">Cambiar contraseña</a>
                            @endif    
                            @if(AdminAuthHelper::hasPermission('management/special-fees/add'))
                                <a href="{{route('management/special-fees/add',$user->id )}}" class="btn btn-primary">Administrar Cuota especial</a>
                            @endif                            
                            <a href="{{ route('management/users') }}" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('custom_script')
<!-- iCheck -->
{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}
{!! $editValidator !!}
<script type="text/javascript">
    $(document).ready(function() {
        // Styles to checkbox
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        // Styles to file upload
        $('input[type=file]').bootstrapFileInput();
        $('.file-inputs').bootstrapFileInput();

        //Date picker
        $('#birthdate').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
        });
    });
</script>
@stop