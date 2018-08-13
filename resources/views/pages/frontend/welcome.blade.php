@extends('templates.frontend.master.index')
@section('content')
	<div class="gtco-loader"></div>
	
	<div id="page">
		<header id="gtco-header" class="gtco-cover gtco-cover-md" role="banner" style="background-image: url(images/cambures-rojos.jpg)" data-stellar-background-ratio="0.5">
			<div class="overlay"></div>
			<div class="gtco-container">
				<div class="row">
					<div class="col-md-12 col-md-offset-0 text-left">
						<div class="row row-mt-15em">
							<div class="col-md-7 mt-text animate-box" data-animate-effect="fadeInUp">
								<span class="intro-text-small">Asociacion de vecinos</span>
								<h1 class="cursive-font">Asoyaracuy</h1>	
							</div>
							<div class="col-md-4 col-md-push-1 animate-box" data-animate-effect="fadeInRight">
								<div class="form-wrap">
									<div class="tab">
										<div class="tab-content">
											<div class="tab-content-inner active" data-content="signup">
												<h3 class="cursive-font">Inicio de sesion</h3>
												{!!Form::open(array('id'=> 'login', 'files'=>true)) !!}
													<div class="row form-group">
														<div class="col-md-12">
															
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label for="date-start">Correo</label>
															<input type="text" id="email" class="form-control">
														</div>
													</div>
													<div class="row form-group">
														<div class="col-md-12">
															<label for="date-start">Contrasena</label>
															<input type=password id="password" class="form-control">
														</div>
													</div>
													<!-- <div class="row form-group">
														<div class="col-md-12">
															<label for="date-start">Date</label>
															<input type="text" id="date" class="form-control">
														</div>
													</div> -->
													<!-- <div class="row form-group">
														<div class="col-md-12">
															<label for="date-start">Time</label>
															<input type="text" id="time" class="form-control">
														</div>
													</div> -->

													<div class="row form-group">
														<div class="col-md-12">
															<input type="submit" class="btn btn-primary btn-block" value="Ingresar">
														</div>
													</div>
												</form>	
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
	
	<!-- </div> -->

	</div>

	<div class="gototop js-top">
		<a href="#" class="js-gotop"><i class="icon-arrow-up"></i></a>
	</div>
	
@endsection
@section('custom_script')
	<script type="text/javascript">
		
    </script>
@stop  