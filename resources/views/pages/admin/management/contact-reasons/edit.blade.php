@extends('templates.admin.master.index') 
@section('title', 'Admin users') 
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
                    {!! Form::model($contactReason, array('files' => true, 'id' => 'editContactReasonForm', 'class' => 'panel-body form-horizontal')) !!}
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('title', 'Título', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                {!! Form::text('title', $contactReason->title, array('class' => 'form-control')) !!}
                                <span class="help-block help-block-error right-light">{{ $errors->first('title') }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('enabled', 'Habilitado' , array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                            <div class="col-lg-8">
                                <div class="checkbox">
                                    {!! Form::checkbox('enabled', null, $contactReason->enabled, array('class' => 'minimal-red')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-lg-8 col-lg-offset-2">
                            {!! Form::submit('Guardar', array('class' => 'btn btn-primary')) !!}
                            <a href="{{ route('management/contact-reasons') }}" class="btn btn-default">Cancelar</a>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
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
    });
</script>
@stop