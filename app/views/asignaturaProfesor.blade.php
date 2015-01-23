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
					<li><a href="{{ url('/asignatura') }}">Asignaturas</a></li></li>
					<li class="active"><a href="{{ url('/configuracion') }}">Configuración</a></li></li>
		      	</ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid main-container">
			<div id="panel-header" class="col-xs-12">
				<div class="col-xs-10">
					<h1>IIQ201 - 345 - ASIGNATURA 1</h1>
				</div>
				<div class="col-xs-2 panel-header-toolbar">
				</div>
			</div>
			<div class="row">

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Información</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">

						<div class="row">
							<div class="col-xs-4">
								Código:
							</div>
							<div class="col-xs-8">
								IIQ201
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4">
								Asignatura:
							</div>
							<div class="col-xs-8">
								ASIGNATURA 1
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4">
								Fecha Inicio:
							</div>
							<div class="col-xs-8">
								12-05-2014
							</div>
						</div>

						<div class="row">
							<div class="col-xs-4">
								Matriculados:
							</div>
							<div class="col-xs-8">
								3
							</div>
						</div>

					</div>
				</div>

				<div class="col-sm-9">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Asistencia</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
							<a href="#" class="glyphicon glyphicon-floppy-disk" title="Guardar Asistencia"></a>
						</div>
					</div>
					<div class="widget-container">
						{{ Form::open(array('url' => 'asignarAsistencia')) }}
							<div class="col-sm-12">
								<div class="col-xs-3">
									Fecha:
								</div>
								<div class="col-xs-9">
									<input type="date" value="{{ date('Y-m-d') }}" name="fechaAsistencia">
								</div>
							</div>
							<div class="col-sm-12">
								<table class="table table-hover">
									<thead>
										<th>Matrícula</th>
										<th>Alumno</th>
										<th>Asistencia</th>
									</thead>
									<tbody>
										<tr>
											<td>16794318710</td>
											<td>MIGUEL DE ORUE DIAZ</td>
											<td class="text-center">{{ Form::checkbox('asistencia', '16794318710'); }}</td>
										</tr>
										<tr>
											<td>16794318710</td>
											<td>MIGUEL DE ORUE DIAZ</td>
											<td class="text-center">{{ Form::checkbox('asistencia', '16794318710'); }}</td>
										</tr>
										<tr>
											<td>16794318710</td>
											<td>MIGUEL DE ORUE DIAZ</td>
											<td class="text-center">{{ Form::checkbox('asistencia', '16794318710'); }}</td>
										</tr>
										<tr>
											<td>16794318710</td>
											<td>MIGUEL DE ORUE DIAZ</td>
											<td class="text-center">{{ Form::checkbox('asistencia', '16794318710'); }}</td>
										</tr>
									</tbody>
								</table>
							</div>
						{{ Form::close() }}
					</div>

					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Bitácora</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
							<a href="#" class="glyphicon glyphicon-floppy-disk" title="Guardar Bítacora"></a>
						</div>
					</div>
					<div class="widget-container">
						{{ Form::open(array('url' => 'bitacoraModulo')) }}
							<div class="col-sm-12">
								<div class="col-xs-3">
									Fecha:
								</div>
								<div class="col-xs-9">
									<input type="date" value="{{ date('Y-m-d') }}" name="fechaAsistencia">
								</div>
							</div>
							<div class="col-sm-12">
								<div class="col-xs-3">
									Descripción:
								</div>
								<div class="col-xs-9">
									{{ Form::textarea('bitacora', '', array('class' => 'form-control', 'rows' => '3')) }}
								</div>
							</div>
						{{ Form::close() }}
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
