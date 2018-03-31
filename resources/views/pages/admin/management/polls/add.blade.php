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
            {!! Form::model($poll, array('files' => true, 'id' => 'addPollForm', 'class' => 'panel-body form-horizontal')) !!}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {!! Form::label('title', 'Título', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    {!! Form::text('title', null, array('class' => 'form-control')) !!}
                                    <span class="help-block help-block-error right-light">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('startDate', 'Fecha de inicio', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    <div class="input-group date">
                                        {!! Form::text('startDate', null, array('class' => 'form-control', 'id' => 'startDate')) !!}
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
                                        {!! Form::text('endDate', null, array('class' => 'form-control', 'id' => 'endDate')) !!}
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
                                        {!! Form::file('image', array('id' => 'image', 'class' => 'file-upload', 'title' => 'Browse')) !!}
                                        <span class="red help-block help-block-error">{{ $errors->first('image') }}</span>        
                                    </div>
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
                            
                            <div class="form-group">
                                {!! Form::label('options[1]', 'Opciones', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
                                <div class="col-lg-8">
                                    
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"></th>
                                                <th>Opción</th>
                                                <th>Color</th>
                                                <th class="text-center"></th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody id="tbody" class="pollOptionsContent" >
                                            <tr id="tr-1"  data-parameter="1">
                                                <td >
                                                    <span class="handle">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </span>                                        
                                                </td>
                                                <td class="form-group">
                                                    <input type="text" name="options[1][title]" class="form-control optionInputs" />
                                                    <span class="red help-block help-block-error">{{ $errors->first('options.1.title') }}</span>
                                                </td>
                                                <td class="form-group text-center">
                                                    <input type="text" name="options[1][color]" class="form-control form-control-options colorpicker" />
                                                    <span class="red help-block help-block-error">{{ $errors->first('options.1.color') }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a class="btn btn-sm btn-danger deleteOption"  data-id="1"  data-parameter="1"  title="Delete" >
                                                            <i class="fa fa-trash-o"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <a class="btn btn-primary addOptionButton">Agregar opción <i class="fa fa-plus"></i></a>
                                            <br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                {!! Form::submit('Guardar', array('id'=>'submit','class' => 'btn btn-primary')) !!}
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
{!! $validator !!}
<!-- iCheck -->
{!! Html::script('admin/plugins/iCheck/icheck.min.js') !!}
<!-- Moment -->
{!! Html::script('admin/plugins/moment/min/moment.min.js') !!}
<!-- Daterangepicker -->
{!! Html::script('admin/plugins/bootstrap-daterangepicker/daterangepicker.js') !!}
<!-- Colorpicker -->
{!! Html::script('admin/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') !!}

<script type="text/javascript">
    $(document).ready(function() {
        // Date picker
        $('#endDate').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                format: 'YYYY-MM-DD H:mm',
                daysOfWeek: [
                   "Do",
                   "Lu",
                   "Ma",
                   "Mi",
                   "Ju",
                   "Vi",
                   "Sa"
               ],
               monthNames: [
                   "Enero",
                   "Febrero",
                   "Marzo",
                   "Abril",
                   "Mayo",
                   "Junio",
                   "Julio",
                   "Augosto",
                   "Septiembre",
                   "Octubre",
                   "Noviembre",
                   "Diciembre"
               ],
               firstDay: 1
            }
        });
        $('#startDate').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                applyLabel: "Aplicar",
                cancelLabel: "Cancelar",
                format: 'YYYY-MM-DD H:mm',
                daysOfWeek: [
                     "Do",
                     "Lu",
                     "Ma",
                     "Mi",
                     "Ju",
                     "Vi",
                     "Sa"
                 ],
                 monthNames: [
                     "Enero",
                     "Febrero",
                     "Marzo",
                     "Abril",
                     "Mayo",
                     "Junio",
                     "Julio",
                     "Agosto",
                     "Septiembre",
                     "Octubre",
                     "Noviembre",
                     "Diciembre"
                 ],
                 firstDay: 1
            }
        });

        // Sortable functionality
        $('.pollOptionsContent').sortable({
            start: function(event, ui){
                    iBefore = ui.item.index();
            },
            update: function(event, ui) {
                    iAfter = ui.item.index();
                    evictee = $('#tbody-'+'tr:eq('+iAfter+')');
                    evictor = $('#tbody-'+'tr:eq('+iBefore+')');

                    evictee.replaceWith(evictor);
                    if(iBefore > iAfter)
                        evictor.after(evictee);
                    else
                        evictor.before(evictee);
            }
     	});
        
        // Styles to colorpicker
        $('.colorpicker').colorpicker({
            format: 'hex'
        })
        
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
        
        // Fields wrapper
        var container = $('.pollOptionsContent');
        
        var counter = 1; 
        var index = 1;

        // Add new option
        $(addButton).click(function(e){ //on add input button click
            e.preventDefault();
            // text box increment
            counter++; 
            index++;

            // Append new option
            $(".pollOptionsContent").each(function( subIndex ) {
                $(this).append('<tr id="tr-'+index+'" data-parameter="'+index+'">\
                                    <td><span class="handle"><i class="fa fa-ellipsis-v"></i> <i class="fa fa-ellipsis-v"></i>\</span>\</td>\
                                    <td class="form-group">\
                                        <input type="text" name="options['+index+'][title]" class="form-control form-control-options optionInputs" />\
                                    </td>\
                                    <td class="form-group text-center">\
                                        <input type="text" name="options['+index+'][color]" class="form-control form-control-options colorpicker" />\
                                    </td>\
                                    <td class="text-center">\
                                        <div class="btn-group">\
                                            <a class="btn btn-sm btn-danger deleteOption" data-id="'+index+'" data-parameter="'+index+' title="Delete" >\
                                                <i class="fa fa-trash-o"></i>\
                                            </a>\
                                        </div>\
                                    </td>\
                                </tr>'
                ); 
            });
            
            // Styles to colorpicker
            $('.colorpicker').colorpicker({
                format: 'hex'
            })

        });

        // Event to remove old option
        $(container).on('click', '.deleteOption', function(e){ 
            if(counter>=2){
                // Get element to delete
                var deleteElement = $(this).parent('div').parent('td').parent('tr');
                var dataValue = $(this).attr('data-id');

                // Remove element
                deleteElement.remove();
    
                // Get element to delete
                var deleteSecondElement = $('a[data-id='+dataValue+']').parent('div').parent('td').parent('tr');
    
                // Remove second element            
                deleteSecondElement.remove();

                counter--;
            }else{
                alert('La encuesta debe tener al menos una opción');
            }
        });
        
    });
</script>
@stop