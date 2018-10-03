@extends('templates.frontend.master.index')
@section('content')
	<div class="overlay col-12  my-auto">
	<!--<img src="{!! asset('frontend/images/cambures-rojos.jpg') !!}" style="max-width: 100%; max-height: 38.45em;"> -->
	</div>
    <div class="masthead">
      <div class="masthead-bg"></div>
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-12 my-auto">
            <div class="masthead-content text-white py-5 py-md-0">
	            <h1 class="mb-3">Asoyaracuy</h1>
	            <p class="mb-5">Asociación vecinal sin fines de lucro.</p>
	            {!!Form::open(array('id'=> 'login', 'route' => 'login')) !!}
	            <div class="input-group input-group-newsletter">
            		{!! Form::text('email', null, array('id' => 'email', 'class' => 'form-control', 'placeholder' => 'Correo electrónico')) !!}
		             <br />
		            @if ($errors->has('email'))
	                    <span class="help-block">
	                        <strong>{{ $errors->first('email') }}</strong>
	                    </span>
	                @endif
	            </div>
	            <div class="input-group input-group-newsletter">
		            {!! Form::password('password', null, array('id' => 'password', 'class' => 'form-control', 'placeholder' => 'Contraseña')) !!}
	            	@if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
	            </div>
	            <div class="input-group input-group-newsletter">
	            	<button class="btn btn-secondary" type="submit">Ingresar</button>
	            </div>
	            {!!Form::close()!!}
	            <div class="input-group input-group-newsletter">
	            	<a href="{{route('demo')}}"><button class="btn btn-primary" type="button">Demo</button>
	            </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="social-icons">
      <ul class="list-unstyled text-center mb-0">
        <li class="list-unstyled-item">
          <a href="#">
            <i class="fab fa-twitter"></i>
          </a>
        </li>
        <li class="list-unstyled-item">
          <a href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
        </li>
        <li class="list-unstyled-item">
          <a href="#">
            <i class="fab fa-instagram"></i>
          </a>
        </li>
      </ul>
    </div>

@endsection
@section('custom_script')
	<script type="text/javascript">
		
    </script>
@stop  