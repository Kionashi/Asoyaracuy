@extends('templates.admin.master.index') 
@section('title', 'Encuestas') 
@section('content')
<!-- iCheck -->
{!! Html::style('admin/plugins/iCheck/minimal/red.css') !!}
<!-- Colopicker -->
{!! Html::style('admin/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') !!}
<!-- DateRangePicker -->
{!! Html::style('admin/plugins/bootstrap-daterangepicker/daterangepicker.css') !!}

<div class="row">
    <div class="col-md-12">
        <!-- Body -->
        <div class="nav-tabs-custom margin">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
            </ul>
            {!! Form::model($poll, array('files' => true, 'id' => 'editPollForm', 'class' => 'panel-body form-horizontal')) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('title', 'Título', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    {!! Form::text('title', null, array('class' => 'form-control', 'disabled')) !!}
                                    <span class="help-block help-block-error right-light">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('startDate', 'Fecha de inicio', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <div class="input-group date">
                                        {!! Form::text('startDate', null, array('class' => 'form-control', 'id' => 'startDate', 'disabled')) !!}
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <span class="help-block help-block-error right-light">{{ $errors->first('startDate') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('endDate', 'Fecha de fin', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <div class="input-group date">
                                        {!! Form::text('endDate', null, array('class' => 'form-control', 'id' => 'endDate', 'disabled')) !!}
                                        <div class="input-group-addon">
                                          <i class="fa fa-calendar"></i>
                                        </div>
                                    </div>
                                    <span class="help-block help-block-error right-light">{{ $errors->first('endDate') }}</span>
                                </div>
                            </div>
                            <div class="form-group" class="file-height">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    {!! Form::label('image', 'Imagen', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                    <div class="col-lg-8">
                                        <img class="col-xs-6 col-md-4 col-sm-4 col-lg-4 responsive-img" src="{!!asset($poll->image)!!}" style="border: 1px solid #ddd;" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('enabled', 'Habilitado' , array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <div class="checkbox">
                                        {!! Form::checkbox('enabled', null, $poll->enabled ,array('class' => 'minimal-red', 'disabled')) !!}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                {!! Form::label('options[1]', 'Opciones', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th>Opción</th>
                                                <th>Color</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody" class="pollOptionsContent" >
                                        	@foreach($poll->pollOptions as $i => $pollOption)
                                            <tr id="tr-{{$i+1}}"  data-parameter="{{$i+1}}">
                                                <td >
                                                    <span class="handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>                                        
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="options[{{$i+1}}][title]" value="{{$pollOption->title}}" class="form-control optionInputs" disabled="disabled" />
                                                </td>
                                                <td class="form-group text-center">
                                                    <input type="text" name="options[{{$i+1}}][color]" value="{{$pollOption->color}}" class="form-control form-control-options colorpicker" disabled="disabled" />
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                @if(\AdminAuthHelper::hasPermission('management/polls/edit'))
                                    <a href="{{route('management/polls/edit', $poll->id)}}" class="btn btn-primary" style="display:{{\AdminAuthHelper::hasPermission('management/polls/edit')?'':'none'}}">Editar</a>
                                @endif
                                <a href="{{ route('management/polls') }}" class="btn btn-default">Cancelar</a>
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
<!-- iCheck -->
{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}

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

        // Add button ID
        var addButton = $('.addOptionButton');
        
    });
</script>
@stop