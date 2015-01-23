<!doctype html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>SmartB University - Be Smart</title>
		<link rel="shortcut icon" href="{{ URL::to('favicon.ico') }}">
		{{ HTML::style('css/bootstrap.css') }}
		{{ HTML::style('css/modulos-pdf.css?v=2.0') }}
	</head>
	<body class="pdf-layout">
		<div class="container-fluid main-container">
			<div class="row text-center">
				<br>
				<br>
				<img src="{{ asset('image/logo-pdf.jpg'); }}" width="200">
				<br>
				<br>
				<br>
				<h1>CONSTANCIA</h1>
				<br>
			</div>
			<br>
			<br>
			<div class="row">
				<div class="col-xs-offset-1 col-xs-10">
					<p class="indent">Sindy Alicia González Reyes, Trabajador Social, 
						Encargada del Programa de Apoyo a la Adaptación Universitaria (PAAU), 
						deja constancia que el/la Sr/a. {{ $profesor->usuario}}, matrícula 
						{{ $profesor->rut }} de la carrera {{ $profesor->carrera()->first()->carrera }}, se desempeñó durante {{ $ciclo->semestre }} 
						del año {{ $ciclo->ano }}  como tutor académico 
						en el Programa de Apoyo a la Adaptación Universitaria (PAAU) 
						dependiente de la Dirección Académica de Pregrado de la 
						Universidad de La Frontera. </p>
					<p>Se entrega la siguiente constancia para efectos que la persona estime conveniente.</p>
					<br>
					<br>
					<p>Temuco, {{ Template::getMes(date('m')) }} de {{ date('Y') }}</p>
				</div>	
			</div>
		</div>
	</body>
</html>
