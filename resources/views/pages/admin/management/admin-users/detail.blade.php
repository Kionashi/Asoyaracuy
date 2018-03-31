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
			{{ Form::model($adminUser, array('class'=>'form-horizontal panel-body','id' => 'detail-admin-users-form')) }}
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<div class="box-body">
							<div class="form-group">
								{{ Form::label(null, 'Nombre', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
								 	{{ Form::text('firstName', null, array('class'=>'form-control', 'id' => 'firstName', 'disabled')) }}
								</div>
							</div>
							<div class="form-group">
								{{ Form::label(null, 'Apellido', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
								 	{{ Form::text('lastName', null, array('class'=>'form-control', 'id' => 'lastName', 'disabled')) }}
								</div>
							</div>
							<div class="form-group">
								{{ Form::label(null, 'Correo electrónico', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
								 	{{ Form::text('email', null, array('class'=>'form-control', 'id' => 'email', 'disabled')) }}
								</div>
							</div>
							<div class="form-group">
								{{ Form::label(null, 'Teléfono', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
								 	{{ Form::text('phone', null, array('class'=>'form-control', 'id' => 'phone', 'disabled')) }}
								</div>
							</div>
							<div class="form-group">
								{{ Form::label(null, 'Roles', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
								@foreach ($adminUser->adminUserRoles as $adminUserRole)
									@if(\AdminAuthHelper::hasType($adminUserRole->adminUserType)|| \AdminAuthHelper::hasPermission('management/admin-users/detail', \AdminUserType::ADMIN))
								 		{{ Form::text('adminUserRole', $adminUserRole->name, array('class'=>'form-control', 'id' => 'role', 'disabled')) }}
								 	@endif
								@endforeach
								</div>
							</div>
							<div class="form-group">
								{{ Form::label(null, 'Habilitado', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
									<div class="checkbox">
								 		{{ Form::checkbox('enabled', '', null, array('disabled' => true, 'class' => 'minimal-red')) }}
								 	</div>
								</div>
							</div>
						</div>
					</div>
					<div class="box-body">
						<div class="form-group">
							<div class="col-lg-8 col-lg-offset-2">
							@if(\AdminAuthHelper::hasPermission('management/admin-users/edit'))
								<a  href="{{route('management/admin-users/edit', $adminUser->id)}}" class="btn btn-primary">Editar</i></a>
							@endif	
								<a class="btn btn-default" href="{{route('management/admin-users')}}">Volver</a>					
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

