<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Menú Navegación</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		   	</button>
			<a class="navbar-brand" href="{{ url('/') }}">
				<img src="{{ asset('image/logoufro.jpg'); }}" id="brand-logo" title="Programa de Apoyo a la Adaptación Universitaria">
				<span class="hidden-xs">
					Programa de Apoyo a la Adaptación Universitaria
					<br>
					<small id="sub-logo" class="hidden-sm">Dirección Académica de Pregrado</small>
				</span>
			</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
				@if (isset($menues))
					@foreach ($menues as $menu)
						<li {{ $menu['active'] }}><a href="{{ $menu['url'] }}">{{ $menu['menu'] }}</a></li>
					@endforeach
				@endif
		  	</ul>
		</div>
	</div>
</nav>