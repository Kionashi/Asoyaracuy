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
            {{ Form::model($audit, array('class'=>'form-horizontal panel-body','id' => 'detail-contact-form')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Acción', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('action', $audit->action, array('class'=>'form-control', 'id'=> 'action', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Ejecutor', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('adminUser', $audit->adminUser->firstName . ' ' . $audit->adminUser->lastName, array('class'=>'form-control', 'id' => 'adminUser', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Dirección IP', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('ipAddress', $audit->ipAddress, array('class'=>'form-control', 'id' => 'ipAddress', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Detalles', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::textarea('details', null, array('class'=>'form-control', 'id' => 'details', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Fecha', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('dateContact', \AdminDateHelper::formatDate($audit->created_at), array('class'=>'form-control', 'id'=> 'dateContact', 'disabled')) }}
                                </div>
                            </div>                            
                        </div>
                    </div>
                
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <a class="btn btn-default" href="{{route('management/audits')}}">Volver</a>                    
                            </div>
                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop 