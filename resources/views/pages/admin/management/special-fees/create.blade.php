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
            {!! Form::open($user, array('id' => 'addSpecialFee', 'class' => 'panel-body form-horizontal')) !!}
                {!! Form::hidden('userId', {{$userId}} ) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('amount', 'Monto', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    {!! Form::number('amount', null, array('class' => 'form-control')) !!}
                                    <span class="help-block help-block-error right-light">{{ $errors->first('amount') }}</span>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                {!! Form::submit('Guardar', array('id'=>'submit','class' => 'btn btn-primary')) !!}
                                <a href="{{ route('management/users') }}" class="btn btn-default">Cancelar</a>
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

{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}
{!! $validator !!}
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

        // Date picker
        $('#birthdate').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            maxDate:'180d'
        });
    });
</script>
@stop