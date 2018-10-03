@extends('templates.admin.master.index')
@section('section', 'dashboard')
@section('title', 'Dashboard')

@section('content')

	<h1>Panel de administración</h1>
	<div class="col-md-3"><h2>Balance de la organización: {{$organizationBalance}}</h2></div>
	<div class="col-md-3"><h2></h2></div>
	<div class="col-md-3"><h2></h2></div>
	<div class="col-md-3"><h2></h2></div>
    [DASHBOARD CONTENT]
@stop