@extends('templates.admin.master.index') 
@section('title', 'Admin users') 
@section('content')
<div class="row">
	<div class="col-md-12">
		<!-- Body -->
			<div class="nav-tabs-custom margin">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">General</a></li>
				</ul>
					{!! Form::model($adminUser, array('route' => array('management/admin-users/change-password', $adminUser->id), 'id' => 'changePasswordForm', 'class' => 'panel-body form-horizontal')) !!}
					<div class="tab-content">
							<div class="box-body">
								<div class="form-group">
									{!! Form::label('password', 'Password', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
									<div class="col-lg-8">
										{!! Form::password('password', array('class' => 'form-control')) !!}
										<span class="help-block help-block-error right-light">{{ $errors->first('password') }}</span>
									</div>
								</div>
								<div class="form-group">
									{!! Form::label('password', 'Password confirmation', array('class' => 'col-lg-2 col-sm-2 control-label')) !!}
									<div class="col-lg-8">
										{!!  Form::password('passwordConfirmation', array('class' => 'form-control')) !!}
										<span class="help-block help-block-error right-light">{{ $errors->first('passwordConfirmation') }}</span>
									</div>
								</div>
							</div>
						<div class="box-body">
							<div class="form-group">
								<div class="col-lg-8 col-lg-offset-2">
									{!! Form::submit('Save', array('class' => 'btn btn-primary')) !!}
									<a href="{{ route('management/admin-users') }}" class="btn btn-default">Cancel</a>
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
<script type="text/javascript">

    $(document).ready(function() {
    });
    
</script>
	{!! $validator !!}
@stop