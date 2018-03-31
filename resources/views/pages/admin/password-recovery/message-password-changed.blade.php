@extends('templates.admin.public.index')
@section('title', 'Password recovery')
@section('content')
<div class="login-box-body">
    <p class="login-box-msg">Recuperar contraseña</p>
    @if(session()->has('errorMessage'))
        <div class="alert alert-danger">
            <p>{{ session('errorMessage') }}</p>
        </div>
    @endif
    @if (Session::has('successMessage'))
           <div class="alert alert-success">
            <p>{{ session('successMessage') }}</p>
        </div>
    @endif
    <p class="login-box-msg">
        <a href="{{route('sign-in')}}">Regresar al inicio de sesión.</a>
    <p class="login-box-msg">
</div>
@stop



