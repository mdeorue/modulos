<div id="login-box" class="col-md-3">
	<div class="login-header">
		<h1>Login</h1>
	</div>
	@if(Session::has('mensajeError'))
	    <div class="mensaje-error">
	    	<p class="text-center"><span class="glyphicon glyphicon-exclamation-sign"></span> {{ Session::get('mensajeError') }}</p>
	   	</div>
	@endif
	<div class="row">
		<div class="col-xs-12">
			{{ Form::open(array('role'=>'form', 'url' => '/usuario/login')) }}
				<div class="col-md-offset-1 col-md-10">
					{{ Form::text('rut', e(Input::old('rut')), array('placeholder'=>'Rut', 'autofocus'=>'autofocus', 'class' => 'col-xs-12')) }}
				</div>
				<div class="col-md-offset-1 col-md-10">
					{{ Form::password('password', array('placeholder'=>'Contraseña', 'class' => 'col-xs-12')) }}
				</div>
				<div class="col-md-offset-1 col-md-10 text-center">
					{{ Form::submit('Entrar', array('class'=>'btn btn-default col-xs-12')) }}
				</div>
			{{ Form::close() }}
		</div>
	</div>
</div>