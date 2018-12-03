@extends('templates.frontend.master.login')
@section('content')

  <div class="masthead">
    <div class="container h-100" style="padding-bottom: 7em;">
          <div class="masthead-content text-white py-5 py-md-0">
            <h1 class="col-md-12">Asoyaracuy</h1>
            <p class="col-md-12">Asociación vecinal sin fines de lucro.</p>
            <div class="col-md-7" style="padding-left: 5em; padding-top: 3em;">
              <p> <b>Esta es una red privada, ingresa tu usuario y tu contraseña para acceder al sitio </b></p>
	            {!!Form::open(array('id'=> 'login', 'route' => 'login')) !!}
	            <div class="col-md-12">
            		{!! Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Correo electrónico')) !!}
		             <br />
		            @if ($errors->has('email'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('email') }}</strong>
	                    </span>
	                @endif
	            </div>
	            <div class="col-md-12">
		            {!! Form::password('password', array('id' => 'password', 'class' => 'form-control', 'placeholder' => 'Contraseña')) !!}

	            	@if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
	            </div>
	            <div class="col-md-6">
	            	<button class="btn btn-primary" type="submit">Ingresar</button>
	            </div>
	            {!!Form::close()!!}
	            <div class="col-md-6">
	            	<a href="{{route('demo')}}"><button class="btn btn-danger" type="button">Demo</button></a>
              </div>
            </div>
          </div>
    </div>
  </div>

@endsection
@section('custom_script')
	<script type="text/javascript">
		
    </script>
@stop  