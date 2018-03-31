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
            {{ Form::model($contact, array('class'=>'form-horizontal panel-body','id' => 'detail-contact-form')) }}
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        <div class="box-body">
                            <div class="form-group">
                                {{ Form::label(null, 'Nombre', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('firstName', $contact->firstName, array('class'=>'form-control', 'id'=> 'firstName', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Apellido', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                     {{ Form::text('lastName', $contact->lastName, array('class'=>'form-control', 'id' => 'lastName', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Correo eletrónico', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('email', $contact->email, array('class'=>'form-control', 'id' => 'email', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Número telefónico', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('phone', $contact->phone, array('class'=>'form-control', 'id' => 'phone', 'disabled')) }}
                                </div>
                            </div>    
                            <div class="form-group">
                                {{ Form::label(null, 'Dirección IP', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::text('ipAddress', $contact->ipAddress, array('class'=>'form-control', 'id' => 'ipAddress', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Razón de contacto', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('dateContact', $contact->contactReason->title, array('class'=>'form-control', 'id'=> 'dateContact', 'disabled')) }}
                                </div>
                            </div>                            
                            <div class="form-group">
                                {{ Form::label(null, 'Mensaje', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
                                <div class="col-lg-8">
                                    {{ Form::textarea('message', null, array('class'=>'form-control', 'id' => 'message', 'disabled')) }}
                                </div>
                            </div>
                            <div class="form-group">
                                {{ Form::label(null, 'Fecha', array('class'=>'col-lg-2 col-sm-2 control-label')) }}
                                <div class="col-lg-8">
                                    {{ Form::text('dateContact', \AdminDateHelper::formatDate($contact->dateContact), array('class'=>'form-control', 'id'=> 'dateContact', 'disabled')) }}
                                </div>
                            </div>                            
                        </div>
                    </div>
                
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-2">
                                <a class="btn btn-default" href="{{route('management/contacts')}}">Volver</a>                    
                            </div>
                        </div>
                    </div>
                </div>
            {{Form::close()}}
        </div>
    </div>
</div>
@stop 