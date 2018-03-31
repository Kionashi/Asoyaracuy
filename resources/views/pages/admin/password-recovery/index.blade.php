@extends('templates.admin.public.index')
@section('title', 'Recuperar contraseña')
@section('content')     

<div class="login-box-body">
    <p class="login-box-msg">Recuperar contraseña</p>
    @if (Session::has('successMessage'))
        <div class="alert alert-success">
            <p>{{ session('successMessage') }}</p>
        </div>
    @else
        {!! Form::open(array('id' => 'password-recovery-form')) !!}
            <div class="form-group has-feedback">
                {!! Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Correo electrónico')) !!}
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <span class="error-help-block">{{$errors->first('email')}}</span>
            </div>
            
            <div class="row">
                <div class="col-xs-12">
                    @if(session()->has('errorMessage'))
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <p>{{ session('errorMessage') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Recuperar contraseña</button>
                </div>
            </div>
        {!! Form::close() !!}
    @endif
    <br/>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-3 col-xs-4">
            <a href="{{route('sign-in')}}">Regresar a iniciar sesión</a>
        </div>
    </div>
</div>
@stop

@section('custom_script')
    {!! $validator !!}
@stop