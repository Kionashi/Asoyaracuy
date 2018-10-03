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
            <div class="masthead-content text-white py-7 py-md-0">
	            <h1 class="mb-3">Bienvenido {{$user->house}} {{$user->balance}}Bs</h1> 
	            @if(isset($message)) 
	            <p>{{$message}}</p>
	            @endif
	            <p class="mb-5">Registrar pago</p>
	            {{Form::open(array('route' => 'create-payment', 'files' => true)) }}
					{{Form::select('type', array('none' => 'Tipo de pago','Cheque' => 'Cheque', 'Transferencia' => 'Transferencia', 'Deposito' => 'Deposito'), null, array('class' => 'form-control', 'id' => 'payment_method2')) }} 
					</br>
			    	<select id="bank" name="bank" class = "form-control"><option value="Mercantil">Mercantil</option><option value="Venezuela">Venezuela</option><option value="Provincial">Provincial</option><option value="Bicentenario">Bicentenario</option><option value="Exterior">Exterior</option><option value="Banesco">Banesco</option><option value="BOD">BOD</option><option value="Industrial">Industrial</option><option value="Caroni">Caron&iacute;</option><option value="Banco del tesoro">Banco del tesoro</option></select>  
					</br>
					{{Form::text('confirmation_code','',array('class' => 'form-control','placeholder'=> 'Codigo de confirmacion'))}}
					</br>
					{{Form::text('amount','',array('class' => 'form-control','placeholder'=>'Monto'))}}
					</br>
					{{Form::text('date','',array('class' => 'form-control','placeholder'=>'Fecha del pago: AAAA-MM-DD'))}}
					</br>
					{!! Form::file('file') !!}
					</br>	
			    	{{Form::submit('Registrar pago',array('class' => 'btn btn-lg btn-primary btn-block')) }} 
	            {!!Form::close()!!}
	            <div class="input-group input-group-newsletter">
	            	<a href="{{route('demo')}}"><button class="btn btn-primary" type="button">Demo</button></a>
	            </div>
            </div>
          </div>

        </div>

      </div>
    </div>

     <div class="social-icons masthead-content py-5 py-md-0 text-white">
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

@endsection
@section('custom_script')
	<script type="text/javascript">
		
    </script>
@stop  
