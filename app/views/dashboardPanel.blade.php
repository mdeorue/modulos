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
		    		<li class="active"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
			        <li><a href="{{ url('/modulo') }}">Módulos</a></li>
					<li><a href="{{ url('/asignatura') }}">Asignaturas</a></li></li>
					<li><a href="{{ url('/configuracion') }}">Configuración</a></li></li>
		      	</ul>
		    </div><!-- /.navbar-collapse -->
		  </div><!-- /.container-fluid -->
		</nav>
		<div class="container-fluid main-container">
			<div id="panel-header" class="col-xs-12">
				<div class="col-xs-10">
					<h1>Dashboard <small>[062013 - 092013]</small></h1>
				</div>
				<div class="col-xs-2 panel-header-toolbar">
				</div>
			</div>
			<div class="row">

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Postulaciones</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							100 
							<small>Postulaciones</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Inscripciones</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							80 
							<small>Inscripciones</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Alumnos</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							50 
							<small>Alumnos</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Tutores</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							20 
							<small>Tutores</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Facultades</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							4 
							<small>Facultades</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Carreras</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							35 
							<small>Carreras</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Asignatura</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							50 
							<small>Asignaturas</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Módulos</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							100 
							<small>Módulos</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Asistencia</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							90 
							<small>%</small>
						</p>
					</div>
				</div>

				<div class="col-sm-3">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Aprobación</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<p class="result-text text-center">
							75 
							<small>%</small>
						</p>
					</div>
				</div>				

				<div class="col-sm-8">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Inscripción por Año de Ingreso</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
						<table class="table table-hover">
							<thead>
								<th>Año Ingreso</th>
								<th>Alumnos</th>
								<th>Módulos</th>
								<th>Aprobación</th>
							</thead>
							<tbody>
								<tr>
									<td>2013</td>
									<td>100</td>
									<td>30</td>
									<td>60%</td>
								</tr>
								<tr>
									<td>2014</td>
									<td>90</td>
									<td>26</td>
									<td>70%</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="col-xs-12 panel-header-2">
						<div class="col-xs-10">
							<h2>Inscripción por Facultad</h2>
						</div>
						<div class="panel-header-2-toolbar pull-right">
						</div>
					</div>
					<div class="widget-container">
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
