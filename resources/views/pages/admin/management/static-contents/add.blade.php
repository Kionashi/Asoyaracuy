@extends('templates.admin.master.index') 
@section('title', 'Admin users') 
@section('content')
<!-- iCheck -->
{!! Html::style('admin/plugins/iCheck/minimal/red.css') !!}
@if ($errors->first('message'))
    <div class="col-xs-12">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <b><i class="icon fa fa-ban"></i>¡Error! </b> {{ $errors->first('message') }}
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-12">
        <!-- Body -->
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
            </ul>
            {!! Form::model($staticContent, array('files' => true, 'id' => 'addStaticContentForm', 'class' => 'panel-body form-horizontal')) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                        	<div class="form-group">
                                {!! Form::label('sections', 'Sección', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <div>
                                        {!! Form::select('section', $sections, null, array('class' => 'form-control select2', 'placeholder' => 'Seleccione una opción', 'style' => 'width:100% !important;')) !!}
                                    </div>
                                    <span class="right-light">{{ $errors->first('order') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('content', 'Contenido', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    {!! Form::textArea('content', '', array('id' => 'content', 'class' => 'control-ckeditor form-control')) !!}
                                    <span class="help-block help-block-error right-light">{{ $errors->first('content') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('enabled', 'Habilitado' , array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <div class="checkbox">
                                        {!! Form::checkbox('enabled', null, '' ,array('class' => 'minimal-red')) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                {!! Form::submit('Guardar', array('id'=>'submit','class' => 'btn btn-primary')) !!}
                                <a href="{{ route('management/static-contents') }}" class="btn btn-default">Cancelar</a>
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
<!-- iCheck -->
{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}
<!-- CK Editor -->
{!! Html::script('admin/plugins/ckeditor/ckeditor.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        // Replace new editor
        CKEDITOR.replace('content');
        CKEDITOR.instances['content'].on('blur', function() {
            CKEDITOR.instances['content'].updateElement();
            $('#content').change();
        });
        
        
        // Styles to checkbox
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
    });
</script>


@stop