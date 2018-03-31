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
            {{ Form::model($staticContent, array('class'=>'form-horizontal panel-body','id' => 'detail-admin-users-form')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Nombre', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('section', StaticContentSection::getFriendlyName($staticContent->section), array('class'=>'form-control', 'id' => 'name', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label(null, 'Contenido', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    {!! Form::textArea('content', null, array('id' => 'content', 'class' => 'control-ckeditor form-control', 'disabled' => true)) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Habilitado', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    <div class="checkbox">
                                         {{ Form::checkbox('enabled', null, null, array('disabled' => true, 'class' => 'minimal-red')) }}
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                            @if(\AdminAuthHelper::hasPermission('management/static-contents/edit'))
                                <a  href="{{route('management/static-contents/edit', $staticContent->id)}}" class="btn btn-primary">Editar</i></a>
                            @endif    
                                <a class="btn btn-default" href="{{route('management/static-contents')}}">Volver</a>                    
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
<!-- CKEditor -->
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

