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
	            
	            <h2 class="mb-5">Registrar pago</h2>
	           	{{ Form::open(array('class'=>'form-horizontal panel-body','id' => 'createFee','files' => 'true')) }}
					{{Form::select('type', array('CASH' => 'Efectivo', 'TRANSFERENCE' => 'Transferencia', 'DEPOSIT' => 'Deposito'), null, array('class' => 'form-control', 'placeholder' => 'Tipo de pago', 'id' => 'payment_method2')) }} 
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
