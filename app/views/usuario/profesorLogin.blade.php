<div id="login-box" class="col-md-3">
	<div class="login-header">
		<h1>Login</h1>
	</div>
	@if(Session::has('mensajeError'))
	    <div class="mensaje-error">
	    	<p class="text-center">{{ Session::get('mensajeError') }}</p>
	   	</div>
	@endif
	{{ Form::open(array('role'=>'form', 'url' => '/usuario/login')) }}
		<div class="col-md-offset-1 col-md-10">
			{{ Form::text('rut', e(Input::old('rut')), array('placeholder'=>'Matrícula', 'autofocus'=>'autofocus', 'autocomplete' => 'off')) }}
		</div>
		<div class="col-md-offset-1 col-md-10">
			{{ Form::password('password', array('placeholder'=>'Contraseña')) }}
		</div>
		<div class="input-group col-md-offset-1 col-md-10 text-center">
			{{ Form::submit('Entrar', array('class'=>'btn btn-default col-xs-12')) }}
			<p class="text-center">
				<a href="{{ URL::to('olvidePass') }}" >¿Olvidé mi contraseña?</a>
			</p>
		</div>
	{{ Form::close() }}
</div>