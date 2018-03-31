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
			{{ Form::model($contactReason, array('class'=>'form-horizontal panel-body','id' => 'detail-contact-reasons-form')) }}
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<div class="box-body">
							<div class="form-group">
								{{ Form::label(null, 'Título', array('class'=>'col-lg-2 col-sm-2 control-label')) }} 
								<div class="col-lg-8">
								 	{{ Form::text('title', null, array('class'=>'form-control', 'id' => 'title', 'disabled')) }}
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
							@if(\AdminAuthHelper::hasPermission('management/contact-reasons/edit'))
								<a  href="{{route('management/contact-reasons/edit', $contactReason->id)}}" class="btn btn-primary">Editar</i></a>
							@endif	
								<a class="btn btn-default" href="{{route('management/contact-reasons')}}">Volver</a>					
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

