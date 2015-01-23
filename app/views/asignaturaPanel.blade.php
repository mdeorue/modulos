<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SmartB University - Be Smart</title>
		<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">
		{{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300') }}
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/modulos-style.css?v=2.0') }}
		{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js') }}
	</head>
	<body>
		<nav class="navbar navbar-default" role="navigation">
		  <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="#">Universidad de la Frontera</a>
		    </div>

		    <!-- Collect the nav links, forms, and other content for toggling -->
		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		    	<ul class="nav navbar-nav navbar-right">
		    		<li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
			        <li><a href="{{ url('/modulo') }}">Módulos</a></li>
					<li class="active"><a href="{{ url('/asignatura') }}">Asignaturas</a></li></li>
					<li><a href="{{ url('/configuracion') }}">Configuración</a></li></li>
		      	</ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid main-container">
			<div id="panel-header" class="col-xs-12">
				<div class="col-xs-10">
					<h1>Asignaturas</h1>
				</div>
				<div class="col-xs-2 panel-header-toolbar">
					<a href="#" class="glyphicon glyphicon-plus" title="Crear Asignatura"></a>
				</div>
			</div>
			<div class="col-sm-4" id="left-container">
				{{ Form::open(array('url' => 'hola', 'class' => 'form-horizontal', 'role' => 'form')) }}
					<div class="form-group">
						<div class="col-xs-12">
					      {{ Form::select('facultad', array(0 => 'Elige una Facultad', 1 => 'FACULTAD DE INGENIERIA Y CIENCIAS'), 0, array('id' => 'facu-select')) }}
					    </div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
					      {{ Form::select('carrera', array(0 => 'Elige una Carrera', 1 => 'INGENIERIA CIVIL INDUSTRIAL MENCION INFORMATICA'), 0, array('id' => 'carr-select')) }}
					    </div>
					</div>
					<div class="form-group">
						<div class="col-xs-12">
					      {{ Form::select('carrera', array(0 => 'Elige una Asignatura', 1 => 'IIQ201 - ASIGNATURA 1'), 0, array('id' => 'asig-select')) }}
					    </div>
					</div>
				{{ Form::close() }}
			</div>
			<div class="col-sm-8" id="middle-container">
				<div class="col-xs-12 panel-header-2">
					<div class="col-xs-10">
						<h2>IIQ201 - ASIGNATURA 1</h2>
					</div>
					<div class="panel-header-2-toolbar pull-right">
						<a href="#" class="glyphicon glyphicon-pencil" title="Editar Módulo"></a>
						<a href="#" class="glyphicon glyphicon-remove" title="Crear Módulo"></a>
					</div>
				</div>
				<div class="col-sm-12">
					{{ Form::open(array('url' => 'hola3', 'class' => 'form-horizontal', 'role' => 'form')) }}
						<div class="row">
							<div class="col-xs-4">
								Código:
							</div>
							<div class="col-xs-8">
								{{ Form::text('codAsig', 'IIQ201', array('disabled' => 'disabled')) }}
							</div>
						</div>
						<div class="row">
							<div class="col-xs-4">
								Asignatura:
							</div>
							<div class="col-xs-8">
								{{ Form::text('asignatura', 'ASIGNATURA 1', array('disabled' => 'disabled')) }}
							</div>
						</div>
					{{ Form::close() }}
				</div>
						<div class="row">
							<div class="col-xs-12">
								<h3>Temario</h3>
								<ul>
									<li>Capítulo 1. Introducción a la Programación</li>
									<li>Capítulo 2. Variables</li>
									<li>Capítulo 3. Flujo de Control</li>
									<li>Capítulo 4. Ciclos</li>
								</ul>
							</div>
						</div>
			</div>
		</div>
		<div class="col-sm-12 main-footer">
  			<p class="text-center">Powered by <a href="mailto:migueldeorue@gmail.com">SmartB Project</a> {{ date('Y') }}</p>
		</div>
		{{ HTML::script('js/bootstrap.min.js') }}
		<script type="text/javascript">
			$('#facu-select').change(function(event) {
				event.preventDefault();
				var facu = $(this).val();
				if(facu != 0){
					$('#carr-select').show();
				}else{
					$('#carr-select').hide();
					$('#asig-select').hide();
					$('#middle-container').hide();
					$('#modulos-init').hide();
				}
			});

			$('#carr-select').change(function(event) {
				event.preventDefault();
				var carr = $(this).val();
				if(carr != 0){
					$('#asig-select').show();
				}else{
					$('#asig-select').hide();
					$('#middle-container').hide();
				}
			});

			$('#asig-select').change(function(event) {
				event.preventDefault();
				var asig = $(this).val();
				if(asig != 0){
					$('#middle-container').show();
				}else{
					$('#middle-container').hide();
				}
			});
		</script>
	</body>
</html>
